<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use RuntimeException;
use Throwable;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Order $order): Payment
    {
        try {
            return Cache::lock(
                "midtrans:snap:{$order->getKey()}",
                30
            )->block(
                10,
                fn (): Payment => $this->createTransactionOnce($order)
            );
        } catch (LockTimeoutException $exception) {
            $existingPayment = Payment::query()
                ->where('order_id', $order->getKey())
                ->first();

            if ($existingPayment && filled($existingPayment->snap_token)) {
                return $existingPayment;
            }

            throw new RuntimeException(
                'Transaksi pembayaran sedang dibuat. Silakan coba kembali.',
                previous: $exception
            );
        }
    }

    private function createTransactionOnce(Order $order): Payment
    {
        $freshOrder = Order::query()
            ->with(['items', 'payment'])
            ->findOrFail($order->getKey());

        if ($freshOrder->payment_status === 'paid') {
            throw new RuntimeException('Pesanan sudah dibayar.');
        }

        if ($freshOrder->status === 'cancelled') {
            throw new RuntimeException('Pesanan sudah dibatalkan.');
        }

        if ($freshOrder->expires_at?->isPast()) {
            throw new RuntimeException('Batas waktu pembayaran sudah habis.');
        }

        if ($freshOrder->payment && filled($freshOrder->payment->snap_token)) {
            return $freshOrder->payment;
        }

        $itemDetails = $freshOrder->items
            ->map(function ($item): array {
                return [
                    'id' => $item->sku ?: 'ITEM-'.$item->id,
                    'price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'name' => mb_substr(
                        $item->product_name.' - '.$item->variant_name,
                        0,
                        50
                    ),
                ];
            })
            ->values()
            ->all();

        if ($freshOrder->service_fee > 0) {
            $itemDetails[] = [
                'id' => 'SERVICE-FEE',
                'price' => $freshOrder->service_fee,
                'quantity' => 1,
                'name' => 'Biaya layanan',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $freshOrder->order_number,
                'gross_amount' => $freshOrder->total,
            ],
            'customer_details' => [
                'first_name' => $freshOrder->customer_name,
                'email' => $freshOrder->customer_email
                    ?: 'customer@demas-store.test',
                'phone' => $freshOrder->customer_phone,
            ],
            'item_details' => $itemDetails,
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit' => 'minutes',
                'duration' => 15,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (Throwable $exception) {
            report($exception);

            throw new RuntimeException(
                'Midtrans error: '.$exception->getMessage(),
                previous: $exception
            );
        }

        return DB::transaction(function () use ($freshOrder, $snapToken): Payment {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($freshOrder->getKey());

            $payment = Payment::query()
                ->where('order_id', $lockedOrder->id)
                ->lockForUpdate()
                ->first();

            if ($payment && filled($payment->snap_token)) {
                return $payment;
            }

            $payment ??= new Payment([
                'order_id' => $lockedOrder->id,
            ]);

            $payment->fill([
                'gateway' => 'midtrans',
                'gateway_order_id' => $lockedOrder->order_number,
                'snap_token' => $snapToken,
                'gross_amount' => $lockedOrder->total,
                'transaction_status' => 'pending',
            ]);

            $payment->save();

            return $payment;
        }, attempts: 3);
    }
}

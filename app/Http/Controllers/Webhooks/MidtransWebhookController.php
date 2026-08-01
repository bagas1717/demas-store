<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Inventory\OrderStockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MidtransWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        OrderStockService $stockService
    ): JsonResponse {
        $payload = $request->all();
        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');
        $transactionStatus = (string) ($payload['transaction_status'] ?? '');
        $fraudStatus = (string) ($payload['fraud_status'] ?? '');

        if ($orderId === '' || $statusCode === '' || $grossAmount === '' || $signatureKey === '') {
            return response()->json(['message' => 'Payload tidak lengkap.'], 422);
        }

        $expectedSignature = hash(
            'sha512',
            $orderId.$statusCode.$grossAmount.config('midtrans.server_key')
        );

        if (! hash_equals($expectedSignature, $signatureKey)) {
            return response()->json(['message' => 'Signature tidak valid.'], 403);
        }

        $order = Order::query()
            ->where('order_number', $orderId)
            ->first();

        if (! $order) {
            if (str_starts_with($orderId, 'payment_notif_test_')) {
                return response()->json([
                    'message' => 'Midtrans test notification received.',
                ]);
            }

            return response()->json(['message' => 'Pesanan tidak ditemukan.'], 404);
        }

        if ((int) round((float) $grossAmount) !== (int) $order->total) {
            return response()->json([
                'message' => 'Nominal transaksi tidak sesuai.',
            ], 422);
        }

        $allowedStatuses = [
            'capture', 'settlement', 'pending', 'deny', 'cancel',
            'expire', 'failure', 'refund', 'partial_refund',
        ];

        if (! in_array($transactionStatus, $allowedStatuses, true)) {
            return response()->json([
                'message' => 'Status transaksi tidak valid.',
            ], 422);
        }

        $notificationHash = hash('sha256', implode('|', [
            $orderId,
            (string) ($payload['transaction_id'] ?? ''),
            $transactionStatus,
            $statusCode,
            $grossAmount,
            $fraudStatus,
        ]));

        $duplicate = false;

        try {
            DB::transaction(function () use (
                $order,
                $payload,
                $transactionStatus,
                $fraudStatus,
                $notificationHash,
                $stockService,
                &$duplicate
            ): void {
                $lockedOrder = Order::query()
                    ->lockForUpdate()
                    ->findOrFail($order->id);

                $payment = Payment::query()
                    ->where('order_id', $lockedOrder->id)
                    ->lockForUpdate()
                    ->first();

                if (! $payment) {
                    $payment = Payment::create([
                        'order_id' => $lockedOrder->id,
                        'gateway' => 'midtrans',
                        'gateway_order_id' => $lockedOrder->order_number,
                        'gross_amount' => $lockedOrder->total,
                    ]);
                }

                if (
                    filled($payment->last_notification_hash) &&
                    hash_equals($payment->last_notification_hash, $notificationHash)
                ) {
                    $duplicate = true;
                    return;
                }

                $payment->update([
                    'transaction_id' => $payload['transaction_id'] ?? null,
                    'payment_type' => $payload['payment_type'] ?? null,
                    'transaction_status' => $transactionStatus,
                    'fraud_status' => $fraudStatus !== '' ? $fraudStatus : null,
                    'raw_response' => $payload,
                    'last_notification_hash' => $notificationHash,
                ]);

                $this->applyStatus(
                    $lockedOrder,
                    $payment,
                    $transactionStatus,
                    $fraudStatus,
                    $stockService
                );
            }, attempts: 3);
        } catch (Throwable $exception) {
            Log::error('Webhook Midtrans gagal diproses.', [
                'order_id' => $orderId,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'message' => 'Notification processing failed.',
            ], 500);
        }

        return response()->json([
            'message' => $duplicate
                ? 'Duplicate notification ignored.'
                : 'Notification processed.',
        ]);
    }

    private function applyStatus(
        Order $order,
        Payment $payment,
        string $transactionStatus,
        string $fraudStatus,
        OrderStockService $stockService
    ): void {
        $successful = $transactionStatus === 'settlement' || (
            $transactionStatus === 'capture' &&
            in_array($fraudStatus, ['', 'accept'], true)
        );

        if ($successful) {
            if ($order->payment_status === 'refunded') {
                return;
            }

            if ($order->payment_status !== 'paid') {
                $paidAt = now();

                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                    'paid_at' => $paidAt,
                ]);

                $payment->update([
                    'paid_at' => $paidAt,
                    'expired_at' => null,
                ]);
            }

            return;
        }

        if ($transactionStatus === 'pending') {
            return;
        }

        if ($transactionStatus === 'expire') {
            if (in_array($order->payment_status, ['paid', 'refunded'], true)) {
                return;
            }

            if ($order->payment_status !== 'expired') {
                $order->update([
                    'payment_status' => 'expired',
                    'status' => 'cancelled',
                ]);

                $payment->update(['expired_at' => now()]);
            }

            $stockService->release($order);
            return;
        }

        if (in_array($transactionStatus, ['deny', 'cancel', 'failure'], true)) {
            if (in_array($order->payment_status, ['paid', 'refunded'], true)) {
                return;
            }

            if ($order->payment_status !== 'failed') {
                $order->update([
                    'payment_status' => 'failed',
                    'status' => 'cancelled',
                ]);
            }

            $stockService->release($order);
            return;
        }

        if (in_array($transactionStatus, ['refund', 'partial_refund'], true)) {
            if ($order->payment_status !== 'refunded') {
                $order->update([
                    'payment_status' => 'refunded',
                    'status' => 'cancelled',
                ]);
            }
        }
    }
}

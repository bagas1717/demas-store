<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(Request $request): View
    {
        $this->attachGuestOrders($request);

        $baseQuery = $request->user()
            ->orders();

        $stats = [
            'totalOrders' => (clone $baseQuery)->count(),
            'totalSpent' => (clone $baseQuery)
                ->where('payment_status', 'paid')
                ->sum('total'),
            'pendingOrders' => (clone $baseQuery)
                ->where('payment_status', 'unpaid')
                ->count(),
            'processingOrders' => (clone $baseQuery)
                ->where('status', 'processing')
                ->count(),
            'completedOrders' => (clone $baseQuery)
                ->where('status', 'completed')
                ->count(),
            'cancelledOrders' => (clone $baseQuery)
                ->where('status', 'cancelled')
                ->count(),
        ];

        $latestOrders = $request->user()
            ->orders()
            ->with(['items'])
            ->withCount('items')
            ->latest()
            ->take(5)
            ->get();

        return view(
            'pages.account.dashboard',
            array_merge($stats, compact('latestOrders'))
        );
    }

    public function orders(Request $request): View
    {
        $this->attachGuestOrders($request);

        $orders = $request->user()
            ->orders()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return view(
            'pages.account.orders',
            compact('orders')
        );
    }

    public function showOrder(
        Request $request,
        Order $order
    ): View {
        Gate::authorize('view', $order);

        $order->load([
            'items',
            'payment',
        ]);

        return view(
            'pages.order-show',
            compact('order')
        );
    }

    public function requestOrderDetails(
        Request $request,
        Order $order
    ): RedirectResponse {
        Gate::authorize('view', $order);

        $whatsappUrl = DB::transaction(
            function () use ($order): ?string {
                $lockedOrder = Order::query()
                    ->whereKey($order->getKey())
                    ->lockForUpdate()
                    ->with(['items', 'payment'])
                    ->firstOrFail();

                abort_unless(
                    $lockedOrder->payment_status === 'paid',
                    403,
                    'Detail pesanan hanya dapat diminta setelah pembayaran berhasil.'
                );

                if ($lockedOrder->detail_requested_at) {
                    return null;
                }

                $lockedOrder->forceFill([
                    'detail_requested_at' => now(),
                ])->save();

                $payment = $lockedOrder->payment;

                $productNames = $lockedOrder->items
                    ->map(
                        fn ($item) =>
                            ($item->product_name ?? $item->name)
                            .' - '
                            .($item->variant_name ?? 'Paket produk')
                            .' x'
                            .$item->quantity
                    )
                    ->implode(', ');

                $message = implode(PHP_EOL, [
                    'Halo Demas Store, pembayaran saya sudah berhasil.',
                    '',
                    'Nomor pesanan: '.$lockedOrder->order_number,
                    'Nama: '.$lockedOrder->customer_name,
                    'Produk: '.$productNames,
                    'Total: Rp'.number_format($lockedOrder->total, 0, ',', '.'),
                    'Status pembayaran: Dibayar',
                    'Metode pembayaran: '.(
                        $payment?->payment_type
                            ? str($payment->payment_type)
                                ->replace('_', ' ')
                                ->title()
                            : 'Tidak tersedia'
                    ),
                    'Waktu pembayaran: '.(
                        $payment?->paid_at
                            ?->timezone('Asia/Jakarta')
                            ->format('d M Y, H:i')
                        ?? $lockedOrder->paid_at
                            ?->timezone('Asia/Jakarta')
                            ->format('d M Y, H:i')
                        ?? 'Tidak tersedia'
                    ),
                    'ID transaksi: '.(
                        $payment?->transaction_id
                        ?? 'Tidak tersedia'
                    ),
                    '',
                    'Mohon kirimkan detail produk pesanan saya.',
                    'Saya akan melampirkan screenshot bukti pembayaran jika diperlukan.',
                ]);

                $whatsappNumber = preg_replace(
                    '/\D+/',
                    '',
                    (string) config(
                        'services.whatsapp.order_fulfillment',
                        '62881080631917'
                    )
                );

                return 'https://wa.me/'
                    .$whatsappNumber
                    .'?text='
                    .urlencode($message);
            },
            attempts: 3
        );

        if ($whatsappUrl === null) {
            return redirect()
                ->route('account.orders.show', $order)
                ->with(
                    'info',
                    'Permintaan detail pesanan sudah pernah dikirim. Jika ada kendala, silakan hubungi Customer Service.'
                );
        }

        return redirect()->away($whatsappUrl);
    }

    private function attachGuestOrders(Request $request): void
    {
        $user = $request->user();
        $email = strtolower(trim($user->email));

        Order::query()
            ->whereNull('user_id')
            ->whereRaw('LOWER(customer_email) = ?', [$email])
            ->update([
                'user_id' => $user->id,
            ]);
    }
}

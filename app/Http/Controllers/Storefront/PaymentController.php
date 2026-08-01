<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payments\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use RuntimeException;

class PaymentController extends Controller
{
    public function create(
        Order $order,
        MidtransService $midtrans
    ): RedirectResponse {
        $order->refresh();

        abort_if($order->payment_status === 'paid', 422, 'Pesanan sudah dibayar.');
        abort_if($order->status === 'cancelled', 422, 'Pesanan sudah dibatalkan.');
        abort_if($order->expires_at?->isPast(), 422, 'Batas waktu pembayaran sudah habis.');

        try {
            $midtrans->createTransaction($order);
        } catch (RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->to(
            URL::temporarySignedRoute(
                'orders.show',
                $order->expires_at ?? now()->addMinutes(15),
                ['order' => $order]
            )
        );
    }
}

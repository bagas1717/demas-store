<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payments\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RuntimeException;
use Throwable;

class AccountPaymentController extends Controller
{
    public function store(
        Request $request,
        Order $order,
        MidtransService $midtransService
    ): JsonResponse {
        Gate::authorize('pay', $order);
        $order->refresh();

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Pesanan sudah dibayar.'], 422);
        }

        if ($order->status === 'cancelled') {
            return response()->json(['message' => 'Pesanan sudah dibatalkan.'], 422);
        }

        if ($order->expires_at?->isPast()) {
            return response()->json([
                'message' => 'Batas waktu pembayaran sudah habis.',
            ], 422);
        }

        try {
            $payment = $midtransService->createTransaction($order);

            if (! filled($payment->snap_token)) {
                return response()->json([
                    'message' => 'Token pembayaran tidak tersedia.',
                ], 500);
            }

            return response()->json([
                'snap_token' => $payment->snap_token,
            ]);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 409);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Pembayaran gagal dibuka.',
            ], 500);
        }
    }
}

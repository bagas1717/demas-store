<?php

namespace App\Services\Inventory;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderStockService
{
    public function release(Order $order): void
    {
        DB::transaction(function () use ($order): void {
            $lockedOrder = Order::query()
                ->with('items')
                ->lockForUpdate()
                ->findOrFail($order->id);

            if ($lockedOrder->stock_released_at !== null) {
                return;
            }

            if ($lockedOrder->payment_status === 'paid') {
                return;
            }

            foreach ($lockedOrder->items as $item) {
                if (! $item->product_variant_id) {
                    continue;
                }

                $variant = ProductVariant::query()
                    ->lockForUpdate()
                    ->find($item->product_variant_id);

                if (! $variant) {
                    throw new RuntimeException(
                        "Paket produk untuk item {$item->id} tidak ditemukan."
                    );
                }

                $variant->increment('stock', $item->quantity);
            }

            $lockedOrder->update([
                'stock_released_at' => now(),
            ]);
        }, attempts: 3);
    }
}

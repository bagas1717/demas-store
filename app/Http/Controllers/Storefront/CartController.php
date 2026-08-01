<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->hydrateCart(
            $request->session()->get('cart', [])
        );

        return view('pages.cart', compact('cart'));
    }

    public function store(
        Request $request,
        ProductVariant $variant
    ): JsonResponse {
        $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        abort_unless(
            $variant->is_active && $variant->product?->is_active,
            404
        );

        $quantity = (int) $request->input('quantity', 1);

        if ($variant->stock < 1) {
            return response()->json([
                'message' => 'Stok paket sudah habis.',
            ], 422);
        }

        $cart = $request->session()->get('cart', []);

        $currentQuantity = (int) ($cart[$variant->id] ?? 0);
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $variant->stock) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia.',
            ], 422);
        }

        $cart[$variant->id] = $newQuantity;

        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Paket berhasil ditambahkan.',
            'cart_count' => array_sum($cart),
        ]);
    }

    public function update(
        Request $request,
        ProductVariant $variant
    ): JsonResponse {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($validated['quantity'] > $variant->stock) {
            return response()->json([
                'message' => 'Jumlah melebihi stok yang tersedia.',
            ], 422);
        }

        $cart = $request->session()->get('cart', []);

        if (! array_key_exists($variant->id, $cart)) {
            return response()->json([
                'message' => 'Paket tidak ditemukan di keranjang.',
            ], 404);
        }

        $cart[$variant->id] = $validated['quantity'];

        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Jumlah berhasil diperbarui.',
            'cart_count' => array_sum($cart),
        ]);
    }

    public function destroy(
        Request $request,
        ProductVariant $variant
    ): JsonResponse {
        $cart = $request->session()->get('cart', []);

        unset($cart[$variant->id]);

        $request->session()->put('cart', $cart);

        return response()->json([
            'message' => 'Paket dihapus dari keranjang.',
            'cart_count' => array_sum($cart),
        ]);
    }

    private function hydrateCart(array $sessionCart): array
    {
        if ($sessionCart === []) {
            return [
                'items' => collect(),
                'count' => 0,
                'subtotal' => 0,
            ];
        }

        $variants = ProductVariant::query()
            ->with('product')
            ->whereIn('id', array_keys($sessionCart))
            ->where('is_active', true)
            ->get();

        $items = $variants->map(function (
            ProductVariant $variant
        ) use ($sessionCart) {
            $quantity = min(
                (int) $sessionCart[$variant->id],
                $variant->stock
            );

            return [
                'variant' => $variant,
                'quantity' => $quantity,
                'line_total' => $variant->price * $quantity,
            ];
        });

        return [
            'items' => $items,
            'count' => $items->sum('quantity'),
            'subtotal' => $items->sum('line_total'),
        ];
    }
}

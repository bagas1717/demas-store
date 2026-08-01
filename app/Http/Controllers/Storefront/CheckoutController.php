<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $cart = $this->getCheckoutItems($request);

        if ($cart['items']->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Belum ada produk untuk checkout.');
        }

        $checkoutToken = $request->session()->get('checkout_token');

        if (
            ! is_string($checkoutToken) ||
            $checkoutToken === '' ||
            Order::query()->where('checkout_token', $checkoutToken)->exists()
        ) {
            $checkoutToken = (string) Str::uuid();
            $request->session()->put('checkout_token', $checkoutToken);
        }

        return view('pages.checkout', compact('cart', 'checkoutToken'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_email' => ['required', 'email', 'max:150'],
            'customer_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $checkoutToken = $request->session()->get('checkout_token');

        if (! is_string($checkoutToken) || $checkoutToken === '') {
            $checkoutToken = (string) Str::uuid();
            $request->session()->put('checkout_token', $checkoutToken);
        }

        $existingOrder = Order::query()
            ->where('checkout_token', $checkoutToken)
            ->first();

        if ($existingOrder) {
            return $this->redirectToOrder(
                $existingOrder,
                'Pesanan yang sama sudah dibuat sebelumnya.'
            );
        }

        $checkoutData = $this->getCheckoutItems($request);

        if ($checkoutData['items']->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Belum ada produk untuk checkout.');
        }

        $sessionCart = $checkoutData['items']
            ->mapWithKeys(fn (array $item): array => [
                $item['variant']->id => $item['quantity'],
            ])
            ->all();

        try {
            $order = Cache::lock("checkout:{$checkoutToken}", 20)
                ->block(10, function () use (
                    $validated,
                    $sessionCart,
                    $request,
                    $checkoutToken
                ): Order {
                    $existingOrder = Order::query()
                        ->where('checkout_token', $checkoutToken)
                        ->first();

                    if ($existingOrder) {
                        return $existingOrder;
                    }

                    return DB::transaction(function () use (
                        $validated,
                        $sessionCart,
                        $request,
                        $checkoutToken
                    ): Order {
                        $existingOrder = Order::query()
                            ->where('checkout_token', $checkoutToken)
                            ->lockForUpdate()
                            ->first();

                        if ($existingOrder) {
                            return $existingOrder;
                        }

                        $variants = ProductVariant::query()
                            ->with('product')
                            ->whereIn('id', array_keys($sessionCart))
                            ->lockForUpdate()
                            ->get();

                        if ($variants->count() !== count($sessionCart)) {
                            throw ValidationException::withMessages([
                                'cart' => 'Ada paket yang sudah tidak tersedia.',
                            ]);
                        }

                        $subtotal = 0;
                        $preparedItems = [];

                        foreach ($variants as $variant) {
                            $quantity = (int) $sessionCart[$variant->id];

                            if (! $variant->is_active) {
                                throw ValidationException::withMessages([
                                    'cart' => "Paket {$variant->name} sudah tidak aktif.",
                                ]);
                            }

                            if (! $variant->product?->is_active) {
                                throw ValidationException::withMessages([
                                    'cart' => "Produk {$variant->product?->name} sudah tidak aktif.",
                                ]);
                            }

                            if ($quantity < 1 || $quantity > $variant->stock) {
                                throw ValidationException::withMessages([
                                    'cart' => "Stok {$variant->name} tidak mencukupi.",
                                ]);
                            }

                            $lineTotal = $variant->price * $quantity;
                            $subtotal += $lineTotal;

                            $preparedItems[] = [
                                'variant' => $variant,
                                'quantity' => $quantity,
                                'line_total' => $lineTotal,
                            ];
                        }

                        $serviceFee = 0;

                        $order = Order::create([
                            'user_id' => $request->user()?->id,
                            'checkout_token' => $checkoutToken,
                            'order_number' => $this->generateOrderNumber(),
                            'customer_name' => $validated['customer_name'],
                            'customer_phone' => $validated['customer_phone'],
                            'customer_email' => strtolower(trim($validated['customer_email'])),
                            'customer_note' => $validated['customer_note'] ?? null,
                            'subtotal' => $subtotal,
                            'service_fee' => $serviceFee,
                            'total' => $subtotal + $serviceFee,
                            'status' => 'pending_payment',
                            'payment_status' => 'unpaid',
                            'expires_at' => now()->addMinutes(15),
                        ]);

                        foreach ($preparedItems as $item) {
                            $variant = $item['variant'];

                            $order->items()->create([
                                'product_id' => $variant->product_id,
                                'product_variant_id' => $variant->id,
                                'product_name' => $variant->product->name,
                                'variant_name' => $variant->name,
                                'sku' => $variant->sku,
                                'unit_price' => $variant->price,
                                'quantity' => $item['quantity'],
                                'line_total' => $item['line_total'],
                            ]);

                            $variant->decrement('stock', $item['quantity']);
                        }

                        return $order;
                    }, attempts: 3);
                });
        } catch (LockTimeoutException) {
            $order = Order::query()
                ->where('checkout_token', $checkoutToken)
                ->first();

            if (! $order) {
                return back()
                    ->withInput()
                    ->with('error', 'Checkout sedang diproses. Silakan coba beberapa saat lagi.');
            }
        } catch (QueryException $exception) {
            $order = Order::query()
                ->where('checkout_token', $checkoutToken)
                ->first();

            if (! $order) {
                throw $exception;
            }
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Pesanan gagal dibuat. Silakan coba kembali.');
        }

        $request->session()->forget(['cart', 'buy_now']);

        return $this->redirectToOrder($order, 'Pesanan berhasil dibuat.');
    }

    public function show(Order $order): View
    {
        $order->load(['items', 'payment']);

        $paymentUrl = URL::temporarySignedRoute(
            'payments.create',
            $order->expires_at ?? now()->addMinutes(15),
            ['order' => $order]
        );

        return view('pages.order-show', [
            'order' => $order,
            'paymentUrl' => $paymentUrl,
        ]);
    }

    public function buyNow(
        Request $request,
        ProductVariant $variant
    ): RedirectResponse {
        abort_unless(
            $variant->is_active && $variant->product?->is_active,
            404
        );

        if ($variant->stock < 1) {
            return back()->with('error', 'Stok paket sudah habis.');
        }

        $request->session()->put('buy_now', [
            'variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $request->session()->forget('checkout_token');

        return redirect()->route('checkout.create');
    }

    private function getCart(Request $request): array
    {
        $sessionCart = $request->session()->get('cart', []);

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
        ) use ($sessionCart): array {
            $quantity = (int) $sessionCart[$variant->id];

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

    private function getCheckoutItems(Request $request): array
    {
        $buyNow = $request->session()->get('buy_now');

        if ($buyNow) {
            $variant = ProductVariant::query()
                ->with('product')
                ->whereKey($buyNow['variant_id'])
                ->where('is_active', true)
                ->first();

            if (! $variant || ! $variant->product?->is_active) {
                return [
                    'items' => collect(),
                    'count' => 0,
                    'subtotal' => 0,
                    'mode' => 'buy_now',
                ];
            }

            $quantity = min(
                (int) ($buyNow['quantity'] ?? 1),
                $variant->stock
            );

            $items = collect([[
                'variant' => $variant,
                'quantity' => $quantity,
                'line_total' => $variant->price * $quantity,
            ]]);

            return [
                'items' => $items,
                'count' => $quantity,
                'subtotal' => $items->sum('line_total'),
                'mode' => 'buy_now',
            ];
        }

        $cart = $this->getCart($request);
        $cart['mode'] = 'cart';

        return $cart;
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'DMS-'.now()->format('ymd').'-'.Str::upper(Str::random(6));
        } while (Order::query()->where('order_number', $number)->exists());

        return $number;
    }

    private function redirectToOrder(
        Order $order,
        string $message
    ): RedirectResponse {
        $orderUrl = URL::temporarySignedRoute(
            'orders.show',
            $order->expires_at ?? now()->addMinutes(15),
            ['order' => $order]
        );

        return redirect()->to($orderUrl)->with('success', $message);
    }
}

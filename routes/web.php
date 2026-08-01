<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Storefront\AccountController;
use App\Http\Controllers\Storefront\AccountPaymentController;
use App\Http\Controllers\Storefront\AccountSettingsController;
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\HomeController;
use App\Http\Controllers\Storefront\PaymentController;
use App\Http\Controllers\Webhooks\MidtransWebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/produk/{product}', [HomeController::class, 'show'])
    ->name('products.show');

Route::prefix('keranjang')
    ->name('cart.')
    ->group(function (): void {
        Route::get('/', [CartController::class, 'index'])
            ->name('index');

        Route::post('/{variant}', [CartController::class, 'store'])
            ->name('store');

        Route::patch('/{variant}', [CartController::class, 'update'])
            ->name('update');

        Route::delete('/{variant}', [CartController::class, 'destroy'])
            ->name('destroy');
    });

Route::get('/checkout', [CheckoutController::class, 'create'])
    ->name('checkout.create');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get(
    '/pesanan/{order}',
    [CheckoutController::class, 'show']
)
    ->middleware('signed')
    ->name('orders.show');

Route::post(
    '/pesanan/{order}/pembayaran',
    [PaymentController::class, 'create']
)
    ->middleware('signed')
    ->name('payments.create');

Route::post(
    '/webhooks/midtrans',
    MidtransWebhookController::class
)->name('webhooks.midtrans');

Route::post(
    '/beli-sekarang/{variant}',
    [CheckoutController::class, 'buyNow']
)->name('checkout.buy-now');

Route::delete('/beli-sekarang', function (Request $request) {
    $request->session()->forget('buy_now');

    return redirect()->route('home');
})->name('checkout.buy-now.destroy');

Route::middleware(['auth', 'verified'])
    ->prefix('akun')
    ->name('account.')
    ->group(function (): void {
        Route::get(
            '/',
            [AccountController::class, 'dashboard']
        )->name('dashboard');

        Route::get(
            '/pesanan',
            [AccountController::class, 'orders']
        )->name('orders.index');

        Route::get(
            '/pesanan/{order}',
            [AccountController::class, 'showOrder']
        )->name('orders.show');

        Route::post(
            '/pesanan/{order}/bayar',
            [AccountPaymentController::class, 'store']
        )->name('orders.pay');

        Route::post(
            '/pesanan/{order}/minta-detail',
            [AccountController::class, 'requestOrderDetails']
        )->name('orders.request-details');

        Route::get(
            '/pengaturan',
            [AccountSettingsController::class, 'edit']
        )->name('settings.edit');

        Route::put(
            '/pengaturan/profil',
            [AccountSettingsController::class, 'updateProfile']
        )->name('settings.profile');

        Route::put(
            '/pengaturan/password',
            [AccountSettingsController::class, 'updatePassword']
        )->name('settings.password');

        Route::delete(
            '/pengaturan/perangkat-lain',
            [AccountSettingsController::class, 'destroyOtherSessions']
        )->name('settings.sessions.destroy-others');

        Route::delete(
            '/pengaturan/perangkat/{sessionId}',
            [AccountSettingsController::class, 'destroySession']
        )->name('settings.sessions.destroy');
    });

Route::middleware('guest')->group(function (): void {
    Route::get(
        '/auth/google',
        [GoogleAuthController::class, 'redirect']
    )->name('google.redirect');

    Route::get(
        '/auth/google/callback',
        [GoogleAuthController::class, 'callback']
    )->name('google.callback');
});

Route::view(
    '/syarat-dan-ketentuan',
    'pages.legal.terms'
)->name('terms');

Route::view(
    '/kebijakan-privasi',
    'pages.legal.privacy'
)->name('privacy');

Route::view(
    '/kebijakan-pengembalian',
    'pages.legal.refund'
)->name('refund-policy');

Route::view(
    '/cara-pembelian',
    'pages.support.purchase-guide'
)->name('purchase-guide');

Route::view(
    '/faq',
    'pages.support.faq'
)->name('faq');
<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse
            {
                public function toResponse($request)
                {
                    return redirect()->route('verification.notice');
                }
            };
        });
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => view('pages.auth.login'));
        Fortify::registerView(fn () => view('pages.auth.register'));
        Fortify::verifyEmailView(fn () => view('pages.auth.verify-email'));

        Fortify::requestPasswordResetLinkView(
            fn () => view('pages.auth.forgot-password')
        );

        Fortify::resetPasswordView(
            fn (Request $request) => view('pages.auth.reset-password', [
                'request' => $request,
                'token' => $request->route('token'),
            ])
        );

        RateLimiter::for('login', function (Request $request) {
            $email = Str::transliterate(
                Str::lower((string) $request->input('email'))
            );

            return Limit::perMinute(5)->by(
                $email.'|'.$request->ip()
            );
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                (string) $request->session()->get('login.id')
            );
        });
    }
}

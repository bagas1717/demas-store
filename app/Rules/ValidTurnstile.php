<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ValidTurnstile implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        if (! is_string($value) || $value === '') {
            $fail('Silakan selesaikan verifikasi keamanan.');

            return;
        }

        $response = Http::asForm()
            ->timeout(10)
            ->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret' => config('services.turnstile.secret_key'),
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]
            );

        if (
            ! $response->successful() ||
            ! $response->json('success')
        ) {
            $fail('Verifikasi keamanan gagal. Silakan coba kembali.');
        }
    }
}

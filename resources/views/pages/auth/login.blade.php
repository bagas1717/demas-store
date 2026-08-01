@extends('layouts.storefront')

@section('title', 'Masuk — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-md">
            <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-8">
                <div>
                    <h1 class="text-3xl font-black text-[#25233a]">Masuk</h1>
                    <p class="mt-2 text-sm text-[#77758d]">Masuk dengan akun yang telah kamu daftarkan.</p>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-2xl bg-green-50 p-4 text-sm font-bold text-green-700">{{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-7 grid gap-5">
                    @csrf

                    <label class="grid gap-2">
                        <span class="text-sm font-black text-[#25233a]">Email</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email" placeholder="nama@email.com"
                            class="rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2]">
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-black text-[#25233a]">Password</span>
                        <div class="relative">
                            <input id="login-password" type="password" name="password" required
                                autocomplete="current-password" placeholder="Masukkan password"
                                class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 pr-12 text-[#25233a] outline-none transition focus:border-[#304cb2]">
                            <button type="button" data-password-toggle="login-password"
                                class="absolute inset-y-0 right-3 grid place-items-center px-2 text-[#77758d] transition hover:text-[#304cb2]"
                                aria-label="Tampilkan kata sandi" aria-pressed="false">
                                <svg data-eye-open class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <svg data-eye-closed class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <path d="m3 3 18 18" />
                                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                                    <path d="M9.9 4.2A10.7 10.7 0 0 1 12 4c6.5 0 10 8 10 8a17.7 17.7 0 0 1-2.1 3.2" />
                                    <path d="M6.6 6.6C3.7 8.5 2 12 2 12s3.5 8 10 8a10.3 10.3 0 0 0 5.4-1.6" />
                                </svg>
                            </button>
                        </div>
                    </label>

                    <div class="flex items-center justify-between gap-4 text-sm">
                        <label class="flex items-center gap-3 text-[#77758d]">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-[#ece7df]">
                            Ingat saya
                        </label>

                        <a href="{{ route('password.request') }}" class="font-black text-[#304cb2]">Lupa password?</a>
                    </div>

                    <div>
                        <div class="flex w-full items-stretch justify-center gap-3">
                            <div id="turnstile-widget" class="cf-turnstile"
                                data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                                data-size="normal"></div>

                            <button type="button" id="refresh-turnstile"
                                class="grid h-[65px] w-[52px] shrink-0 place-items-center rounded-xl border-2 border-[#ece7df] bg-white text-2xl font-black text-[#304cb2] transition hover:border-[#304cb2] hover:bg-[#f5f7ff]"
                                aria-label="Muat ulang captcha" title="Muat ulang captcha">
                                ↻
                            </button>
                        </div>

                        @error('cf-turnstile-response')
                            <p class="mt-2 text-sm font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="rounded-2xl bg-[#304cb2] px-5 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#273f96]">
                        Masuk
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-[#77758d]">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-black text-[#ff7424]">Daftar</a>
                </p>

                <div class="my-6 flex items-center gap-4">
                    <div class="h-px flex-1 bg-[#ece7df]"></div>
                    <span class="text-xs font-bold uppercase tracking-wide text-[#77758d]">atau lanjutkan dengan</span>
                    <div class="h-px flex-1 bg-[#ece7df]"></div>
                </div>

                <a href="{{ route('google.redirect') }}"
                    class="flex w-full items-center justify-center gap-3 rounded-2xl border-2 border-[#ece7df] bg-white px-5 py-4 font-black text-[#25233a] transition hover:-translate-y-0.5 hover:border-[#304cb2]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4"
                            d="M21.6 12.23c0-.71-.06-1.4-.18-2.07H12v3.92h5.39a4.61 4.61 0 0 1-2 3.02v2.51h3.24c1.9-1.75 2.97-4.33 2.97-7.38Z" />
                        <path fill="#34A853"
                            d="M12 22c2.7 0 4.97-.9 6.63-2.39l-3.24-2.51c-.9.6-2.05.96-3.39.96-2.61 0-4.82-1.76-5.61-4.13H3.05v2.59A10 10 0 0 0 12 22Z" />
                        <path fill="#FBBC05"
                            d="M6.39 13.93A6.02 6.02 0 0 1 6.07 12c0-.67.12-1.32.32-1.93V7.48H3.05A10 10 0 0 0 2 12c0 1.61.38 3.13 1.05 4.52l3.34-2.59Z" />
                        <path fill="#EA4335"
                            d="M12 5.94c1.47 0 2.79.51 3.83 1.5l2.87-2.87C16.96 2.95 14.7 2 12 2a10 10 0 0 0-8.95 5.48l3.34 2.59C7.18 7.7 9.39 5.94 12 5.94Z" />
                    </svg>
                    Google
                </a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-password-toggle]').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const input = document.getElementById(button.dataset.passwordToggle);

                        if (!input) {
                            return;
                        }

                        const isVisible = input.type === 'text';

                        input.type = isVisible ? 'password' : 'text';
                        button.setAttribute('aria-pressed', String(!isVisible));
                        button.setAttribute(
                            'aria-label',
                            isVisible ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi'
                        );

                        button.querySelector('[data-eye-open]')?.classList.toggle('hidden', !isVisible);
                        button.querySelector('[data-eye-closed]')?.classList.toggle('hidden',
                        isVisible);
                    });
                });

                document
                    .getElementById('refresh-turnstile')
                    ?.addEventListener('click', function() {
                        if (typeof turnstile !== 'undefined') {
                            turnstile.reset('#turnstile-widget');
                        }
                    });
            });
        </script>
    @endpush
@endsection

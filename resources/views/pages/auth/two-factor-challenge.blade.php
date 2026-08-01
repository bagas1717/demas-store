<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Dua Faktor — Demas Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#fff8ee] text-[#171936]">
    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">
            <a href="{{ url('/') }}" class="mb-6 flex items-center justify-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#3455c5] shadow-md">
                    <span class="text-xl font-black text-white">D</span>
                </div>

                <div class="text-left">
                    <h1 class="text-xl font-black tracking-tight text-[#171936]">
                        DEMAS <span class="text-[#ff6b1a]">STORE</span>
                    </h1>
                    <p class="text-xs text-[#77778e]">
                        Aplikasi premium terpercaya
                    </p>
                </div>
            </a>

            <div
                class="rounded-[28px] border-2 border-[#e8e4dc] bg-white p-6 shadow-[0_12px_30px_rgba(23,25,54,0.10)] sm:p-8">

                <div class="text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#fff0e5]">
                        <svg class="h-8 w-8 text-[#ff6b1a]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>

                    <p class="mt-5 text-xs font-black uppercase tracking-wider text-[#3455c5]">
                        Keamanan akun
                    </p>

                    <h2 class="mt-2 text-2xl font-black text-[#171936]">
                        Verifikasi Dua Faktor
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-[#77778e]">
                        Masukkan kode 6 digit dari aplikasi autentikator untuk melanjutkan ke akun Demas Store.
                    </p>
                </div>

                @if ($errors->any())
                    <div
                        class="mt-5 rounded-2xl border border-[#ffb4c7] bg-[#fff0f4] px-4 py-3 text-sm font-semibold text-[#b4234d]">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-7">
                    @csrf

                    <label for="code" class="mb-2 block text-sm font-bold text-[#171936]">
                        Kode autentikator
                    </label>

                    <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                        autofocus maxlength="6" placeholder="000000"
                        class="w-full rounded-2xl border-2 border-[#dfe4fa] bg-[#f7f8ff] px-4 py-4 text-center text-2xl font-black tracking-[0.35em] text-[#171936] outline-none transition placeholder:text-[#b9bdd0] focus:border-[#3455c5] focus:ring-4 focus:ring-[#3455c5]/10">

                    <button type="submit"
                        class="mt-5 w-full rounded-2xl bg-[#ff6b1a] px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-[#ff6b1a]/20 transition hover:-translate-y-0.5 hover:bg-[#f45f0c] active:translate-y-0">
                        Verifikasi dan Masuk
                    </button>
                </form>

                <div class="my-7 flex items-center gap-4">
                    <div class="h-px flex-1 bg-[#ece9e3]"></div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#9997a8]">
                        atau
                    </span>
                    <div class="h-px flex-1 bg-[#ece9e3]"></div>
                </div>

                <details class="group rounded-2xl border border-[#ece9e3] bg-[#fffaf3] p-4">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-center gap-2 text-sm font-bold text-[#3455c5]">
                        Gunakan recovery code

                        <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-5">
                        @csrf

                        <label for="recovery_code" class="mb-2 block text-sm font-bold text-[#171936]">
                            Recovery code
                        </label>

                        <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code"
                            placeholder="Masukkan recovery code"
                            class="w-full rounded-2xl border-2 border-[#dfe4fa] bg-white px-4 py-3.5 text-[#171936] outline-none transition placeholder:text-[#aaa8b8] focus:border-[#3455c5] focus:ring-4 focus:ring-[#3455c5]/10">

                        <button type="submit"
                            class="mt-4 w-full rounded-2xl bg-[#3455c5] px-5 py-3.5 text-sm font-black text-white transition hover:bg-[#2948b3]">
                            Masuk dengan Recovery Code
                        </button>
                    </form>
                </details>
            </div>

            <a href="{{ url('/') }}"
                class="mt-5 block text-center text-sm font-bold text-[#3455c5] hover:underline">
                Kembali ke beranda
            </a>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Dua Faktor — Demas Store</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-white">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10">

        {{-- Efek latar --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-violet-600/25 blur-3xl"></div>
            <div class="absolute -right-24 bottom-10 h-72 w-72 rounded-full bg-cyan-500/20 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/3 h-64 w-64 -translate-x-1/2 rounded-full bg-fuchsia-500/10 blur-3xl">
            </div>
        </div>

        <div class="relative w-full max-w-md">
            {{-- Logo / nama toko --}}
            <a href="{{ url('/') }}" class="mb-7 flex items-center justify-center gap-3">
                <div
                    class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 via-fuchsia-500 to-cyan-400 shadow-lg shadow-violet-500/20">
                    <span class="text-xl font-black text-white">D</span>
                </div>

                <div>
                    <h1 class="text-xl font-black tracking-tight">
                        Demas Store
                    </h1>
                    <p class="text-xs text-slate-400">
                        Aplikasi premium terpercaya
                    </p>
                </div>
            </a>

            <div
                class="rounded-3xl border border-white/10 bg-white/[0.07] p-6 shadow-2xl shadow-black/30 backdrop-blur-xl sm:p-8">

                <div class="text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500/25 to-cyan-400/20 ring-1 ring-white/10">
                        <svg class="h-8 w-8 text-violet-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>

                    <h2 class="mt-5 text-2xl font-black tracking-tight">
                        Verifikasi Dua Faktor
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Masukkan kode 6 digit dari aplikasi autentikator untuk melanjutkan ke akun Demas Store.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-2xl border border-red-400/20 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Kode autentikator --}}
                <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-7">
                    @csrf

                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-200">
                        Kode autentikator
                    </label>

                    <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                        autofocus maxlength="6" placeholder="000000"
                        class="w-full rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-4 text-center text-2xl font-bold tracking-[0.45em] text-white outline-none transition placeholder:text-slate-600 focus:border-violet-400 focus:ring-4 focus:ring-violet-500/10">

                    <button type="submit"
                        class="mt-5 w-full rounded-2xl bg-gradient-to-r from-violet-600 via-fuchsia-500 to-cyan-500 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-violet-600/20 transition hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0">
                        Verifikasi dan Masuk
                    </button>
                </form>

                <div class="my-7 flex items-center gap-4">
                    <div class="h-px flex-1 bg-white/10"></div>
                    <span class="text-xs font-medium uppercase tracking-wider text-slate-500">
                        atau
                    </span>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                {{-- Recovery code --}}
                <details class="group">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-center gap-2 text-sm font-semibold text-slate-300 transition hover:text-white">
                        Gunakan recovery code
                        <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>

                    <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-5">
                        @csrf

                        <label for="recovery_code" class="mb-2 block text-sm font-semibold text-slate-200">
                            Recovery code
                        </label>

                        <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code"
                            placeholder="Masukkan recovery code"
                            class="w-full rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3.5 text-white outline-none transition placeholder:text-slate-600 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-500/10">

                        <button type="submit"
                            class="mt-4 w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3.5 text-sm font-bold text-white transition hover:border-white/20 hover:bg-white/10">
                            Masuk dengan Recovery Code
                        </button>
                    </form>
                </details>
            </div>

            <p class="mt-6 text-center text-xs leading-5 text-slate-500">
                Keamanan akunmu adalah prioritas kami.
            </p>
        </div>
    </div>
</body>

</html>

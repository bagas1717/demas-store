@extends('layouts.account')

@section('title', 'Pengaturan Akun — Demas Store')

@section('content')
<div class="min-w-0">
    <a
        href="{{ route('account.dashboard') }}"
        class="inline-flex items-center gap-2 rounded-2xl border-2 border-[#dfe4ff] bg-white px-4 py-2.5 text-sm font-black text-[#304cb2] transition hover:bg-[#f7f8ff]"
    >
        <span aria-hidden="true">←</span>
        Dashboard
    </a>

    {{-- PROFIL --}}
    <section class="mt-7 border-b border-[#ddd8d0] pb-8">
        <h1 class="text-2xl font-black">Profil</h1>
        <p class="mt-2 text-sm leading-6 text-[#77758d]">
            Informasi ini bersifat pribadi. Pastikan data akun selalu benar dan jangan membagikan informasi sensitif.
        </p>

        @if (session('profile_success'))
            <div class="mt-5 rounded-2xl bg-green-50 p-4 text-sm font-bold text-green-700">
                {{ session('profile_success') }}
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('account.settings.profile') }}"
            class="mt-7 grid gap-5"
        >
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-black">Nama kamu</span>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        autocomplete="name"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                    >
                    @error('name')
                        <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-black">Username</span>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username', $user->username) }}"
                        placeholder="contoh: bagasputra"
                        autocomplete="username"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                    >
                    @error('username')
                        <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-black">Alamat Email</span>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        autocomplete="email"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                    >
                    @error('email')
                        <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-black">Nomor WhatsApp</span>
                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="+6281234567890"
                        autocomplete="tel"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                    >
                    @error('phone')
                        <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <button
                type="submit"
                class="w-fit rounded-2xl bg-[#ffd84d] px-6 py-3.5 font-black text-[#25233a] transition hover:-translate-y-0.5 hover:bg-[#ffcf1f]"
            >
                Ubah Profil
            </button>
        </form>
    </section>

    {{-- PASSWORD --}}
    <section class="border-b border-[#ddd8d0] py-8">
        <h2 class="text-xl font-black">Ubah Kata Sandi</h2>
        <p class="mt-2 text-sm leading-6 text-[#77758d]">
            Gunakan kata sandi yang kuat dan berbeda dari layanan lain.
        </p>

        @if (session('password_success'))
            <div class="mt-5 rounded-2xl bg-green-50 p-4 text-sm font-bold text-green-700">
                {{ session('password_success') }}
            </div>
        @endif

        @if ($user->provider === 'google' && blank($user->password))
            <div class="mt-6 rounded-2xl border-2 border-[#dfe4ff] bg-[#f7f8ff] p-5">
                <p class="font-black">Kata sandi dikelola melalui Google</p>
                <p class="mt-2 text-sm text-[#77758d]">
                    Akun ini tidak menggunakan kata sandi lokal Demas Store.
                </p>
            </div>
        @else
            <form
                method="POST"
                action="{{ route('account.settings.password') }}"
                class="mt-7 grid gap-5"
            >
                @csrf
                @method('PUT')

                <label class="grid gap-2">
                    <span class="text-sm font-black">Kata Sandi Saat Ini</span>
                    <input
                        type="password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        placeholder="Kata sandi saat ini"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                    >
                    @error('current_password')
                        <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                    @enderror
                </label>

                <div class="grid gap-5 md:grid-cols-2">
                    <label class="grid gap-2">
                        <span class="text-sm font-black">Kata Sandi Baru</span>
                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >
                        @error('password')
                            <span class="text-sm font-bold text-red-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-black">Konfirmasi Kata Sandi Baru</span>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi kata sandi baru"
                            class="rounded-2xl border-2 border-[#ece7df] bg-white px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-fit rounded-2xl bg-[#ff7424] px-6 py-3.5 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#e85e0c]"
                >
                    Ubah Kata Sandi
                </button>
            </form>
        @endif
    </section>

    {{-- TWO FACTOR --}}
    <section class="border-b border-[#ddd8d0] py-8">
        <h2 class="text-xl font-black">Two-Factor Authentication</h2>
        <p class="mt-2 text-sm leading-6 text-[#77758d]">
            Tambahkan lapisan keamanan menggunakan aplikasi authenticator.
        </p>

        @if (blank($user->two_factor_secret))
            <p class="mt-6 font-black text-red-500">
                Kamu belum mengaktifkan Two-Factor Authentication
            </p>

            <p class="mt-3 text-sm leading-6 text-[#77758d]">
                Setelah diaktifkan, kamu akan diminta memasukkan token acak dari Google Authenticator atau aplikasi serupa ketika login.
            </p>

            <form method="POST" action="{{ route('two-factor.enable') }}" class="mt-5">
                @csrf
                <button
                    type="submit"
                    class="rounded-2xl bg-[#ffd84d] px-6 py-3 font-black text-[#25233a]"
                >
                    Aktifkan
                </button>
            </form>
        @elseif (blank($user->two_factor_confirmed_at))
            <p class="mt-6 font-black text-[#ff7424]">
                Selesaikan aktivasi Two-Factor Authentication
            </p>

            <div class="mt-5 grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border-2 border-[#ece7df] bg-white p-5">
                    <p class="font-black">1. Pindai QR Code</p>
                    <div class="mt-4 w-fit rounded-2xl bg-white p-3">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                </div>

                <div class="rounded-3xl border-2 border-[#ece7df] bg-white p-5">
                    <p class="font-black">2. Masukkan kode autentikasi</p>

                    <form method="POST" action="{{ route('two-factor.confirm') }}" class="mt-4 grid gap-4">
                        @csrf
                        <input
                            type="text"
                            name="code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            placeholder="6 digit kode"
                            required
                            class="rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 outline-none focus:border-[#304cb2]"
                        >

                        <button
                            type="submit"
                            class="w-fit rounded-2xl bg-[#304cb2] px-5 py-3 font-black text-white"
                        >
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>

            <form method="POST" action="{{ route('two-factor.disable') }}" class="mt-5">
                @csrf
                @method('DELETE')

                <button type="submit" class="text-sm font-black text-red-500">
                    Batalkan aktivasi
                </button>
            </form>
        @else
            <div class="mt-6 flex flex-col gap-4 rounded-3xl border-2 border-green-200 bg-green-50 p-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="font-black text-green-700">Two-Factor Authentication aktif</p>
                    <p class="mt-1 text-sm text-green-700/80">
                        Akunmu dilindungi dengan kode autentikasi tambahan.
                    </p>
                </div>

                <form method="POST" action="{{ route('two-factor.disable') }}">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-2xl bg-red-500 px-5 py-3 text-sm font-black text-white"
                    >
                        Nonaktifkan
                    </button>
                </form>
            </div>

            <details class="mt-5 rounded-3xl border-2 border-[#ece7df] bg-white p-5">
                <summary class="cursor-pointer font-black">Lihat kode pemulihan</summary>

                <div class="mt-4 grid gap-2 rounded-2xl bg-[#f7f8ff] p-4 font-mono text-sm">
                    @foreach ((array) $user->recoveryCodes() as $code)
                        <span>{{ $code }}</span>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('two-factor.recovery-codes') }}" class="mt-4">
                    @csrf

                    <button type="submit" class="text-sm font-black text-[#304cb2]">
                        Buat ulang kode pemulihan
                    </button>
                </form>
            </details>
        @endif
    </section>

    {{-- PROVIDER --}}
    <section class="border-b border-[#ddd8d0] py-8">
        <h2 class="text-xl font-black">Hubungkan Akun</h2>
        <p class="mt-2 text-sm leading-6 text-[#77758d]">
            Hubungkan akun dengan provider lain untuk mempermudah proses autentikasi.
        </p>

        <div class="mt-6 flex items-center justify-between gap-4 rounded-3xl border-2 border-[#ece7df] bg-white p-5">
            <div class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#f7f8ff] font-black text-[#304cb2]">
                    G
                </span>

                <div>
                    <p class="font-black">Google</p>
                    <p class="mt-1 text-xs text-[#77758d]">
                        {{ $user->provider === 'google' ? 'Akun Google sudah terhubung.' : 'Belum terhubung.' }}
                    </p>
                </div>
            </div>

            @if ($user->provider === 'google')
                <span class="rounded-full bg-green-100 px-4 py-2 text-xs font-black text-green-700">
                    Terhubung
                </span>
            @else
                <a
                    href="{{ route('google.redirect') }}"
                    class="rounded-2xl bg-[#ffd84d] px-5 py-3 text-sm font-black text-[#25233a]"
                >
                    Hubungkan
                </a>
            @endif
        </div>
    </section>

    {{-- DEVICES --}}
    <section class="pt-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-black">Kelola Akses dan Perangkat</h2>
                <p class="mt-2 text-sm leading-6 text-[#77758d]">
                    Lihat browser dan perangkat yang masih aktif pada akun ini.
                </p>
            </div>

            @if ($sessions->where('id', '!=', $currentSessionId)->isNotEmpty())
                <form method="POST" action="{{ route('account.settings.sessions.destroy-others') }}">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rounded-2xl border-2 border-red-200 bg-red-50 px-5 py-3 text-sm font-black text-red-600"
                    >
                        Keluarkan Perangkat Lain
                    </button>
                </form>
            @endif
        </div>

        @if (session('session_success'))
            <div class="mt-5 rounded-2xl bg-green-50 p-4 text-sm font-bold text-green-700">
                {{ session('session_success') }}
            </div>
        @endif

        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @forelse ($sessions as $session)
                @php
                    $isCurrent = hash_equals($currentSessionId, $session->id);
                @endphp

                <article class="rounded-3xl border-2 border-[#ece7df] bg-white p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-black">
                                {{ $session->platform }} — {{ $session->browser }}
                            </p>

                            <div class="mt-4 grid gap-2 text-sm text-[#77758d]">
                                <p>IP: {{ $session->ip_address ?: 'Tidak tersedia' }}</p>
                                <p>
                                    Terakhir aktif:
                                    {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)
                                        ->timezone('Asia/Jakarta')
                                        ->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                        </div>

                        @if ($isCurrent)
                            <span class="shrink-0 rounded-full bg-[#e8f3ff] px-3 py-1 text-[10px] font-black text-[#304cb2]">
                                Perangkat Saat Ini
                            </span>
                        @endif
                    </div>

                    @unless ($isCurrent)
                        <form
                            method="POST"
                            action="{{ route('account.settings.sessions.destroy', $session->id) }}"
                            class="mt-5"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-sm font-black text-red-500">
                                Keluarkan perangkat
                            </button>
                        </form>
                    @endunless
                </article>
            @empty
                <div class="rounded-3xl border-2 border-dashed border-[#dfe4ff] bg-white p-8 text-center md:col-span-2">
                    <p class="font-black">Data sesi belum tersedia</p>
                    <p class="mt-2 text-sm text-[#77758d]">
                        Pastikan SESSION_DRIVER menggunakan database.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

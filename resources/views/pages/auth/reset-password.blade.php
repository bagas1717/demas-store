@extends('layouts.storefront')

@section('title', 'Reset Password — Demas Store')

@section('content')
<section class="px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-md">
        <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-3xl font-black text-[#25233a]">Buat Password Baru</h1>

            <p class="mt-2 text-sm leading-6 text-[#77758d]">
                Gunakan password baru yang kuat dan mudah kamu ingat.
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="mt-7 grid gap-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <label class="grid gap-2">
                    <span class="text-sm font-black text-[#25233a]">Email</span>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        required
                        readonly
                        autocomplete="email"
                        class="rounded-2xl border-2 border-[#ece7df] bg-[#f7f8ff] px-4 py-3 text-[#77758d] outline-none"
                    >
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-black text-[#25233a]">Password Baru</span>

                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Masukkan password baru"
                        class="rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2]"
                    >
                </label>

                <label class="grid gap-2">
                    <span class="text-sm font-black text-[#25233a]">Konfirmasi Password Baru</span>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi password baru"
                        class="rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2]"
                    >
                </label>

                <button
                    type="submit"
                    class="rounded-2xl bg-[#304cb2] px-5 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#273f96]"
                >
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

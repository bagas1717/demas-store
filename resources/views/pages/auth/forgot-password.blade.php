@extends('layouts.storefront')

@section('title', 'Lupa Password — Demas Store')

@section('content')
<section class="px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-md">
        <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-8">
            <a href="{{ route('login') }}" class="text-sm font-black text-[#304cb2]">
                ← Kembali ke halaman masuk
            </a>

            <h1 class="mt-5 text-3xl font-black text-[#25233a]">Lupa Password</h1>

            <p class="mt-2 text-sm leading-6 text-[#77758d]">
                Masukkan email akunmu. Kami akan mengirimkan tautan untuk membuat password baru.
            </p>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-bold text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-7 grid gap-5">
                @csrf

                <label class="grid gap-2">
                    <span class="text-sm font-black text-[#25233a]">Email</span>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2]"
                    >
                </label>

                <button
                    type="submit"
                    class="rounded-2xl bg-[#304cb2] px-5 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#273f96]"
                >
                    Kirim Link Reset Password
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

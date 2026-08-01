@extends('layouts.storefront')

@section('title', 'Verifikasi Email — Demas Store')

@section('content')

<section class="px-4 py-12 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-md">

        <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 text-center shadow-sm sm:p-8">

            <span class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-[#ffd84d] text-3xl">
                ✉️
            </span>

            <h1 class="mt-6 text-3xl font-black">
                Verifikasi emailmu
            </h1>

            <p class="mt-3 leading-7 text-[#77758d]">
                Kami telah mengirim link verifikasi ke:
            </p>

            <p class="mt-2 font-black text-[#304cb2]">
                {{ auth()->user()->email }}
            </p>

            <p class="mt-4 text-sm leading-6 text-[#77758d]">
                Buka email tersebut dan klik tombol verifikasi sebelum
                mengakses profil serta riwayat pesanan.
            </p>

            @if (session('status') === 'verification-link-sent')
                <div class="mt-6 rounded-2xl bg-green-50 p-4 text-sm font-bold text-green-700">
                    Link verifikasi baru berhasil dikirim.
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('verification.send') }}"
                class="mt-7"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-[#304cb2] px-6 py-4 font-black text-white"
                >
                    Kirim ulang email verifikasi
                </button>
            </form>

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-3"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-2xl border-2 border-[#ece7df] px-6 py-4 font-black"
                >
                    Keluar dari akun
                </button>
            </form>

        </div>

    </div>
</section>

@endsection
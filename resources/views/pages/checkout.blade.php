@extends('layouts.storefront')

@section('title', 'Checkout — Demas Store')

@section('content')

<section class="px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <div class="mb-8">
            <span class="text-sm font-black uppercase tracking-wider text-[#ff7424]">
                Selesaikan pesanan
            </span>

            <h1 class="mt-2 text-4xl font-black">
                Checkout
            </h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
                <strong>Periksa kembali data berikut:</strong>

                <ul class="mt-2 list-inside list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('checkout.store') }}"
            class="grid gap-6 lg:grid-cols-[1fr_380px]"
        >
            @csrf

            <div class="rounded-[28px] border-2 border-[#ece7df] bg-white p-5 sm:p-8">

                <h2 class="text-2xl font-black">
                    Data pembeli
                </h2>

                <p class="mt-2 text-sm text-[#77758d]">
                    Pastikan nomor WhatsApp aktif untuk menerima informasi pesanan.
                </p>

                <div class="mt-7 grid gap-5 sm:grid-cols-2">

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-sm font-black">
                            Nama pembeli
                        </span>

                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            required
                            autocomplete="name"
                            placeholder="Masukkan nama"
                            class="rounded-2xl border-2 border-[#ece7df] px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-black">
                            Nomor WhatsApp
                        </span>

                        <input
                            type="tel"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            required
                            autocomplete="tel"
                            placeholder="08xxxxxxxxxx"
                            class="rounded-2xl border-2 border-[#ece7df] px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-black">
                            Email
                            <small class="font-normal text-[#77758d]">
                                opsional
                            </small>
                        </span>

                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            autocomplete="email"
                            placeholder="nama@email.com"
                            class="rounded-2xl border-2 border-[#ece7df] px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >
                    </label>

                    <label class="grid gap-2 sm:col-span-2">
                        <span class="text-sm font-black">
                            Catatan pesanan
                            <small class="font-normal text-[#77758d]">
                                opsional
                            </small>
                        </span>

                        <textarea
                            name="customer_note"
                            rows="4"
                            placeholder="Contoh: kirim informasi akun melalui WhatsApp"
                            class="rounded-2xl border-2 border-[#ece7df] px-4 py-3 outline-none transition focus:border-[#304cb2]"
                        >{{ old('customer_note') }}</textarea>
                    </label>

                </div>
            </div>

            <aside class="h-fit rounded-[28px] bg-[#25233a] p-6 text-white lg:sticky lg:top-28">

                <h2 class="text-xl font-black">
                    Ringkasan pesanan
                </h2>

                <div class="mt-6 max-h-72 space-y-4 overflow-y-auto pr-2">
                    @foreach ($cart['items'] as $item)
                        @php
                            $variant = $item['variant'];
                        @endphp

                        <div class="flex justify-between gap-4 border-b border-white/10 pb-4">
                            <div>
                                <p class="text-sm font-black">
                                    {{ $variant->product->name }}
                                </p>

                                <p class="mt-1 text-xs text-white/50">
                                    {{ $variant->name }}
                                </p>

                                <p class="mt-1 text-xs text-white/50">
                                    {{ $item['quantity'] }} ×
                                    Rp{{ number_format($variant->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <strong class="shrink-0 text-sm">
                                Rp{{ number_format($item['line_total'], 0, ',', '.') }}
                            </strong>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-between text-sm text-white/60">
                    <span>Jumlah item</span>
                    <span>{{ $cart['count'] }}</span>
                </div>

                <div class="mt-3 flex justify-between text-sm text-white/60">
                    <span>Biaya layanan</span>
                    <span>Rp0</span>
                </div>

                <div class="my-6 border-t border-white/10"></div>

                <div class="flex items-end justify-between">
                    <span class="text-white/60">
                        Total
                    </span>

                    <strong class="text-2xl text-[#ffd84d]">
                        Rp{{ number_format($cart['subtotal'], 0, ',', '.') }}
                    </strong>
                </div>

                <button
                    type="submit"
                    class="mt-6 w-full rounded-2xl bg-[#ff7424] px-5 py-4 font-black transition hover:-translate-y-0.5"
                >
                    Buat pesanan
                </button>

                <p class="mt-4 text-center text-xs leading-5 text-white/40">
                    Pembayaran QRIS akan ditambahkan pada tahap berikutnya.
                </p>

            </aside>
        </form>

    </div>
</section>

@endsection
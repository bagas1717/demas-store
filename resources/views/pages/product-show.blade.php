@extends('layouts.storefront')

@section('title', $product->name . ' — Demas Store')

@section('content')

@php
    $accentColor = $product->accent_color ?: '#304CB2';
    $variants = $product->activeVariants;
@endphp

<section class="px-4 py-6 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <nav class="mb-5 flex flex-wrap items-center gap-2 text-sm text-[#77758d]">
            <a
                href="{{ route('home') }}"
                class="transition hover:text-[#304cb2]"
            >
                Beranda
            </a>

            <span>/</span>

            <span>
                {{ $product->category?->name ?? 'Produk' }}
            </span>

            <span>/</span>

            <span class="font-bold text-[#25233a]">
                {{ $product->name }}
            </span>
        </nav>

        <div class="grid gap-6 lg:grid-cols-[0.85fr_1.15fr]">

            <div class="space-y-4">

                <div
                    class="relative grid min-h-[360px] place-items-center overflow-hidden rounded-[32px] border-2 border-white bg-white p-8 shadow-sm"
                    style="background-color: {{ $accentColor }}18"
                >
                    <div
                        class="absolute -right-20 -top-20 h-64 w-64 rounded-full"
                        style="background-color: {{ $accentColor }}15"
                    ></div>

                    @if ($product->logo_path)
                        <img
                            src="{{ asset('storage/' . $product->logo_path) }}"
                            alt="{{ $product->name }}"
                            class="relative z-10 h-44 w-44 rounded-[36px] object-contain drop-shadow-xl sm:h-56 sm:w-56"
                        >
                    @else
                        <div
                            class="relative z-10 grid h-44 w-44 place-items-center rounded-[36px] text-6xl font-black text-white shadow-xl sm:h-56 sm:w-56"
                            style="background-color: {{ $accentColor }}"
                        >
                            {{ mb_substr($product->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                @if ($product->banner_path)
                    <img
                        src="{{ asset('storage/' . $product->banner_path) }}"
                        alt="Banner {{ $product->name }}"
                        class="w-full rounded-[28px] object-cover"
                    >
                @endif

            </div>

            <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-5 sm:p-8">

                <span
                    class="inline-flex rounded-full px-4 py-2 text-xs font-black"
                    style="background-color: {{ $accentColor }}20; color: {{ $accentColor }}"
                >
                    {{ $product->category?->name ?? 'Aplikasi Premium' }}
                </span>

                <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                    {{ $product->name }}
                </h1>

                <p class="mt-4 max-w-2xl leading-7 text-[#77758d]">
                    {{ $product->description ?: $product->short_description }}
                </p>

                <div class="mt-8">

                    <div class="mb-4 flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm font-black uppercase tracking-wider text-[#ff7424]">
                                Pilihan paket
                            </p>

                            <h2 class="mt-1 text-2xl font-black">
                                Pilih sesuai kebutuhanmu
                            </h2>
                        </div>

                        <span class="text-sm text-[#77758d]">
                            {{ $variants->count() }} paket
                        </span>
                    </div>

                    @if ($variants->isEmpty())
                        <div class="rounded-2xl border-2 border-dashed border-[#dfe4ff] p-8 text-center">
                            <p class="font-black">
                                Paket belum tersedia
                            </p>

                            <p class="mt-2 text-sm text-[#77758d]">
                                Silakan kembali lagi nanti.
                            </p>
                        </div>
                    @else
                        <div class="grid gap-3">
                            @foreach ($variants as $variant)
                                <label
                                    class="variant-option relative cursor-pointer rounded-2xl border-2 border-[#ece7df] p-4 transition hover:border-[#304cb2]"
                                    data-variant-id="{{ $variant->id }}"
                                    data-name="{{ $variant->name }}"
                                    data-price="{{ $variant->price }}"
                                    data-stock="{{ $variant->stock }}"
                                >
                                    <input
                                        type="radio"
                                        name="variant_id"
                                        value="{{ $variant->id }}"
                                        class="peer sr-only"
                                        @disabled($variant->stock <= 0)
                                    >

                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h3 class="font-black">
                                                    {{ $variant->name }}
                                                </h3>

                                                @if ($variant->is_popular)
                                                    <span class="rounded-full bg-[#ffd84d] px-2.5 py-1 text-[10px] font-black">
                                                        Populer
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="mt-2 flex flex-wrap gap-2 text-xs text-[#77758d]">

                                                @if ($variant->account_type)
                                                    <span class="rounded-full bg-[#f4f2ff] px-3 py-1.5">
                                                        {{ ucfirst(str_replace('_', ' ', $variant->account_type)) }}
                                                    </span>
                                                @endif

                                                @if ($variant->duration_value && $variant->duration_unit)
                                                    <span class="rounded-full bg-[#fff3e8] px-3 py-1.5">
                                                        {{ $variant->duration_value }}

                                                        @switch($variant->duration_unit)
                                                            @case('day')
                                                                Hari
                                                                @break
                                                            @case('week')
                                                                Minggu
                                                                @break
                                                            @case('month')
                                                                Bulan
                                                                @break
                                                            @case('year')
                                                                Tahun
                                                                @break
                                                            @default
                                                                {{ ucfirst($variant->duration_unit) }}
                                                        @endswitch
                                                    </span>
                                                @elseif ($variant->duration_unit === 'lifetime')
                                                    <span class="rounded-full bg-[#fff3e8] px-3 py-1.5">
                                                        Lifetime
                                                    </span>
                                                @endif

                                                @if ($variant->user_limit)
                                                    <span class="rounded-full bg-[#ecfae8] px-3 py-1.5">
                                                        {{ $variant->user_limit }} pengguna
                                                    </span>
                                                @endif

                                                @if ($variant->profile_limit)
                                                    <span class="rounded-full bg-[#e8f3ff] px-3 py-1.5">
                                                        {{ $variant->profile_limit }} profil
                                                    </span>
                                                @endif

                                            </div>

                                            @if ($variant->stock <= 0)
                                                <p class="mt-3 text-xs font-black text-red-500">
                                                    Stok habis
                                                </p>
                                            @elseif ($variant->stock <= $variant->minimum_stock)
                                                <p class="mt-3 text-xs font-black text-[#ff7424]">
                                                    Tersisa {{ $variant->stock }}
                                                </p>
                                            @else
                                                <p class="mt-3 text-xs font-bold text-green-600">
                                                    Stok tersedia: {{ $variant->stock }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="shrink-0 sm:text-right">
                                            @if ($variant->compare_price && $variant->compare_price > $variant->price)
                                                <p class="text-sm text-[#aaa6b3] line-through">
                                                    Rp{{ number_format($variant->compare_price, 0, ',', '.') }}
                                                </p>
                                            @endif

                                            <strong class="text-xl text-[#304cb2]">
                                                Rp{{ number_format($variant->price, 0, ',', '.') }}
                                            </strong>
                                        </div>

                                    </div>

                                    <div class="pointer-events-none absolute inset-0 rounded-2xl border-[3px] border-transparent peer-checked:border-[#304cb2]"></div>
                                </label>
                            @endforeach
                        </div>
                    @endif

                </div>

                <div
                    id="selectedPackage"
                    class="mt-6 hidden rounded-2xl bg-[#f7f8ff] p-5"
                >
                    <p class="text-xs font-black uppercase tracking-wider text-[#77758d]">
                        Paket dipilih
                    </p>

                    <div class="mt-2 flex items-center justify-between gap-4">
                        <strong id="selectedPackageName"></strong>

                        <strong
                            id="selectedPackagePrice"
                            class="text-[#304cb2]"
                        ></strong>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">

                    <button
                        id="addToCartButton"
                        type="button"
                        disabled
                        class="w-full rounded-2xl border-2 border-[#304cb2] px-6 py-4 font-black text-[#304cb2] transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:border-gray-300 disabled:text-gray-400"
                    >
                        Pilih paket terlebih dahulu
                    </button>

                    <form
                        id="buyNowForm"
                        method="POST"
                        action=""
                    >
                        @csrf

                        <button
                            id="buyNowButton"
                            type="submit"
                            disabled
                            class="w-full rounded-2xl bg-[#ff7424] px-6 py-4 font-black text-white transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:bg-gray-300"
                        >
                            Beli Sekarang
                        </button>
                    </form>

                </div>

                @if ($product->instructions || $product->terms)
                    <div class="mt-8 grid gap-4">

                        @if ($product->instructions)
                            <details class="rounded-2xl border border-[#ece7df] p-4">
                                <summary class="cursor-pointer font-black">
                                    Cara aktivasi
                                </summary>

                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#77758d]">
                                    {{ $product->instructions }}
                                </p>
                            </details>
                        @endif

                        @if ($product->terms)
                            <details class="rounded-2xl border border-[#ece7df] p-4">
                                <summary class="cursor-pointer font-black">
                                    Syarat dan ketentuan
                                </summary>

                                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-[#77758d]">
                                    {{ $product->terms }}
                                </p>
                            </details>
                        @endif

                    </div>
                @endif

            </div>

        </div>

    </div>
</section>

@if ($relatedProducts->isNotEmpty())
    <section class="px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <h2 class="text-3xl font-black">
                Produk serupa
            </h2>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relatedProducts as $relatedProduct)
                    <x-storefront.product-card :product="$relatedProduct" />
                @endforeach
            </div>

        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    const variantOptions = document.querySelectorAll(
        'input[name="variant_id"]'
    );

    const selectedPackage = document.getElementById(
        'selectedPackage'
    );

    const selectedPackageName = document.getElementById(
        'selectedPackageName'
    );

    const selectedPackagePrice = document.getElementById(
        'selectedPackagePrice'
    );

    const addToCartButton = document.getElementById(
        'addToCartButton'
    );

    const buyNowForm = document.getElementById(
        'buyNowForm'
    );

    const buyNowButton = document.getElementById(
        'buyNowButton'
    );

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(number);
    };

    variantOptions.forEach((option) => {
        option.addEventListener('change', () => {
            const wrapper = option.closest('.variant-option');

            selectedPackage.classList.remove('hidden');

            selectedPackageName.textContent =
                wrapper.dataset.name;

            selectedPackagePrice.textContent =
                formatRupiah(Number(wrapper.dataset.price));

            addToCartButton.disabled = false;
            addToCartButton.textContent =
                'Tambah ke keranjang';

            addToCartButton.dataset.variantId =
                wrapper.dataset.variantId;

            buyNowButton.disabled = false;

            buyNowForm.action =
                `/beli-sekarang/${wrapper.dataset.variantId}`;
        });
    });

    addToCartButton.addEventListener('click', async () => {
    const variantId = addToCartButton.dataset.variantId;

    if (!variantId) {
        return;
    }

    addToCartButton.disabled = true;
    addToCartButton.textContent = 'Menambahkan...';

    try {
        const response = await fetch(
            `/keranjang/${variantId}`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    quantity: 1,
                }),
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message ?? 'Paket gagal ditambahkan.'
            );
        }

        const headerCartCount = document.getElementById(
            'headerCartCount'
        );

        if (headerCartCount) {
            headerCartCount.textContent = data.cart_count;
        }

        addToCartButton.textContent = 'Berhasil ditambahkan ✓';

        setTimeout(() => {
            addToCartButton.disabled = false;
            addToCartButton.textContent = 'Tambah ke keranjang';
        }, 1400);
        } catch (error) {
            alert(error.message);

            addToCartButton.disabled = false;
            addToCartButton.textContent = 'Tambah ke keranjang';
        }
    });
</script>
@endpush
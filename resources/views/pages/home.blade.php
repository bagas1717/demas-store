@extends('layouts.storefront')

@section('title', 'Demas Store — Aplikasi Premium')

@section('content')

    @if ($heroBanners->isNotEmpty())
        <section class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">

                @foreach ($heroBanners as $banner)
                    <a href="{{ filled($banner->link) ? $banner->link : '#katalog' }}"
                        class="block overflow-hidden rounded-[32px]">
                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}"
                            class="block h-auto w-full object-cover">
                    </a>
                @endforeach

            </div>
        </section>
    @else
        <section class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">

                <div
                    class="relative overflow-hidden rounded-[32px] bg-[#304cb2] px-7 py-8 text-white sm:px-10 sm:py-10 lg:px-16 lg:py-12">

                    <div class="relative z-10 max-w-2xl">

                        <span class="inline-flex rounded-full bg-[#ffd84d] px-4 py-2 text-xs font-black text-[#25233a]">
                            APLIKASI PREMIUM
                        </span>

                        <h1 class="mt-5 text-4xl font-black leading-[0.95] tracking-tight sm:text-6xl lg:text-7xl">
                            Premium makin mudah, harga tetap ramah.
                        </h1>

                        <p class="mt-4 max-w-xl text-sm leading-7 text-white/75 sm:text-base">
                            Netflix, Canva, CapCut, Spotify, dan berbagai aplikasi premium lainnya dalam satu tempat.
                        </p>

                        <a href="#katalog"
                            class="mt-6 inline-flex rounded-2xl bg-[#ff7424] px-6 py-3.5 font-black text-white transition hover:-translate-y-1">
                            Lihat Katalog
                        </a>

                    </div>

                    <div class="absolute -bottom-28 -right-20 h-64 w-64 rounded-full bg-[#ff8fab]"></div>

                    <div class="absolute right-32 top-10 h-16 w-16 rotate-12 rounded-3xl bg-[#ffd84d]"></div>

                    <div class="absolute bottom-8 right-80 hidden h-14 w-14 -rotate-12 rounded-full bg-[#9be28f] lg:block">
                    </div>

                </div>

            </div>
        </section>
    @endif

    @if ($popularProducts->isNotEmpty())
        <section id="populer" class="px-4 py-10 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">

                <div class="mb-6">
                    <span class="text-sm font-black uppercase tracking-wider text-[#ff7424]">
                        Pilihan favorit
                    </span>

                    <h2 class="mt-2 text-3xl font-black sm:text-4xl">
                        Populer sekarang!
                    </h2>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($popularProducts as $product)
                        <x-storefront.product-card :product="$product" />
                    @endforeach
                </div>

            </div>
        </section>
    @endif

    <section id="katalog" class="px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">

            <div class="mb-7 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">

                <div>
                    <span class="text-sm font-black uppercase tracking-wider text-[#304cb2]">
                        Semua produk
                    </span>

                    <h2 class="mt-2 text-3xl font-black sm:text-4xl">
                        Pilih aplikasi favoritmu
                    </h2>
                </div>

                <div class="flex gap-2 overflow-x-auto pb-2">
                    @foreach ($categories as $category)
                        <span class="shrink-0 rounded-full px-4 py-2 text-xs font-black"
                            style="background-color: {{ $category->color ?: '#ffd84d' }}30">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>

            </div>

            @if ($products->isEmpty())
                <div class="rounded-[28px] border-2 border-dashed border-[#dfe4ff] bg-white p-12 text-center">
                    <h3 class="text-xl font-black">
                        Belum ada produk
                    </h3>

                    <p class="mt-2 text-[#77758d]">
                        Tambahkan produk dan paket melalui panel admin.
                    </p>
                </div>
            @else
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($products as $product)
                        <x-storefront.product-card :product="$product" />
                    @endforeach
                </div>
            @endif

        </div>
    </section>

@endsection

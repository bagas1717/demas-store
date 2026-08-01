@props(['product'])

@php
    $activeVariants = $product->activeVariants;

    $minimumPrice = $activeVariants->min('price');

    $totalStock = $activeVariants->sum('stock');

    $variantCount = $activeVariants->count();

    $accentColor = $product->accent_color ?: '#304CB2';
@endphp

<article class="group overflow-hidden rounded-[28px] border-2 border-[#ece7df] bg-white p-3 transition duration-200 hover:-translate-y-1 hover:shadow-xl">

    <div
        class="relative grid aspect-[4/3] place-items-center overflow-hidden rounded-[22px]"
        style="background-color: {{ $accentColor }}20"
    >
        @if ($product->is_popular)
            <span class="absolute left-3 top-3 rounded-full bg-[#ffd84d] px-3 py-1.5 text-xs font-black">
                Populer
            </span>
        @endif

        @if ($totalStock <= 0)
            <span class="absolute right-3 top-3 rounded-full bg-[#ff8fab] px-3 py-1.5 text-xs font-black text-white">
                Habis
            </span>
        @elseif ($totalStock <= 3)
            <span class="absolute right-3 top-3 rounded-full bg-[#ff7424] px-3 py-1.5 text-xs font-black text-white">
                Tersisa {{ $totalStock }}
            </span>
        @else
            <span class="absolute right-3 top-3 rounded-full bg-[#9be28f] px-3 py-1.5 text-xs font-black">
                Stok {{ $totalStock }}
            </span>
        @endif

        @if ($product->logo_path)
            <img
                src="{{ asset('storage/' . $product->logo_path) }}"
                alt="{{ $product->name }}"
                class="h-28 w-28 rounded-3xl object-contain transition duration-300 group-hover:scale-105"
            >
        @else
            <div
                class="grid h-28 w-28 place-items-center rounded-3xl text-4xl font-black text-white shadow-lg"
                style="background-color: {{ $accentColor }}"
            >
                {{ mb_substr($product->name, 0, 1) }}
            </div>
        @endif
    </div>

    <div class="p-3">

        <p class="text-xs font-bold uppercase tracking-wider text-[#8b8799]">
            {{ $product->category?->name ?? 'Aplikasi Premium' }}
        </p>

        <h3 class="mt-2 text-lg font-black">
            {{ $product->name }}
        </h3>

        <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-[#77758d]">
            {{ $product->short_description ?: 'Pilih paket sesuai kebutuhanmu.' }}
        </p>

        <div class="mt-5 flex items-end justify-between gap-3">

            <div>
                <p class="text-xs text-[#8b8799]">
                    Mulai dari
                </p>

                <strong class="text-lg text-[#304cb2]">
                    @if ($minimumPrice)
                        Rp{{ number_format($minimumPrice, 0, ',', '.') }}
                    @else
                        Belum tersedia
                    @endif
                </strong>

                <p class="mt-1 text-xs text-[#8b8799]">
                    {{ $variantCount }} pilihan paket
                </p>
            </div>

            @if ($variantCount > 0)
                <a
                    href="{{ route('products.show', $product) }}"
                    class="rounded-2xl bg-[#ff7424] px-4 py-3 text-center text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-[#e95d0b]"
                >
                    Lihat Paket
                </a>
            @else
                <span
                    class="cursor-not-allowed rounded-2xl bg-gray-300 px-4 py-3 text-center text-sm font-black text-white"
                >
                    Belum Tersedia
                </span>
            @endif

        </div>

    </div>
</article>
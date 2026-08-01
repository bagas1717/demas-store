@extends('layouts.storefront')

@section('title', 'Keranjang — Demas Store')

@section('content')

<section class="px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl">

        <div class="mb-8">
            <span class="text-sm font-black uppercase tracking-wider text-[#ff7424]">
                Belanjaanmu
            </span>

            <h1 class="mt-2 text-4xl font-black tracking-tight">
                Keranjang
            </h1>
        </div>

        @if ($cart['items']->isEmpty())
            <div class="rounded-[32px] border-2 border-dashed border-[#dfe4ff] bg-white p-12 text-center">
                <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-[#ffd84d] text-3xl">
                    🛒
                </div>

                <h2 class="mt-6 text-2xl font-black">
                    Keranjang masih kosong
                </h2>

                <p class="mt-2 text-[#77758d]">
                    Pilih paket aplikasi yang kamu butuhkan.
                </p>

                <a
                    href="{{ route('home') }}#katalog"
                    class="mt-6 inline-flex rounded-2xl bg-[#304cb2] px-6 py-4 font-black text-white"
                >
                    Lihat katalog
                </a>
            </div>
        @else
            <div class="grid gap-6 lg:grid-cols-[1fr_360px]">

                <div class="space-y-4">
                    @foreach ($cart['items'] as $item)
                        @php
                            $variant = $item['variant'];
                            $product = $variant->product;
                        @endphp

                        <article
                            id="cart-item-{{ $variant->id }}"
                            class="grid gap-4 rounded-[28px] border-2 border-[#ece7df] bg-white p-4 sm:grid-cols-[96px_1fr_auto] sm:items-center"
                        >
                            <div
                                class="grid aspect-square place-items-center rounded-2xl"
                                style="background-color: {{ ($product->accent_color ?: '#304CB2') }}18"
                            >
                                @if ($product->logo_path)
                                    <img
                                        src="{{ asset('storage/' . $product->logo_path) }}"
                                        alt="{{ $product->name }}"
                                        class="h-16 w-16 rounded-2xl object-contain"
                                    >
                                @else
                                    <strong class="text-3xl">
                                        {{ mb_substr($product->name, 0, 1) }}
                                    </strong>
                                @endif
                            </div>

                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-[#8b8799]">
                                    {{ $product->name }}
                                </p>

                                <h2 class="mt-1 font-black">
                                    {{ $variant->name }}
                                </h2>

                                <p class="mt-2 text-lg font-black text-[#304cb2]">
                                    Rp{{ number_format($variant->price, 0, ',', '.') }}
                                </p>

                                <p class="mt-1 text-xs text-[#77758d]">
                                    Stok tersedia: {{ $variant->stock }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between gap-4 sm:flex-col sm:items-end">
                                <div class="flex items-center rounded-xl border border-[#ece7df]">
                                    <button
                                        type="button"
                                        class="cart-decrease grid h-10 w-10 place-items-center font-black"
                                        data-id="{{ $variant->id }}"
                                    >
                                        −
                                    </button>

                                    <span
                                        id="quantity-{{ $variant->id }}"
                                        class="min-w-10 text-center font-black"
                                    >
                                        {{ $item['quantity'] }}
                                    </span>

                                    <button
                                        type="button"
                                        class="cart-increase grid h-10 w-10 place-items-center font-black"
                                        data-id="{{ $variant->id }}"
                                        data-stock="{{ $variant->stock }}"
                                    >
                                        +
                                    </button>
                                </div>

                                <button
                                    type="button"
                                    class="cart-remove text-sm font-black text-red-500"
                                    data-id="{{ $variant->id }}"
                                >
                                    Hapus
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="h-fit rounded-[28px] bg-[#25233a] p-6 text-white lg:sticky lg:top-28">

                    <h2 class="text-xl font-black">
                        Ringkasan belanja
                    </h2>

                    <div class="mt-6 space-y-4 text-sm">
                        <div class="flex justify-between text-white/60">
                            <span>Jumlah item</span>
                            <span id="summaryCount">
                                {{ $cart['count'] }}
                            </span>
                        </div>

                        <div class="flex justify-between text-white/60">
                            <span>Biaya layanan</span>
                            <span>Rp0</span>
                        </div>
                    </div>

                    <div class="my-6 border-t border-white/10"></div>

                    <div class="flex items-end justify-between gap-4">
                        <span class="text-white/60">Subtotal</span>

                        <strong
                            id="summarySubtotal"
                            class="text-2xl text-[#ffd84d]"
                        >
                            Rp{{ number_format($cart['subtotal'], 0, ',', '.') }}
                        </strong>
                    </div>

                    <a
                        href="{{ route('checkout.create') }}"
                        class="mt-6 block w-full rounded-2xl bg-[#ff7424] px-5 py-4 text-center font-black transition hover:-translate-y-0.5"
                    >
                        Lanjut checkout
                    </a>

                    <p class="mt-4 text-center text-xs leading-5 text-white/40">
                        Stok akan diperiksa kembali saat checkout.
                    </p>
                </aside>

            </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    const formatRupiah = (value) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0,
        }).format(value);
    };

    async function updateCartItem(variantId, quantity) {
        const response = await fetch(
            `/keranjang/${variantId}`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ quantity }),
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message ?? 'Keranjang gagal diperbarui.'
            );
        }

        window.location.reload();
    }

    async function removeCartItem(variantId) {
        const response = await fetch(
            `/keranjang/${variantId}`,
            {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            }
        );

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message ?? 'Paket gagal dihapus.'
            );
        }

        window.location.reload();
    }

    document.querySelectorAll('.cart-increase')
        .forEach((button) => {
            button.addEventListener('click', async () => {
                const id = button.dataset.id;
                const stock = Number(button.dataset.stock);
                const quantityElement = document.getElementById(
                    `quantity-${id}`
                );

                const currentQuantity = Number(
                    quantityElement.textContent.trim()
                );

                if (currentQuantity >= stock) {
                    alert('Jumlah sudah mencapai batas stok.');
                    return;
                }

                try {
                    await updateCartItem(
                        id,
                        currentQuantity + 1
                    );
                } catch (error) {
                    alert(error.message);
                }
            });
        });

    document.querySelectorAll('.cart-decrease')
        .forEach((button) => {
            button.addEventListener('click', async () => {
                const id = button.dataset.id;
                const quantityElement = document.getElementById(
                    `quantity-${id}`
                );

                const currentQuantity = Number(
                    quantityElement.textContent.trim()
                );

                if (currentQuantity <= 1) {
                    await removeCartItem(id);
                    return;
                }

                try {
                    await updateCartItem(
                        id,
                        currentQuantity - 1
                    );
                } catch (error) {
                    alert(error.message);
                }
            });
        });

    document.querySelectorAll('.cart-remove')
        .forEach((button) => {
            button.addEventListener('click', async () => {
                if (!confirm('Hapus paket ini dari keranjang?')) {
                    return;
                }

                try {
                    await removeCartItem(button.dataset.id);
                } catch (error) {
                    alert(error.message);
                }
            });
        });
</script>
@endpush
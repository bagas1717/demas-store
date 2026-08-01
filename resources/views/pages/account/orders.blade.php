@extends('layouts.account')

@section('title', 'Riwayat Pesanan — Demas Store')
@section('account-heading', 'Riwayat Pesanan')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-black uppercase tracking-wider text-[#ff7424]">
                Akun Saya
            </p>

            <h1 class="mt-2 text-3xl font-black sm:text-4xl">
                Riwayat Pesanan
            </h1>

            <p class="mt-2 text-sm text-[#77758d]">
                Lihat status pembayaran dan proses seluruh pesananmu.
            </p>
        </div>

        <a
            href="{{ route('home') }}#katalog"
            class="w-fit rounded-2xl bg-[#ffd84d] px-5 py-3 text-sm font-black"
        >
            Belanja Lagi
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-[28px] border-2 border-[#ece7df] bg-white">
        @forelse ($orders as $order)
            <article class="border-b border-[#ece7df] p-5 last:border-b-0 sm:p-6">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase text-[#77758d]">
                            Nomor Pesanan
                        </p>

                        <h2 class="mt-1 font-black">
                            {{ $order->order_number }}
                        </h2>

                        <p class="mt-2 text-sm text-[#77758d]">
                            {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                            · {{ $order->items_count }} item
                        </p>
                    </div>

                    <div class="sm:text-right">
                        <p class="text-xl font-black text-[#304cb2]">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </p>

                        <div class="mt-2 flex flex-wrap gap-2 sm:justify-end">
                            <span class="rounded-full bg-[#fff3d6] px-3 py-1 text-xs font-black">
                                {{ match ($order->payment_status) {
                                    'paid' => 'Dibayar',
                                    'expired' => 'Kedaluwarsa',
                                    'failed' => 'Gagal',
                                    'refunded' => 'Dikembalikan',
                                    default => 'Belum Dibayar',
                                } }}
                            </span>

                            <span class="rounded-full bg-[#e8f3ff] px-3 py-1 text-xs font-black">
                                {{ match ($order->status) {
                                    'processing' => 'Diproses',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    default => 'Menunggu Pembayaran',
                                } }}
                            </span>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('account.orders.show', $order) }}"
                    class="mt-5 inline-flex rounded-2xl bg-[#304cb2] px-5 py-3 text-sm font-black text-white transition hover:-translate-y-0.5"
                >
                    Lihat Detail
                </a>
            </article>
        @empty
            <div class="p-12 text-center">
                <h2 class="text-2xl font-black">Belum ada pesanan</h2>
                <p class="mt-2 text-[#77758d]">
                    Pesanan yang dibuat saat login akan muncul di sini.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection

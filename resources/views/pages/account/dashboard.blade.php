@extends('layouts.account')

@section('title', 'Dashboard Akun — Demas Store')
@section('account-heading', 'Dashboard')

@section('content')
<div class="mx-auto max-w-7xl">

    {{-- BANNER INFORMASI --}}
    <section class="rounded-[28px] bg-[#2da6df] p-6 text-white shadow-sm sm:p-7">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-black">Tingkatkan keamanan akunmu</h1>
                <p class="mt-2 text-sm text-white/80">
                    Pastikan email terverifikasi dan gunakan password yang kuat.
                </p>
            </div>

            <a
                href="{{ route('account.settings.edit') }}"
                class="w-fit rounded-2xl bg-white px-5 py-3 text-sm font-black text-[#304cb2]"
            >
                Buka Pengaturan
            </a>
        </div>
    </section>

    {{-- PROFIL + RINGKASAN --}}
    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <section class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6">
            <div class="flex items-center gap-4">
                @if (auth()->user()->avatar)
                    <img
                        src="{{ auth()->user()->avatar }}"
                        alt="{{ auth()->user()->name }}"
                        class="h-16 w-16 rounded-2xl object-cover"
                        referrerpolicy="no-referrer"
                    >
                @else
                    <span class="grid h-16 w-16 place-items-center rounded-2xl bg-[#ffd84d] text-xl font-black">
                        {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif

                <div class="min-w-0">
                    <h2 class="truncate text-xl font-black">{{ auth()->user()->name }}</h2>
                    <p class="mt-1 truncate text-sm text-[#77758d]">{{ auth()->user()->email }}</p>

                    <span class="mt-3 inline-flex rounded-full bg-[#e8f3ff] px-3 py-1 text-xs font-black text-[#304cb2]">
                        {{ auth()->user()->is_admin ? 'Administrator' : 'Member' }}
                    </span>
                </div>
            </div>

            <a
                href="{{ route('account.settings.edit') }}"
                class="mt-5 inline-flex rounded-2xl bg-[#304cb2] px-5 py-3 text-sm font-black text-white"
            >
                Kelola Profil
            </a>
        </section>

        <section class="rounded-[28px] bg-[#3f3949] p-6 text-white">
            <p class="text-sm font-bold text-white/65">Total Belanja</p>
            <p class="mt-3 text-3xl font-black text-[#ffd84d]">
                Rp{{ number_format($totalSpent, 0, ',', '.') }}
            </p>

            <div class="mt-5 flex items-center justify-between border-t border-white/10 pt-5">
                <span class="text-sm text-white/70">Jumlah Pesanan</span>
                <span class="text-xl font-black">{{ $totalOrders }}</span>
            </div>
        </section>
    </div>

    {{-- STATISTIK --}}
    <section class="mt-8">
        <h2 class="text-2xl font-black">Ringkasan Pesanan</h2>

        <div class="mt-5 grid gap-4 sm:grid-cols-2">
            <div class="rounded-[26px] bg-[#2b2732] p-6 text-center text-white">
                <p class="text-4xl font-black">{{ $totalOrders }}</p>
                <p class="mt-3 text-sm font-bold text-white/70">Total Pesanan</p>
            </div>

            <div class="rounded-[26px] bg-[#2b2732] p-6 text-center text-white">
                <p class="text-3xl font-black">
                    Rp{{ number_format($totalSpent, 0, ',', '.') }}
                </p>
                <p class="mt-3 text-sm font-bold text-white/70">Total Belanja</p>
            </div>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-[24px] border-2 border-[#e6b900] bg-[#c6a33a] p-5 text-center text-white">
                <p class="text-3xl font-black">{{ $pendingOrders }}</p>
                <p class="mt-3 text-sm font-bold">Menunggu</p>
            </div>

            <div class="rounded-[24px] border-2 border-[#20a7ea] bg-[#3388ae] p-5 text-center text-white">
                <p class="text-3xl font-black">{{ $processingOrders }}</p>
                <p class="mt-3 text-sm font-bold">Dalam Proses</p>
            </div>

            <div class="rounded-[24px] border-2 border-[#21c56c] bg-[#348c5d] p-5 text-center text-white">
                <p class="text-3xl font-black">{{ $completedOrders }}</p>
                <p class="mt-3 text-sm font-bold">Selesai</p>
            </div>

            <div class="rounded-[24px] border-2 border-[#d43179] bg-[#91355f] p-5 text-center text-white">
                <p class="text-3xl font-black">{{ $cancelledOrders }}</p>
                <p class="mt-3 text-sm font-bold">Dibatalkan</p>
            </div>
        </div>
    </section>

    {{-- PESANAN TERBARU --}}
    <section class="mt-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black">Pesanan Terbaru</h2>
                <p class="mt-1 text-sm text-[#77758d]">
                    Lima pesanan terbaru dari akunmu.
                </p>
            </div>

            <a
                href="{{ route('account.orders.index') }}"
                class="text-sm font-black text-[#304cb2]"
            >
                Lihat Semua
            </a>
        </div>

        <div class="mt-5 overflow-hidden rounded-[28px] border-2 border-[#ece7df] bg-white">
            @forelse ($latestOrders as $order)
                <a
                    href="{{ route('account.orders.show', $order) }}"
                    class="flex flex-col gap-4 border-b border-[#ece7df] p-5 transition last:border-b-0 hover:bg-[#f7f8ff] sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <p class="text-xs font-bold text-[#77758d]">
                            {{ $order->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                        </p>

                        <h3 class="mt-1 font-black">{{ $order->order_number }}</h3>

                        <p class="mt-1 text-sm text-[#77758d]">
                            {{ $order->items_count }} item
                        </p>
                    </div>

                    <div class="sm:text-right">
                        <p class="font-black text-[#304cb2]">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </p>

                        <div class="mt-2 flex flex-wrap gap-2 sm:justify-end">
                            <span class="rounded-full bg-[#fff3d6] px-3 py-1 text-xs font-black">
                                {{ $order->payment_status === 'paid' ? 'Dibayar' : 'Belum Dibayar' }}
                            </span>

                            <span class="rounded-full bg-[#e8f3ff] px-3 py-1 text-xs font-black">
                                {{ match ($order->status) {
                                    'processing' => 'Diproses',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                    default => 'Menunggu',
                                } }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <h3 class="text-xl font-black">Belum ada pesanan</h3>
                    <p class="mt-2 text-sm text-[#77758d]">
                        Pesanan yang kamu buat akan tampil di sini.
                    </p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

@extends('layouts.storefront')

@section('title', 'Detail Pesanan — Demas Store')

@section('content')

    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">

            <a href="{{ route('account.orders.index') }}" class="font-black text-[#304cb2]">
                ← Kembali ke riwayat pesanan
            </a>

            <div class="mt-6 rounded-[32px] border-2 border-[#ece7df] bg-white p-6 sm:p-8">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wider text-[#77758d]">
                            Nomor pesanan
                        </p>

                        <h1 class="mt-2 text-2xl font-black">
                            {{ $order->order_number }}
                        </h1>

                        <p class="mt-2 text-sm text-[#77758d]">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="rounded-full bg-[#fff3d6] px-4 py-2 text-xs font-black">
                            {{ match ($order->payment_status) {
                                'paid' => 'Sudah Dibayar',
                                'expired' => 'Kedaluwarsa',
                                'failed' => 'Pembayaran Gagal',
                                'refunded' => 'Dana Dikembalikan',
                                default => 'Belum Dibayar',
                            } }}
                        </span>

                        <span class="rounded-full bg-[#e8f3ff] px-4 py-2 text-xs font-black">
                            {{ match ($order->status) {
                                'processing' => 'Sedang Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default => 'Menunggu Pembayaran',
                            } }}
                        </span>
                    </div>
                </div>

                <div class="mt-8 border-t-2 border-dashed border-[#ece7df] pt-6">
                    <h2 class="text-lg font-black">
                        Produk
                    </h2>

                    <div class="mt-4 grid gap-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between gap-6 rounded-2xl bg-[#f7f8ff] p-4">
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-black">
                                        {{ $item->product_name ?? $item->name }}
                                    </h3>

                                    <p class="mt-1 text-sm text-[#77758d]">
                                        {{ $item->variant_name ?? 'Paket produk' }}
                                    </p>

                                    <p class="mt-2 text-xs text-[#77758d]">
                                        Harga satuan:
                                        <strong class="text-[#25233a]">
                                            Rp{{ number_format($item->unit_price, 0, ',', '.') }}
                                        </strong>

                                        <span class="mx-1">•</span>

                                        Jumlah:
                                        <strong class="text-[#25233a]">
                                            {{ $item->quantity }}
                                        </strong>
                                    </p>
                                </div>

                                <div class="shrink-0 self-center text-right">
                                    <p class="text-xs font-bold text-[#77758d]">
                                        Total item
                                    </p>

                                    <p class="mt-1 text-base font-black text-[#304cb2]">
                                        Rp{{ number_format($item->line_total, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 border-t-2 border-dashed border-[#ece7df] pt-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-[#77758d]">Subtotal</span>

                        <span class="font-bold">
                            Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-3 flex justify-between text-sm">
                        <span class="text-[#77758d]">Biaya layanan</span>

                        <span class="font-bold">
                            Rp{{ number_format($order->service_fee, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-5 flex justify-between border-t border-[#ece7df] pt-5">
                        <span class="text-lg font-black">Total</span>

                        <span class="text-2xl font-black text-[#ff7424]">
                            Rp{{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if (
                    $order->payment_status === 'unpaid' &&
                        $order->status === 'pending_payment' &&
                        (!$order->expires_at || $order->expires_at->isFuture()))
                    <div class="mt-8">
                        <button type="button" id="payNowButton"
                            class="w-full rounded-2xl bg-[#304cb2] px-6 py-4 font-black text-white transition hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:opacity-60">
                            Bayar Sekarang
                        </button>

                        @if ($order->expires_at)
                            <p class="mt-3 text-center text-sm text-[#77758d]">
                                Batas pembayaran:
                                {{ $order->expires_at->format('d M Y, H:i') }}
                            </p>
                        @endif
                    </div>
                @elseif ($order->payment_status === 'paid')
                    @php
                        $payment = $order->payment;

                        $whatsappNumber = config('services.whatsapp.order_fulfillment', '62881080631917');

                        $productNames = $order->items
                            ->map(
                                fn($item) => ($item->product_name ?? $item->name) .
                                    ' - ' .
                                    ($item->variant_name ?? 'Paket produk') .
                                    ' x' .
                                    $item->quantity,
                            )
                            ->implode(', ');

                        $message = implode(PHP_EOL, [
                            'Halo Demas Store, pembayaran saya sudah berhasil.',
                            '',
                            'Nomor pesanan: ' . $order->order_number,
                            'Nama: ' . $order->customer_name,
                            'Produk: ' . $productNames,
                            'Total: Rp' . number_format($order->total, 0, ',', '.'),
                            'Status pembayaran: Dibayar',
                            'Metode pembayaran: ' .
                            ($payment?->payment_type
                                ? str($payment->payment_type)->replace('_', ' ')->title()
                                : 'Tidak tersedia'),
                            'Waktu pembayaran: ' .
                            ($payment?->paid_at?->format('d M Y, H:i') ??
                                ($order->paid_at?->format('d M Y, H:i') ?? 'Tidak tersedia')),
                            'ID transaksi: ' . ($payment?->transaction_id ?? 'Tidak tersedia'),
                            '',
                            'Mohon kirimkan detail produk pesanan saya.',
                            'Saya akan melampirkan screenshot bukti pembayaran jika diperlukan.',
                        ]);

                        $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message);
                    @endphp

                    <div class="mt-8 rounded-3xl border-2 border-green-200 bg-green-50 p-5 sm:p-6">
                        <div class="flex items-start gap-4">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-green-600 text-white">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" aria-hidden="true">
                                    <path d="m5 12 4 4L19 6" />
                                </svg>
                            </span>

                            <div>
                                <h2 class="text-lg font-black text-green-800">
                                    Pembayaran berhasil diterima
                                </h2>

                                <p class="mt-1 text-sm leading-6 text-green-700">
                                    Hubungi customer service untuk meminta detail produk.
                                </p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-3 rounded-2xl bg-white/80 p-4 text-sm">
                            <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
                                <span class="text-[#77758d]">
                                    Metode pembayaran
                                </span>

                                <span class="font-black text-[#25233a]">
                                    {{ $payment?->payment_type ? str($payment->payment_type)->replace('_', ' ')->title() : 'Tidak tersedia' }}
                                </span>
                            </div>

                            <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
                                <span class="text-[#77758d]">
                                    Waktu pembayaran
                                </span>

                                <span class="font-black text-[#25233a]">
                                    {{ $payment?->paid_at?->format('d M Y, H:i') ?? ($order->paid_at?->format('d M Y, H:i') ?? 'Tidak tersedia') }}
                                </span>
                            </div>

                            <div class="flex flex-col gap-1 sm:flex-row sm:justify-between">
                                <span class="text-[#77758d]">
                                    ID transaksi
                                </span>

                                <span class="break-all font-black text-[#25233a]">
                                    {{ $payment?->transaction_id ?? 'Tidak tersedia' }}
                                </span>
                            </div>
                        </div>

                        @php
                            $customerServiceNumber = preg_replace(
                                '/\D+/',
                                '',
                                (string) config('services.whatsapp.customer_service', '6281234567890'),
                            );

                            $customerServiceUrl =
                                'https://wa.me/' .
                                $customerServiceNumber .
                                '?text=' .
                                urlencode(
                                    'Halo Customer Service Demas Store, saya mengalami kendala pada pesanan ' .
                                        $order->order_number .
                                        '.',
                                );
                        @endphp

                        @if (!$order->detail_requested_at)
                            <form action="{{ route('account.orders.request-details', $order) }}" method="POST"
                                target="_blank" id="requestOrderDetailsForm" class="mt-5">
                                @csrf

                                <button type="submit" id="requestOrderDetailsButton"
                                    class="flex w-full items-center justify-center gap-3 rounded-2xl bg-[#25D366] px-5 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#1fb85a] disabled:cursor-not-allowed disabled:opacity-60">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M12.04 2a9.84 9.84 0 0 0-8.45 14.88L2 22l5.25-1.55A9.98 9.98 0 1 0 12.04 2Zm0 17.98a8.04 8.04 0 0 1-4.1-1.12l-.3-.18-3.12.92.93-3.04-.2-.31a7.99 7.99 0 1 1 6.79 3.73Zm4.4-5.98c-.24-.12-1.43-.7-1.65-.78-.22-.08-.38-.12-.54.12-.16.24-.62.78-.76.94-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.19-.71-.64-1.2-1.42-1.34-1.66-.14-.24-.01-.37.1-.49.11-.11.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.47-.4-.41-.54-.42h-.46c-.16 0-.42.06-.64.3-.22.24-.84.82-.84 2s.86 2.32.98 2.48c.12.16 1.7 2.6 4.12 3.64.58.25 1.03.4 1.38.51.58.18 1.1.16 1.52.1.46-.07 1.43-.58 1.63-1.15.2-.56.2-1.04.14-1.14-.06-.1-.22-.16-.46-.28Z" />
                                    </svg>

                                    Minta Detail Pesanan via WhatsApp
                                </button>
                            </form>

                            <p class="mt-3 text-center text-xs leading-5 text-green-800">
                                Tombol ini hanya dapat digunakan satu kali untuk setiap pesanan.
                                Tambahkan screenshot bukti pembayaran secara manual jika diperlukan.
                            </p>
                        @else
                            <div class="mt-5 rounded-2xl border border-green-200 bg-white/80 p-4 text-center">
                                <p class="font-black text-green-800">
                                    Permintaan detail pesanan sudah dikirim
                                </p>

                                <p class="mt-1 text-xs leading-5 text-green-700">
                                    Dikirim pada {{ $order->detail_requested_at->format('d M Y, H:i') }}.
                                    Tombol WhatsApp tidak dapat digunakan kembali untuk pesanan ini.
                                </p>
                            </div>
                        @endif

                        <div class="mt-4 rounded-2xl bg-white/80 p-4 text-center">
                            <p class="text-sm font-bold text-[#25233a]">
                                Ada kendala dengan pesanan ini?
                            </p>

                            <a href="{{ $customerServiceUrl }}" target="_blank" rel="noopener noreferrer"
                                class="mt-2 inline-flex font-black text-[#304cb2] hover:underline">
                                Hubungi Customer Service
                            </a>
                        </div>
                    </div>
                @else
                    <div class="mt-8 rounded-2xl bg-red-50 p-4 text-center font-black text-red-700">
                        Pesanan ini sudah tidak dapat dibayar.
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    @if ($order->payment_status === 'paid' && !$order->detail_requested_at)
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('requestOrderDetailsForm');
                const button = document.getElementById('requestOrderDetailsButton');

                if (!form || !button) {
                    return;
                }

                form.addEventListener('submit', () => {
                    button.disabled = true;
                    button.textContent = 'Membuka WhatsApp...';

                    window.setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                });
            });
        </script>
    @endif
    @if ($order->payment_status === 'unpaid' && $order->status === 'pending_payment')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const button = document.getElementById('payNowButton');

                if (!button) {
                    return;
                }

                button.addEventListener('click', async () => {
                    const originalText = button.textContent;

                    button.disabled = true;
                    button.textContent = 'Membuka pembayaran...';

                    try {
                        const response = await fetch(
                            @json(route('account.orders.pay', $order)), {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': @json(csrf_token()),
                                },
                                body: JSON.stringify({}),
                            }
                        );

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(
                                data.message ?? 'Pembayaran gagal dibuka.'
                            );
                        }

                        window.snap.pay(data.snap_token, {
                            onSuccess: function() {
                                window.location.reload();
                            },

                            onPending: function() {
                                window.location.reload();
                            },

                            onError: function() {
                                alert('Pembayaran gagal diproses.');
                                window.location.reload();
                            },

                            onClose: function() {
                                button.disabled = false;
                                button.textContent = originalText;
                            },
                        });
                    } catch (error) {
                        alert(error.message);

                        button.disabled = false;
                        button.textContent = originalText;
                    }
                });
            });
        </script>
    @endif
@endpush

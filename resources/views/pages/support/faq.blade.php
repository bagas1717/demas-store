@extends('layouts.storefront')

@section('title', 'FAQ — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="text-center">
                <span class="inline-flex rounded-full bg-[#fff0e5] px-4 py-2 text-sm font-black text-[#ff7424]">
                    Bantuan
                </span>

                <h1 class="mt-4 text-3xl font-black text-[#25233a] sm:text-4xl">
                    Pertanyaan yang Sering Diajukan
                </h1>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-[#77758d]">
                    Temukan jawaban mengenai pembelian, pembayaran, pengiriman,
                    garansi, dan penggunaan produk Demas Store.
                </p>
            </div>

            <div class="mt-10 space-y-4">
                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm" open>
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Bagaimana cara membeli produk?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Pilih produk dari katalog, tentukan varian, masukkan ke
                        keranjang, isi data pembeli, lalu selesaikan pembayaran.
                        Pesanan akan diproses setelah pembayaran berhasil.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apakah saya harus membuat akun?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Beberapa transaksi dapat dilakukan sebagai tamu, tetapi
                        membuat akun lebih disarankan agar riwayat pesanan lebih
                        mudah dilihat dan dikelola.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Metode pembayaran apa saja yang tersedia?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Metode pembayaran mengikuti pilihan yang tersedia pada
                        halaman pembayaran, seperti QRIS, transfer bank,
                        dompet digital, atau metode lain yang didukung.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Berapa lama pesanan diproses?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Waktu pemrosesan bergantung pada jenis produk dan
                        ketersediaan stok. Produk otomatis dapat diproses lebih
                        cepat, sedangkan produk manual memerlukan pemeriksaan
                        admin.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Di mana saya melihat status pesanan?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Pengguna yang sudah login dapat membuka menu Pesanan
                        Saya. Pengguna tamu dapat menggunakan halaman pesanan
                        yang diberikan setelah checkout.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Bagaimana produk dikirimkan?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Detail produk dapat dikirim melalui halaman pesanan,
                        email, atau WhatsApp, tergantung jenis produk dan sistem
                        pemrosesan yang digunakan.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apakah produk memiliki garansi?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Garansi mengikuti ketentuan yang tercantum pada setiap
                        produk. Pastikan membaca masa dan cakupan garansi
                        sebelum melakukan pembelian.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Bagaimana cara mengajukan garansi?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Hubungi customer service dengan menyertakan nomor
                        pesanan, deskripsi kendala, serta foto atau tangkapan
                        layar apabila diperlukan.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apakah pesanan bisa dibatalkan?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Pesanan yang belum dibayar dapat kedaluwarsa secara
                        otomatis. Pesanan yang telah dibayar dan diproses
                        umumnya tidak dapat dibatalkan.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apakah pembayaran bisa dikembalikan?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Pengembalian dana hanya dipertimbangkan untuk kondisi
                        tertentu, seperti produk tidak tersedia, pembayaran
                        ganda, atau kesalahan sistem yang telah diverifikasi.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apa yang harus dilakukan jika pembayaran berhasil tetapi status belum berubah?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Tunggu beberapa saat dan muat ulang halaman pesanan.
                        Jika status masih belum berubah, hubungi customer
                        service dengan nomor pesanan dan bukti pembayaran.
                    </p>
                </details>

                <details class="group rounded-3xl border-2 border-[#ece7df] bg-white p-5 shadow-sm">
                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-4 font-black text-[#25233a]">
                        Apakah customer service meminta OTP atau PIN?

                        <span
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-xl bg-[#fff0e5] text-xl text-[#ff7424] transition group-open:rotate-45">
                            +
                        </span>
                    </summary>

                    <p class="mt-4 leading-7 text-[#77758d]">
                        Tidak. Demas Store tidak meminta kode OTP, PIN,
                        kata sandi perbankan, CVV, atau kode keamanan pembayaran.
                    </p>
                </details>
            </div>

            <div class="mt-10 rounded-[28px] bg-[#25233a] p-6 text-center text-white sm:p-8">
                <h2 class="text-2xl font-black">
                    Masih Membutuhkan Bantuan?
                </h2>

                <p class="mx-auto mt-3 max-w-xl leading-7 text-white/65">
                    Hubungi customer service dan sertakan nomor pesanan agar
                    kendala dapat diperiksa lebih cepat.
                </p>

                <a href="https://wa.me/{{ config('services.whatsapp.customer_service', '6281234567890') }}?text={{ urlencode('Halo Demas Store, saya ingin bertanya.') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="mt-6 inline-flex rounded-2xl bg-[#ffd84d] px-6 py-4 font-black text-[#25233a] transition hover:-translate-y-0.5 hover:bg-[#ffcf1f]">
                    Hubungi Customer Service
                </a>
            </div>
        </div>
    </section>
@endsection

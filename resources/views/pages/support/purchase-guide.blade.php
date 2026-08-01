@extends('layouts.storefront')

@section('title', 'Cara Pembelian — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-5xl">
            <div class="text-center">
                <span class="inline-flex rounded-full bg-[#fff0e5] px-4 py-2 text-sm font-black text-[#ff7424]">
                    Panduan Pembelian
                </span>

                <h1 class="mt-4 text-3xl font-black text-[#25233a] sm:text-4xl">
                    Cara Membeli di Demas Store
                </h1>

                <p class="mx-auto mt-4 max-w-2xl leading-7 text-[#77758d]">
                    Ikuti langkah berikut untuk membeli produk digital dengan
                    mudah dan aman.
                </p>
            </div>

            <div class="mt-10 grid gap-5 md:grid-cols-2">
                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#304cb2] text-lg font-black text-white">
                            1
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Pilih Produk
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Buka halaman katalog, lalu pilih aplikasi atau
                                produk digital yang ingin dibeli.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#ff7424] text-lg font-black text-white">
                            2
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Pilih Varian
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Pilih paket, masa aktif, jenis akun, dan jumlah
                                perangkat sesuai kebutuhan.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#ffd84d] text-lg font-black text-[#25233a]">
                            3
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Masukkan ke Keranjang
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Periksa kembali produk dan harga, kemudian
                                masukkan produk ke keranjang belanja.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#25233a] text-lg font-black text-white">
                            4
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Isi Data Pembeli
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Masukkan nama, email, dan nomor WhatsApp aktif
                                agar pesanan dapat diproses dengan benar.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#304cb2] text-lg font-black text-white">
                            5
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Lakukan Pembayaran
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Pilih metode pembayaran yang tersedia dan
                                selesaikan pembayaran sebelum batas waktu habis.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#ff7424] text-lg font-black text-white">
                            6
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Tunggu Pesanan Diproses
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Setelah pembayaran terverifikasi, status pesanan
                                akan diperbarui dan produk akan segera diproses.
                            </p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[28px] border-2 border-[#ece7df] bg-white p-6 shadow-sm md:col-span-2">
                    <div class="flex items-start gap-4">
                        <span
                            class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-green-600 text-lg font-black text-white">
                            7
                        </span>

                        <div>
                            <h2 class="text-xl font-black text-[#25233a]">
                                Terima Detail Produk
                            </h2>

                            <p class="mt-2 leading-7 text-[#77758d]">
                                Detail akun atau petunjuk penggunaan akan
                                disampaikan melalui halaman pesanan, email,
                                atau WhatsApp sesuai jenis produk.
                            </p>
                        </div>
                    </div>
                </article>
            </div>

            <div class="mt-8 rounded-[28px] border-2 border-[#ffd84d] bg-[#fff9dc] p-6">
                <h2 class="text-xl font-black text-[#25233a]">
                    Hal yang Perlu Diperhatikan
                </h2>

                <ul class="mt-4 list-disc space-y-3 pl-5 leading-7 text-[#5f5c70]">
                    <li>
                        Pastikan email dan nomor WhatsApp yang dimasukkan aktif.
                    </li>

                    <li>
                        Baca deskripsi, masa aktif, jumlah perangkat, dan
                        ketentuan garansi sebelum membeli.
                    </li>

                    <li>
                        Simpan nomor pesanan untuk memudahkan proses bantuan.
                    </li>

                    <li>
                        Jangan memberikan kode OTP, PIN, atau informasi
                        pembayaran kepada siapa pun.
                    </li>

                    <li>
                        Hubungi customer service resmi apabila pesanan belum
                        diterima sesuai estimasi.
                    </li>
                </ul>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}#katalog"
                    class="inline-flex rounded-2xl bg-[#304cb2] px-6 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#273f96]">
                    Lihat Katalog
                </a>
            </div>
        </div>
    </section>
@endsection

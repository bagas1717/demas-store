@extends('layouts.storefront')

@section('title', 'Syarat dan Ketentuan — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-10">
                <div class="border-b border-[#ece7df] pb-6 text-center">
                    <h1 class="text-3xl font-black text-[#25233a]">
                        Syarat dan Ketentuan
                    </h1>

                    <p class="mt-3 text-sm text-[#77758d]">
                        Terakhir diperbarui: {{ date('d F Y') }}
                    </p>
                </div>

                <div class="mt-8 space-y-8 leading-7 text-[#5f5c70]">
                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            1. Pengantar
                        </h2>

                        <p class="mt-3">
                            Selamat datang di Demas Store. Demas Store merupakan
                            platform yang menyediakan berbagai produk dan layanan
                            digital.
                        </p>

                        <p class="mt-3">
                            Dengan mendaftar, mengakses, melakukan transaksi,
                            dan menggunakan layanan Demas Store, Pengguna dianggap
                            telah membaca, memahami, dan menyetujui seluruh Syarat
                            dan Ketentuan ini.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            2. Penggunaan Layanan
                        </h2>

                        <p class="mt-3">
                            - Pengguna harus berusia minimal 18 tahun atau telah
                            memperoleh izin dari orang tua atau wali.
                        </p>

                        <p class="mt-3">
                            - Pengguna wajib memberikan informasi pendaftaran yang
                            benar, lengkap, dan terbaru.
                        </p>

                        <p class="mt-3">
                            - Pengguna bertanggung jawab menjaga kerahasiaan email,
                            kata sandi, dan seluruh aktivitas pada akun.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            3. Transaksi
                        </h2>

                        <p class="mt-3">
                            - Semua transaksi yang telah dibayar dan mulai diproses
                            bersifat final, kecuali ditentukan lain oleh ketentuan
                            produk atau hukum yang berlaku.
                        </p>

                        <p class="mt-3">
                            - Pengguna wajib memastikan produk, varian, harga,
                            masa aktif, jumlah perangkat, dan informasi pesanan
                            telah sesuai sebelum melakukan pembayaran.
                        </p>

                        <p class="mt-3">
                            - Harga produk dapat berubah sewaktu-waktu tanpa
                            pemberitahuan sebelumnya.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            4. Pembayaran
                        </h2>

                        <p class="mt-3">
                            - Pembayaran hanya dianggap sah apabila dilakukan
                            melalui metode pembayaran resmi yang tersedia pada
                            website Demas Store.
                        </p>

                        <p class="mt-3">
                            - Pesanan yang tidak dibayar sampai batas waktu yang
                            ditentukan dapat dibatalkan secara otomatis.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            5. Produk Digital
                        </h2>

                        <p class="mt-3">
                            - Produk digital akan dikirimkan atau diproses setelah
                            pembayaran dinyatakan berhasil.
                        </p>

                        <p class="mt-3">
                            - Pengguna wajib menggunakan produk sesuai deskripsi
                            dan ketentuan yang tercantum pada halaman produk.
                        </p>

                        <p class="mt-3">
                            - Pengguna dilarang mengubah data akun, membagikan
                            akses secara berlebihan, mengambil cookies, memakai
                            bot, atau mencoba mengambil alih akun tanpa izin.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            6. Garansi
                        </h2>

                        <p class="mt-3">
                            - Durasi dan ketentuan garansi dapat berbeda pada
                            setiap produk.
                        </p>

                        <p class="mt-3">
                            - Klaim garansi wajib menyertakan nomor pesanan,
                            penjelasan kendala, dan bukti pendukung apabila
                            diperlukan.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            7. Hak Kekayaan Intelektual
                        </h2>

                        <p class="mt-3">
                            Seluruh konten, desain, logo, ikon, teks, dan materi
                            promosi Demas Store dilindungi oleh ketentuan hak
                            cipta yang berlaku.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            8. Batasan Tanggung Jawab
                        </h2>

                        <p class="mt-3">
                            Demas Store tidak bertanggung jawab atas kerugian
                            akibat kesalahan Pengguna, gangguan jaringan,
                            perangkat, layanan pembayaran, atau perubahan dari
                            penyedia layanan pihak ketiga.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            9. Perubahan Layanan
                        </h2>

                        <p class="mt-3">
                            Demas Store berhak mengubah, membatasi, menangguhkan,
                            atau menghentikan layanan untuk alasan keamanan,
                            pemeliharaan, pengembangan, atau perubahan kebijakan.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            10. Force Majeure
                        </h2>

                        <p class="mt-3">
                            Demas Store tidak bertanggung jawab atas gangguan
                            yang disebabkan oleh keadaan di luar kendali, seperti
                            bencana alam, gangguan listrik, gangguan internet,
                            tindakan pemerintah, atau gangguan layanan pihak ketiga.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            11. Hukum yang Berlaku
                        </h2>

                        <p class="mt-3">
                            Syarat dan Ketentuan ini diatur berdasarkan hukum
                            yang berlaku di Republik Indonesia.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            12. Kontak
                        </h2>

                        <p class="mt-3">
                            Pertanyaan dan permintaan bantuan dapat disampaikan
                            melalui customer service resmi Demas Store.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.storefront')

@section('title', 'Daftar — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-[520px]">
            <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-8">
                <h1 class="text-3xl font-black text-[#25233a]">
                    Daftar
                </h1>

                <p class="mt-2 text-sm text-[#77758d]">
                    Masukkan informasi pendaftaran yang valid.
                </p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form id="register-form" method="POST" action="{{ route('register') }}" class="mt-7 grid gap-5">
                    @csrf

                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="grid gap-2">
                            <span class="text-sm font-black text-[#25233a]">
                                Nama lengkap
                            </span>

                            <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                                placeholder="Nama lengkap"
                                class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2] focus:bg-white">
                        </label>

                        <label class="grid gap-2">
                            <span class="text-sm font-black text-[#25233a]">
                                Username
                            </span>

                            <input type="text" name="username" value="{{ old('username') }}" autocomplete="username"
                                placeholder="Username"
                                class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2] focus:bg-white">
                        </label>
                    </div>

                    <label class="grid gap-2">
                        <span class="text-sm font-black text-[#25233a]">
                            Alamat email
                        </span>

                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="nama@email.com"
                            class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 text-[#25233a] outline-none transition focus:border-[#304cb2] focus:bg-white">
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-black text-[#25233a]">
                            Nomor WhatsApp
                        </span>

                        <div
                            class="flex overflow-hidden rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] focus-within:border-[#304cb2] focus-within:bg-white">
                            <div
                                class="flex items-center gap-2 border-r-2 border-[#ece7df] px-4 text-sm font-bold text-[#25233a]">
                                <span>🇮🇩</span>
                                <span>+62</span>
                            </div>

                            <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"
                                placeholder="81234567890"
                                class="min-w-0 flex-1 bg-transparent px-4 py-3 text-[#25233a] outline-none">
                        </div>
                    </label>

                    <div class="grid gap-4 md:grid-cols-2">
                        {{-- Kata sandi --}}
                        <label class="grid gap-2">
                            <span class="text-sm font-black text-[#25233a]">
                                Kata sandi
                            </span>

                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 pr-12 outline-none transition focus:border-[#304cb2]">

                                <button type="button" data-password-toggle="password"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#77758d] transition hover:text-[#304cb2]"
                                    aria-label="Tampilkan kata sandi">
                                    <svg data-eye-open class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>

                                    <svg data-eye-closed class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m3 3 18 18" />
                                        <path d="M10.6 10.7a2 2 0 0 0 2.7 2.7" />
                                        <path d="M9.9 4.2A10.7 10.7 0 0 1 12 4c6 0 9.5 8 9.5 8a16 16 0 0 1-2.1 3.1" />
                                        <path d="M6.6 6.6C4 8.4 2.5 12 2.5 12s3.5 8 9.5 8a9.8 9.8 0 0 0 4.1-.9" />
                                    </svg>
                                </button>
                            </div>

                            @error('password')
                                <p class="text-sm font-bold text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </label>

                        {{-- Konfirmasi kata sandi --}}
                        <label class="grid gap-2">
                            <span class="text-sm font-black text-[#25233a]">
                                Konfirmasi kata sandi
                            </span>

                            <div class="relative">
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    autocomplete="new-password" placeholder="Ulangi kata sandi"
                                    class="w-full rounded-2xl border-2 border-[#ece7df] bg-[#fffaf3] px-4 py-3 pr-12 outline-none transition focus:border-[#304cb2]">

                                <button type="button" data-password-toggle="password_confirmation"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#77758d] transition hover:text-[#304cb2]"
                                    aria-label="Tampilkan konfirmasi kata sandi">
                                    <svg data-eye-open class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>

                                    <svg data-eye-closed class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m3 3 18 18" />
                                        <path d="M10.6 10.7a2 2 0 0 0 2.7 2.7" />
                                        <path d="M9.9 4.2A10.7 10.7 0 0 1 12 4c6 0 9.5 8 9.5 8a16 16 0 0 1-2.1 3.1" />
                                        <path d="M6.6 6.6C4 8.4 2.5 12 2.5 12s3.5 8 9.5 8a9.8 9.8 0 0 0 4.1-.9" />
                                    </svg>
                                </button>
                            </div>
                        </label>
                    </div>

                    {{-- Persetujuan --}}
                    <label class="mt-3 flex items-start gap-3">
                        <input type="checkbox" name="terms" value="1" required
                            class="mt-1 h-4 w-4 shrink-0 rounded border-[#c9c5bd] text-[#304cb2] focus:ring-[#304cb2]">

                        <span class="text-sm leading-6 text-[#77758d]">
                            Saya telah membaca dan menyetujui
                            <button type="button" data-open-terms class="font-black text-[#304cb2] hover:underline">
                                Syarat dan Ketentuan
                            </button>
                            Demas Store.
                        </span>
                    </label>

                    @error('terms')
                        <p class="-mt-3 text-sm font-bold text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <div>
                        <div class="flex w-full items-stretch justify-center gap-3">
                            <div id="turnstile-widget" class="cf-turnstile"
                                data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"
                                data-size="normal"></div>

                            <button type="button" id="refresh-turnstile"
                                class="grid h-[65px] w-[52px] shrink-0 place-items-center rounded-xl border-2 border-[#ece7df] bg-white text-2xl font-black text-[#304cb2] transition hover:border-[#304cb2] hover:bg-[#f5f7ff]"
                                aria-label="Muat ulang captcha" title="Muat ulang captcha">
                                ↻
                            </button>
                        </div>

                        @error('cf-turnstile-response')
                            <p class="mt-2 text-sm font-bold text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-2xl bg-[#ff7424] px-5 py-4 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#ef6416]">
                        Daftar
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-[#77758d]">
                    Sudah memiliki akun?

                    <a href="{{ route('login') }}" class="font-black text-[#304cb2]">
                        Masuk
                    </a>
                </p>

                <div class="my-7 flex items-center gap-4">
                    <div class="h-px flex-1 bg-[#ece7df]"></div>

                    <span class="text-xs font-bold text-[#77758d]">
                        Atau lanjutkan dengan
                    </span>

                    <div class="h-px flex-1 bg-[#ece7df]"></div>
                </div>

                <a href="{{ route('google.redirect') }}"
                    class="flex w-full items-center justify-center gap-3 rounded-2xl border-2 border-[#ece7df] bg-white px-5 py-4 font-black text-[#25233a] transition hover:-translate-y-0.5 hover:border-[#304cb2]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4"
                            d="M21.6 12.23c0-.71-.06-1.4-.18-2.07H12v3.92h5.39a4.61 4.61 0 0 1-2 3.02v2.51h3.24c1.9-1.75 2.97-4.33 2.97-7.38Z" />
                        <path fill="#34A853"
                            d="M12 22c2.7 0 4.97-.9 6.63-2.39l-3.24-2.51c-.9.6-2.05.96-3.39.96-2.61 0-4.82-1.76-5.61-4.13H3.05v2.59A10 10 0 0 0 12 22Z" />
                        <path fill="#FBBC05"
                            d="M6.39 13.93A6.02 6.02 0 0 1 6.07 12c0-.67.12-1.32.32-1.93V7.48H3.05A10 10 0 0 0 2 12c0 1.61.38 3.13 1.05 4.52l3.34-2.59Z" />
                        <path fill="#EA4335"
                            d="M12 5.94c1.47 0 2.79.51 3.83 1.5l2.87-2.87C16.96 2.95 14.7 2 12 2a10 10 0 0 0-8.95 5.48l3.34 2.59C7.18 7.7 9.39 5.94 12 5.94Z" />
                    </svg>

                    Google
                </a>
            </div>
        </div>
    </section>

    {{-- Modal Syarat dan Ketentuan --}}
    <div id="terms-modal"
        class="fixed inset-0 z-[100] hidden items-center justify-center bg-[#25233a]/70 px-4 py-6 backdrop-blur-sm"
        role="dialog" aria-modal="true" aria-labelledby="terms-modal-title">
        <div class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-[28px] bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-[#ece7df] px-5 py-4 sm:px-7">
                <div>
                    <h2 id="terms-modal-title" class="text-xl font-black text-[#25233a] sm:text-2xl">
                        Syarat dan Ketentuan
                    </h2>

                    <p class="mt-1 text-xs text-[#77758d] sm:text-sm">
                        Baca dan scroll sampai bawah untuk melanjutkan.
                    </p>
                </div>

                <button id="close-terms-button" type="button"
                    class="grid h-10 w-10 shrink-0 place-items-center rounded-xl text-2xl text-[#77758d] transition hover:bg-[#fff3e8] hover:text-[#ff7424]"
                    aria-label="Tutup syarat dan ketentuan">
                    ×
                </button>
            </div>

            <div id="terms-scroll-content" class="overflow-y-auto px-5 py-6 text-sm leading-7 text-[#5f5c70] sm:px-7">
                <div class="space-y-7">
                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            1. Pengantar
                        </h3>

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

                        <p class="mt-3">
                            Apabila Pengguna tidak menyetujui sebagian atau seluruh
                            ketentuan yang berlaku, Pengguna tidak diperkenankan
                            menggunakan layanan Demas Store.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            2. Penggunaan Layanan
                        </h3>

                        <p class="mt-3">
                            <strong>Kelayakan:</strong>
                            Pengguna harus berusia minimal 18 tahun atau telah
                            memperoleh izin dari orang tua atau wali untuk
                            menggunakan layanan Demas Store.
                        </p>

                        <p class="mt-3">
                            <strong>Akun Pengguna:</strong>
                            Pengguna wajib memberikan informasi yang benar,
                            lengkap, dan terbaru ketika membuat akun.
                        </p>

                        <p class="mt-3">
                            Pengguna bertanggung jawab menjaga kerahasiaan email,
                            kata sandi, kode verifikasi, dan seluruh aktivitas yang
                            terjadi melalui akun Pengguna.
                        </p>

                        <p class="mt-3">
                            Pengguna dilarang membagikan, menjual, atau
                            memindahtangankan akun Demas Store kepada pihak lain
                            tanpa izin.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            3. Transaksi
                        </h3>

                        <p class="mt-3">
                            <strong>Pembelian:</strong>
                            Semua transaksi yang dilakukan melalui Demas Store
                            bersifat final setelah pembayaran berhasil atau
                            pesanan mulai diproses, kecuali ditentukan lain oleh
                            ketentuan produk atau hukum yang berlaku.
                        </p>

                        <p class="mt-3">
                            Pengguna wajib membaca nama produk, varian, harga,
                            masa aktif, jumlah perangkat, ketentuan garansi, dan
                            informasi lain sebelum melakukan pembayaran.
                        </p>

                        <p class="mt-3">
                            Kesalahan memilih produk, varian, atau memasukkan data
                            yang disebabkan oleh kelalaian Pengguna menjadi
                            tanggung jawab Pengguna.
                        </p>

                        <p class="mt-3">
                            <strong>Harga:</strong>
                            Harga produk dapat berubah sewaktu-waktu tanpa
                            pemberitahuan sebelumnya.
                        </p>

                        <p class="mt-3">
                            Jika terjadi kesalahan harga akibat gangguan teknis,
                            Demas Store berhak membatalkan transaksi dan
                            mengembalikan pembayaran yang telah diterima.
                        </p>

                        <p class="mt-3">
                            <strong>Metode pembayaran:</strong>
                            Pembayaran hanya dianggap sah apabila dilakukan
                            melalui metode pembayaran resmi yang tersedia di
                            website Demas Store.
                        </p>

                        <p class="mt-3">
                            Pesanan yang tidak dibayar hingga batas waktu yang
                            ditentukan dapat dibatalkan secara otomatis.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            4. Pengembalian dan Pengembalian Dana
                        </h3>

                        <p class="mt-3">
                            Demas Store tidak menerima pengembalian produk digital
                            yang telah dikirimkan, diaktifkan, atau digunakan.
                        </p>

                        <p class="mt-3">
                            Pengembalian dana dapat dipertimbangkan apabila produk
                            tidak tersedia, pembayaran terjadi dua kali, produk
                            yang diterima tidak sesuai, atau terjadi kesalahan
                            sistem yang telah diverifikasi.
                        </p>

                        <p class="mt-3">
                            Pengembalian dana tidak berlaku untuk kesalahan memilih
                            produk, kesalahan memasukkan data, perubahan keputusan,
                            ketidakcocokan perangkat, atau pelanggaran ketentuan
                            penggunaan.
                        </p>

                        <p class="mt-3">
                            Seluruh permintaan pengembalian dana akan melalui
                            proses pemeriksaan terlebih dahulu.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            5. Pengiriman dan Penggunaan Produk Digital
                        </h3>

                        <p class="mt-3">
                            Produk digital akan dikirim atau diproses setelah
                            pembayaran dinyatakan berhasil.
                        </p>

                        <p class="mt-3">
                            Waktu pemrosesan dapat berbeda berdasarkan jenis
                            produk, ketersediaan stok, dan metode pengiriman.
                        </p>

                        <p class="mt-3">
                            Untuk produk yang diproses secara manual, Pengguna
                            dapat diminta menghubungi customer service dengan
                            menyertakan nomor pesanan.
                        </p>

                        <p class="mt-3">
                            Pengguna wajib menggunakan produk sesuai deskripsi dan
                            ketentuan pada halaman produk.
                        </p>

                        <p class="mt-3">
                            Pengguna dilarang mengubah email, kata sandi, profil
                            utama, metode pembayaran, membagikan akses secara
                            berlebihan, mengambil cookies, menggunakan bot, atau
                            mencoba mengambil alih akun tanpa izin.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            6. Garansi Produk
                        </h3>

                        <p class="mt-3">
                            Masa dan ketentuan garansi dapat berbeda pada setiap
                            produk. Pengguna wajib membaca informasi garansi
                            sebelum melakukan pembelian.
                        </p>

                        <p class="mt-3">
                            Klaim garansi wajib menyertakan nomor pesanan,
                            penjelasan kendala, serta bukti foto atau tangkapan
                            layar apabila diperlukan.
                        </p>

                        <p class="mt-3">
                            Penyelesaian garansi dapat berupa perbaikan akses,
                            penggantian produk, perpanjangan masa aktif, atau
                            solusi lain sesuai hasil pemeriksaan.
                        </p>

                        <p class="mt-3">
                            Garansi tidak berlaku apabila masalah disebabkan oleh
                            pelanggaran, kelalaian, atau perubahan data akun oleh
                            Pengguna.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            7. Hak Kekayaan Intelektual
                        </h3>

                        <p class="mt-3">
                            Seluruh konten pada website Demas Store, termasuk
                            teks, desain, logo, ikon, gambar, dan materi promosi,
                            dilindungi oleh ketentuan hak cipta yang berlaku.
                        </p>

                        <p class="mt-3">
                            Pengguna dilarang menyalin, mendistribusikan,
                            memodifikasi, atau menggunakan konten Demas Store
                            untuk kepentingan komersial tanpa izin tertulis.
                        </p>

                        <p class="mt-3">
                            Merek dan logo milik layanan pihak ketiga tetap menjadi
                            hak masing-masing pemiliknya.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            8. Batasan Tanggung Jawab
                        </h3>

                        <p class="mt-3">
                            Demas Store berusaha menyediakan layanan yang aman dan
                            akurat, tetapi tidak menjamin bahwa layanan akan selalu
                            bebas dari gangguan, kesalahan, atau keterlambatan.
                        </p>

                        <p class="mt-3">
                            Demas Store tidak bertanggung jawab atas kerugian yang
                            timbul akibat kesalahan Pengguna, penyalahgunaan akun,
                            gangguan internet, perangkat, penyedia pembayaran,
                            atau layanan pihak ketiga.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            9. Layanan Pihak Ketiga
                        </h3>

                        <p class="mt-3">
                            Sebagian produk Demas Store berkaitan dengan aplikasi
                            atau platform yang dimiliki pihak ketiga.
                        </p>

                        <p class="mt-3">
                            Demas Store tidak memiliki kendali penuh atas
                            perubahan fitur, harga, kebijakan, pembatasan wilayah,
                            gangguan server, atau penghentian layanan pihak ketiga.
                        </p>

                        <p class="mt-3">
                            Apabila terjadi perubahan, Demas Store akan berusaha
                            memberikan solusi sesuai kemampuan dan ketentuan
                            garansi yang berlaku.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            10. Perubahan dan Penghentian Layanan
                        </h3>

                        <p class="mt-3">
                            Demas Store berhak mengubah, membatasi, menangguhkan,
                            atau menghentikan sebagian maupun seluruh layanan untuk
                            alasan keamanan, pemeliharaan, pengembangan, kebijakan,
                            regulasi, atau kondisi operasional.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            11. Force Majeure
                        </h3>

                        <p class="mt-3">
                            Demas Store tidak bertanggung jawab atas keterlambatan
                            atau kegagalan layanan akibat kejadian di luar kendali,
                            termasuk bencana alam, perang, kerusuhan, kebakaran,
                            banjir, gangguan listrik, gangguan internet, gangguan
                            pusat data, tindakan pemerintah, dan gangguan penyedia
                            layanan pihak ketiga.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            12. Hukum yang Berlaku
                        </h3>

                        <p class="mt-3">
                            Syarat dan Ketentuan ini diatur berdasarkan hukum yang
                            berlaku di Republik Indonesia.
                        </p>

                        <p class="mt-3">
                            Perselisihan akan diselesaikan terlebih dahulu melalui
                            musyawarah. Jika tidak tercapai penyelesaian,
                            perselisihan dapat diselesaikan melalui mekanisme hukum
                            yang berlaku di Indonesia.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            13. Perubahan Syarat dan Ketentuan
                        </h3>

                        <p class="mt-3">
                            Demas Store berhak memperbarui Syarat dan Ketentuan
                            ini sewaktu-waktu untuk menyesuaikan perkembangan
                            layanan, keamanan, kebijakan, dan hukum yang berlaku.
                        </p>

                        <p class="mt-3">
                            Versi terbaru akan ditampilkan pada website Demas
                            Store dan berlaku sejak tanggal diterbitkan.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            14. Ketentuan Lain-lain
                        </h3>

                        <p class="mt-3">
                            Syarat dan Ketentuan ini merupakan keseluruhan
                            perjanjian antara Pengguna dan Demas Store mengenai
                            penggunaan layanan.
                        </p>

                        <p class="mt-3">
                            Apabila salah satu ketentuan dianggap tidak sah atau
                            tidak dapat dilaksanakan, ketentuan lainnya tetap
                            berlaku.
                        </p>

                        <p class="mt-3">
                            Kegagalan Demas Store dalam menegakkan suatu ketentuan
                            tidak dianggap sebagai pengabaian hak untuk
                            menegakkannya di kemudian hari.
                        </p>
                    </section>

                    <section>
                        <h3 class="text-lg font-black text-[#25233a]">
                            15. Kontak
                        </h3>

                        <p class="mt-3">
                            Pertanyaan, kendala, klaim garansi, atau permintaan
                            bantuan dapat disampaikan melalui customer service
                            resmi yang tercantum pada website Demas Store.
                        </p>

                        <p class="mt-3">
                            Pengguna disarankan menyertakan nomor pesanan untuk
                            mempercepat proses pemeriksaan.
                        </p>
                    </section>
                </div>
            </div>

            <div class="border-t border-[#ece7df] bg-white px-5 py-4 sm:px-7">
                <p id="terms-scroll-message" class="mb-3 text-center text-xs font-bold text-[#ff7424]">
                    Scroll sampai bagian paling bawah untuk melanjutkan.
                </p>

                <div class="grid gap-3 sm:grid-cols-2">
                    <button id="reject-terms-button" type="button"
                        class="rounded-2xl border-2 border-[#ece7df] bg-white px-5 py-3 font-black text-[#77758d] transition hover:border-[#ff7424] hover:text-[#ff7424]">
                        Tidak Setuju
                    </button>

                    <button id="accept-terms-button" type="button" disabled
                        class="cursor-not-allowed rounded-2xl bg-[#d6d4dc] px-5 py-3 font-black text-white transition">
                        Saya Setuju dan Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('terms-modal');
                const termsCheckbox = document.getElementById('terms-checkbox');
                const openTermsButton = document.getElementById('open-terms-button');
                const closeTermsButton = document.getElementById('close-terms-button');
                const rejectTermsButton = document.getElementById('reject-terms-button');
                const acceptTermsButton = document.getElementById('accept-terms-button');
                const termsScrollContent = document.getElementById('terms-scroll-content');
                const termsScrollMessage = document.getElementById('terms-scroll-message');
                const registerForm = document.getElementById('register-form');

                let termsAccepted = {{ old('terms') ? 'true' : 'false' }};

                if (termsAccepted) {
                    termsCheckbox.checked = true;
                }

                function disableAcceptButton() {
                    acceptTermsButton.disabled = true;
                    acceptTermsButton.className =
                        'cursor-not-allowed rounded-2xl bg-[#d6d4dc] px-5 py-3 font-black text-white transition';

                    termsScrollMessage.textContent =
                        'Scroll sampai bagian paling bawah untuk mengaktifkan tombol.';

                    termsScrollMessage.className =
                        'mb-3 text-center text-xs font-bold text-[#ff7424]';
                }

                function enableAcceptButton() {
                    acceptTermsButton.disabled = false;
                    acceptTermsButton.className =
                        'rounded-2xl bg-[#304cb2] px-5 py-3 font-black text-white transition hover:-translate-y-0.5 hover:bg-[#273f96]';

                    termsScrollMessage.textContent =
                        'Syarat dan Ketentuan telah dibaca sampai selesai.';

                    termsScrollMessage.className =
                        'mb-3 text-center text-xs font-bold text-green-600';
                }

                function openTermsModal() {
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    document.body.classList.add('overflow-hidden');

                    termsScrollContent.scrollTop = 0;

                    disableAcceptButton();

                    window.setTimeout(function() {
                        closeTermsButton.focus();

                        const contentNotScrollable =
                            termsScrollContent.scrollHeight <=
                            termsScrollContent.clientHeight + 8;

                        if (contentNotScrollable) {
                            enableAcceptButton();
                        }
                    }, 50);
                }

                function closeTermsModal() {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');

                    document.body.classList.remove('overflow-hidden');
                }

                termsCheckbox.addEventListener('click', function(event) {
                    if (termsAccepted && termsCheckbox.checked === false) {
                        termsAccepted = false;
                        return;
                    }

                    if (!termsAccepted) {
                        event.preventDefault();
                        termsCheckbox.checked = false;
                        openTermsModal();
                    }
                });

                openTermsButton.addEventListener('click', function() {
                    openTermsModal();
                });

                closeTermsButton.addEventListener('click', function() {
                    if (!termsAccepted) {
                        termsCheckbox.checked = false;
                    }

                    closeTermsModal();
                });

                rejectTermsButton.addEventListener('click', function() {
                    termsAccepted = false;
                    termsCheckbox.checked = false;
                    closeTermsModal();
                });

                acceptTermsButton.addEventListener('click', function() {
                    if (acceptTermsButton.disabled) {
                        return;
                    }

                    termsAccepted = true;
                    termsCheckbox.checked = true;
                    closeTermsModal();
                });

                termsScrollContent.addEventListener('scroll', function() {
                    const remainingScroll =
                        termsScrollContent.scrollHeight -
                        termsScrollContent.scrollTop -
                        termsScrollContent.clientHeight;

                    if (remainingScroll <= 12) {
                        enableAcceptButton();
                    }
                });

                modal.addEventListener('click', function(event) {
                    if (event.target === modal && termsAccepted) {
                        closeTermsModal();
                    }
                });

                document.addEventListener('keydown', function(event) {
                    if (
                        event.key === 'Escape' &&
                        !modal.classList.contains('hidden')
                    ) {
                        if (!termsAccepted) {
                            termsCheckbox.checked = false;
                        }

                        closeTermsModal();
                    }
                });

                registerForm.addEventListener('submit', function(event) {
                    if (!termsAccepted || !termsCheckbox.checked) {
                        event.preventDefault();
                        termsCheckbox.checked = false;
                        openTermsModal();
                    }
                });

                document
                    .querySelectorAll('[data-password-toggle]')
                    .forEach(function(button) {
                        button.addEventListener('click', function() {
                            const inputId =
                                button.getAttribute('data-password-toggle');

                            const input = document.getElementById(inputId);
                            const eyeOpen = button.querySelector('[data-eye-open]');
                            const eyeClosed = button.querySelector('[data-eye-closed]');

                            const isHidden = input.type === 'password';

                            input.type = isHidden ? 'text' : 'password';

                            eyeOpen.classList.toggle('hidden', isHidden);
                            eyeClosed.classList.toggle('hidden', !isHidden);

                            button.setAttribute(
                                'aria-label',
                                isHidden ?
                                'Sembunyikan kata sandi' :
                                'Tampilkan kata sandi'
                            );
                        });
                    });

                document
                    .getElementById('refresh-turnstile')
                    ?.addEventListener('click', function() {
                        if (typeof turnstile !== 'undefined') {
                            turnstile.reset('#turnstile-widget');
                        }
                    });
            });
        </script>
    @endpush
@endsection

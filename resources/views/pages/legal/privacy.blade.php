@extends('layouts.storefront')

@section('title', 'Kebijakan Privasi — Demas Store')

@section('content')
    <section class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-[32px] border-2 border-[#ece7df] bg-white p-6 shadow-sm sm:p-10">
                <div class="border-b border-[#ece7df] pb-6 text-center">
                    <h1 class="text-3xl font-black text-[#25233a]">
                        Kebijakan Privasi
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
                            Kebijakan Privasi ini menjelaskan bagaimana Demas
                            Store mengumpulkan, menggunakan, menyimpan, dan
                            melindungi informasi Pengguna.
                        </p>

                        <p class="mt-3">
                            Dengan menggunakan layanan Demas Store, Pengguna
                            menyetujui pemrosesan data sesuai Kebijakan Privasi ini.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            2. Informasi yang Dikumpulkan
                        </h2>

                        <p class="mt-3">
                            Demas Store dapat mengumpulkan informasi berikut:
                        </p>

                        <ul class="mt-3 list-disc space-y-2 pl-6">
                            <li>Nama lengkap.</li>
                            <li>Alamat email.</li>
                            <li>Nomor WhatsApp.</li>
                            <li>Username.</li>
                            <li>Riwayat transaksi dan pesanan.</li>
                            <li>Alamat IP dan informasi perangkat.</li>
                            <li>Informasi lain yang diberikan kepada customer service.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            3. Penggunaan Informasi
                        </h2>

                        <p class="mt-3">
                            Informasi Pengguna digunakan untuk:
                        </p>

                        <ul class="mt-3 list-disc space-y-2 pl-6">
                            <li>Membuat dan mengelola akun.</li>
                            <li>Memproses pesanan dan pembayaran.</li>
                            <li>Mengirimkan produk atau informasi transaksi.</li>
                            <li>Menangani klaim garansi dan bantuan.</li>
                            <li>Mencegah penipuan dan penyalahgunaan.</li>
                            <li>Meningkatkan kualitas layanan.</li>
                            <li>Memenuhi kewajiban hukum.</li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            4. Informasi Pembayaran
                        </h2>

                        <p class="mt-3">
                            - Pembayaran diproses melalui penyedia pembayaran pihak
                            ketiga. Demas Store tidak menyimpan PIN, CVV, kata
                            sandi perbankan, atau kode OTP Pengguna.
                        </p>

                        <p class="mt-3">
                            - Informasi tertentu seperti nomor transaksi, metode
                            pembayaran, jumlah pembayaran, dan status transaksi
                            dapat disimpan untuk keperluan pencatatan pesanan.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            5. Cookies
                        </h2>

                        <p class="mt-3">
                            Demas Store dapat menggunakan cookies untuk menjaga
                            sesi login, menyimpan keranjang, meningkatkan keamanan,
                            dan memberikan pengalaman penggunaan yang lebih baik.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            6. Pembagian Informasi
                        </h2>

                        <p class="mt-3">
                            - Demas Store tidak menjual data pribadi Pengguna.
                        </p>

                        <p class="mt-3">
                            - Informasi dapat dibagikan secara terbatas kepada
                            penyedia pembayaran, layanan email, hosting, keamanan,
                            atau pihak lain yang diperlukan untuk menjalankan
                            layanan.
                        </p>

                        <p class="mt-3">
                            - Informasi juga dapat diberikan apabila diwajibkan
                            oleh hukum atau permintaan resmi pihak berwenang.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            7. Keamanan Data
                        </h2>

                        <p class="mt-3">
                            - Demas Store menerapkan langkah teknis dan operasional
                            yang wajar untuk melindungi data Pengguna.
                        </p>

                        <p class="mt-3">
                            - Namun, tidak ada sistem elektronik yang dapat menjamin
                            keamanan sepenuhnya. Pengguna juga wajib menjaga
                            kerahasiaan kata sandi dan perangkatnya.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            8. Penyimpanan Data
                        </h2>

                        <p class="mt-3">
                            Data disimpan selama diperlukan untuk menyediakan
                            layanan, menyelesaikan transaksi, menangani sengketa,
                            mencegah penipuan, dan memenuhi kewajiban hukum.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            9. Hak Pengguna
                        </h2>

                        <p class="mt-3">
                            - Pengguna dapat meminta pembaruan atau koreksi terhadap
                            data pribadi yang tidak akurat.
                        </p>

                        <p class="mt-3">
                            - Permintaan penghapusan data dapat diajukan kepada
                            customer service, sepanjang data tersebut tidak masih
                            diperlukan untuk transaksi, keamanan, atau kewajiban hukum.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            10. Layanan Pihak Ketiga
                        </h2>

                        <p class="mt-3">
                            Website dapat menggunakan atau mengarahkan Pengguna
                            ke layanan pihak ketiga. Kebijakan privasi pihak
                            ketiga tersebut berada di luar kendali Demas Store.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            11. Perubahan Kebijakan
                        </h2>

                        <p class="mt-3">
                            Demas Store berhak memperbarui Kebijakan Privasi ini
                            untuk menyesuaikan perubahan layanan, teknologi,
                            keamanan, dan peraturan yang berlaku.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-black text-[#25233a]">
                            12. Kontak
                        </h2>

                        <p class="mt-3">
                            Pertanyaan mengenai privasi dan penggunaan data dapat
                            disampaikan melalui customer service resmi Demas Store.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

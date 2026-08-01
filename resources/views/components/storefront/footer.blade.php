<footer id="footer" class="mt-12 overflow-hidden bg-[#25233a] text-white">
    <div class="border-t-4 border-[#ffd84d]">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <div class="flex items-center justify-center gap-3">
                    <span
                        class="grid h-12 w-12 place-items-center rounded-2xl bg-[#ffd84d] text-xl font-black text-[#25233a]">
                        D
                    </span>

                    <span class="text-xl font-black">
                        DEMAS STORE
                    </span>
                </div>

                <p class="mt-5 leading-7 text-white/65">
                    Demas Store menyediakan berbagai pilihan aplikasi premium
                    dengan proses pembelian yang praktis, stok yang jelas, dan
                    pelayanan yang cepat. Temukan paket yang sesuai dengan
                    kebutuhanmu dan nikmati pengalaman belanja digital yang aman
                    serta nyaman.
                </p>
            </div>

            <div class="mt-12 grid gap-10 text-center sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <h3 class="font-black text-[#ffd84d]">
                        Peta Situs
                    </h3>

                    <div class="mt-5 grid gap-3 text-sm text-white/65">
                        <a class="transition hover:text-white" href="{{ route('home') }}">
                            Beranda
                        </a>

                        <a class="transition hover:text-white" href="{{ route('home') }}#katalog">
                            Katalog
                        </a>

                        @guest
                            <a class="transition hover:text-white" href="{{ route('login') }}">
                                Masuk
                            </a>

                            <a class="transition hover:text-white" href="{{ route('register') }}">
                                Daftar
                            </a>
                        @endguest

                        @auth
                            <a class="transition hover:text-white" href="{{ route('account.orders.index') }}">
                                Pesanan Saya
                            </a>
                        @endauth
                    </div>
                </div>

                <div>
                    <h3 class="font-black text-[#ffd84d]">
                        Dukungan
                    </h3>

                    <div class="mt-5 grid gap-3 text-sm text-white/65">
                        <a class="transition hover:text-white"
                            href="https://wa.me/{{ config('services.whatsapp.customer_service', '6282138001793') }}"
                            target="_blank" rel="noopener noreferrer">
                            WhatsApp
                        </a>

                        <a class="transition hover:text-white" href="mailto:demasstore77@gmail.com">
                            Email
                        </a>

                        <a href="{{ route('purchase-guide') }}" class="transition hover:text-white hover:underline">
                            Cara Pembelian
                        </a>

                        <a href="{{ route('faq') }}" class="transition hover:text-white hover:underline">
                            FAQ
                        </a>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="font-black text-[#ffd84d]">
                        Legalitas
                    </h3>

                    <div class="mt-5 grid gap-3 text-sm text-white/65">
                        <a href="{{ route('terms') }}" class="transition hover:text-white hover:underline">
                            Syarat dan Ketentuan
                        </a>

                        <a href="{{ route('privacy') }}" class="transition hover:text-white hover:underline">
                            Kebijakan Privasi
                        </a>

                        <a href="{{ route('refund-policy') }}" class="transition hover:text-white hover:underline">
                            Kebijakan Pengembalian
                        </a>
                    </div>
                </div>

                <div>
                    <h3 class="font-black text-[#ffd84d]">
                        Media Sosial
                    </h3>

                    <div class="mt-5 grid gap-3 text-sm text-white/65">
                        <a class="transition hover:text-white" href="#" target="_blank" rel="noopener noreferrer">
                            Instagram Demas Store
                        </a>

                        <a class="transition hover:text-white" href="#" target="_blank" rel="noopener noreferrer">
                            TikTok Demas Store
                        </a>

                        <a class="transition hover:text-white" href="#" target="_blank" rel="noopener noreferrer">
                            Twitter X Demas Store
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-6 text-center text-sm text-white/45">
                © {{ date('Y') }} Demas Store. All rights reserved.
            </div>
        </div>
    </div>
</footer>

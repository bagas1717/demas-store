@php
    $headerCartCount = array_sum(session()->get('cart', []));
@endphp

<header class="sticky top-0 z-50 border-b border-[#dfe4ff] bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-20 items-center gap-3">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                <span
                    class="grid h-11 w-11 place-items-center rounded-2xl bg-[#304cb2] text-xl font-black text-white shadow-[4px_4px_0_#ff7424]">
                    D
                </span>

                <span class="hidden text-xl font-black tracking-tight lg:block">
                    DEMAS <span class="text-[#ff7424]">STORE</span>
                </span>
            </a>

            <form action="{{ route('home') }}" method="GET" class="relative min-w-0 flex-1">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#77758d]"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />
                </svg>

                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Cari Netflix, Canva, CapCut..."
                    class="h-12 w-full rounded-2xl border-2 border-[#dfe4ff] bg-[#f7f8ff] pl-12 pr-4 text-sm outline-none transition focus:border-[#304cb2]">
            </form>

            <div class="flex shrink-0 items-center gap-2">
                <a href="{{ route('cart.index') }}"
                    class="relative grid h-12 w-12 place-items-center rounded-2xl bg-[#ff8fab] text-white transition hover:-translate-y-0.5"
                    aria-label="Keranjang" title="Keranjang">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5.4 5M7 13l-2 4h14M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" />
                    </svg>

                    <span id="headerCartCount"
                        class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-[#304cb2] px-1 text-[10px] font-black">
                        {{ $headerCartCount }}
                    </span>
                </a>

                @auth
                    <a href="{{ route('account.orders.index') }}"
                        class="hidden rounded-2xl bg-[#9be28f] px-4 py-3 text-sm font-black text-[#25233a] lg:inline-flex">
                        Riwayat Pesanan
                    </a>

                    <a href="{{ route('account.orders.index') }}"
                        class="grid h-12 w-12 place-items-center rounded-2xl bg-[#9be28f] text-[#25233a] lg:hidden"
                        aria-label="Riwayat Pesanan" title="Riwayat Pesanan">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2ZM14 3v5h5" />
                        </svg>
                    </a>

                    <div class="relative" data-account-menu>
                        <button type="button" data-account-menu-button
                            class="flex h-12 items-center gap-2 rounded-2xl bg-[#ffd84d] px-2 font-black text-[#25233a] transition hover:-translate-y-0.5 sm:px-3"
                            aria-label="Buka menu akun" aria-expanded="false">
                            @if (auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                    class="h-9 w-9 rounded-xl object-cover" referrerpolicy="no-referrer">
                            @else
                                <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/70 text-sm font-black">
                                    {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif

                            <span class="hidden max-w-28 truncate text-sm xl:block">
                                {{ auth()->user()->name }}
                            </span>

                            <svg class="hidden h-4 w-4 xl:block" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div data-account-menu-panel
                            class="invisible absolute right-0 top-[calc(100%+12px)] z-[70] w-72 translate-y-2 rounded-3xl border-2 border-[#ece7df] bg-white p-3 opacity-0 shadow-2xl transition duration-200">
                            <div class="rounded-2xl bg-[#304cb2] p-4 text-white">
                                <p class="text-xs font-bold text-white/70">
                                    Telah masuk sebagai
                                </p>

                                <p class="mt-1 truncate font-black">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="mt-1 truncate text-xs text-white/70">
                                    {{ auth()->user()->email }}
                                </p>

                                @if (auth()->user()->is_admin)
                                    <span
                                        class="mt-3 inline-flex rounded-full bg-[#ffd84d] px-3 py-1 text-[10px] font-black text-[#25233a]">
                                        Administrator
                                    </span>
                                @endif
                            </div>

                            <div class="mt-2 grid gap-1">
                                <a href="{{ route('account.dashboard') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] transition hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                                    </svg>
                                    Dashboard Akun
                                </a>

                                <a href="{{ route('account.orders.index') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] transition hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M6 3h9l3 3v15H6z" />
                                        <path d="M9 10h6M9 14h6M9 18h4" />
                                    </svg>
                                    Riwayat Pesanan
                                </a>

                                <a href="{{ route('account.settings.edit') }}"
                                    class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] transition hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <circle cx="12" cy="12" r="3" />
                                        <path
                                            d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-2.83 2.83-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .6 1.7 1.7 0 0 0-.4 1v.1h-4v-.1a1.7 1.7 0 0 0-1.1-1.6 1.7 1.7 0 0 0-1.88.34l-.06.06-2.83-2.83.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.6-1 1.7 1.7 0 0 0-1-.4h-.1v-4H3a1.7 1.7 0 0 0 1.6-1.1 1.7 1.7 0 0 0-.34-1.88l-.06-.06 2.83-2.83.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.6 1.7 1.7 0 0 0 .4-1v-.1h4V3a1.7 1.7 0 0 0 1.1 1.6 1.7 1.7 0 0 0 1.88-.34l.06-.06 2.83 2.83-.06.06A1.7 1.7 0 0 0 19.4 9c.26.37.46.78.6 1 .13.39.2.8.2 1.2v.2c0 .4-.07.81-.2 1.2-.14.22-.34.63-.6 1Z" />
                                    </svg>
                                    Pengaturan
                                </a>

                                @if (auth()->user()->canAccessPanel(filament()->getPanel('admin')))
                                    <a href="{{ filament()->getPanel('admin')->getUrl() }}"
                                        class="flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] transition hover:bg-[#e8f3ff] hover:text-[#304cb2]">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z" />
                                        </svg>
                                        Panel Admin
                                    </a>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('logout') }}"
                                class="mt-2 border-t border-[#ece7df] pt-2">
                                @csrf
                                <button type="submit"
                                    class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-sm font-black text-red-500 transition hover:bg-red-50">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M10 17l5-5-5-5M15 12H3M14 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden text-sm font-black text-[#304cb2] sm:inline">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="rounded-2xl bg-[#ffd84d] px-4 py-3 text-sm font-black">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>

        <nav class="flex gap-2 overflow-x-auto pb-3">
            <a href="{{ route('home') }}"
                class="shrink-0 rounded-full bg-[#304cb2] px-4 py-2 text-xs font-bold text-white">
                Semua
            </a>

            <a href="{{ route('home') }}#populer"
                class="shrink-0 rounded-full bg-[#ffd84d] px-4 py-2 text-xs font-bold">
                Populer
            </a>

            <a href="{{ route('home') }}#katalog"
                class="shrink-0 rounded-full bg-[#9be28f] px-4 py-2 text-xs font-bold">
                Produk
            </a>

            <a href="{{ route('home') }}#footer"
                class="shrink-0 rounded-full bg-[#b8a1ff] px-4 py-2 text-xs font-bold">
                Bantuan
            </a>
        </nav>
    </div>
</header>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menus = document.querySelectorAll('[data-account-menu]');

                menus.forEach(function(menu) {
                    const button = menu.querySelector('[data-account-menu-button]');
                    const panel = menu.querySelector('[data-account-menu-panel]');

                    if (!button || !panel) {
                        return;
                    }

                    const closeMenu = function() {
                        panel.classList.add('invisible', 'translate-y-2', 'opacity-0');
                        panel.classList.remove('visible', 'translate-y-0', 'opacity-100');
                        button.setAttribute('aria-expanded', 'false');
                    };

                    const openMenu = function() {
                        panel.classList.remove('invisible', 'translate-y-2', 'opacity-0');
                        panel.classList.add('visible', 'translate-y-0', 'opacity-100');
                        button.setAttribute('aria-expanded', 'true');
                    };

                    button.addEventListener('click', function(event) {
                        event.stopPropagation();

                        if (button.getAttribute('aria-expanded') === 'true') {
                            closeMenu();
                        } else {
                            openMenu();
                        }
                    });

                    document.addEventListener('click', function(event) {
                        if (!menu.contains(event.target)) {
                            closeMenu();
                        }
                    });

                    document.addEventListener('keydown', function(event) {
                        if (event.key === 'Escape') {
                            closeMenu();
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce

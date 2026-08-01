@php
    $user = auth()->user();
@endphp

<header class="sticky top-0 z-50 border-b border-[#dfe4ff] bg-white/95 backdrop-blur">
    <div class="flex min-h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex min-w-0 items-center gap-3">
            <button
                type="button"
                data-open-account-sidebar
                class="grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-[#304cb2] text-white lg:hidden"
                aria-label="Buka menu akun"
            >
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>

            <div class="min-w-0">
                <p class="truncate text-sm font-black text-[#25233a]">
                    @yield('account-heading', 'Akun Saya')
                </p>
                <p class="truncate text-xs text-[#77758d]">Demas Store</p>
            </div>
        </div>

        <div class="relative" data-account-menu>
            <button
                type="button"
                data-account-menu-button
                class="flex h-12 items-center gap-2 rounded-2xl bg-[#ffd84d] px-2 font-black text-[#25233a] transition hover:-translate-y-0.5 sm:px-3"
                aria-expanded="false"
                aria-label="Buka menu akun"
            >
                @if ($user->avatar)
                    <img
                        src="{{ $user->avatar }}"
                        alt="{{ $user->name }}"
                        class="h-9 w-9 rounded-xl object-cover"
                        referrerpolicy="no-referrer"
                    >
                @else
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/70 text-sm font-black">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                @endif

                <span class="hidden max-w-32 truncate text-sm sm:block">{{ $user->name }}</span>

                <svg class="hidden h-4 w-4 sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div
                data-account-menu-panel
                class="invisible absolute right-0 top-[calc(100%+12px)] z-[90] w-72 translate-y-2 rounded-3xl border-2 border-[#ece7df] bg-white p-3 opacity-0 shadow-2xl transition duration-200"
            >
                <div class="rounded-2xl bg-[#304cb2] p-4 text-white">
                    <p class="text-xs font-bold text-white/70">Telah masuk sebagai</p>
                    <p class="mt-1 truncate font-black">{{ $user->name }}</p>
                    <p class="mt-1 truncate text-xs text-white/70">{{ $user->email }}</p>

                    @if ($user->is_admin)
                        <span class="mt-3 inline-flex rounded-full bg-[#ffd84d] px-3 py-1 text-[10px] font-black text-[#25233a]">
                            Administrator
                        </span>
                    @endif
                </div>

                <div class="mt-2 grid gap-1">
                    <a href="{{ route('account.dashboard') }}"
                        class="rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                        Dashboard
                    </a>

                    <a href="{{ route('account.orders.index') }}"
                        class="rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                        Riwayat Pesanan
                    </a>

                    <a href="{{ route('account.settings.edit') }}"
                        class="rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] hover:bg-[#f7f8ff] hover:text-[#304cb2]">
                        Pengaturan
                    </a>

                    @if ($user->canAccessPanel(filament()->getPanel('admin')))
                        <a href="{{ filament()->getPanel('admin')->getUrl() }}"
                            class="rounded-2xl px-4 py-3 text-sm font-black text-[#5f5c70] hover:bg-[#e8f3ff] hover:text-[#304cb2]">
                            Panel Admin
                        </a>
                    @endif
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-[#ece7df] pt-2">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-2xl px-4 py-3 text-left text-sm font-black text-red-500 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('accountSidebar');
                const backdrop = document.getElementById('accountSidebarBackdrop');

                const openSidebar = () => {
                    sidebar?.classList.remove('-translate-x-full');
                    backdrop?.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                };

                const closeSidebar = () => {
                    sidebar?.classList.add('-translate-x-full');
                    backdrop?.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                };

                document.querySelector('[data-open-account-sidebar]')?.addEventListener('click', openSidebar);
                document.querySelector('[data-close-account-sidebar]')?.addEventListener('click', closeSidebar);
                backdrop?.addEventListener('click', closeSidebar);

                document.querySelectorAll('[data-account-menu]').forEach(function (menu) {
                    const button = menu.querySelector('[data-account-menu-button]');
                    const panel = menu.querySelector('[data-account-menu-panel]');

                    if (!button || !panel) return;

                    const closeMenu = () => {
                        panel.classList.add('invisible', 'translate-y-2', 'opacity-0');
                        panel.classList.remove('visible', 'translate-y-0', 'opacity-100');
                        button.setAttribute('aria-expanded', 'false');
                    };

                    const openMenu = () => {
                        panel.classList.remove('invisible', 'translate-y-2', 'opacity-0');
                        panel.classList.add('visible', 'translate-y-0', 'opacity-100');
                        button.setAttribute('aria-expanded', 'true');
                    };

                    button.addEventListener('click', function (event) {
                        event.stopPropagation();
                        button.getAttribute('aria-expanded') === 'true' ? closeMenu() : openMenu();
                    });

                    document.addEventListener('click', function (event) {
                        if (!menu.contains(event.target)) closeMenu();
                    });

                    document.addEventListener('keydown', function (event) {
                        if (event.key === 'Escape') {
                            closeMenu();
                            closeSidebar();
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce

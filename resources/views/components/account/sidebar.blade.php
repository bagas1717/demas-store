@php
    $user = auth()->user();
@endphp

<aside class="lg:sticky lg:top-40">
    <div class="overflow-hidden rounded-[26px] border-2 border-[#e3e6f5] bg-white shadow-sm">
        <div class="border-b border-[#ece7df] bg-[#f7f8ff] p-4">
            <div class="flex items-center gap-3">
                @if ($user->avatar)
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}"
                        class="h-12 w-12 shrink-0 rounded-2xl object-cover" referrerpolicy="no-referrer">
                @else
                    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl bg-[#ffd84d] font-black">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                @endif

                <div class="min-w-0">
                    <p class="truncate font-black">{{ $user->name }}</p>
                    <p class="truncate text-xs text-[#77758d]">{{ $user->email }}</p>
                    <span class="mt-2 inline-flex rounded-full bg-[#e8f3ff] px-2.5 py-1 text-[10px] font-black text-[#304cb2]">
                        {{ $user->is_admin ? 'Administrator' : 'Member' }}
                    </span>
                </div>
            </div>
        </div>

        <nav class="grid gap-1 p-3">
            <a href="{{ route('account.dashboard') }}"
                @class([
                    'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black transition',
                    'bg-[#ffd84d] text-[#25233a]' => request()->routeIs('account.dashboard'),
                    'text-[#666378] hover:bg-[#f7f8ff] hover:text-[#304cb2]' => !request()->routeIs('account.dashboard'),
                ])>
                Dashboard
            </a>

            <a href="{{ route('account.orders.index') }}"
                @class([
                    'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black transition',
                    'bg-[#9be28f] text-[#25233a]' => request()->routeIs('account.orders.*'),
                    'text-[#666378] hover:bg-[#f7f8ff] hover:text-[#304cb2]' => !request()->routeIs('account.orders.*'),
                ])>
                Riwayat Pesanan
            </a>

            <a href="{{ route('account.settings.edit') }}"
                @class([
                    'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-black transition',
                    'bg-[#304cb2] text-white' => request()->routeIs('account.settings.*'),
                    'text-[#666378] hover:bg-[#f7f8ff] hover:text-[#304cb2]' => !request()->routeIs('account.settings.*'),
                ])>
                Pengaturan
            </a>

            @if ($user->canAccessPanel(filament()->getPanel('admin')))
                <a href="{{ filament()->getPanel('admin')->getUrl() }}"
                    class="rounded-2xl px-4 py-3 text-sm font-black text-[#666378] transition hover:bg-[#e8f3ff] hover:text-[#304cb2]">
                    Panel Admin
                </a>
            @endif
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="border-t border-[#ece7df] p-3">
            @csrf
            <button type="submit"
                class="w-full rounded-2xl px-4 py-3 text-left text-sm font-black text-red-500 transition hover:bg-red-50">
                Keluar
            </button>
        </form>
    </div>
</aside>

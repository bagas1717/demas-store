<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Akun Saya — Demas Store')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-[#fff8ed] text-[#25233a]">
    <div class="flex min-h-screen flex-col">
        <x-storefront.header />

        <main class="flex-1">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
                <div class="grid gap-7 lg:grid-cols-4 xl:grid-cols-5">
                    <div class="lg:col-span-1">
                        <x-account.sidebar />
                    </div>

                    <section class="min-w-0 lg:col-span-3 xl:col-span-4">
                        @yield('content')
                    </section>
                </div>
            </div>
        </main>

        <x-storefront.footer />
    </div>

    <a
        href="https://wa.me/{{ config('services.whatsapp.customer_service', '6281234567890') }}?text={{ urlencode('Halo Demas Store, saya ingin bertanya.') }}"
        target="_blank"
        rel="noopener noreferrer"
        class="fixed bottom-4 right-4 z-40 flex items-center gap-3 rounded-2xl bg-[#ffd84d] px-4 py-3 font-black text-[#25233a] shadow-[0_10px_30px_rgba(37,35,58,0.28)] transition hover:-translate-y-1 hover:bg-[#ffcf1f] sm:bottom-6 sm:right-6"
    >
        <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/80">CS</span>
        <span class="hidden text-sm sm:inline">Customer Service</span>
    </a>

    @stack('scripts')
</body>
</html>

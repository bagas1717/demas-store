<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Demas Store - Katalog aplikasi premium.">

    <title>
        @yield('title', 'Demas Store')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    @if (config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
    @endif
</head>

<body @class([
    'min-h-screen',
    'bg-[#443e50] text-white' => View::hasSection('hide-storefront-chrome'),
    'bg-[#fff8ed] text-[#25233a]' => !View::hasSection(
        'hide-storefront-chrome'),
])>
    @unless (View::hasSection('hide-storefront-chrome'))
        <x-storefront.header />
    @endunless

    <main>
        @yield('content')
    </main>

    @unless (View::hasSection('hide-storefront-chrome'))
        <x-storefront.footer />

        <a href="https://wa.me/{{ config('services.whatsapp.customer_service', '6281234567890') }}?text={{ urlencode('Halo Demas Store, saya ingin bertanya.') }}"
            target="_blank" rel="noopener noreferrer"
            class="fixed bottom-4 right-4 z-50 flex items-center gap-3 rounded-2xl bg-[#ffd84d] px-4 py-3 font-black text-[#25233a] shadow-[0_10px_30px_rgba(37,35,58,0.28)] transition hover:-translate-y-1 hover:bg-[#ffcf1f] sm:bottom-6 sm:right-6"
            aria-label="Hubungi customer service melalui WhatsApp">
            <span class="grid h-9 w-9 place-items-center rounded-xl bg-white/80">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    aria-hidden="true">
                    <path d="M4 12a8 8 0 1 1 14.7 4.4L20 21l-4.7-1.2A8 8 0 0 1 4 12Z" />
                    <path d="M8.5 9.5c.8 2.2 2.1 3.5 4.3 4.3" />
                    <path d="M13.1 13.7c.5.2 1 .1 1.3-.3l.7-.9" />
                    <path d="M8.4 9.8c-.2-.5-.1-1 .3-1.3l.9-.7" />
                </svg>
            </span>

            <span class="hidden text-sm sm:inline">
                Customer Service
            </span>
        </a>
    @endunless

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dua Faktor</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-lg">
            <h1 class="text-center text-2xl font-bold text-gray-900">
                Verifikasi Dua Faktor
            </h1>

            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan kode autentikasi dari aplikasi authenticator.
            </p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/two-factor-challenge') }}" class="mt-6">
                @csrf

                <label for="code" class="block text-sm font-medium text-gray-700">
                    Kode autentikasi
                </label>

                <input
                    id="code"
                    name="code"
                    type="text"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    autofocus
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                    placeholder="Masukkan 6 digit kode"
                >

                <button
                    type="submit"
                    class="mt-4 w-full rounded-lg bg-gray-900 px-4 py-3 font-semibold text-white"
                >
                    Verifikasi
                </button>
            </form>

            <div class="my-5 flex items-center gap-3">
                <div class="h-px flex-1 bg-gray-200"></div>
                <span class="text-xs text-gray-500">atau</span>
                <div class="h-px flex-1 bg-gray-200"></div>
            </div>

            <form method="POST" action="{{ url('/two-factor-challenge') }}">
                @csrf

                <label for="recovery_code" class="block text-sm font-medium text-gray-700">
                    Recovery code
                </label>

                <input
                    id="recovery_code"
                    name="recovery_code"
                    type="text"
                    autocomplete="one-time-code"
                    class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                    placeholder="Masukkan recovery code"
                >

                <button
                    type="submit"
                    class="mt-4 w-full rounded-lg border border-gray-300 px-4 py-3 font-semibold text-gray-800"
                >
                    Gunakan recovery code
                </button>
            </form>
        </div>
    </div>
</body>
</html>
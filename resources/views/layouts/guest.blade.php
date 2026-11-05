<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $brandName ?? config('app.name', 'MEP Solutions') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-brand-900 antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">

        <!-- BRAND PANEL -->
        <div class="relative hidden overflow-hidden bg-brand-950 text-white lg:flex lg:flex-col lg:items-center lg:justify-center lg:p-12">
            <div class="absolute inset-0 texture-grid opacity-40"></div>
            <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-ember-500/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 h-96 w-96 rounded-full bg-aqua-500/20 blur-3xl"></div>

            <div class="relative flex flex-col items-center text-center">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-6">
                    <span class="grid h-20 w-20 place-items-center rounded-2xl bg-gradient-to-br from-ember-500 to-ember-600 font-display text-2xl font-bold leading-none shadow-lift">{{ $brandInitials ?? 'BR' }}</span>
                    <span class="font-display text-3xl font-extrabold tracking-tight">{{ $brandName ?? 'MEP Solutions' }}</span>
                </a>
                <p class="mt-6 max-w-xs leading-relaxed text-brand-200">Trusted technical services — managed all in one place.</p>
            </div>
        </div>

        <!-- FORM PANEL -->
        <div class="flex items-center justify-center bg-brand-50/50 p-6 sm:p-10">
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="mb-8 flex items-center justify-center gap-2.5 lg:hidden">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-ember-500 to-ember-600 font-display text-lg font-bold text-white">{{ $brandInitials ?? 'BR' }}</span>
                    <span class="font-display text-xl font-bold text-brand-900">{{ $brandName ?? 'MEP Solutions' }}</span>
                </a>

                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-sm text-brand-400">
                    @php $isLogin = request()->routeIs('login'); @endphp
                    <a href="{{ $isLogin ? route('home') : route('login') }}" class="font-semibold text-brand-500 transition hover:text-brand-700">
                        {{ $isLogin ? '← Back to website' : '← Back to sign in' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
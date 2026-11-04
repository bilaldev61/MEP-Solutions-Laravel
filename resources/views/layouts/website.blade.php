<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $settings['hero_subtitle'] ?? 'Professional plumbing, welding, cleaning and wiring services.' }}">
    <title>{{ $settings['site_name'] ?? 'MEP Solutions' }} — @yield('title')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans">

    @php
    $navLinks = [
    'Home' => route('home'),
    'Services' => route('services'),
    'About Us' => route('about'),
    'Contact' => route('contact'),
    ];
    @endphp

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 bg-brand-950/85 backdrop-blur-md shadow-lift">
        <div x-data="{ open: false }" class="shell flex items-center justify-between py-2.5">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-ember-500 to-ember-600 text-white font-display font-bold">{{ $brandInitials }}</span>
                <span class="font-display text-lg font-bold text-white">
                    {{ $settings['site_name'] ?? $brandName }}
                </span>
            </a>

            <!-- Desktop nav -->
            <nav class="hidden items-center gap-8 md:flex">
                @foreach($navLinks as $label => $url)
                <a href="{{ $url }}"
                    class="{{ request()->url() === $url ? 'text-ember-400 after:w-full' : '' }} nav-link">
                    {{ $label }}
                </a>
                @endforeach
            </nav>

            <div class="hidden md:block">
                <a href="tel:{{ $settings['phone'] ?? '' }}" class="btn-primary !py-2 !text-[13px]">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    Call Now
                </a>
            </div>

            <!-- Mobile toggle -->
            <button @click="open = !open" class="text-white md:hidden" aria-label="Toggle menu">
                <svg x-show="!open" class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                </svg>
                <svg x-show="open" x-cloak class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>

            <!-- Mobile panel -->
            <div x-show="open" x-cloak x-transition.origin.top
                class="absolute inset-x-0 top-full border-t border-white/10 bg-brand-950/95 backdrop-blur-md md:hidden">
                <nav class="shell flex flex-col gap-1 py-4">
                    @foreach($navLinks as $label => $url)
                    <a href="{{ $url }}"
                        class="rounded-lg px-4 py-3 text-sm font-medium {{ request()->url() === $url ? 'bg-white/10 text-ember-400' : 'text-brand-100 hover:bg-white/5' }}">
                        {{ $label }}
                    </a>
                    @endforeach
                    <a href="tel:{{ $settings['phone'] ?? '' }}" class="btn-primary mt-2"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg> Call Now</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    @yield('content')

    <!-- FOOTER -->
    <footer class="mt-20 bg-brand-950 text-brand-200">
        <div class="shell grid gap-10 py-14 md:grid-cols-4">
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-ember-500 to-ember-600 font-display font-bold text-white">{{ $brandInitials }}</span>
                    <span class="font-display text-lg font-bold text-white">{{ $settings['site_name'] ?? 'MEP Solutions' }}</span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-brand-300">
                    {{ $settings['hero_subtitle'] ?? 'Licensed technicians for plumbing, welding, cleaning and electrical work — homes and businesses, around the clock.' }}
                </p>
            </div>
            <div>
                <h4 class="font-display text-sm font-bold uppercase tracking-wider text-white">Explore</h4>
                <ul class="mt-4 space-y-2 text-sm">
                    @foreach($navLinks as $label => $url)
                    <li><a href="{{ $url }}" class="text-brand-300 transition hover:text-ember-400">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="font-display text-sm font-bold uppercase tracking-wider text-white">Get in touch</h4>
                <ul class="mt-4 space-y-3 text-sm">
                    <li class="flex items-start gap-2"><span>📞</span><a href="tel:{{ $settings['phone'] ?? '' }}" class="hover:text-ember-400">{{ $settings['phone'] ?? 'Call us' }}</a></li>
                    <li class="flex items-start gap-2"><span>📧</span><span>{{ $settings['email'] ?? 'info@brmepsolutions.com' }}</span></li>
                    <li class="flex items-start gap-2"><span>📍</span><span>{{ $settings['address'] ?? 'United States' }}</span></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="shell flex flex-col items-center justify-between gap-2 py-5 text-xs text-brand-400 sm:flex-row">
                <p>© {{ date('Y') }} {{ $settings['site_name'] ?? 'MEP Solutions' }}. All rights reserved.</p>
                <p>{{ $settings['working_hours'] ?? 'Open 24/7 for emergencies' }}</p>
            </div>
        </div>
    </footer>

    <!-- FLOATING ACTIONS -->
    <div class="fixed bottom-4 right-4 z-50 flex flex-col items-end gap-2 sm:bottom-6 sm:right-6 sm:gap-3">
        <a href="{{ route('contact') }}"
            class="btn-primary !px-4 !py-2.5 shadow-lift sm:!px-6 sm:!py-3" title="Get a free quote">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
            </svg><span class="hidden sm:inline">Free Quote</span>
        </a>
        <a href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}" target="_blank" rel="noopener"
            class="grid h-12 w-12 place-items-center rounded-full bg-[#25D366] text-white shadow-lift transition hover:scale-105 sm:h-14 sm:w-14"
            title="Chat on WhatsApp">
            <svg viewBox="0 0 24 24" class="h-6 w-6 sm:h-7 sm:w-7" fill="currentColor">
                <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm5.8 14.09c-.24.68-1.42 1.32-1.95 1.36-.5.05-1.14.08-1.83-.11-.42-.11-.96-.29-1.65-.59-2.9-1.25-4.79-4.17-4.93-4.36-.14-.19-1.18-1.57-1.18-3s.75-2.12 1.01-2.41c.26-.29.57-.36.76-.36l.55.01c.18 0 .42-.07.65.5.24.58.81 2 .88 2.14.07.14.12.31.02.5-.1.19-.14.31-.29.48-.14.17-.3.38-.43.51-.14.14-.29.29-.12.57.17.29.75 1.24 1.62 2.01 1.11.99 2.05 1.3 2.34 1.44.29.14.45.12.62-.07.17-.19.71-.83.9-1.11.19-.29.38-.24.64-.14.26.1 1.65.78 1.94.92.29.14.48.22.55.34.07.12.07.68-.17 1.36Z" />
            </svg>
        </a>
    </div>

</body>

</html>
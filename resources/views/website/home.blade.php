@extends('layouts.website')
@section('title', 'Professional Technical Services')

@php
// Map each trade to a signature colour so cards feel distinct, not templated.
$trade = function (string $name): array {
$n = strtolower($name);
if (str_contains($n, 'plumb') || str_contains($n, 'water') || str_contains($n, 'leak') || str_contains($n, 'drain'))
return ['bar' => 'from-aqua-400 to-aqua-600', 'chip' => 'bg-aqua-50 text-aqua-700'];
if (str_contains($n, 'weld') || str_contains($n, 'fabricat') || str_contains($n, 'metal'))
return ['bar' => 'from-ember-400 to-ember-600', 'chip' => 'bg-ember-50 text-ember-700'];
if (str_contains($n, 'wir') || str_contains($n, 'electric') || str_contains($n, 'light') || str_contains($n, 'power'))
return ['bar' => 'from-amber-400 to-ember-500', 'chip' => 'bg-amber-50 text-amber-700'];
if (str_contains($n, 'clean') || str_contains($n, 'ac') || str_contains($n, 'hvac') || str_contains($n, 'maint'))
return ['bar' => 'from-emerald-400 to-aqua-600', 'chip' => 'bg-emerald-50 text-emerald-700'];
return ['bar' => 'from-brand-400 to-brand-600', 'chip' => 'bg-brand-50 text-brand-700'];
};
@endphp

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-brand-950 text-white">
    <div class="absolute inset-0 texture-grid opacity-40"></div>
    <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-ember-500/20 blur-3xl"></div>
    <div class="absolute -bottom-32 -left-16 h-96 w-96 rounded-full bg-aqua-500/20 blur-3xl"></div>

    <div class="shell relative grid items-center gap-10 py-14 sm:py-20 lg:grid-cols-2 lg:gap-12">
        <div class="animate-fade-up">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-ember-300 ring-1 ring-white/15">
                ⚡ Licensed &amp; insured technicians
            </span>
            <h1 class="mt-6 font-display text-4xl font-extrabold leading-tight text-balance sm:text-5xl lg:text-6xl">
                {{ $settings['hero_title'] ?? 'Expert plumbing, welding, cleaning &amp; wiring' }}
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-relaxed text-brand-200">
                {{ $settings['hero_subtitle'] ?? 'Fast, reliable technical services for homes and businesses — done right the first time.' }}
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:mt-9 sm:flex-row sm:flex-wrap sm:gap-4">
                <a href="{{ route('contact') }}" class="btn-primary w-full text-base sm:w-auto">Get Free Quote</a>
                <a href="tel:{{ $settings['phone'] ?? '' }}" class="btn-ghost w-full text-base sm:w-auto">📞 Call Now</a>
            </div>
            <div class="mt-8 flex flex-wrap gap-x-6 gap-y-3 text-sm text-brand-300 sm:mt-10 sm:gap-x-8">
                <span class="flex items-center gap-2">✔ Same-day response</span>
                <span class="flex items-center gap-2">✔ Transparent pricing</span>
                <span class="flex items-center gap-2">✔ Workmanship guaranteed</span>
            </div>
        </div>

        <!-- Hero image -->
        <div class="animate-fade-up relative" style="animation-delay:.1s">
            <div class="rounded-4xl bg-gradient-to-br from-white/10 to-white/5 p-3 ring-1 ring-white/15 backdrop-blur">
                <div class="relative overflow-hidden rounded-[1.6rem] ring-1 ring-white/10">
                    <img src="{{ asset('images/hero-worker.webp') }}"
                        alt="Professional technician at work"
                        class="h-[18rem] w-full object-cover object-top sm:h-[24rem]"
                        width="1200" height="1500" loading="eager" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-950/85 via-brand-950/10 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 flex flex-wrap justify-center gap-1.5 p-3 sm:gap-2 sm:p-5">
                        @php $chipClass = 'inline-flex items-center gap-1.5 rounded-full bg-white/12 px-2.5 py-1 text-xs font-semibold text-white ring-1 ring-white/20 backdrop-blur transition hover:bg-white/25 hover:ring-white/40 sm:px-3 sm:py-1.5'; @endphp
                        @forelse($services->take(4) as $service)
                        <a href="{{ route('services') }}#service-{{ $service->id }}" class="{{ $chipClass }}">
                            <span aria-hidden>{{ $service->icon ?? '🔧' }}</span> {{ $service->name }}
                        </a>
                        @empty
                        @foreach([['🔧','Plumbing'],['🔥','Welding'],['🧴','Cleaning'],['⚡','Wiring']] as $t)
                        <a href="{{ route('services') }}" class="{{ $chipClass }}">{{ $t[0] }} {{ $t[1] }}</a>
                        @endforeach
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="absolute right-2 top-2 rounded-lg bg-white px-3 py-1.5 shadow-lift sm:-left-4 sm:-top-5 sm:right-auto sm:rounded-2xl sm:px-5 sm:py-4">
                <p class="font-display text-base font-extrabold leading-none text-brand-900 sm:text-2xl">24/7</p>
                <p class="mt-0.5 text-[9px] font-semibold uppercase tracking-wider text-ember-600 sm:mt-1 sm:text-xs">Service</p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section class="section bg-brand-100">
    <div class="shell">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Our Services</span>
            <h2 class="section-title">Solutions for every trade</h2>
            <p class="section-sub">One trusted team for all your home and business technical needs.</p>
        </div>

        <div class="mt-10 grid gap-7 sm:mt-14 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($services as $service)
            @php $c = $trade($service->name); @endphp
            <article class="card group relative overflow-hidden p-0">
                <!-- Fixed-height stripe container; only the absolutely-positioned
                     inner bar changes height, so hover never resizes the grid row. -->
                <div class="relative h-2.5 w-full">
                    <div class="absolute inset-x-0 bottom-0 h-1.5 bg-gradient-to-r {{ $c['bar'] }} transition-all duration-300 group-hover:h-2.5"></div>
                </div>
                <!-- Soft oversized icon watermark -->
                <span aria-hidden class="pointer-events-none absolute -right-4 -top-5 select-none text-[7rem] leading-none opacity-[0.06] transition-opacity duration-300 group-hover:opacity-[0.12]">{{ $service->icon ?? '🔧' }}</span>
                <div class="relative p-6">
                    <div class="flex items-center gap-4">
                        <span class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl text-3xl {{ $c['chip'] }} shadow-sm transition-transform duration-300 group-hover:scale-105">{{ $service->icon ?? '🔧' }}</span>
                        <h3 class="font-display text-lg font-bold text-brand-900">{{ $service->name }}</h3>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-brand-500">{{ $service->description }}</p>
                    <a href="{{ route('contact') }}" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-ember-600 transition-colors hover:text-ember-700">
                        Request this service <span aria-hidden class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full rounded-2xl border border-dashed border-brand-200 py-16 text-center text-brand-400">
                Services coming soon.
            </div>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('services') }}" class="btn-dark hover:bg-ember-500">View All Services</a>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="section bg-brand-50">
    <div class="shell">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">Why BR MEP Solutions</span>
            <h2 class="section-title">Built on reliability</h2>
            <p class="section-sub">Everything you want in a technical services partner — delivered professionally.</p>
        </div>
        <div class="mt-10 grid gap-6 sm:mt-14 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
            ['⚡','Fast Response','We arrive quickly when you need us most'],
            ['🛡️','Licensed &amp; Insured','Fully certified, insured professionals'],
            ['💯','Quality Work','Guaranteed satisfaction on every job'],
            ['🕐','24/7 Available','Emergency service around the clock'],
            ] as $f)
            <div class="card group text-left transition duration-200 hover:-translate-y-1 hover:shadow-lift">
                <span class="grid h-14 w-14 place-items-center rounded-2xl bg-brand-900 text-3xl text-white transition duration-200 group-hover:bg-ember-500">{{ $f[0] }}</span>
                <h3 class="mt-5 font-display text-lg font-bold text-brand-900">{!! $f[1] !!}</h3>
                <p class="mt-2 text-sm leading-relaxed text-brand-500">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- PROCESS -->
<section class="section bg-brand-950 text-white">
    <div class="shell">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow text-ember-300">How it works</span>
            <h2 class="section-title text-white">From call to fixed in 3 steps</h2>
        </div>
        <div class="mt-10 grid gap-8 sm:mt-14 md:grid-cols-3">
            @foreach([
            ['01','Tell us the issue','Reach out by phone, WhatsApp or the quote form.'],
            ['02','We diagnose &amp; quote','A technician assesses the job with clear, upfront pricing.'],
            ['03','We fix it right','Quality workmanship, guaranteed and cleaned up.'],
            ] as $s)
            <div class="relative rounded-2xl bg-white/5 p-7 ring-1 ring-white/10">
                <span class="font-display text-5xl font-extrabold text-ember-500/40">{{ $s[0] }}</span>
                <h3 class="mt-2 font-display text-lg font-bold text-white">{!! $s[1] !!}</h3>
                <p class="mt-2 text-sm text-brand-300">{!! $s[2] !!}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="shell">
        <div class="relative overflow-hidden rounded-4xl bg-gradient-to-br from-ember-500 to-ember-700 px-8 py-16 text-center shadow-lift sm:px-16">
            <div class="absolute inset-0 texture-grid opacity-30"></div>
            <div class="relative">
                <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">Need help right now?</h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-ember-50">Contact us today for a free quote — fast, reliable service.</p>
                <div class="mt-8 flex flex-col gap-3 sm:mt-9 sm:flex-row sm:flex-wrap sm:justify-center sm:gap-4">
                    <a href="{{ route('contact') }}" class="btn w-full bg-brand-950 text-white hover:bg-brand-900 sm:w-auto">Get Free Quote</a>
                    <a href="tel:{{ $settings['phone'] ?? '' }}" class="btn w-full bg-white text-ember-700 hover:bg-ember-50 sm:w-auto">📞 {{ $settings['phone'] ?? 'Call Us' }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
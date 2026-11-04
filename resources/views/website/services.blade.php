@extends('layouts.website')
@section('title', 'Our Services')

@php
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
    <div class="absolute -right-16 top-0 h-72 w-72 rounded-full bg-aqua-500/20 blur-3xl"></div>
    <div class="shell relative py-20 text-center sm:py-24">
        <span class="eyebrow text-ember-300">What we offer</span>
        <h1 class="mt-3 font-display text-4xl font-extrabold sm:text-5xl">Our Services</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-brand-200">Professional plumbing, welding, cleaning and wiring solutions — done right, guaranteed.</p>
    </div>
</section>

<!-- SERVICES GRID -->
<section class="section bg-brand-50/40">
    <div class="shell grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($services as $service)
        @php $c = $trade($service->name); @endphp
        <article id="service-{{ $service->id }}" class="card group flex scroll-mt-24 flex-col overflow-hidden p-0">
            <div class="h-1.5 w-full bg-gradient-to-r {{ $c['bar'] }}"></div>
            <div class="flex flex-1 flex-col p-7">
                <span class="grid h-16 w-16 place-items-center rounded-2xl text-4xl {{ $c['chip'] }}">{{ $service->icon ?? '🔧' }}</span>
                <h3 class="mt-5 font-display text-xl font-bold text-brand-900">{{ $service->name }}</h3>
                <p class="mt-3 flex-1 text-sm leading-relaxed text-brand-500">{{ $service->description }}</p>
                <a href="{{ route('contact') }}" class="btn-dark mt-6 w-full text-sm hover:bg-ember-500">Request Service</a>
            </div>
        </article>
        @empty
        <div class="col-span-full rounded-2xl border border-dashed border-brand-200 py-20 text-center">
            <p class="text-5xl">🔧</p>
            <p class="mt-4 text-lg text-brand-400">Services will be listed here soon.</p>
        </div>
        @endforelse
    </div>
</section>

<!-- CTA -->
<section class="section">
    <div class="shell">
        <div class="relative overflow-hidden rounded-4xl bg-brand-950 px-8 py-16 text-center shadow-lift sm:px-16">
            <div class="absolute inset-0 texture-grid opacity-30"></div>
            <div class="relative">
                <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">Ready to get started?</h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-brand-200">Contact us now and get a free quote within minutes.</p>
                <a href="{{ route('contact') }}" class="btn-primary mt-8 text-base">Get Free Quote</a>
            </div>
        </div>
    </div>
</section>

@endsection
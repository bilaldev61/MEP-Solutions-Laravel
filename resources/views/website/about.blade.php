@extends('layouts.website')
@section('title', 'About Us')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-brand-950 text-white">
    <div class="absolute inset-0 texture-grid opacity-40"></div>
    <div class="absolute -left-16 top-0 h-72 w-72 rounded-full bg-ember-500/20 blur-3xl"></div>
    <div class="shell relative py-20 text-center sm:py-24">
        <span class="eyebrow text-ember-300">Who we are</span>
        <h1 class="mt-3 font-display text-4xl font-extrabold sm:text-5xl">About Us</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-brand-200">Trusted technical experts serving homes and businesses.</p>
    </div>
</section>

<!-- STORY + STATS -->
<section class="section">
    <div class="shell grid items-center gap-10 sm:gap-14 lg:grid-cols-2">
        <div>
            <span class="eyebrow">Our story</span>
            <div class="mt-3 flex items-center gap-3">
                <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-gradient-to-br from-ember-500 to-ember-600 font-display text-lg font-bold leading-none text-white shadow-lift">BR</span>
                <h2 class="section-title">{{ $settings['site_name'] ?? 'MEP Solutions' }}</h2>
            </div>
            <p class="mt-6 text-lg leading-relaxed text-brand-500">
                {{ $settings['about_text'] ?? 'We are MEP Solutions — a professional plumbing and maintenance company based in the USA. We provide fast, reliable, and high-quality services for residential and commercial properties.' }}
            </p>
            <p class="mt-4 leading-relaxed text-brand-500">
                Our team of licensed, experienced technicians is available around the clock — from emergency repairs to scheduled maintenance across plumbing, welding, cleaning and wiring.
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:gap-4">
                <a href="{{ route('contact') }}" class="btn-primary w-full sm:w-auto">Contact Us Today</a>
                <a href="{{ route('services') }}" class="btn-dark w-full sm:w-auto hover:bg-ember-500">Explore Services</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-5">
            @foreach([
            ['10+','Years Experience','from-brand-500 to-brand-700'],
            ['500+','Projects Done','from-ember-500 to-ember-700'],
            ['24/7','Always Available','from-aqua-500 to-aqua-700'],
            ['100%','Satisfaction','from-emerald-500 to-emerald-700'],
            ] as $s)
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br {{ $s[2] }} p-7 text-white shadow-lift">
                <div class="absolute inset-0 texture-grid opacity-30"></div>
                <p class="relative font-display text-4xl font-extrabold">{{ $s[0] }}</p>
                <p class="relative mt-2 text-sm font-medium text-white/90">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section bg-brand-50/40">
    <div class="shell">
        <div class="mx-auto max-w-2xl text-center">
            <span class="eyebrow">What drives us</span>
            <h2 class="section-title">Our Values</h2>
        </div>
        <div class="mt-10 grid gap-7 sm:mt-14 md:grid-cols-3">
            @foreach([
            ['🎯','Reliability','We show up on time, every time. Your schedule matters to us.'],
            ['⭐','Quality','We use only the best materials and proven techniques.'],
            ['🤝','Integrity','Honest pricing and transparent communication, always.'],
            ] as $v)
            <div class="card text-center">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-brand-50 text-4xl">{{ $v[0] }}</div>
                <h3 class="mt-4 font-display text-xl font-bold text-brand-900">{{ $v[1] }}</h3>
                <p class="mt-3 text-sm leading-relaxed text-brand-500">{{ $v[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
@extends('layouts.website')
@section('title', 'Contact Us')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-brand-950 text-white">
    <div class="absolute inset-0 texture-grid opacity-40"></div>
    <div class="absolute -right-16 top-0 h-72 w-72 rounded-full bg-ember-500/20 blur-3xl"></div>
    <div class="shell relative py-20 text-center sm:py-24">
        <span class="eyebrow text-ember-300">Let's talk</span>
        <h1 class="mt-3 font-display text-4xl font-extrabold sm:text-5xl">Contact Us</h1>
        <p class="mx-auto mt-4 max-w-xl text-lg text-brand-200">Get a free quote today — we respond within minutes.</p>
    </div>
</section>

<!-- CONTACT -->
<section class="section bg-brand-50/40">
    <div class="shell">

        @if(session('success'))
        <div class="mb-10 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-800 shadow-card">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-emerald-500 text-white">✓</span>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
        @endif

        <div class="grid gap-10 lg:grid-cols-5">

            <!-- FORM -->
            <div class="lg:col-span-3">
                <div class="rounded-3xl border border-brand-100 bg-white p-5 shadow-lift sm:p-10">
                    <span class="eyebrow">Request a visit</span>
                    <h2 class="font-display text-2xl font-bold text-brand-900 sm:text-3xl">Get a Free Quote</h2>

                    <form action="{{ route('lead.submit') }}" method="POST" class="mt-8 space-y-5">
                        @csrf
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label">Your Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required maxlength="100" autocomplete="name" class="field-input">
                                @error('name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label">Phone Number *</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="20" pattern="[+0-9()\s-]{7,20}" title="Enter a valid phone number (digits, spaces, +, - only)" autocomplete="tel" class="field-input">
                                @error('phone')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" class="field-input">
                                @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label">Service Needed</label>
                                <select name="service" class="field-input">
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                    <option value="{{ $service->name }}" @selected(old('service')===$service->name)>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="field-label">Message</label>
                            <textarea name="message" rows="4" maxlength="1000" class="field-input" placeholder="Describe your issue..."
                                oninput="document.getElementById('msg-count').textContent = this.value.length">{{ old('message') }}</textarea>
                            <p class="mt-1 text-xs text-brand-400">
                                <span id="msg-count">{{ mb_strlen(old('message', '')) }}</span>/1000 characters
                            </p>
                            @error('message')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="btn-primary w-full text-base">Send Request →</button>
                    </form>
                </div>
            </div>

            <!-- INFO -->
            <div class="space-y-4 lg:col-span-2">
                <div class="rounded-2xl bg-brand-950 p-6 text-white shadow-lift">
                    <p class="text-sm font-semibold uppercase tracking-widest text-ember-300">Talk to us</p>
                    <a href="tel:{{ $settings['phone'] ?? '' }}" class="mt-3 flex items-center gap-3 text-xl font-bold hover:text-ember-300">
                        <span>📞</span> {{ $settings['phone'] ?? '+971 XX XXX XXXX' }}
                    </a>
                    <a href="https://wa.me/{{ $settings['whatsapp'] ?? '' }}" target="_blank" rel="noopener"
                        class="mt-3 flex items-center gap-3 font-semibold text-aqua-300 hover:text-aqua-200">
                        <span>💬</span> Chat on WhatsApp
                    </a>
                </div>
                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
                    <p class="font-bold text-brand-900">📧 Email</p>
                    <p class="mt-2 text-brand-500">{{ $settings['email'] ?? 'info@brmepsolutions.com' }}</p>
                </div>
                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
                    <p class="font-bold text-brand-900">📍 Address</p>
                    <p class="mt-2 text-brand-500">{{ $settings['address'] ?? 'Dubai, UAE' }}</p>
                </div>
                <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
                    <p class="font-bold text-brand-900">🕐 Working Hours</p>
                    <p class="mt-2 text-brand-500">{{ $settings['working_hours'] ?? 'Monday – Saturday: 8AM – 8PM' }}</p>
                    <p class="text-sm font-semibold text-ember-600">Emergency: 24/7</p>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
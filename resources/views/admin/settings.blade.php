@extends('layouts.admin')
@section('title', 'Site Settings')

@section('content')

<div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-xl font-bold text-brand-900">⚙️ Site Settings</h2>
        <p class="mt-1 text-sm text-brand-500">Changes here reflect instantly on the website.</p>

        @if ($errors->any())
        <div class="mt-4 rounded-xl border border-ember-300 bg-ember-50 px-4 py-3 text-sm font-medium text-ember-700">
            Please fix the highlighted fields below.
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="mt-6 space-y-8">
            @csrf

            <div>
                <h3 class="eyebrow mb-4">General Info</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="site_name">Company Name *</label>
                        <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required maxlength="100" class="field-input">
                        @error('site_name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" required maxlength="20" placeholder="e.g. +1 555 000 0000" class="field-input">
                        @error('phone')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="whatsapp">WhatsApp Number *</label>
                        <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}" required maxlength="20" pattern="\d+" title="Digits only — no + or spaces" placeholder="e.g. 15550000000" class="field-input">
                        <p class="mt-1 text-xs text-brand-400">No + or spaces. US example: 15550000000</p>
                        @error('whatsapp')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="email">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" required maxlength="100" placeholder="you@example.com" class="field-input">
                        @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label" for="address">Address *</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $settings['address'] ?? '') }}" required maxlength="255" class="field-input">
                        @error('address')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label" for="working_hours">Working Hours</label>
                        <input type="text" id="working_hours" name="working_hours" value="{{ old('working_hours', $settings['working_hours'] ?? '') }}" maxlength="100" placeholder="e.g. Monday - Saturday: 8AM - 8PM" class="field-input">
                        @error('working_hours')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="eyebrow mb-4">Home Page Content</h3>
                <div class="space-y-4">
                    <div>
                        <label class="field-label" for="hero_title">Hero Title *</label>
                        <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" required maxlength="150" class="field-input">
                        @error('hero_title')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label" for="hero_subtitle">Hero Subtitle</label>
                        <input type="text" id="hero_subtitle" name="hero_subtitle" value="{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}" maxlength="255" class="field-input">
                        @error('hero_subtitle')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div>
                <h3 class="eyebrow mb-4">About Page Content</h3>
                <label class="field-label" for="about_text">About Us Text</label>
                <textarea id="about_text" name="about_text" rows="4" maxlength="2000" class="field-input">{{ old('about_text', $settings['about_text'] ?? '') }}</textarea>
                @error('about_text')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <h3 class="eyebrow mb-4">Lead Auto-Reply Email</h3>
                <div class="rounded-xl border border-brand-100 bg-brand-50/50 p-4">
                    <input type="hidden" name="auto_reply_enabled" value="0">
                    <label class="flex cursor-pointer items-center gap-3">
                        <input type="checkbox" name="auto_reply_enabled" value="1" class="h-5 w-5 rounded border-brand-300 text-ember-600 focus:ring-ember-500"
                            @checked(old('auto_reply_enabled', $settings['auto_reply_enabled'] ?? '1' )==='1' )>
                        <span class="text-sm font-semibold text-brand-800">Send automatic acknowledgement to every lead who provides an email</span>
                    </label>
                    @error('auto_reply_enabled')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror

                    <div class="mt-5 space-y-4">
                        <div>
                            <label class="field-label" for="auto_reply_subject">Email Subject</label>
                            <input type="text" id="auto_reply_subject" name="auto_reply_subject" maxlength="150" class="field-input"
                                value="{{ old('auto_reply_subject', $settings['auto_reply_subject'] ?? \App\Mail\LeadAcknowledgement::DEFAULT_SUBJECT) }}">
                            @error('auto_reply_subject')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label" for="auto_reply_body">Message Text</label>
                            <textarea id="auto_reply_body" name="auto_reply_body" rows="4" maxlength="1000" class="field-input">{{ old('auto_reply_body', $settings['auto_reply_body'] ?? \App\Mail\LeadAcknowledgement::DEFAULT_BODY) }}</textarea>
                            <p class="mt-1 text-xs text-brand-400">Placeholders: <code class="rounded bg-brand-100 px-1 py-0.5 font-mono">{name}</code> <code class="rounded bg-brand-100 px-1 py-0.5 font-mono">{service}</code> <code class="rounded bg-brand-100 px-1 py-0.5 font-mono">{company}</code> — replaced with each lead's details. Leave blank for the default text.</p>
                            @error('auto_reply_body')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">Save All Settings</button>
        </form>
    </div>
</div>

@endsection
@extends('layouts.admin')
@section('title', 'Site Settings')

@section('content')

<div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-xl font-bold text-brand-900">⚙️ Site Settings</h2>
        <p class="mt-1 text-sm text-brand-500">Changes here reflect instantly on the website.</p>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="mt-6 space-y-8">
            @csrf

            <div>
                <h3 class="eyebrow mb-4">General Info</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label">Company Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}" placeholder="e.g. +1 555 000 0000" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="e.g. 15550000000" class="field-input">
                        <p class="mt-1 text-xs text-brand-400">No + or spaces. US example: 15550000000</p>
                    </div>
                    <div>
                        <label class="field-label">Email Address</label>
                        <input type="text" name="email" value="{{ $settings['email'] ?? '' }}" class="field-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label">Address</label>
                        <input type="text" name="address" value="{{ $settings['address'] ?? '' }}" class="field-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label">Working Hours</label>
                        <input type="text" name="working_hours" value="{{ $settings['working_hours'] ?? '' }}" placeholder="e.g. Monday - Saturday: 8AM - 8PM" class="field-input">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="eyebrow mb-4">Home Page Content</h3>
                <div class="space-y-4">
                    <div>
                        <label class="field-label">Hero Title</label>
                        <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Hero Subtitle</label>
                        <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}" class="field-input">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="eyebrow mb-4">About Page Content</h3>
                <label class="field-label">About Us Text</label>
                <textarea name="about_text" rows="4" class="field-input">{{ $settings['about_text'] ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn-primary">Save All Settings</button>
        </form>
    </div>
</div>

@endsection
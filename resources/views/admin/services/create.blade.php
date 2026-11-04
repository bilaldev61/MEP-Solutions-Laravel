@extends('layouts.admin')
@section('title', 'Add Service')

@section('content')

<div class="mx-auto max-w-xl">
    <a href="{{ route('admin.services.index') }}"
        class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-500 transition hover:text-brand-700">← Back to Services</a>

    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-xl font-bold text-brand-900">🔧 Add New Service</h2>
        <p class="mt-1 text-sm text-brand-500">Create a service that appears on your website.</p>

        <form action="{{ route('admin.services.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div>
                <label class="field-label">Service Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="field-input">
                @error('name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Icon (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g. 🔧 🚿 " class="field-input">
                <p class="mt-1 text-xs text-brand-400">Paste any emoji as the icon</p>
            </div>
            <div>
                <label class="field-label">Description</label>
                <textarea name="description" rows="4" class="field-input" placeholder="Add a service description...">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="field-label">Status</label>
                <select name="active" class="field-input">
                    <option value="1" @selected(old('active', '1' )=='1' )>Active</option>
                    <option value="0" @selected(old('active')==='0' )>Inactive</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn-primary">Save Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
@extends('layouts.admin')
@section('title', 'Services')

@section('content')

{{-- Page header --}}
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-3">
            <h2 class="font-display text-2xl font-bold text-brand-900">🔧 All Services</h2>
            <span class="rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-bold text-brand-700">{{ $services->count() }}</span>
        </div>
        <p class="mt-1 text-sm text-brand-500">Manage the services shown on your website.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary">+ Add Service</a>
</div>

{{-- Table card --}}
<div class="overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-brand-50/60 text-xs uppercase tracking-wider text-brand-500">
                <tr>
                    <th class="px-5 py-3 font-semibold">#</th>
                    <th class="px-5 py-3 font-semibold">Icon</th>
                    <th class="px-5 py-3 font-semibold">Name</th>
                    <th class="px-5 py-3 font-semibold">Description</th>
                    <th class="px-5 py-3 font-semibold">Status</th>
                    <th class="px-5 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse($services as $service)
                <tr class="transition hover:bg-brand-50/40">
                    <td class="px-5 py-4 text-brand-300">{{ $loop->iteration }}</td>
                    <td class="px-5 py-4">
                        <span class="grid h-11 w-11 place-items-center rounded-xl bg-brand-50 text-2xl">{{ $service->icon ?? '🔧' }}</span>
                    </td>
                    <td class="px-5 py-4 font-semibold text-brand-900">{{ $service->name }}</td>
                    <td class="max-w-xs px-5 py-4 text-brand-500">
                        <span class="block truncate" title="{{ $service->description }}">{{ $service->description ?: '—' }}</span>
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold
                                {{ $service->active ? 'bg-emerald-50 text-emerald-700' : 'bg-brand-100 text-brand-500' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $service->active ? 'bg-emerald-500' : 'bg-brand-400' }}"></span>
                            {{ $service->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}"
                                class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">
                                Edit
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg bg-ember-50 px-3 py-1.5 text-xs font-semibold text-ember-700 transition hover:bg-ember-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center">
                        <p class="text-4xl">🔧</p>
                        <p class="mt-3 font-semibold text-brand-700">No services yet</p>
                        <p class="text-sm text-brand-400">Add your first service to display it on the website.</p>
                        <a href="{{ route('admin.services.create') }}" class="btn-primary mt-5">+ Add Service</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
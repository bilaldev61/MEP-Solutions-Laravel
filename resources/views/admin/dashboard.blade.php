@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="mb-6">
    <h2 class="font-display text-2xl font-bold text-brand-900">📊 Dashboard</h2>
    <p class="text-sm text-brand-500">A quick overview of your business today.</p>
</div>

<!-- STATS -->
<div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4">
    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
        <p class="font-display text-4xl font-extrabold text-brand-900">{{ $stats['total_leads'] }}</p>
        <p class="mt-2 text-sm font-medium text-brand-500">Total Leads</p>
    </div>
    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-6 shadow-card">
        <p class="font-display text-4xl font-extrabold text-amber-600">{{ $stats['new_leads'] }}</p>
        <p class="mt-2 text-sm font-medium text-amber-700">New Leads</p>
    </div>
    <div class="rounded-2xl border border-aqua-100 bg-aqua-50 p-6 shadow-card">
        <p class="font-display text-4xl font-extrabold text-aqua-700">{{ $stats['total_employees'] }}</p>
        <p class="mt-2 text-sm font-medium text-aqua-700">Active Employees</p>
    </div>
    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-6 shadow-card">
        <p class="font-display text-4xl font-extrabold text-emerald-700">{{ $stats['today_present'] }}</p>
        <p class="mt-2 text-sm font-medium text-emerald-700">Present Today</p>
    </div>
</div>

<!-- QUICK LINKS -->
<div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-4">
    <a href="{{ route('admin.leads.index') }}" class="card flex flex-col items-center gap-2 p-5 text-center transition hover:shadow-lift">
        <span class="text-3xl">📋</span>
        <span class="font-semibold text-brand-800">View Leads</span>
    </a>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.employees.create') }}" class="card flex flex-col items-center gap-2 p-5 text-center transition hover:shadow-lift">
        <span class="text-3xl">➕</span>
        <span class="font-semibold text-brand-800">Add Employee</span>
    </a>
    @endif
    <a href="{{ route('admin.attendance.index') }}" class="card flex flex-col items-center gap-2 p-5 text-center transition hover:shadow-lift">
        <span class="text-3xl">📅</span>
        <span class="font-semibold text-brand-800">Attendance</span>
    </a>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.settings') }}" class="card flex flex-col items-center gap-2 p-5 text-center transition hover:shadow-lift">
        <span class="text-3xl">⚙️</span>
        <span class="font-semibold text-brand-800">Site Settings</span>
    </a>
    @endif
</div>

<!-- RECENT LEADS -->
<div class="mt-8 overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card">
    <div class="flex items-center justify-between border-b border-brand-50 px-6 py-4">
        <h3 class="font-display text-lg font-bold text-brand-900">Latest Customer Leads</h3>
        <a href="{{ route('admin.leads.index') }}" class="text-sm font-semibold text-ember-600 hover:text-ember-700">View All →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-brand-50/60 text-xs font-semibold uppercase tracking-wider text-brand-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Service</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse($recent_leads as $lead)
                <tr class="transition hover:bg-brand-50/40">
                    <td class="px-4 py-3 font-semibold text-brand-900">{{ $lead->name }}</td>
                    <td class="px-4 py-3"><a href="tel:{{ $lead->phone }}" class="font-medium text-ember-600 hover:text-ember-700">{{ $lead->phone }}</a></td>
                    <td class="px-4 py-3"><span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $lead->service ?? '—' }}</span></td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold
                            {{ $lead->status === 'new' ? 'bg-amber-50 text-amber-700' :
                              ($lead->status === 'contacted' ? 'bg-aqua-50 text-aqua-700' :
                               'bg-emerald-50 text-emerald-700') }}">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-brand-400">{{ $lead->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center">
                        <p class="text-4xl">📭</p>
                        <p class="mt-3 font-semibold text-brand-700">No leads yet</p>
                        <p class="text-sm text-brand-400">New enquiries from the contact form will appear here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
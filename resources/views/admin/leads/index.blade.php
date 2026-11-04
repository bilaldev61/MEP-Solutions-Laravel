@extends('layouts.admin')
@section('title', 'Customer Leads')

@section('content')

<div x-data="{ show: false, lead: {} }">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="font-display text-lg font-bold text-brand-900">📋 All Customer Leads</h2>
            <p class="text-sm text-brand-500">Enquiries submitted through the website contact form.</p>
        </div>
        <span class="rounded-full bg-ember-50 px-3 py-1 text-sm font-bold text-ember-700">
            {{ $leads->total() }} {{ Str::plural('Lead', $leads->total()) }}
        </span>
    </div>

    <div class="overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-brand-50/60 text-xs font-semibold uppercase tracking-wider text-brand-500">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Service</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-50">
                    @forelse($leads as $lead)
                    <tr class="transition hover:bg-brand-50/40">
                        <td class="px-4 py-3 text-brand-400">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-semibold text-brand-900">{{ $lead->name }}</td>
                        <td class="px-4 py-3">
                            <a href="tel:{{ $lead->phone }}" class="font-medium text-ember-600 hover:text-ember-700">{{ $lead->phone }}</a>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $lead->service ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                    class="cursor-pointer rounded-full border-0 px-2.5 py-1 text-xs font-bold focus:ring-2 focus:ring-ember-500
                                    {{ $lead->status === 'new' ? 'bg-amber-50 text-amber-700' :
                                      ($lead->status === 'contacted' ? 'bg-aqua-50 text-aqua-700' :
                                       'bg-emerald-50 text-emerald-700') }}">
                                    <option value="new" @selected($lead->status === 'new')>New</option>
                                    <option value="contacted" @selected($lead->status === 'contacted')>Contacted</option>
                                    <option value="closed" @selected($lead->status === 'closed')>Closed</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-brand-400">{{ $lead->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button"
                                    @click="show = true; lead = $el.dataset"
                                    data-name="{{ $lead->name }}"
                                    data-phone="{{ $lead->phone }}"
                                    data-email="{{ $lead->email ?? '—' }}"
                                    data-service="{{ $lead->service ?? '—' }}"
                                    data-status="{{ ucfirst($lead->status) }}"
                                    data-date="{{ $lead->created_at->format('d M Y, H:i') }}"
                                    data-message="{{ $lead->message ?? 'No message provided.' }}"
                                    class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">
                                    View
                                </button>
                                @if(auth()->user()->isAdmin())
                                <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Delete this lead?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg bg-ember-50 px-3 py-1.5 text-xs font-semibold text-ember-700 transition hover:bg-ember-100">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-16 text-center">
                            <p class="text-4xl">📋</p>
                            <p class="mt-3 font-semibold text-brand-700">No leads yet</p>
                            <p class="text-sm text-brand-400">New enquiries from the contact form will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($leads->hasPages())
        <div class="border-t border-brand-50 px-4 py-3">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

    <!-- VIEW MODAL -->
    <div x-show="show" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-brand-950/60 p-4" @click.self="show = false">
        <div x-show="show" x-transition.origin.center class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-lift">
            <div class="flex items-center justify-between border-b border-brand-100 px-6 py-4">
                <h3 class="font-display text-lg font-bold text-brand-900">Lead Details</h3>
                <button @click="show = false" class="grid h-8 w-8 place-items-center rounded-full text-brand-400 transition hover:bg-brand-50 hover:text-brand-700">✕</button>
            </div>
            <div class="space-y-4 px-6 py-5 text-sm">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Name</p>
                        <p class="mt-1 font-semibold text-brand-900" x-text="lead.name"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Phone</p>
                        <p class="mt-1 text-brand-900" x-text="lead.phone"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Email</p>
                        <p class="mt-1 break-all text-brand-900" x-text="lead.email"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Service</p>
                        <p class="mt-1 text-brand-900" x-text="lead.service"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Status</p>
                        <p class="mt-1 text-brand-900" x-text="lead.status"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Date</p>
                        <p class="mt-1 text-brand-900" x-text="lead.date"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-brand-400">Message</p>
                    <p class="mt-1 whitespace-pre-wrap rounded-xl bg-brand-50 p-4 text-brand-800" x-text="lead.message"></p>
                </div>
            </div>
            <div class="flex flex-wrap justify-end gap-3 border-t border-brand-100 px-6 py-4">
                <a :href="'mailto:' + lead.email + '?subject=Re:%20Your%20enquiry'"
                    class="btn-primary">✉ Reply via Email</a>
                <button @click="show = false" class="btn-dark">Close</button>
            </div>
        </div>
    </div>

</div>

@endsection
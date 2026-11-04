@extends('layouts.admin')
@section('title', 'Payments')

@section('content')

@php $isAdmin = auth()->user()->isAdmin(); @endphp

<div class="grid gap-6 lg:grid-cols-5">

    @if($isAdmin)
    <!-- RECORD PAYMENT FORM -->
    <div class="lg:col-span-2">
        <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
            <h2 class="font-display text-lg font-bold text-brand-900">💰 Record Payment</h2>
            <p class="mt-1 text-sm text-brand-500">Log a salary, bonus or advance for an employee.</p>

            @php
            $formInit = [
            'employeeId' => (string) old('employee_id', ''),
            'month' => (string) old('month', ''),
            'type' => (string) old('type', 'salary'),
            'amount' => (string) old('amount', ''),
            ];
            @endphp
            <form action="{{ route('admin.payments.store') }}" method="POST" class="mt-6 space-y-4"
                x-data="paymentForm({
                    salaries: {{ \Illuminate\Support\Js::from($salaryMap) }},
                    committed: {{ \Illuminate\Support\Js::from($committedMap) }},
                    initial: {{ \Illuminate\Support\Js::from($formInit) }}
                })">
                @csrf
                <div>
                    <label class="field-label">Employee *</label>
                    <select name="employee_id" required x-model="employeeId" class="field-input">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" @selected(old('employee_id')==$employee->id)>{{ $employee->name }} — {{ $employee->role }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label">Amount (USD) *</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-brand-400">$</span>
                        <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount') }}" required x-model="amount" class="field-input pl-7">
                    </div>
                    @error('amount')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    <p x-show="overpay" x-cloak class="mt-1 text-xs font-semibold text-red-600"
                        x-text="'⚠️ Overpay — net payable is ' + money(remaining) + (advances > 0 ? ' (already advanced ' + money(advances) + ')' : '') + '.'"></p>
                </div>

                <div>
                    <label class="field-label">Payment Type *</label>
                    <select name="type" required x-model="type" class="field-input">
                        <option value="salary" @selected(old('type')=='salary' )>Salary</option>
                        <option value="bonus" @selected(old('type')=='bonus' )>Bonus</option>
                        <option value="advance" @selected(old('type')=='advance' )>Advance</option>
                        <option value="other" @selected(old('type')=='other' )>Other</option>
                    </select>
                    @error('type')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label">Payment Date *</label>
                        <input type="date" name="payment_date" value="{{ old('payment_date') }}" required class="field-input">
                        @error('payment_date')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="field-label">Month *</label>
                        <input type="text" name="month" value="{{ old('month') }}" placeholder="e.g. April 2026" required x-model="month" class="field-input">
                        @error('month')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- LIVE SALARY BALANCE -->
                <div x-show="hasEmployee" x-cloak class="rounded-xl border border-brand-100 bg-brand-50/60 p-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-brand-400">Salary balance · <span x-text="month"></span></p>

                    <template x-if="salary > 0">
                        <div class="mt-2 space-y-1.5 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-brand-500">Monthly salary</span>
                                <span class="font-semibold text-brand-900" x-text="money(salary)"></span>
                            </div>
                            <div x-show="advances > 0" class="flex items-center justify-between">
                                <span class="text-brand-500">Advance already given</span>
                                <span class="font-semibold text-red-600" x-text="'− ' + money(advances)"></span>
                            </div>
                            <div x-show="paidSalary > 0" class="flex items-center justify-between">
                                <span class="text-brand-500">Salary already paid</span>
                                <span class="font-semibold text-red-600" x-text="'− ' + money(paidSalary)"></span>
                            </div>
                            <div class="flex items-center justify-between border-t border-brand-200 pt-1.5">
                                <span class="font-semibold text-brand-700">Net payable</span>
                                <span class="font-display font-bold text-emerald-700" x-text="money(remaining)"></span>
                            </div>

                            <div x-show="advances > 0 && type === 'salary'" class="mt-1 rounded-lg bg-amber-50 px-3 py-2 text-xs font-medium text-amber-800">
                                📌 He already received <span x-text="money(advances)"></span> as advance, so the net salary is <span class="font-bold" x-text="money(remaining)"></span> — not the full amount.
                                <button type="button" @click="payNet()" x-show="netPayable > 0" class="ml-1 font-bold text-amber-900 underline">Fill net</button>
                            </div>

                            <div x-show="remaining <= 0" class="mt-1 rounded-lg bg-red-50 px-3 py-2 text-xs font-medium text-red-700">
                                This month is fully settled (salary paid + advances = <span x-text="money(salary)"></span>). Only a bonus or “other” payment can be added.
                            </div>
                        </div>
                    </template>

                    <p x-show="salary === 0" class="mt-2 text-xs text-brand-400">No salary set for this employee — add it under Employees to enable over-payment protection.</p>
                </div>

                <div>
                    <label class="field-label">Notes</label>
                    <textarea name="notes" rows="2" class="field-input" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="btn-primary w-full">Record Payment</button>
            </form>
        </div>
    </div>
    @endif

    <!-- PAYMENT RECORDS -->
    <div class="{{ $isAdmin ? 'lg:col-span-3' : 'lg:col-span-5' }}" x-data="{ detail: null, q: '' }">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-lg font-bold text-brand-900">💰 Payment Records</h2>
                <p class="text-sm text-brand-500">All amounts shown in US Dollars. Voided records are kept for audit.</p>
            </div>
            @php $paidRecords = $payments->where('status', 'paid'); @endphp
            <div class="flex items-center gap-2">
                <input type="search" x-model="q" placeholder="🔍 Filter by name..."
                    aria-label="Filter payments by employee name" class="field-input w-36 sm:w-48">
                <span class="whitespace-nowrap rounded-full bg-ember-50 px-3 py-1 text-sm font-bold text-ember-700">
                    ${{ number_format($paidRecords->sum('amount')) }} paid · {{ $paidRecords->count() }} {{ Str::plural('record', $paidRecords->count()) }}@if($payments->count() - $paidRecords->count() > 0) · {{ $payments->count() - $paidRecords->count() }} voided @endif
                </span>
            </div>
        </div>

        <!-- Mobile: stacked cards -->
        <div class="space-y-3 md:hidden">
            @forelse($payments as $payment)
            <div data-name="{{ strtolower($payment->employee->name ?? '') }}"
                x-show="!q || $el.dataset.name.includes(q.toLowerCase())"
                class="rounded-2xl border border-brand-100 bg-white p-4 shadow-card {{ $payment->isVoided() ? 'opacity-70' : '' }}">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-brand-900">{{ $payment->employee->name ?? '—' }}</p>
                        <p class="mt-0.5 text-xs text-brand-400">{{ $payment->month }}</p>
                    </div>
                    <p class="shrink-0 font-display text-lg font-bold {{ $payment->isVoided() ? 'text-brand-300 line-through' : 'text-emerald-700' }}">${{ number_format($payment->amount) }}</p>
                </div>
                <div class="mt-3 flex flex-wrap items-center justify-between gap-2 border-t border-brand-50 pt-3">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ ucfirst($payment->type) }}</span>
                        @if($payment->isVoided())
                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600">Voided</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="detail = {{ \Illuminate\Support\Js::from(["employee" => $payment->employee->name ?? "—", "amount" => "$" . number_format($payment->amount, 2), "type" => ucfirst($payment->type), "month" => $payment->month, "date" => \Illuminate\Support\Carbon::parse($payment->payment_date)->format("d M Y"), "status" => ucfirst($payment->status), "notes" => $payment->notes ?: "—", "recorded" => $payment->created_at->format("d M Y, h:i A")]) }}"
                            class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">View</button>
                        @if($isAdmin)
                        @if($payment->isVoided())
                        <form action="{{ route('admin.payments.restore', $payment) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">Restore</button>
                        </form>
                        @else
                        <form action="{{ route('admin.payments.void', $payment) }}" method="POST" onsubmit="return confirm('Void this payment? It will be excluded from totals but kept for audit.')" class="inline">
                            @csrf
                            @method('PATCH')
                            <button class="rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">Void</button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="rounded-2xl border border-brand-100 bg-white p-10 text-center shadow-card">
                <p class="text-4xl">💵</p>
                <p class="mt-3 font-semibold text-brand-700">No payments recorded yet</p>
                <p class="text-sm text-brand-400">Use the form to record an employee payment.</p>
            </div>
            @endforelse
        </div>

        <!-- Desktop: table -->
        <div class="hidden overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-brand-50/60 text-xs font-semibold uppercase tracking-wider text-brand-500">
                        <tr>
                            <th class="px-4 py-3">Employee</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        @forelse($payments as $payment)
                        <tr data-name="{{ strtolower($payment->employee->name ?? '') }}"
                            x-show="!q || $el.dataset.name.includes(q.toLowerCase())"
                            class="transition hover:bg-brand-50/40 {{ $payment->isVoided() ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3 font-semibold text-brand-900">{{ $payment->employee->name ?? '—' }}</td>
                            <td class="px-4 py-3 font-bold {{ $payment->isVoided() ? 'text-brand-300 line-through' : 'text-emerald-700' }}">${{ number_format($payment->amount) }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ ucfirst($payment->type) }}</span>
                                    @if($payment->isVoided())
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600">Voided</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="detail = {{ \Illuminate\Support\Js::from(["employee" => $payment->employee->name ?? "—", "amount" => "$" . number_format($payment->amount, 2), "type" => ucfirst($payment->type), "month" => $payment->month, "date" => \Illuminate\Support\Carbon::parse($payment->payment_date)->format("d M Y"), "status" => ucfirst($payment->status), "notes" => $payment->notes ?: "—", "recorded" => $payment->created_at->format("d M Y, h:i A")]) }}"
                                        class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">View</button>
                                    @if($isAdmin)
                                    @if($payment->isVoided())
                                    <form action="{{ route('admin.payments.restore', $payment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-100">Restore</button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.payments.void', $payment) }}" method="POST" onsubmit="return confirm('Void this payment? It will be excluded from totals but kept for audit.')" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="rounded-lg bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">Void</button>
                                    </form>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-16 text-center">
                                <p class="text-4xl">💵</p>
                                <p class="mt-3 font-semibold text-brand-700">No payments recorded yet</p>
                                <p class="text-sm text-brand-400">Use the form to record an employee payment.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAYMENT DETAILS MODAL -->
        <div x-show="detail" x-cloak @click="detail = null" class="fixed inset-0 z-50 grid place-items-center bg-brand-950/60 p-4 backdrop-blur-sm">
            <div @click.stop class="w-full max-w-md rounded-2xl bg-white p-6 shadow-lift">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-display text-lg font-bold text-brand-900">🧾 Payment Details</h3>
                    <button @click="detail = null" class="rounded-lg px-2 py-1 text-brand-400 transition hover:bg-brand-50 hover:text-brand-700">✕</button>
                </div>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Employee</dt>
                        <dd class="text-right font-semibold text-brand-900" x-text="detail?.employee"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Amount</dt>
                        <dd class="text-right font-bold text-emerald-700" x-text="detail?.amount"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Type</dt>
                        <dd class="text-right font-semibold text-brand-900" x-text="detail?.type"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">For Month</dt>
                        <dd class="text-right text-brand-700" x-text="detail?.month"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Payment Date</dt>
                        <dd class="text-right text-brand-700" x-text="detail?.date"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Status</dt>
                        <dd class="text-right font-bold text-brand-700" x-text="detail?.status"></dd>
                    </div>
                    <div class="flex items-start justify-between gap-4 border-b border-brand-50 pb-2">
                        <dt class="shrink-0 text-brand-400">Recorded On</dt>
                        <dd class="text-right text-brand-700" x-text="detail?.recorded"></dd>
                    </div>
                </dl>
                <p class="field-label mt-4">Notes</p>
                <p class="mt-1 break-words rounded-xl bg-brand-50/60 p-3 text-sm leading-relaxed text-brand-700" x-text="detail?.notes"></p>
                <div class="mt-5 flex justify-end">
                    <button @click="detail = null" class="btn-dark">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
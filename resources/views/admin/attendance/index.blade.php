@extends('layouts.admin')
@section('title', 'Attendance')

@section('content')

<div class="grid gap-6 lg:grid-cols-5">

    <!-- MARK ATTENDANCE FORM -->
    <div class="lg:col-span-2">
        <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card">
            <h2 class="font-display text-lg font-bold text-brand-900">📅 Mark Attendance</h2>
            <p class="mt-1 text-sm text-brand-500">Record an employee's day and hours.</p>

            <form action="{{ route('admin.attendance.store') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="field-label">Employee *</label>
                    <select name="employee_id" required class="field-input">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" @selected(old('employee_id')==$employee->id)>{{ $employee->name }} — {{ $employee->role }}</option>
                        @endforeach
                    </select>
                    @error('employee_id')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label">Date *</label>
                    <input type="date" name="date" value="{{ old('date', $date) }}" required class="field-input">
                    @error('date')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="field-label">Status *</label>
                    <select name="status" required class="field-input">
                        <option value="present" @selected(old('status')=='present' )>Present</option>
                        <option value="absent" @selected(old('status')=='absent' )>Absent</option>
                        <option value="half_day" @selected(old('status')=='half_day' )>Half Day</option>
                        <option value="leave" @selected(old('status')=='leave' )>Leave</option>
                    </select>
                    @error('status')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="field-label">Check In</label>
                        <input type="time" name="check_in" value="{{ old('check_in') }}" class="field-input">
                    </div>
                    <div>
                        <label class="field-label">Check Out</label>
                        <input type="time" name="check_out" value="{{ old('check_out') }}" class="field-input">
                    </div>
                </div>

                <div>
                    <label class="field-label">Hours Worked</label>
                    <input type="number" name="hours_worked" value="{{ old('hours_worked') }}" step="0.5" min="0" class="field-input">
                </div>

                <button type="submit" class="btn-primary w-full">Save Attendance</button>
            </form>
        </div>
    </div>

    <!-- ATTENDANCE LIST -->
    <div class="lg:col-span-3">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-display text-lg font-bold text-brand-900">📅 Attendance</h2>
                <p class="text-sm text-brand-500">For {{ \Illuminate\Support\Carbon::parse($date)->format('d M Y') }}</p>
            </div>
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                    class="rounded-lg border border-brand-200 bg-white px-3 py-1.5 text-sm text-brand-700 focus:border-ember-500 focus:outline-none focus:ring-2 focus:ring-ember-500/30">
            </form>
        </div>

        <!-- Mobile: stacked cards -->
        <div class="space-y-3 md:hidden">
            @forelse($attendances as $attendance)
            <div class="rounded-2xl border border-brand-100 bg-white p-4 shadow-card">
                <div class="flex items-center justify-between gap-3">
                    <p class="min-w-0 truncate font-semibold text-brand-900">{{ $attendance->employee->name ?? '—' }}</p>
                    <span class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-xs font-bold
                        {{ $attendance->status === 'present' ? 'bg-emerald-50 text-emerald-700' :
                          ($attendance->status === 'absent' ? 'bg-red-50 text-red-700' :
                           ($attendance->status === 'half_day' ? 'bg-amber-50 text-amber-700' :
                            'bg-aqua-50 text-aqua-700')) }}">
                        {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                    </span>
                </div>
                <div class="mt-3 grid grid-cols-3 gap-2 text-center text-xs">
                    <div class="rounded-lg bg-brand-50/60 px-2 py-1.5">
                        <p class="text-brand-400">In</p>
                        <p class="mt-0.5 font-semibold text-brand-700">{{ $attendance->check_in ?? '—' }}</p>
                    </div>
                    <div class="rounded-lg bg-brand-50/60 px-2 py-1.5">
                        <p class="text-brand-400">Out</p>
                        <p class="mt-0.5 font-semibold text-brand-700">{{ $attendance->check_out ?? '—' }}</p>
                    </div>
                    <div class="rounded-lg bg-brand-50/60 px-2 py-1.5">
                        <p class="text-brand-400">Hours</p>
                        <p class="mt-0.5 font-semibold text-brand-700">{{ $attendance->hours_worked !== null ? $attendance->hours_worked . ' h' : '—' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="rounded-2xl border border-brand-100 bg-white p-10 text-center shadow-card">
                <p class="text-4xl">📅</p>
                <p class="mt-3 font-semibold text-brand-700">No attendance marked</p>
                <p class="text-sm text-brand-400">Pick a date or record attendance using the form.</p>
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
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Check In</th>
                            <th class="px-4 py-3">Check Out</th>
                            <th class="px-4 py-3">Hours</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        @forelse($attendances as $attendance)
                        <tr class="transition hover:bg-brand-50/40">
                            <td class="px-4 py-3 font-semibold text-brand-900">{{ $attendance->employee->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold
                                    {{ $attendance->status === 'present' ? 'bg-emerald-50 text-emerald-700' :
                                      ($attendance->status === 'absent' ? 'bg-red-50 text-red-700' :
                                       ($attendance->status === 'half_day' ? 'bg-amber-50 text-amber-700' :
                                        'bg-aqua-50 text-aqua-700')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $attendance->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-brand-600">{{ $attendance->check_in ?? '—' }}</td>
                            <td class="px-4 py-3 text-brand-600">{{ $attendance->check_out ?? '—' }}</td>
                            <td class="px-4 py-3 text-brand-600">{{ $attendance->hours_worked !== null ? $attendance->hours_worked . ' h' : '—' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16 text-center">
                                <p class="text-4xl">📅</p>
                                <p class="mt-3 font-semibold text-brand-700">No attendance marked</p>
                                <p class="text-sm text-brand-400">Pick a date or record attendance using the form.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
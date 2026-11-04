@extends('layouts.admin')
@section('title', 'Employees')

@section('content')

@php $isAdmin = auth()->user()->isAdmin(); @endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h2 class="font-display text-lg font-bold text-brand-900">👷 All Employees</h2>
        <p class="text-sm text-brand-500">Your team and their monthly salary (USD).</p>
    </div>
    @if($isAdmin)
    <a href="{{ route('admin.employees.create') }}" class="btn-primary">+ Add Employee</a>
    @endif
</div>

<div class="overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-brand-50/60 text-xs font-semibold uppercase tracking-wider text-brand-500">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Nationality</th>
                    <th class="px-4 py-3">Join Date</th>
                    <th class="px-4 py-3">Salary</th>
                    <th class="px-4 py-3">Status</th>
                    @if($isAdmin)<th class="px-4 py-3 text-right">Actions</th>@endif
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @forelse($employees as $employee)
                <tr class="transition hover:bg-brand-50/40">
                    <td class="px-4 py-3 text-brand-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-semibold text-brand-900">{{ $employee->name }}</td>
                    <td class="px-4 py-3">
                        <a href="tel:{{ $employee->phone }}" class="font-medium text-ember-600 hover:text-ember-700">{{ $employee->phone }}</a>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $employee->role }}</span>
                    </td>
                    <td class="px-4 py-3 text-brand-600">{{ $employee->nationality ?? '—' }}</td>
                    <td class="px-4 py-3 text-brand-400">{{ \Illuminate\Support\Carbon::parse($employee->join_date)->format('d M Y') }}</td>
                    <td class="px-4 py-3 font-bold text-emerald-700">${{ number_format($employee->salary) }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold
                            {{ $employee->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    @if($isAdmin)
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.employees.edit', $employee) }}"
                                class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">Edit</a>
                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('Delete this employee?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg bg-ember-50 px-3 py-1.5 text-xs font-semibold text-ember-700 transition hover:bg-ember-100">Delete</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-16 text-center">
                        <p class="text-4xl">👷</p>
                        <p class="mt-3 font-semibold text-brand-700">No employees yet</p>
                        <p class="text-sm text-brand-400">Add your first employee to start tracking attendance and payments.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
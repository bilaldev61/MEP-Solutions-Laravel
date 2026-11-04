@extends('layouts.admin')
@section('title', 'Edit Employee')

@section('content')

<div class="mx-auto max-w-2xl">
    <a href="{{ route('admin.employees.index') }}"
        class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-500 transition hover:text-brand-700">← Back to Employees</a>

    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-xl font-bold text-brand-900">👷 Edit Employee</h2>
        <p class="mt-1 text-sm text-brand-500">Salary is recorded in US Dollars (USD).</p>

        <form action="{{ route('admin.employees.update', $employee) }}" method="POST" class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
            @csrf
            @method('PUT')
            <div>
                <label class="field-label">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $employee->name) }}" required class="field-input">
                @error('name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" required class="field-input">
                @error('phone')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Role *</label>
                <input type="text" name="role" value="{{ old('role', $employee->role) }}" required class="field-input">
                @error('role')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Nationality</label>
                <input type="text" name="nationality" value="{{ old('nationality', $employee->nationality) }}" class="field-input">
            </div>
            <div>
                <label class="field-label">Join Date *</label>
                <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" required class="field-input">
                @error('join_date')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Salary (USD)</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-brand-400">$</span>
                    <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}" step="0.01" min="0" class="field-input pl-7">
                </div>
            </div>
            <div>
                <label class="field-label">Status</label>
                <select name="status" class="field-input">
                    <option value="active" @selected(old('status', $employee->status) == 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $employee->status) == 'inactive')>Inactive</option>
                </select>
            </div>
            <div class="flex flex-wrap gap-3 pt-2 sm:col-span-2">
                <button type="submit" class="btn-primary">Update Employee</button>
                <a href="{{ route('admin.employees.index') }}" class="btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')

<div class="mx-auto max-w-2xl">
    <a href="{{ route('admin.users.index') }}"
        class="mb-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-500 transition hover:text-brand-700">← Back to Users</a>

    <div class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-xl font-bold text-brand-900">👥 Edit User</h2>
        <p class="mt-1 text-sm text-brand-500">Leave the password blank to keep the current one.</p>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="mt-6 space-y-4">
            @csrf
            @method('PATCH')
            <div>
                <label class="field-label">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="field-input">
                @error('name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Email (login) *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="field-input">
                @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">New Password <span class="font-normal text-brand-400">(min 8 characters, optional)</span></label>
                <input type="password" name="password" minlength="8" class="field-input">
                @error('password')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label">Role *</label>
                <select name="role" class="field-input">
                    <option value="manager" @selected(old('role', $user->role) === 'manager')>Manager — limited access</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin — full access</option>
                </select>
                @if($user->id === auth()->id())
                <p class="mt-1 text-xs text-brand-400">Your own role can't be changed from here.</p>
                @else
                @error('role')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                @endif
            </div>
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn-primary">Save Changes</button>
                <a href="{{ route('admin.users.index') }}" class="btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
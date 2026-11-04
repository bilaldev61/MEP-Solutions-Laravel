@extends('layouts.admin')
@section('title', 'Profile Settings')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    <!-- Profile information -->
    <section class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-lg font-bold text-brand-900">👤 Profile Information</h2>
        <p class="mt-1 text-sm text-brand-500">Update your account name and email address.</p>

        @if (session('status') === 'profile-updated')
        <p class="mt-4 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700">Saved.</p>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PATCH')
            <div>
                <label class="field-label" for="name">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" class="field-input">
                @error('name')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="field-input">
                @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center gap-4 pt-1">
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </form>
    </section>

    <!-- Update password -->
    <section class="rounded-2xl border border-brand-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-lg font-bold text-brand-900">🔒 Update Password</h2>
        <p class="mt-1 text-sm text-brand-500">Use a long, random password to stay secure.</p>

        @if (session('status') === 'password-updated')
        <p class="mt-4 rounded-lg bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700">Saved.</p>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="field-label" for="current_password">Current Password</label>
                <input id="current_password" type="password" name="current_password" autocomplete="current-password" class="field-input">
                @error('current_password')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label" for="password">New Password</label>
                <input id="password" type="password" name="password" autocomplete="new-password" class="field-input">
                @error('password')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="field-label" for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="field-input">
            </div>
            <div class="flex items-center gap-4 pt-1">
                <button type="submit" class="btn-primary">Update Password</button>
            </div>
        </form>
    </section>

    <!-- Delete account -->
    <section class="rounded-2xl border border-ember-100 bg-white p-6 shadow-card sm:p-8">
        <h2 class="font-display text-lg font-bold text-ember-700">🗑️ Delete Account</h2>
        <p class="mt-1 text-sm text-brand-500">Once your account is deleted, all of its resources will be permanently removed.</p>

        <div x-data="{ open: false }" class="mt-6">
            <button type="button" @click="open = true" class="btn-dark !bg-ember-600 hover:!bg-ember-700">Delete Account</button>

            <div x-show="open" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-brand-950/60 p-4" @click.outside="open = false">
                <div x-show="open" x-transition class="w-full max-w-md rounded-2xl bg-white p-6 shadow-lift">
                    <h3 class="font-display text-lg font-bold text-brand-900">Are you sure?</h3>
                    <p class="mt-2 text-sm text-brand-500">Please confirm your password to permanently delete your account. This cannot be undone.</p>
                    <form action="{{ route('profile.destroy') }}" method="POST" class="mt-5">
                        @csrf
                        @method('DELETE')
                        <label class="field-label" for="delete_password">Password</label>
                        <input id="delete_password" type="password" name="password" required class="field-input">
                        @error('password', 'userDeletion')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                        <div class="mt-5 flex justify-end gap-3">
                            <button type="button" @click="open = false" class="btn-ghost !text-brand-600">Cancel</button>
                            <button type="submit" class="btn-primary">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection
<x-guest-layout>
    <h1 class="font-display text-2xl font-bold text-brand-900">Forgot your password?</h1>
    <p class="mt-1 text-sm leading-relaxed text-brand-500">No problem — enter the email you use to sign in and we'll send you a link to choose a new password.</p>

    <!-- Session Status (reset link sent confirmation appears here) -->
    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="field-label" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="field-input" placeholder="you@example.com">
            @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    <h1 class="font-display text-2xl font-bold text-brand-900">Choose a new password</h1>
    <p class="mt-1 text-sm leading-relaxed text-brand-500">Set a new password for your account — at least 8 characters.</p>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label class="field-label" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="field-input" placeholder="you@example.com">
            @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
        </div>

        <!-- Password -->
        <div>
            <label class="field-label" for="password">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="field-input" placeholder="••••••••" minlength="8">
            @error('password')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="field-label" for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="field-input" placeholder="••••••••" minlength="8">
            @error('password_confirmation')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
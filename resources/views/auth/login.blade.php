<x-guest-layout>
    <h1 class="font-display text-2xl font-bold text-brand-900">Welcome back</h1>
    <p class="mt-1 text-sm text-brand-500">Sign in to your admin account to continue.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mt-4" :status="session('status')" />

    <div x-data="{
        email: @js(old('email', 'admin@example.com')),
        password: 'password',
        fillAs(role) {
            this.email = role === 'admin' ? 'admin@example.com' : 'manager@example.com';
            this.password = 'password';
            this.$nextTick(() => this.$refs.password.focus());
        }
    }">
        <!-- Demo login helper: form is pre-filled; buttons switch the view -->
        <div class="mt-6 rounded-xl border border-dashed border-ember-400 bg-ember-50/70 px-4 py-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p class="text-sm font-semibold text-ember-700" x-text="email === 'manager@example.com' ? '🔑 Demo login — pre-filled as Manager' : '🔑 Demo login — pre-filled as Admin'"></p>
                <div class="flex gap-2">
                    <button type="button" @click="fillAs('admin')"
                        class="rounded-full bg-brand-900 px-3 py-1 text-xs font-bold text-white transition hover:bg-brand-800">Admin view</button>
                    <button type="button" @click="fillAs('manager')"
                        class="rounded-full bg-aqua-600 px-3 py-1 text-xs font-bold text-white transition hover:bg-aqua-700">Manager view</button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label class="field-label" for="email">Email</label>
                <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username" class="field-input" placeholder="you@example.com">
                @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>

            <!-- Password -->
            <div>
                <label class="field-label" for="password">Password</label>
                <input id="password" type="password" name="password" x-model="password" x-ref="password" required autocomplete="current-password" class="field-input" placeholder="••••••••">
                @error('email')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
                @error('password')<p class="mt-1 text-xs font-medium text-ember-600">{{ $message }}</p>@enderror
            </div>

            <!-- Remember Me -->
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-brand-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-brand-200 text-ember-600 shadow-sm focus:ring-ember-500">
                <span>{{ __('Remember me') }}</span>
            </label>

            <div class="flex items-center justify-between pt-1">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-brand-500 transition hover:text-brand-700">
                    {{ __('Forgot password?') }}
                </a>
                @endif

                <button type="submit" class="btn-primary">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
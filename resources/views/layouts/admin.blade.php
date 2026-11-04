<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-brand-50/50 font-sans">

    <div x-data="{ nav: false }" class="flex min-h-screen">
        <!-- SIDEBAR (off-canvas drawer on mobile, sticky full-height on md+) -->
        <aside :class="nav ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 shrink-0 transform overflow-y-auto bg-brand-950 text-white transition-transform duration-200 md:sticky md:inset-y-auto md:top-0 md:h-screen md:self-start md:translate-x-0">
            <div class="flex items-center gap-3 border-b border-white/10 p-6">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-gradient-to-br from-ember-500 to-ember-600 font-display font-bold">{{ $brandInitials }}</span>
                <div>
                    <p class="font-display font-bold leading-tight">{{ $brandName }}</p>
                    <span class="mt-0.5 inline-block rounded-full px-2 py-0.5 text-[10px] font-bold uppercase leading-none tracking-wider {{ auth()->user()->isAdmin() ? 'bg-ember-500 text-white' : 'bg-aqua-500 text-brand-950' }}">{{ auth()->user()->role }}</span>
                </div>
            </div>
            <nav class="space-y-1 p-4 text-sm">
                @php
                $isAdmin = auth()->user()->isAdmin();
                $items = [
                ['label' => 'Dashboard', 'icon' => '📊', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'adminOnly' => false],
                ['label' => 'Customer Leads', 'icon' => '📋', 'route' => 'admin.leads.index', 'active' => 'admin.leads*', 'adminOnly' => false],
                ['label' => 'Employees', 'icon' => '👷', 'route' => 'admin.employees.index', 'active' => 'admin.employees*', 'adminOnly' => false],
                ['label' => 'Attendance', 'icon' => '📅', 'route' => 'admin.attendance.index', 'active' => 'admin.attendance*', 'adminOnly' => false],
                ['label' => 'Payments', 'icon' => '💰', 'route' => 'admin.payments.index', 'active' => 'admin.payments*', 'adminOnly' => false],
                ['label' => 'Services', 'icon' => '🔧', 'route' => 'admin.services.index', 'active' => 'admin.services*', 'adminOnly' => true],
                ['label' => 'Users', 'icon' => '👥', 'route' => 'admin.users.index', 'active' => 'admin.users*', 'adminOnly' => true],
                ['label' => 'Site Settings', 'icon' => '⚙️', 'route' => 'admin.settings', 'active' => 'admin.settings*', 'adminOnly' => true],
                ];
                @endphp
                @foreach($items as $item)
                @if(!$item['adminOnly'] || $isAdmin)
                <a href="{{ route($item['route']) }}" @click="nav = false"
                    class="flex items-center gap-3 rounded-lg px-4 py-2.5 transition {{ request()->routeIs($item['active']) ? 'bg-ember-500/15 font-semibold text-ember-300' : 'text-brand-200 hover:bg-white/5 hover:text-white' }}">
                    <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
                </a>
                @endif
                @endforeach

                <hr class="my-3 border-white/10">

                <a href="{{ route('home') }}" target="_blank" @click="nav = false"
                    class="flex items-center gap-3 rounded-lg px-4 py-2.5 text-brand-200 transition hover:bg-white/5 hover:text-white">
                    <span>🌐</span> View Website
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg px-4 py-2.5 text-left text-brand-200 transition hover:bg-ember-600/20 hover:text-ember-300">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Mobile overlay -->
        <div x-show="nav" x-cloak @click="nav = false" class="fixed inset-0 z-40 bg-brand-950/60 backdrop-blur-sm md:hidden"></div>

        <!-- MAIN AREA -->
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="relative flex items-center justify-between gap-3 border-b border-brand-100 bg-white px-4 py-4 shadow-sm sm:px-8">
                <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                    <button @click="nav = true" aria-label="Open menu"
                        class="-ml-1 rounded-lg p-1.5 text-brand-600 transition hover:bg-brand-50 md:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </button>
                    <h1 class="truncate font-display text-lg font-bold text-brand-900 sm:text-xl">@yield('title')</h1>
                </div>
                <span class="pointer-events-none absolute left-1/2 hidden -translate-x-1/2 font-display text-lg font-bold text-ember-600 sm:block sm:text-xl">Admin Panel</span>
                <div x-data="{ open: false, t: null }" @mouseenter="clearTimeout(t); open = true" @mouseleave="t = setTimeout(() => open = false, 250)" class="relative shrink-0">
                    <button @click="open = !open" title="{{ auth()->user()->name }}"
                        class="group flex items-center gap-2 text-sm font-medium text-brand-600 transition hover:text-brand-900">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-100 font-semibold text-brand-700 ring-2 ring-transparent transition group-hover:ring-brand-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </button>
                    <div x-show="open" x-cloak @click.outside="open = false" x-transition.origin.top.right
                        class="absolute right-0 z-30 mt-2 w-52 rounded-xl border border-brand-100 bg-white p-1.5 shadow-lift">
                        <div class="px-3 py-2">
                            <p class="text-sm font-semibold text-brand-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-brand-400">{{ auth()->user()->email }}</p>
                        </div>
                        <hr class="my-1 border-brand-50">
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-brand-600 transition hover:bg-brand-50 hover:text-brand-900">
                            👤 Profile Settings
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-ember-700 transition hover:bg-ember-50">
                                🚪 Log out
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            <main class="flex-1 p-4 sm:p-6 md:p-8">
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-semibold text-emerald-800 shadow-card">
                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-emerald-500 text-white">✓</span>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 font-semibold text-red-800 shadow-card">
                    <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-red-500 text-white">✕</span>
                    {{ session('error') }}
                </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
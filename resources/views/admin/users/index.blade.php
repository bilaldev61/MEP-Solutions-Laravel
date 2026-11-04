@extends('layouts.admin')
@section('title', 'Users')

@section('content')

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h2 class="font-display text-lg font-bold text-brand-900">👥 User Accounts</h2>
        <p class="text-sm text-brand-500">Admins have full access. Managers handle day-to-day operations only.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary">+ Add User</a>
</div>

<!-- Mobile: stacked cards -->
<div class="space-y-3 md:hidden">
    @foreach($users as $user)
    <div class="rounded-2xl border border-brand-100 bg-white p-4 shadow-card">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <p class="truncate font-semibold text-brand-900">{{ $user->name }}</p>
                <p class="truncate text-xs text-brand-400">{{ $user->email }}</p>
            </div>
            <span class="inline-flex shrink-0 items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase leading-none tracking-wider {{ $user->isAdmin() ? 'bg-ember-500 text-white' : 'bg-aqua-500 text-brand-950' }}">{{ $user->role }}</span>
        </div>
        <div class="mt-3 flex items-center justify-between gap-2 border-t border-brand-50 pt-3">
            <span class="text-xs text-brand-400">Joined {{ $user->created_at->format('d M Y') }}</span>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">Edit</a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg bg-ember-50 px-3 py-1.5 text-xs font-semibold text-ember-700 transition hover:bg-ember-100">Delete</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Desktop: table -->
<div class="hidden overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-card md:block">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-brand-100 bg-brand-50/60 text-xs uppercase tracking-wider text-brand-500">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Joined</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-brand-50">
                @foreach($users as $user)
                <tr class="transition hover:bg-brand-50/40">
                    <td class="px-4 py-3 text-brand-400">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-semibold text-brand-900">
                        {{ $user->name }}
                        @if($user->id === auth()->id())<span class="ml-1 text-xs font-medium text-brand-400">(you)</span>@endif
                    </td>
                    <td class="px-4 py-3 text-brand-600">{{ $user->email }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase leading-none tracking-wider {{ $user->isAdmin() ? 'bg-ember-500 text-white' : 'bg-aqua-500 text-brand-950' }}">{{ $user->role }}</span>
                    </td>
                    <td class="px-4 py-3 text-brand-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="rounded-lg bg-brand-100 px-3 py-1.5 text-xs font-semibold text-brand-700 transition hover:bg-brand-200">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-lg bg-ember-50 px-3 py-1.5 text-xs font-semibold text-ember-700 transition hover:bg-ember-100">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
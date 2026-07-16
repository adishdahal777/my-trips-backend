@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Users', 'url' => null]]" />

    <x-page-header title="User Management" subtitle="Manage system users and their roles." icon="lucide:users">
        <x-slot name="actions">
            <form method="GET" class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 iconify w-4 h-4 text-muted-foreground" data-icon="lucide:search"></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                    class="pl-9 pr-4 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40 w-56">
            </form>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                <span class="iconify w-4 h-4" data-icon="lucide:user-plus"></span>
                Add User
            </a>
        </x-slot>
    </x-page-header>

    @if (session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($users as $user)
            <div class="bg-card border border-border rounded-xl overflow-hidden hover:shadow-md transition-all duration-200 flex flex-col">
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl flex-shrink-0 bg-primary/10 text-primary flex items-center justify-center">
                            <span class="text-sm font-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold truncate">{{ $user->name }}</h3>
                            <p class="text-xs text-muted-foreground truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide mb-1.5">Roles</p>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse ($user->roles as $role)
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/40">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-xs text-muted-foreground italic">No role assigned</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-auto">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium rounded-full {{ $user->email_verified_at ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400' : 'bg-muted text-muted-foreground' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $user->email_verified_at ? 'bg-green-500' : 'bg-muted-foreground' }}"></span>
                            {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-border px-5 py-3 flex items-center justify-between">
                    <a href="{{ route('admin.users.show', $user) }}"
                        class="inline-flex items-center gap-1 text-xs font-medium text-muted-foreground hover:text-primary transition-colors">
                        <span class="iconify w-3.5 h-3.5" data-icon="lucide:eye"></span>
                        View
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="inline-flex items-center gap-1 text-xs font-medium text-muted-foreground hover:text-primary transition-colors">
                        <span class="iconify w-3.5 h-3.5" data-icon="lucide:pencil"></span>
                        Edit
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                        onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 text-xs font-medium text-muted-foreground hover:text-destructive transition-colors">
                            <span class="iconify w-3.5 h-3.5" data-icon="lucide:trash-2"></span>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-card border border-border rounded-xl p-12 text-center">
                <span class="iconify w-12 h-12 text-muted-foreground/40 mx-auto block" data-icon="lucide:users"></span>
                <p class="mt-3 text-sm font-medium text-muted-foreground">No users found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection

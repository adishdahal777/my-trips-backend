@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <x-page-header title="Dashboard" subtitle="Overview of your MyTrips platform." icon="lucide:layout-dashboard" />

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="iconify w-[18px] h-[18px] text-blue-600 dark:text-blue-400" data-icon="lucide:users"></span>
            </div>
            <div>
                <p class="text-2xl font-bold leading-none">{{ $totalUsers }}</p>
                <p class="text-xs text-muted-foreground uppercase tracking-wide mt-0.5">Total Users</p>
            </div>
        </div>
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-green-50 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="iconify w-[18px] h-[18px] text-green-600 dark:text-green-400" data-icon="lucide:check-circle"></span>
            </div>
            <div>
                <p class="text-2xl font-bold leading-none">{{ $activeUsers }}</p>
                <p class="text-xs text-muted-foreground uppercase tracking-wide mt-0.5">Verified Users</p>
            </div>
        </div>
        <div class="bg-card border border-border rounded-xl p-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-purple-50 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="iconify w-[18px] h-[18px] text-purple-600 dark:text-purple-400" data-icon="lucide:map"></span>
            </div>
            <div>
                <p class="text-2xl font-bold leading-none">{{ $totalTrips }}</p>
                <p class="text-xs text-muted-foreground uppercase tracking-wide mt-0.5">Total Trips</p>
            </div>
        </div>
    </div>

    <div class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border flex items-center justify-between">
            <h2 class="text-sm font-semibold">Recently Registered Users</h2>
            <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-primary hover:underline">View all</a>
        </div>
        <div class="divide-y divide-border">
            @forelse ($recentUsers as $user)
                <div class="px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary inline-flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate">{{ $user->name }}</p>
                        <p class="text-xs text-muted-foreground truncate">{{ $user->email }}</p>
                    </div>
                    <span class="text-xs text-muted-foreground">{{ $user->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="px-5 py-6 text-sm text-muted-foreground text-center">No users yet.</p>
            @endforelse
        </div>
    </div>
@endsection

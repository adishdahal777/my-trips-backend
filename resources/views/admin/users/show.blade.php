@extends('layouts.admin')

@section('title', $user->name)

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Users', 'url' => route('admin.users.index')], ['title' => $user->name, 'url' => null]]" />

    <x-page-header title="{{ $user->name }}" subtitle="{{ $user->email }}" icon="lucide:user">
        <x-slot name="actions">
            <a href="{{ route('admin.users.edit', $user) }}"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                <span class="iconify w-4 h-4" data-icon="lucide:pencil"></span>
                Edit User
            </a>
        </x-slot>
    </x-page-header>

    <div class="mb-6 flex flex-wrap gap-1.5">
        @forelse ($user->roles as $role)
            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-800/40">
                {{ $role->name }}
            </span>
        @empty
            <span class="text-xs text-muted-foreground italic">No role assigned</span>
        @endforelse
    </div>

    <h2 class="text-sm font-semibold text-muted-foreground uppercase tracking-wide mb-4">Public Trips ({{ $publicTrips->count() }})</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($publicTrips as $trip)
            <div class="bg-card border border-border rounded-xl overflow-hidden hover:shadow-md transition-all duration-200 flex flex-col">
                <div class="h-40 bg-muted relative overflow-hidden">
                    @if ($trip->cover_photo)
                        <img src="{{ $trip->cover_photo }}" alt="{{ $trip->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="iconify w-12 h-12 text-muted-foreground/30" data-icon="lucide:image"></span>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3 flex gap-1.5">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            {{ $trip->status === 'completed' ? 'bg-green-500/90 text-white' : ($trip->status === 'ongoing' ? 'bg-blue-500/90 text-white' : 'bg-muted text-muted-foreground') }}">
                            {{ ucfirst($trip->status) }}
                        </span>
                        @if ($trip->is_featured)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-500/90 text-white">
                                Featured
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-sm font-semibold truncate">{{ $trip->name }}</h3>
                    <p class="text-xs text-muted-foreground truncate mb-3">{{ $trip->destination }} {{ $trip->flag }}</p>

                    <div class="mt-auto flex items-center justify-between text-xs text-muted-foreground">
                        <span>{{ $trip->start_date->format('M j') }} — {{ $trip->end_date->format('M j, Y') }}</span>
                        <span>Rs {{ number_format($trip->budget) }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-card border border-border rounded-xl p-12 text-center">
                <span class="iconify w-12 h-12 text-muted-foreground/40 mx-auto block" data-icon="lucide:map"></span>
                <p class="mt-3 text-sm font-medium text-muted-foreground">No public trips.</p>
            </div>
        @endforelse
    </div>
@endsection

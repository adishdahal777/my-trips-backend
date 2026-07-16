@extends('layouts.admin')

@section('title', 'Trips')

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Trips', 'url' => null]]" />

    <x-page-header title="Trip Management" subtitle="Manage all trips across the platform." icon="lucide:map">
        <x-slot name="actions">
            <form method="GET" class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 iconify w-4 h-4 text-muted-foreground" data-icon="lucide:search"></span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search trips..."
                    class="pl-9 pr-4 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40 w-56">
            </form>
            <select name="status" onchange="this.form.submit()" form="filterForm"
                class="px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                <option value="">All Status</option>
                <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </x-slot>
    </x-page-header>

    @if (session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($trips as $trip)
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
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $trip->visibility === 'public' ? 'bg-teal-500/90 text-white' : 'bg-orange-500/90 text-white' }}">
                            {{ ucfirst($trip->visibility) }}
                        </span>
                        @if ($trip->is_featured)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-500/90 text-white">
                                Featured
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl flex-shrink-0 bg-primary/10 text-primary flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr($trip->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold truncate">{{ $trip->name }}</h3>
                            <p class="text-xs text-muted-foreground truncate">{{ $trip->destination }} {{ $trip->flag }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                        <div class="bg-muted/50 rounded-lg py-1.5 px-1">
                            <div class="text-xs font-bold text-foreground">{{ $trip->routeStops()->count() }}</div>
                            <div class="text-[10px] text-muted-foreground">Stops</div>
                        </div>
                        <div class="bg-muted/50 rounded-lg py-1.5 px-1">
                            <div class="text-xs font-bold text-foreground">{{ $trip->photos()->count() }}</div>
                            <div class="text-[10px] text-muted-foreground">Photos</div>
                        </div>
                        <div class="bg-muted/50 rounded-lg py-1.5 px-1">
                            <div class="text-xs font-bold text-foreground">{{ $trip->likes()->count() }}</div>
                            <div class="text-[10px] text-muted-foreground">Likes</div>
                        </div>
                    </div>

                    <div class="mt-auto flex items-center justify-between text-xs text-muted-foreground">
                        <span>{{ $trip->start_date->format('M j') }} — {{ $trip->end_date->format('M j, Y') }}</span>
                        <span>Rs {{ number_format($trip->budget) }}</span>
                    </div>
                </div>

                <form action="{{ route('admin.trips.toggle-featured', $trip) }}" method="POST"
                    class="border-t border-border px-5 py-3 flex items-center justify-between">
                    @csrf
                    @method('PATCH')
                    <span class="text-xs font-medium {{ $trip->is_featured ? 'text-primary' : 'text-muted-foreground' }}">
                        {{ $trip->is_featured ? 'Featured' : 'Not featured' }}
                    </span>
                    <button type="submit" class="inline-flex items-center gap-1 text-xs font-medium text-muted-foreground hover:text-primary transition-colors">
                        <span class="iconify w-3.5 h-3.5" data-icon="lucide:star"></span>
                        {{ $trip->is_featured ? 'Unfeature' : 'Feature' }}
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-full bg-card border border-border rounded-xl p-12 text-center">
                <span class="iconify w-12 h-12 text-muted-foreground/40 mx-auto block" data-icon="lucide:map"></span>
                <p class="mt-3 text-sm font-medium text-muted-foreground">No trips found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $trips->links() }}
    </div>
@endsection

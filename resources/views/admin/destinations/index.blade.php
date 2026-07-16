@extends('layouts.admin')

@section('title', 'Destinations')

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Destinations', 'url' => null]]" />

    <x-page-header title="Popular Destinations" subtitle="Manage destinations shown on the landing page. Users can suggest destinations from the app; approve or reject them here." icon="lucide:globe">
        <x-slot name="actions">
            <select name="status" onchange="location.href='{{ route('admin.destinations.index') }}?status='+this.value"
                class="px-3 py-2 text-sm border border-input rounded-lg bg-background focus:outline-none focus:ring-2 focus:ring-ring/40">
                <option value="">All Status</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </x-slot>
    </x-page-header>

    @if (session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <details class="mb-6 border border-dashed border-border rounded-xl p-5">
        <summary class="text-sm font-medium cursor-pointer">+ Add destination</summary>
        <form action="{{ route('admin.destinations.store') }}" method="POST" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
            @csrf
            <input type="text" name="name" placeholder="Name (e.g. Bali)" required class="px-3 py-2 text-sm border border-input rounded-lg bg-background">
            <input type="text" name="country" placeholder="Country" required class="px-3 py-2 text-sm border border-input rounded-lg bg-background">
            <input type="text" name="flag" placeholder="Flag emoji (e.g. 🇮🇩)" class="px-3 py-2 text-sm border border-input rounded-lg bg-background">
            <input type="number" name="trip_count" placeholder="Trip count" class="px-3 py-2 text-sm border border-input rounded-lg bg-background">
            <input type="url" name="cover_image" placeholder="Cover image URL" class="px-3 py-2 text-sm border border-input rounded-lg bg-background sm:col-span-2">
            <label class="flex items-center gap-2 text-sm sm:col-span-2">
                <input type="checkbox" name="is_featured" value="1"> Feature on landing page
            </label>
            <button type="submit" class="sm:col-span-2 px-4 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                Add Destination
            </button>
        </form>
    </details>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($destinations as $dest)
            <div class="bg-card border border-border rounded-xl overflow-hidden flex flex-col">
                <div class="h-32 bg-muted relative overflow-hidden">
                    @if ($dest->cover_image)
                        <img src="{{ $dest->cover_image }}" alt="{{ $dest->name }}" class="w-full h-full object-cover">
                    @endif
                    <div class="absolute top-2 left-2 flex gap-1.5">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            {{ $dest->status === 'approved' ? 'bg-green-500/90 text-white' : ($dest->status === 'pending' ? 'bg-yellow-500/90 text-white' : 'bg-red-500/90 text-white') }}">
                            {{ ucfirst($dest->status) }}
                        </span>
                        @if ($dest->is_featured)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-500/90 text-white">Featured</span>
                        @endif
                    </div>
                </div>
                <div class="p-4 flex-1">
                    <h3 class="text-sm font-semibold">{{ $dest->flag }} {{ $dest->name }}</h3>
                    <p class="text-xs text-muted-foreground">{{ $dest->country }} · {{ $dest->trip_count }} trips</p>
                    @if ($dest->creator)
                        <p class="text-xs text-muted-foreground mt-1">Suggested by {{ $dest->creator->name }}</p>
                    @endif
                </div>
                <div class="border-t border-border px-4 py-3 flex flex-wrap items-center gap-3">
                    @if ($dest->status === 'pending')
                        <form action="{{ route('admin.destinations.approve', $dest) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-green-600 hover:underline">Approve</button>
                        </form>
                        <form action="{{ route('admin.destinations.reject', $dest) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-destructive hover:underline">Reject</button>
                        </form>
                    @else
                        <form action="{{ route('admin.destinations.toggle-featured', $dest) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-primary hover:underline">
                                {{ $dest->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.destinations.destroy', $dest) }}" method="POST" onsubmit="return confirm('Delete this destination?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs font-medium text-destructive hover:underline">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-card border border-border rounded-xl p-12 text-center">
                <p class="text-sm text-muted-foreground">No destinations found.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $destinations->links() }}
    </div>
@endsection

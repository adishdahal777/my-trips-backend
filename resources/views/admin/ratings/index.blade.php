@extends('layouts.admin')

@section('title', 'Ratings')

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Ratings', 'url' => null]]" />

    <x-page-header title="App Ratings" subtitle="Reviews submitted from the mobile app. Feature the best ones to show on the landing page's Loved By Travelers section." icon="lucide:star" />

    @if (session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($ratings as $rating)
            <div class="bg-card border border-border rounded-xl p-5 flex flex-col">
                <div class="text-yellow-500 text-sm mb-2">{{ str_repeat('★', $rating->stars) }}{{ str_repeat('☆', 5 - $rating->stars) }}</div>
                <p class="text-sm text-muted-foreground flex-1">{{ $rating->comment ?: 'No comment left.' }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold">{{ $rating->user->name ?? 'Deleted user' }}</p>
                        @if ($rating->is_featured)
                            <span class="text-xs text-primary font-medium">Featured</span>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <form action="{{ route('admin.ratings.toggle-featured', $rating) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-primary hover:underline">
                                {{ $rating->is_featured ? 'Unfeature' : 'Feature' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.ratings.destroy', $rating) }}" method="POST" onsubmit="return confirm('Delete this rating?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-medium text-destructive hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-card border border-border rounded-xl p-12 text-center">
                <p class="text-sm text-muted-foreground">No ratings yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $ratings->links() }}
    </div>
@endsection

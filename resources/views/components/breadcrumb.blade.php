@props(['breadcrumbs' => []])

<nav class="flex items-center gap-1.5 text-sm mb-5" aria-label="Breadcrumb">
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-1 text-muted-foreground hover:text-foreground transition-colors">
        <span class="iconify w-4 h-4" data-icon="lucide:home"></span>
        <span class="hidden sm:inline">Dashboard</span>
    </a>

    @foreach ($breadcrumbs as $crumb)
        <span class="iconify w-3.5 h-3.5 text-muted-foreground/60" data-icon="lucide:chevron-right"></span>
        @if (!empty($crumb['url']) && !$loop->last)
            <a href="{{ $crumb['url'] }}" class="text-muted-foreground hover:text-foreground transition-colors truncate max-w-[160px]">
                {{ $crumb['title'] }}
            </a>
        @else
            <span class="text-foreground font-medium truncate max-w-[200px]">{{ $crumb['title'] }}</span>
        @endif
    @endforeach
</nav>

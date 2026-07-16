@props(['title', 'subtitle' => null, 'icon' => null])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3 min-w-0">
        @if ($icon)
            <div class="w-9 h-9 bg-muted rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="iconify w-4.5 h-4.5 text-muted-foreground" data-icon="{{ $icon }}"></span>
            </div>
        @endif
        <div class="min-w-0">
            <h1 class="text-lg font-semibold text-foreground leading-tight">{{ $title }}</h1>
            @if ($subtitle)
                <p class="text-sm text-muted-foreground mt-0.5">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if (isset($actions))
        <div class="flex items-center gap-2 flex-shrink-0">
            {{ $actions }}
        </div>
    @endif
</div>

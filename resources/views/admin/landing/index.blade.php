@extends('layouts.admin')

@section('title', 'Landing Page')

@section('content')
    <x-breadcrumb :breadcrumbs="[['title' => 'Landing Page', 'url' => null]]" />

    <x-page-header title="Landing Page Content" subtitle="Manage the sections, feature cards, and steps shown on the public homepage." icon="lucide:layout" />

    @if (session('success'))
        <div class="mb-5 px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-5 px-4 py-3 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-lg text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Section copy --}}
    <div class="bg-card border border-border rounded-xl p-5 mb-6">
        <h2 class="text-sm font-semibold mb-4">Section Copy</h2>
        <form action="{{ route('admin.landing.sections.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @foreach (['features' => 'Features', 'how_it_works' => 'Simple Process', 'social_showcase' => "And There's More", 'testimonials' => 'Loved By Travelers'] as $key => $label)
                @php $section = $sections[$key] ?? null; @endphp
                <div class="border-t border-border pt-4 first:border-t-0 first:pt-0">
                    <p class="text-xs font-semibold text-muted-foreground uppercase tracking-wide mb-2">{{ $label }}</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" name="sections[{{ $key }}][badge]" value="{{ old("sections.$key.badge", $section->badge ?? '') }}" placeholder="Badge"
                            class="px-3 py-2 text-sm border border-input rounded-lg bg-background">
                        <input type="text" name="sections[{{ $key }}][title]" value="{{ old("sections.$key.title", $section->title ?? '') }}" placeholder="Title (use <br> for line break)"
                            class="px-3 py-2 text-sm border border-input rounded-lg bg-background sm:col-span-2">
                        <textarea name="sections[{{ $key }}][subtitle]" placeholder="Subtitle" rows="2"
                            class="px-3 py-2 text-sm border border-input rounded-lg bg-background sm:col-span-3">{{ old("sections.$key.subtitle", $section->subtitle ?? '') }}</textarea>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="px-4 py-2 text-sm font-medium bg-primary text-primary-foreground rounded-lg hover:opacity-90 transition-opacity">
                Save Section Copy
            </button>
        </form>
    </div>

    {{-- Feature cards --}}
    <div class="bg-card border border-border rounded-xl p-5 mb-6">
        <h2 class="text-sm font-semibold mb-4">Feature Cards</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
            @foreach ($featureCards as $card)
                <form action="{{ route('admin.landing.feature-cards.update', $card) }}" method="POST" class="border border-border rounded-lg p-4 space-y-2">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-2">
                        <select name="icon" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                            @foreach ($icons as $icon)
                                <option value="{{ $icon }}" @selected($card->icon === $icon)>{{ $icon }}</option>
                            @endforeach
                        </select>
                        <select name="color_key" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                            @foreach ($colors as $color)
                                <option value="{{ $color }}" @selected($card->color_key === $color)>{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="title" value="{{ $card->title }}" class="w-full px-2 py-1.5 text-sm border border-input rounded-md bg-background font-medium">
                    <textarea name="description" rows="2" class="w-full px-2 py-1.5 text-xs border border-input rounded-md bg-background">{{ $card->description }}</textarea>
                    <div class="flex items-center justify-between">
                        <input type="number" name="position" value="{{ $card->position }}" class="w-16 px-2 py-1 text-xs border border-input rounded-md bg-background">
                        <div class="flex gap-2">
                            <button type="submit" class="text-xs font-medium text-primary hover:underline">Save</button>
                            <button type="submit" formaction="{{ route('admin.landing.feature-cards.destroy', $card) }}" formmethod="POST"
                                onclick="return confirm('Delete this feature card?')" class="text-xs font-medium text-destructive hover:underline">
                                Delete
                            </button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>

        <details class="border border-dashed border-border rounded-lg p-4">
            <summary class="text-sm font-medium cursor-pointer">+ Add feature card</summary>
            <form action="{{ route('admin.landing.feature-cards.store') }}" method="POST" class="mt-3 space-y-2">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <select name="icon" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                        @foreach ($icons as $icon)<option value="{{ $icon }}">{{ $icon }}</option>@endforeach
                    </select>
                    <select name="color_key" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                        @foreach ($colors as $color)<option value="{{ $color }}">{{ $color }}</option>@endforeach
                    </select>
                </div>
                <input type="text" name="title" placeholder="Title" class="w-full px-2 py-1.5 text-sm border border-input rounded-md bg-background">
                <textarea name="description" placeholder="Description" rows="2" class="w-full px-2 py-1.5 text-xs border border-input rounded-md bg-background"></textarea>
                <input type="number" name="position" placeholder="Position" class="w-24 px-2 py-1 text-xs border border-input rounded-md bg-background">
                <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-primary text-primary-foreground rounded-md">Add</button>
            </form>
        </details>
    </div>

    {{-- Process steps --}}
    <div class="bg-card border border-border rounded-xl p-5">
        <h2 class="text-sm font-semibold mb-4">Process Steps</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
            @foreach ($processSteps as $step)
                <form action="{{ route('admin.landing.process-steps.update', $step) }}" method="POST" class="border border-border rounded-lg p-4 space-y-2">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-2">
                        <select name="icon" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                            @foreach ($icons as $icon)
                                <option value="{{ $icon }}" @selected($step->icon === $icon)>{{ $icon }}</option>
                            @endforeach
                        </select>
                        <select name="color_key" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                            @foreach ($colors as $color)
                                <option value="{{ $color }}" @selected($step->color_key === $color)>{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="title" value="{{ $step->title }}" class="w-full px-2 py-1.5 text-sm border border-input rounded-md bg-background font-medium">
                    <textarea name="description" rows="2" class="w-full px-2 py-1.5 text-xs border border-input rounded-md bg-background">{{ $step->description }}</textarea>
                    <div class="flex items-center justify-between">
                        <input type="number" name="position" value="{{ $step->position }}" class="w-16 px-2 py-1 text-xs border border-input rounded-md bg-background">
                        <div class="flex gap-2">
                            <button type="submit" class="text-xs font-medium text-primary hover:underline">Save</button>
                            <button type="submit" formaction="{{ route('admin.landing.process-steps.destroy', $step) }}" formmethod="POST"
                                onclick="return confirm('Delete this step?')" class="text-xs font-medium text-destructive hover:underline">
                                Delete
                            </button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>

        <details class="border border-dashed border-border rounded-lg p-4">
            <summary class="text-sm font-medium cursor-pointer">+ Add step</summary>
            <form action="{{ route('admin.landing.process-steps.store') }}" method="POST" class="mt-3 space-y-2">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <select name="icon" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                        @foreach ($icons as $icon)<option value="{{ $icon }}">{{ $icon }}</option>@endforeach
                    </select>
                    <select name="color_key" class="px-2 py-1.5 text-xs border border-input rounded-md bg-background">
                        @foreach ($colors as $color)<option value="{{ $color }}">{{ $color }}</option>@endforeach
                    </select>
                </div>
                <input type="text" name="title" placeholder="Title" class="w-full px-2 py-1.5 text-sm border border-input rounded-md bg-background">
                <textarea name="description" placeholder="Description" rows="2" class="w-full px-2 py-1.5 text-xs border border-input rounded-md bg-background"></textarea>
                <input type="number" name="position" placeholder="Position" class="w-24 px-2 py-1 text-xs border border-input rounded-md bg-background">
                <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-primary text-primary-foreground rounded-md">Add</button>
            </form>
        </details>
    </div>
@endsection

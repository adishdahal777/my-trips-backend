@extends('layouts.frontend')

@section('title', $trip->name . ' — MyTrips')

@push('head-css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<main class="ft-home">

    {{-- ═══════════════════════════════════════════════════
         NAVIGATION
    ═══════════════════════════════════════════════════ --}}
    <nav class="ft-nav">
        <div class="ft-nav-inner wrap">
            <a href="/" class="ft-brand">
                <svg class="ft-brand-icon" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M2 12h20"/>
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                </svg>
                <span>MyTrips</span>
            </a>
            <div class="ft-nav-links">
                <a href="/#features">Features</a>
                <a href="/#trips">Explore</a>
                <a href="/#destinations">Destinations</a>
            </div>
            <div class="ft-nav-actions">
                <button class="btn-ghost btn-sm" onclick="toggleTheme()" aria-label="Toggle theme">
                    <svg class="theme-light" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                    <svg class="theme-dark" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                </button>
                <a href="#download" class="btn btn-primary btn-sm">Get the app</a>
            </div>
            <button class="ft-mob-menu" onclick="document.querySelector('.ft-nav-links').classList.toggle('open')" aria-label="Menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </button>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════════
         HERO
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-hero" style="min-height:75vh;">
        <div class="ft-hero-bg">
            @if ($trip->cover_photo)
                <img src="{{ $trip->cover_photo }}" alt="{{ $trip->name }}" fetchpriority="high" />
            @else
                <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=1600&q=85" alt="" fetchpriority="high" />
            @endif
            <div class="ft-hero-overlay"></div>
        </div>
        <div class="ft-hero-content wrap" style="grid-template-columns:1fr; padding:140px 0 60px;">
            <div class="ft-hero-text" style="max-width:700px;">
                <div style="display:flex;gap:10px;margin-bottom:20px;" class="reveal">
                    <span class="ft-hc-status {{ $trip->status }}">{{ ucfirst($trip->status) }}</span>
                    @if ($trip->visibility === 'public')
                    <span class="ft-hero-eyebrow" style="margin-bottom:0;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        Public trip
                    </span>
                    @endif
                </div>
                <h1 class="ft-hero-title reveal reveal-delay-1" style="font-size:clamp(36px,5vw,60px);">{{ $trip->name }}</h1>
                <div class="reveal reveal-delay-2" style="display:flex;align-items:center;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
                    <span style="font-size:15px;color:rgba(255,255,255,0.75);font-weight:600;">{{ $trip->flag }} {{ $trip->destination }}</span>
                    @if ($trip->start_date && $trip->end_date)
                        <span style="color:rgba(255,255,255,0.35);">·</span>
                        <span style="font-size:14px;color:rgba(255,255,255,0.65);">{{ $trip->start_date->format('M j') }} — {{ $trip->end_date->format('M j, Y') }}</span>
                        <span style="color:rgba(255,255,255,0.35);">·</span>
                        <span style="font-size:14px;color:rgba(255,255,255,0.65);">{{ $trip->start_date->diffInDays($trip->end_date) }} days</span>
                    @endif
                    <span style="color:rgba(255,255,255,0.35);">·</span>
                    <span style="font-size:14px;color:rgba(255,255,255,0.65);">{{ $trip->routeStops->count() }} stops</span>
                </div>
                @if ($trip->description)
                    <p class="ft-hero-desc reveal reveal-delay-2" style="max-width:600px;">{{ Str::limit($trip->description, 200) }}</p>
                @endif
                <div class="reveal reveal-delay-3" style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.2);backdrop-filter:blur(8px);display:grid;place-items:center;font-weight:700;font-size:16px;border:2px solid rgba(255,255,255,0.3);color:#fff;">{{ strtoupper(substr($trip->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:700;font-size:14px;color:#fff;">{{ $trip->user->name ?? 'Anonymous' }}</div>
                        </div>
                    </div>
                    <div style="margin-left:8px;display:flex;gap:16px;font-size:13px;color:rgba(255,255,255,0.65);">
                        <span>❤️ {{ $trip->likes->count() }}</span>
                        <span>💬 {{ $trip->comments->count() }}</span>
                    </div>
                </div>
                <div class="ft-hero-cta reveal reveal-delay-3">
                    <button class="btn btn-primary btn-lg" style="background:#fff;color:var(--text);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.5-9.5-9A5.5 5.5 0 0 1 12 6a5.5 5.5 0 0 1 9.5 6c-2.5 4.5-9.5 9-9.5 9z"/></svg>
                        Like this trip
                    </button>
                    <button class="btn btn-secondary btn-lg" style="background:rgba(255,255,255,0.1);color:#fff;border:1px solid rgba(255,255,255,0.25);backdrop-filter:blur(10px);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                        Share
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         QUICK STATS STRIP
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-stats tight">
        <div class="wrap">
            <div class="ft-stats-grid">
                <div class="ft-stat reveal">
                    <div class="ft-stat-num">{{ $trip->start_date && $trip->end_date ? $trip->start_date->diffInDays($trip->end_date) . 'd' : '—' }}</div>
                    <div class="ft-stat-label">Duration</div>
                </div>
                <div class="ft-stat reveal reveal-delay-1">
                    <div class="ft-stat-num">{{ $trip->routeStops->count() }}</div>
                    <div class="ft-stat-label">Total stops</div>
                </div>
                <div class="ft-stat reveal reveal-delay-2">
                    <div class="ft-stat-num">Rs {{ number_format($trip->spent ?: $trip->budget) }}</div>
                    <div class="ft-stat-label">{{ $trip->spent ? 'Total spent' : 'Budget' }}</div>
                </div>
                <div class="ft-stat reveal reveal-delay-3">
                    <div class="ft-stat-num">{{ $trip->photos->count() }}</div>
                    <div class="ft-stat-label">Photos</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         SECTION NAVIGATION (Tabs as web pills)
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-nav-wrap">
        <div class="wrap">
            <div class="tp-nav reveal">
                <button class="tp-nav-pill active" data-tab="overview">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    Overview
                </button>
                <button class="tp-nav-pill" data-tab="route">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Route
                </button>
                <button class="tp-nav-pill" data-tab="expenses">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Expenses
                </button>
                <button class="tp-nav-pill" data-tab="photos">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                    Photos
                </button>
                <button class="tp-nav-pill" data-tab="notes">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Notes
                </button>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         TAB: OVERVIEW
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-panel active" id="panel-overview">

        {{-- Budget Overview --}}
        @php
            $totalSpent = $trip->spent ?: $trip->expenses->sum('amount');
            $budgetPct = $trip->budget > 0 ? min(round(($totalSpent / $trip->budget) * 100), 100) : 0;
            $remaining = max($trip->budget - $totalSpent, 0);
            $categoryIcons = ['Accommodation' => '🏨', 'Food' => '🍽️', 'Transport' => '🚌', 'Activities' => '🎭', 'Shopping' => '🛍️', 'Other' => '📦'];
            $categoryColors = ['Accommodation' => 'var(--teal)', 'Food' => 'var(--coral)', 'Transport' => 'var(--brand)', 'Activities' => '#7C3AED', 'Shopping' => '#EC4899', 'Other' => '#8A877F'];
        @endphp
        <section class="ft-features tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge">Budget overview</span>
                    <div class="sec-title" style="margin-top:12px;">Rs {{ number_format($totalSpent) }} spent of Rs {{ number_format($trip->budget) }}</div>
                    <div class="sec-sub" style="text-align:center;">Rs {{ number_format($remaining) }} remaining · {{ $budgetPct }}% of budget utilized</div>
                </div>

                <div class="ft-features-showcase reveal-scale" style="margin-top:24px;">
                    <div class="ft-fs-content">
                        <span class="ft-fs-label">Trip budget</span>
                        <h2 style="font-size:28px;">Budget breakdown</h2>
                        <div class="tp-budget-track" style="height:10px;margin:20px 0 16px;">
                            <div class="tp-budget-fill" style="width:{{ $budgetPct }}%;height:100%;"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;color:var(--text-muted);margin-bottom:24px;">
                            <span>Spent Rs {{ number_format($totalSpent) }}</span>
                            <span>Remaining Rs {{ number_format($remaining) }}</span>
                        </div>
                        <div class="ft-fs-stats">
                            @foreach ($expensesByCategory->take(3) as $cat => $data)
                            <div class="ft-fs-stat">
                                <strong>{{ $categoryIcons[$cat] ?? '📦' }} {{ $cat }} — Rs {{ number_format($data['total']) }}</strong>
                                <span>{{ $trip->budget > 0 ? round(($data['total'] / $trip->budget) * 100) : 0 }}% of budget · {{ $data['count'] }} expense{{ $data['count'] > 1 ? 's' : '' }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ft-fs-visual">
                        <div style="display:flex;flex-direction:column;gap:12px;width:100%;">
                            @foreach ($expensesByCategory as $cat => $data)
                            @php
                                $pct = $totalSpent > 0 ? round(($data['total'] / $totalSpent) * 100) : 0;
                            @endphp
                            <div style="display:flex;align-items:center;gap:12px;">
                                <span style="font-size:20px;width:32px;text-align:center;">{{ $categoryIcons[$cat] ?? '📦' }}</span>
                                <div style="flex:1;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
                                        <span style="font-size:13px;font-weight:600;color:var(--text);">{{ $cat }}</span>
                                        <span style="font-size:13px;font-weight:700;color:var(--text);">Rs {{ number_format($data['total']) }}</span>
                                    </div>
                                    <div style="height:6px;background:var(--surface-3);border-radius:var(--r-pill);overflow:hidden;">
                                        <div style="height:100%;width:{{ $pct }}%;background:{{ $categoryColors[$cat] ?? '#8A877F' }};border-radius:var(--r-pill);transition:width 1s cubic-bezier(0.16,1,0.3,1);"></div>
                                    </div>
                                </div>
                                <span style="font-size:12px;color:var(--text-muted);width:32px;text-align:right;">{{ $pct }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- About this trip --}}
        <section class="ft-how tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge" style="background:var(--coral-soft);color:var(--coral);">About</span>
                    <div class="sec-title" style="margin-top:12px;">About this trip</div>
                </div>

                <div style="max-width:700px;margin:32px auto 0;text-align:center;" class="reveal">
                    <p style="font-size:16px;line-height:1.8;color:var(--text-soft);">{{ $trip->description ?: 'No description provided for this trip.' }}</p>
                    @if ($trip->pref_purpose || $trip->pref_accommodation || $trip->pref_pace || $trip->pref_food_priority)
                    <div style="display:flex;gap:10px;justify-content:center;margin-top:24px;flex-wrap:wrap;">
                        @if ($trip->pref_purpose)
                            <span style="padding:8px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-pill);font-size:14px;color:var(--text-soft);">🎯 {{ $trip->pref_purpose }}</span>
                        @endif
                        @if ($trip->pref_accommodation)
                            <span style="padding:8px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-pill);font-size:14px;color:var(--text-soft);">🏠 {{ $trip->pref_accommodation }}</span>
                        @endif
                        @if ($trip->pref_pace)
                            <span style="padding:8px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-pill);font-size:14px;color:var(--text-soft);">🚶 {{ $trip->pref_pace }}</span>
                        @endif
                        @if ($trip->pref_food_priority)
                            <span style="padding:8px 18px;background:var(--surface);border:1px solid var(--border);border-radius:var(--r-pill);font-size:14px;color:var(--text-soft);">🍜 {{ $trip->pref_food_priority }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- Route Preview --}}
        <section class="ft-features tight">
            <div class="wrap">
                <div class="sec-head">
                    <div>
                        <div class="sec-title">The route</div>
                        <div class="sec-sub">{{ $trip->routeStops->count() }} stops on this journey.</div>
                    </div>
                    <button class="sec-link" onclick="switchTab('route')">View full route
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </button>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">
                    @foreach ($trip->routeStops->take(7) as $i => $stop)
                    <div class="ft-feature-card reveal" style="display:flex;align-items:center;gap:14px;padding:18px 20px;@if($i > 0) animation-delay:{{ $i * 0.08 }}s; @endif">
                        <div style="width:36px;height:36px;border-radius:50%;background:{{ $stop->color ?: 'var(--brand)' }};color:#fff;display:grid;place-items:center;font-size:13px;font-weight:700;flex-shrink:0;">{{ $stop->label }}</div>
                        <div>
                            <div style="font-weight:700;font-size:14px;color:var(--text);">{{ $stop->name }}</div>
                            <div style="font-size:12px;color:var(--text-muted);">Stop {{ $stop->position }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Preferences --}}
        @if ($trip->pref_purpose || $trip->pref_accommodation || $trip->pref_pace || $trip->pref_food_priority)
        <section class="ft-trips tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge" style="background:var(--teal-soft);color:var(--teal);">Preferences</span>
                    <div class="sec-title" style="margin-top:12px;">Trip preferences</div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-top:32px;max-width:800px;margin-left:auto;margin-right:auto;">
                    @if ($trip->pref_purpose)
                    <div class="ft-feature-card reveal" style="text-align:center;padding:28px 20px;">
                        <div style="font-size:28px;margin-bottom:12px;">🎯</div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:6px;">Purpose</div>
                        <div style="font-size:15px;font-weight:700;color:var(--text);">{{ $trip->pref_purpose }}</div>
                    </div>
                    @endif
                    @if ($trip->pref_accommodation)
                    <div class="ft-feature-card reveal" style="text-align:center;padding:28px 20px;">
                        <div style="font-size:28px;margin-bottom:12px;">🏠</div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:6px;">Accommodation</div>
                        <div style="font-size:15px;font-weight:700;color:var(--text);">{{ $trip->pref_accommodation }}</div>
                    </div>
                    @endif
                    @if ($trip->pref_pace)
                    <div class="ft-feature-card reveal" style="text-align:center;padding:28px 20px;">
                        <div style="font-size:28px;margin-bottom:12px;">🚶</div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:6px;">Pace</div>
                        <div style="font-size:15px;font-weight:700;color:var(--text);">{{ $trip->pref_pace }}</div>
                    </div>
                    @endif
                    @if ($trip->pref_food_priority)
                    <div class="ft-feature-card reveal" style="text-align:center;padding:28px 20px;">
                        <div style="font-size:28px;margin-bottom:12px;">🍜</div>
                        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin-bottom:6px;">Food Priority</div>
                        <div style="font-size:15px;font-weight:700;color:var(--text);">{{ $trip->pref_food_priority }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════
         TAB: ROUTE
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-panel" id="panel-route">

        {{-- Map --}}
        <section class="ft-features tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge">Interactive map</span>
                    <div class="sec-title" style="margin-top:12px;">Route visualization</div>
                    <div class="sec-sub" style="text-align:center;">{{ $trip->routeStops->count() }} stops on this journey</div>
                </div>

                <div class="tp-map reveal-scale" style="margin-top:24px;">
                    <div id="tripLeafletMap" class="tp-map-inner" style="position:relative;"></div>
                </div>

                {{-- Route Stats --}}
                <div class="ft-stats-grid reveal" style="margin-top:32px;grid-template-columns:repeat(4,1fr);">
                    <div class="ft-stat">
                        <div class="ft-stat-num">{{ $trip->routeStops->count() }}</div>
                        <div class="ft-stat-label">Stops</div>
                    </div>
                    <div class="ft-stat">
                        <div class="ft-stat-num">{{ $trip->start_date && $trip->end_date ? $trip->start_date->diffInDays($trip->end_date) : '—' }}</div>
                        <div class="ft-stat-label">Days</div>
                    </div>
                    <div class="ft-stat">
                        <div class="ft-stat-num">{{ $trip->expenses->count() }}</div>
                        <div class="ft-stat-label">Expenses</div>
                    </div>
                    <div class="ft-stat">
                        <div class="ft-stat-num">{{ $trip->notes->count() }}</div>
                        <div class="ft-stat-label">Notes</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Detailed Path --}}
        <section class="ft-how tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge" style="background:var(--coral-soft);color:var(--coral);">Step by step</span>
                    <div class="sec-title" style="margin-top:12px;">Detailed path</div>
                </div>

                <div style="max-width:700px;margin:40px auto 0;">
                    @foreach ($trip->routeStops->sortBy('position') as $i => $stop)
                    <div class="reveal" style="display:flex;gap:16px;@if($i > 0) margin-top:-1px; @endif">
                        <div style="display:flex;flex-direction:column;align-items:center;">
                            <div style="width:40px;height:40px;border-radius:50%;background:{{ $stop->color ?: 'var(--brand)' }};color:#fff;display:grid;place-items:center;font-size:14px;font-weight:700;flex-shrink:0;box-shadow:0 2px 8px {{ ($stop->color ?: 'var(--brand)') }}33;">{{ $stop->label }}</div>
                            @if ($i < $trip->routeStops->count() - 1)
                            <div style="width:2px;flex:1;min-height:24px;background:var(--border);"></div>
                            @endif
                        </div>
                        <div style="padding-bottom:28px;flex:1;">
                            <div style="display:flex;justify-content:space-between;align-items:baseline;">
                                <div style="font-weight:700;font-size:16px;color:var(--text);">{{ $stop->name }}</div>
                                <div style="font-size:12px;color:var(--text-muted);">Stop {{ $stop->position }}</div>
                            </div>
                            <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ $stop->lat }}, {{ $stop->lng }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

    {{-- ═══════════════════════════════════════════════════
         TAB: EXPENSES
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-panel" id="panel-expenses">

        {{-- Total Hero --}}
        <section style="padding:0;">
            <div class="ft-cta-card reveal-scale" style="border-radius:0;min-height:300px;">
                <div class="ft-cta-bg">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1400&q=80" alt="" />
                    <div class="ft-cta-overlay"></div>
                </div>
                <div class="ft-cta-content" style="padding:60px 40px;">
                    <span style="font-size:14px;color:rgba(255,255,255,0.7);">Total spent on this trip</span>
                    <div style="font-family:var(--font-display);font-size:clamp(48px,6vw,72px);font-weight:800;color:#fff;letter-spacing:-0.03em;margin:8px 0;">Rs {{ number_format($totalSpent) }}</div>
                    <span style="font-size:16px;color:rgba(255,255,255,0.7);">Remaining: <strong style="color:#fff;">Rs {{ number_format($remaining) }}</strong></span>
                </div>
            </div>
        </section>

        {{-- Category Breakdown --}}
        <section class="ft-features tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge">Categories</span>
                    <div class="sec-title" style="margin-top:12px;">Spending breakdown</div>
                </div>

                <div class="ft-features-grid" style="margin-top:24px;">
                    @foreach ($expensesByCategory as $cat => $data)
                    @php
                        $pct = $totalSpent > 0 ? round(($data['total'] / $totalSpent) * 100) : 0;
                    @endphp
                    <div class="ft-feature-card reveal">
                        <div class="ft-fc-icon" style="background:{{ $categoryColors[$cat] ?? '#8A877F' }}15;color:{{ $categoryColors[$cat] ?? '#8A877F' }};">
                            <span style="font-size:22px;">{{ $categoryIcons[$cat] ?? '📦' }}</span>
                        </div>
                        <h3 style="font-size:20px;">Rs {{ number_format($data['total']) }}</h3>
                        <p style="margin-bottom:8px;">{{ $cat }}</p>
                        <div style="height:4px;background:var(--surface-3);border-radius:var(--r-pill);overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $categoryColors[$cat] ?? '#8A877F' }};border-radius:var(--r-pill);transition:width 1s cubic-bezier(0.16,1,0.3,1);"></div>
                        </div>
                        <div style="font-size:12px;color:var(--text-muted);margin-top:6px;">{{ $pct }}% · {{ $data['count'] }} expense{{ $data['count'] > 1 ? 's' : '' }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Transactions --}}
        @if ($trip->expenses->isNotEmpty())
        <section class="ft-trips tight">
            <div class="wrap">
                <div class="sec-head">
                    <div>
                        <div class="sec-title">Transaction history</div>
                        <div class="sec-sub">Recent expenses from this trip.</div>
                    </div>
                </div>

                <div class="ft-trips-grid reveal" style="grid-template-columns:1fr;">
                    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;">
                        @foreach ($trip->expenses->sortByDesc('date') as $expense)
                        <div style="display:flex;align-items:center;gap:14px;padding:16px 24px;border-bottom:1px solid var(--border-light);transition:background 0.15s;@if($loop->last) border-bottom:none; @endif">
                            <span style="font-size:22px;flex-shrink:0;">{{ $categoryIcons[$expense->category] ?? '📦' }}</span>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:14px;font-weight:500;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $expense->description }}</div>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">{{ $expense->category }} · {{ $expense->date->format('M j') }}</div>
                            </div>
                            <div style="font-family:var(--font-display);font-size:15px;font-weight:700;color:var(--coral);white-space:nowrap;">-Rs {{ number_format($expense->amount, 2) }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
    </div>

    {{-- ═══════════════════════════════════════════════════
         TAB: PHOTOS
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-panel" id="panel-photos">
        <section class="ft-destinations tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge" style="background:var(--teal-soft);color:var(--teal);">Photo journal</span>
                    <div class="sec-title" style="margin-top:12px;">{{ $trip->photos->count() }} photos from the journey</div>
                    <div class="sec-sub" style="text-align:center;">Moments captured across this trip.</div>
                </div>

                @if ($trip->photos->isEmpty())
                    <div class="text-center py-12 text-muted-foreground">No photos uploaded yet.</div>
                @else
                <div class="ft-dest-grid" style="margin-top:32px;grid-template-columns:repeat(3,1fr);">
                    @foreach ($trip->photos as $photo)
                    <div class="ft-dest-card @if($loop->index === 0 || $loop->index === 6) ft-dest-lg @endif reveal-scale" style="aspect-ratio:1;">
                        <img src="{{ $photo->url }}" alt="{{ $photo->caption }}" loading="lazy" style="transition:transform 0.5s ease;" />
                        <div class="ft-dest-overlay" style="background:linear-gradient(to top,rgba(0,0,0,0.7) 0%,transparent 50%);"></div>
                        <div class="ft-dest-body" style="padding:16px;">
                            <div style="font-size:13px;color:#fff;font-weight:500;">{{ $photo->caption }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
    </div>

    {{-- ═══════════════════════════════════════════════════
         TAB: NOTES
    ═══════════════════════════════════════════════════ --}}
    <div class="tp-panel" id="panel-notes">
        <section class="ft-features tight">
            <div class="wrap">
                <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                    <span class="badge" style="background:rgba(124,58,237,0.08);color:#7C3AED;">Journal</span>
                    <div class="sec-title" style="margin-top:12px;">Trip notes</div>
                    <div class="sec-sub" style="text-align:center;">Personal journal entries from the journey.</div>
                </div>

                @if ($trip->notes->isEmpty())
                    <div class="text-center py-12 text-muted-foreground">No notes yet.</div>
                @else
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:20px;margin-top:32px;">
                    @foreach ($trip->notes as $note)
                    <div class="ft-feature-card reveal" style="padding:0;overflow:hidden;border:none;background:{{ $note->color ?: '#f8fafc' }};border:1px solid var(--border);">
                        <div style="padding:24px 24px 0;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                                <span style="font-size:28px;">{{ $note->mood }}</span>
                                <span style="font-size:12px;color:var(--text-muted);">{{ $note->date->format('M j, Y') }}</span>
                            </div>
                            <h3 style="font-family:var(--font-display);font-size:18px;font-weight:700;color:var(--text);margin-bottom:10px;">{{ $note->title }}</h3>
                        </div>
                        <p style="font-size:14px;line-height:1.7;color:var(--text-soft);padding:0 24px 24px;display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;overflow:hidden;">{{ $note->body }}</p>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </section>
    </div>

    {{-- ═══════════════════════════════════════════════════
         COMMENTS
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-testimonials tight">
        <div class="wrap">
            <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                <span class="badge" style="background:var(--coral-soft);color:var(--coral);">Community</span>
                <div class="sec-title" style="margin-top:12px;">Comments ({{ $trip->comments->count() }})</div>
            </div>

            <div style="max-width:700px;margin:32px auto 0;">
                @php
                $commentColors = [
                    ['color' => 'var(--coral-soft)', 'text' => 'var(--coral)'],
                    ['color' => 'var(--teal-soft)', 'text' => 'var(--teal)'],
                    ['color' => 'rgba(124,58,237,0.08)', 'text' => '#7C3AED'],
                    ['color' => 'var(--brand-soft)', 'text' => 'var(--brand)'],
                ];
                @endphp
                @foreach ($trip->comments as $comment)
                @php $cColor = $commentColors[$loop->index % count($commentColors)]; @endphp
                <div class="ft-test-card reveal" style="margin-bottom:16px;">
                    <div style="display:flex;gap:12px;">
                        <div class="ft-test-avatar" style="background:{{ $cColor['color'] }};color:{{ $cColor['text'] }};">{{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}</div>
                        <div style="flex:1;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                                <strong style="font-size:14px;color:var(--text);">{{ $comment->user->name ?? 'Anonymous' }}</strong>
                                <span style="font-size:12px;color:var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p style="font-size:14px;line-height:1.65;color:var(--text-soft);margin:0;">{{ $comment->body }}</p>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Comment Input --}}
                <div class="ft-test-card reveal" style="display:flex;gap:12px;align-items:center;margin-top:16px;">
                    <div class="ft-test-avatar" style="background:var(--brand-soft);color:var(--brand);">Y</div>
                    <div style="flex:1;padding:12px 18px;background:var(--surface-3);border-radius:var(--r-pill);font-size:14px;color:var(--text-muted);cursor:pointer;">Write a comment...</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         CTA / DOWNLOAD
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-cta tight" id="download">
        <div class="wrap">
            <div class="ft-cta-card reveal-scale">
                <div class="ft-cta-bg">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200&q=80" alt="" />
                    <div class="ft-cta-overlay"></div>
                </div>
                <div class="ft-cta-content">
                    <h2>Ready to start<br>your next adventure?</h2>
                    <p>Join thousands of travelers who use MyTrips to document, track, and share their journeys. Available on iOS and Android.</p>
                    <div class="ft-cta-buttons">
                        <a href="#" class="btn btn-primary btn-lg">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Download for free
                        </a>
                        <a href="#" class="btn btn-secondary btn-lg" style="background:rgba(255,255,255,0.15);color:#fff;border-color:rgba(255,255,255,0.3);">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Watch demo
                        </a>
                    </div>
                    <div class="ft-cta-platforms">
                        <span>Available on</span>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.523 2.094a.336.336 0 0 0-.06-.005h-.005c-.15.005-.69.04-1.39.22a3.85 3.85 0 0 0-2.166 1.583c-.53.82-.89 1.89-.93 2.98-.005.12-.01.24-.01.355 0 .13.005.26.015.385.055 1.17.45 2.29 1.08 3.21a3.9 3.9 0 0 0 2.27 1.47c.72.18 1.32.22 1.48.225h.04c.15-.005.75-.05 1.47-.23a3.92 3.92 0 0 0 2.28-1.48c.63-.92 1.02-2.04 1.07-3.2a5.06 5.06 0 0 0 .02-.39c.005-.05.01-.1.01-.15a4.1 4.1 0 0 0-.05-.6 3.84 3.84 0 0 0-.97-2.02 3.8 3.8 0 0 0-2.07-1.46c-.38-.1-.78-.16-1.19-.17a5.86 5.86 0 0 0-.225-.005l-.04.003-.025.002zm-2.24 1.1c.04-.02.16-.04.33-.04.2 0 .44.04.7.12a3.09 3.09 0 0 1 1.68 1.24c.42.65.71 1.49.75 2.38.005.12.005.24 0 .36-.04.97-.34 1.86-.79 2.56a3.1 3.1 0 0 1-1.71 1.2c-.27.07-.53.11-.8.11-.18 0-.37-.02-.55-.06a3.12 3.12 0 0 1-1.79-1.21c-.46-.7-.76-1.59-.8-2.54-.01-.12-.01-.24 0-.36.04-.97.35-1.88.8-2.58.46-.71 1.07-1.27 1.79-1.48.24-.07.46-.1.68-.1.15 0 .3.01.44.04l-.01.01.04.01z"/></svg>
                        <span style="font-size:12px;opacity:0.7;">Web app coming soon</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════ --}}
    <footer class="ft-footer">
        <div class="wrap">
            <div class="ft-footer-grid">
                <div class="ft-footer-brand">
                    <a href="/" class="ft-brand">
                        <svg class="ft-brand-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M2 12h20"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <span>MyTrips</span>
                    </a>
                    <p>The modern trip-sharing app for explorers. Track every route, expense, and memory.</p>
                </div>
                <div class="ft-footer-col">
                    <h4>Product</h4>
                    <a href="/#features">Features</a>
                    <a href="/#how-it-works">How it works</a>
                    <a href="/#trips">Explore trips</a>
                    <a href="/#download">Download</a>
                </div>
                <div class="ft-footer-col">
                    <h4>Company</h4>
                    <a href="#">About us</a>
                    <a href="#">Blog</a>
                    <a href="#">Careers</a>
                    <a href="#">Contact</a>
                </div>
                <div class="ft-footer-col">
                    <h4>Legal</h4>
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms of service</a>
                    <a href="#">Cookie policy</a>
                </div>
            </div>
            <div class="ft-footer-bottom">
                <span>&copy; {{ date('Y') }} MyTrips. All rights reserved.</span>
                <div class="ft-footer-social">
                    <a href="#" aria-label="Twitter"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    <a href="#" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg></a>
                    <a href="#" aria-label="GitHub"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

</main>

<script>
function switchTab(name) {
    document.querySelectorAll('.tp-nav-pill').forEach(t => t.classList.toggle('active', t.dataset.tab === name));
    document.querySelectorAll('.tp-panel').forEach(p => p.classList.toggle('active', p.id === 'panel-' + name));
    window.scrollTo({ top: document.querySelector('.tp-nav-wrap').offsetTop - 80, behavior: 'smooth' });
}
document.querySelectorAll('.tp-nav-pill').forEach(tab => {
    tab.addEventListener('click', () => switchTab(tab.dataset.tab));
});
</script>

<style>
/* ══════════════════════════════════════════════════════════════
   SECTION NAVIGATION (Tab Pills)
   ══════════════════════════════════════════════════════════════ */
.tp-nav-wrap {
    position: sticky;
    top: 0;
    z-index: 50;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 12px 0;
}
.tp-nav {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    scrollbar-width: none;
    justify-content: center;
    flex-wrap: wrap;
}
.tp-nav::-webkit-scrollbar { display: none; }
.tp-nav-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-muted);
    background: none;
    border: 1px solid var(--border);
    border-radius: var(--r-pill);
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.25s ease;
    font-family: var(--font-body);
}
.tp-nav-pill:hover {
    color: var(--text);
    border-color: var(--text-muted);
}
.tp-nav-pill.active {
    color: #fff;
    background: var(--brand);
    border-color: var(--brand);
    box-shadow: 0 2px 8px rgba(37,99,235,0.3);
}
.tp-nav-pill svg { flex-shrink: 0; }

/* ══════════════════════════════════════════════════════════════
   PANELS
   ══════════════════════════════════════════════════════════════ */
.tp-panel { display: none; }
.tp-panel.active { display: block; }

/* ══════════════════════════════════════════════════════════════
   MAP
   ══════════════════════════════════════════════════════════════ */
.tp-map {
    border-radius: var(--r-xl);
    overflow: hidden;
    border: 1px solid var(--border);
}
.tp-map-inner {
    position: relative;
    height: 400px;
    background: var(--surface-2);
    overflow: hidden;
}

/* ══════════════════════════════════════════════════════════════
   RESPONSIVE
   ══════════════════════════════════════════════════════════════ */
@media (max-width: 768px) {
    .tp-nav { justify-content: flex-start; flex-wrap: nowrap; }
    .tp-map-inner { height: 280px; }
}

@media (max-width: 600px) {
    .tp-nav-pill {
        padding: 8px 14px;
        font-size: 13px;
    }
    .tp-nav-pill svg { display: none; }
}
</style>

@php
    $stopsForMap = $trip->routeStops->sortBy('position')->values()->map(function ($s) {
        return [
            'lat' => (float) $s->lat,
            'lng' => (float) $s->lng,
            'label' => $s->label,
            'name' => $s->name,
            'color' => $s->color ?: '#2563EB',
        ];
    });
@endphp
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    (function () {
        const el = document.getElementById('tripLeafletMap');
        if (!el || typeof L === 'undefined') return;

        const stops = @json($stopsForMap);

        if (stops.length === 0) {
            el.innerHTML = '<div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--text-muted);font-size:14px;">No route stops yet</div>';
            return;
        }

        const map = L.map(el, { scrollWheelZoom: false });
        L.tileLayer('https://basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}@2x.png', { maxZoom: 19 }).addTo(map);

        const points = stops.map(s => [s.lat, s.lng]);
        stops.forEach(s => {
            const icon = L.divIcon({
                className: '',
                html: '<div style="width:28px;height:28px;border-radius:14px;border:2.5px solid #fff;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:11px;background:' + s.color + ';box-shadow:0 2px 4px rgba(0,0,0,0.3);">' + s.label + '</div>',
                iconSize: [28, 28],
                iconAnchor: [14, 14],
            });
            L.marker([s.lat, s.lng], { icon }).bindPopup('<strong>' + s.name + '</strong>').addTo(map);
        });

        if (points.length > 1) {
            const straightLine = L.polyline(points, { color: '#2563EB', weight: 3, opacity: 0.6, dashArray: '2,8' }).addTo(map);
            map.fitBounds(points, { padding: [30, 30] });

            const coordsStr = points.map(p => p[1] + ',' + p[0]).join(';');
            fetch('https://router.project-osrm.org/route/v1/driving/' + coordsStr + '?overview=full&geometries=geojson')
                .then(r => r.json())
                .then(data => {
                    const route = data.routes && data.routes[0];
                    if (!route) return;
                    const routeCoords = route.geometry.coordinates.map(c => [c[1], c[0]]);
                    map.removeLayer(straightLine);
                    L.polyline(routeCoords, { color: '#2563EB', weight: 4 }).addTo(map);
                    map.fitBounds(routeCoords, { padding: [30, 30] });
                })
                .catch(() => {});
        } else {
            map.setView(points[0], 13);
        }
    })();
</script>
@endpush

@endsection

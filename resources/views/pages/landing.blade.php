@extends('layouts.frontend')

@section('title', 'MyTrips — Every Trip Tells a Story')

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
                <a href="#features">Features</a>
                <a href="#how-it-works">How it works</a>
                <a href="#trips">Explore</a>
                <a href="#destinations">Destinations</a>
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
    <section class="ft-hero">
        <div class="ft-hero-bg">
            <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1600&q=85" alt="" fetchpriority="high" />
            <div class="ft-hero-overlay"></div>
        </div>
        <div class="ft-hero-content wrap">
            <div class="ft-hero-text">
                <span class="ft-hero-eyebrow reveal">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Trip-sharing for modern explorers
                </span>
                <h1 class="ft-hero-title reveal reveal-delay-1">Every trip<br>tells a story.</h1>
                <p class="ft-hero-desc reveal reveal-delay-2">Track routes, log expenses, capture moments, and write journal entries — all in one beautiful app. Share your adventures with the world or keep them private.</p>
                <div class="ft-hero-cta reveal reveal-delay-3">
                    <a href="#download" class="btn btn-primary btn-lg">
                        Start your journey
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="#trips" class="btn btn-secondary btn-lg">Explore trips</a>
                </div>
            </div>
            <div class="ft-hero-cards reveal-scale reveal-delay-2">
                <div class="ft-hero-card ft-hc-1">
                    <img src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?w=400&q=80" alt="" />
                    <div class="ft-hc-body">
                        <span class="ft-hc-status ongoing">Ongoing</span>
                        <strong>Bali Adventure</strong>
                        <span>12 stops · $1,240 spent</span>
                    </div>
                </div>
                <div class="ft-hero-card ft-hc-2">
                    <img src="https://images.unsplash.com/photo-1530789253388-582c481c54b0?w=400&q=80" alt="" />
                    <div class="ft-hc-body">
                        <span class="ft-hc-status completed">Completed</span>
                        <strong>Kathmandu Valley</strong>
                        <span>8 stops · $890 spent</span>
                    </div>
                </div>
                <div class="ft-hero-card ft-hc-3">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=400&q=80" alt="" />
                    <div class="ft-hc-body">
                        <span class="ft-hc-status upcoming">Upcoming</span>
                        <strong>Swiss Alps Trek</strong>
                        <span>Starts Aug 15</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="ft-hero-scroll reveal">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M19 12l-7 7-7-7"/></svg>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         STATS STRIP
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-stats tight">
        <div class="wrap">
            <div class="ft-stats-grid">
                <div class="ft-stat reveal">
                    <div class="ft-stat-num" data-count="{{ $totalTrips }}">{{ number_format($totalTrips) }}</div>
                    <div class="ft-stat-label">Trips logged</div>
                </div>
                <div class="ft-stat reveal reveal-delay-1">
                    <div class="ft-stat-num" data-count="{{ $totalUsers }}">{{ number_format($totalUsers) }}</div>
                    <div class="ft-stat-label">Travelers</div>
                </div>
                <div class="ft-stat reveal reveal-delay-2">
                    <div class="ft-stat-num" data-count="184">184k</div>
                    <div class="ft-stat-label">Kilometers traveled</div>
                </div>
                <div class="ft-stat reveal reveal-delay-3">
                    <div class="ft-stat-num" data-count="12400">12,400</div>
                    <div class="ft-stat-label">Photos captured</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         FEATURES
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-features tight" id="features">
        <div class="wrap">
            <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                <span class="badge">Features</span>
                <div class="sec-title" style="margin-top:12px;">Everything you need to<br>remember every journey</div>
                <div class="sec-sub" style="text-align:center;">From route mapping to expense tracking, MyTrips gives you the tools to document and share your adventures beautifully.</div>
            </div>

            <div class="ft-features-grid">
                <div class="ft-feature-card reveal">
                    <div class="ft-fc-icon" style="background:var(--brand-soft);color:var(--brand);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3>Route Mapping</h3>
                    <p>Plot every stop on your journey with interactive maps. See your path come alive with colored waypoints and distances.</p>
                </div>
                <div class="ft-feature-card reveal reveal-delay-1">
                    <div class="ft-fc-icon" style="background:var(--coral-soft);color:var(--coral);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                    </div>
                    <h3>Expense Tracking</h3>
                    <p>Log every rupee, dollar, or euro spent. Categorize expenses and watch your budget with smart AI-powered insights.</p>
                </div>
                <div class="ft-feature-card reveal reveal-delay-2">
                    <div class="ft-fc-icon" style="background:var(--teal-soft);color:var(--teal);">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                    </div>
                    <h3>Photo Journal</h3>
                    <p>Capture geotagged photos at every destination. Build a visual story of your trip that lasts forever.</p>
                </div>
                <div class="ft-feature-card reveal reveal-delay-3">
                    <div class="ft-fc-icon" style="background:rgba(124,58,237,0.08);color:#7C3AED;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    </div>
                    <h3>Trip Notes</h3>
                    <p>Write journal entries with mood tracking and color coding. Capture how you felt at every moment of your journey.</p>
                </div>
            </div>

            <div class="ft-features-showcase reveal-scale">
                <div class="ft-fs-content">
                    <span class="ft-fs-label">And there's more</span>
                    <h2>Social sharing<br>built right in.</h2>
                    <p>Publish your trips publicly and let others explore your adventures. Get likes, comments, and inspire fellow travelers from around the globe.</p>
                    <div class="ft-fs-stats">
                        <div class="ft-fs-stat">
                            <strong>Public Feed</strong>
                            <span>Discover trips from the community</span>
                        </div>
                        <div class="ft-fs-stat">
                            <strong>Privacy Controls</strong>
                            <span>Choose what to share: photos, notes, expenses</span>
                        </div>
                        <div class="ft-fs-stat">
                            <strong>Comments & Likes</strong>
                            <span>Engage with fellow travelers</span>
                        </div>
                    </div>
                </div>
                <div class="ft-fs-visual">
                    <div class="ft-phone-mockup">
                        <div class="ft-phone-notch"></div>
                        <div class="ft-phone-screen">
                            <div class="ft-phone-header">
                                <div class="ft-phone-avatar">A</div>
                                <div>
                                    <strong>Aarav Sharma</strong>
                                    <span>Kathmandu → Pokhara</span>
                                </div>
                            </div>
                            <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=400&q=80" alt="" class="ft-phone-img" />
                            <div class="ft-phone-actions">
                                <span>❤️ 124</span>
                                <span>💬 18</span>
                                <span>📤 Share</span>
                            </div>
                            <div class="ft-phone-text">The sunrise at Sarangkot was absolutely breathtaking. 5 days into our Nepal trek and every step has been worth it.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         HOW IT WORKS
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-how tight" id="how-it-works">
        <div class="wrap">
            <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                <span class="badge" style="background:var(--coral-soft);color:var(--coral);">Simple process</span>
                <div class="sec-title" style="margin-top:12px;">Three steps to your<br>first trip story</div>
            </div>

            <div class="ft-steps">
                <div class="ft-step reveal">
                    <div class="ft-step-num">01</div>
                    <div class="ft-step-visual">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3>Create your trip</h3>
                    <p>Set your destination, dates, and budget. Add route stops to map out your journey from start to finish.</p>
                </div>
                <div class="ft-step-connector reveal reveal-delay-1">
                    <svg width="40" height="2" viewBox="0 0 40 2"><line x1="0" y1="1" x2="40" y2="1" stroke="var(--border)" stroke-width="2" stroke-dasharray="4 4"/></svg>
                </div>
                <div class="ft-step reveal reveal-delay-1">
                    <div class="ft-step-num">02</div>
                    <div class="ft-step-visual">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--coral)" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                    </div>
                    <h3>Capture moments</h3>
                    <p>Log expenses, snap photos, and write journal notes as you travel. Everything stays organized by date and location.</p>
                </div>
                <div class="ft-step-connector reveal reveal-delay-2">
                    <svg width="40" height="2" viewBox="0 0 40 2"><line x1="0" y1="1" x2="40" y2="1" stroke="var(--border)" stroke-width="2" stroke-dasharray="4 4"/></svg>
                </div>
                <div class="ft-step reveal reveal-delay-2">
                    <div class="ft-step-num">03</div>
                    <div class="ft-step-visual">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="1.5"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                    </div>
                    <h3>Share your story</h3>
                    <p>Publish your trip to the public feed or keep it private. Let the world see your adventure — or just your future self.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         FEATURED TRIPS
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-trips tight" id="trips">
        <div class="wrap">
            <div class="sec-head">
                <div>
                    <div class="sec-title">Explore public trips</div>
                    <div class="sec-sub">See where fellow travelers have been. Get inspired for your next adventure.</div>
                </div>
                <a href="#" class="sec-link">View all trips
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            <div class="ft-trips-grid">
                @forelse ($publicTrips as $index => $trip)
                    <a href="{{ route('trip.show', $trip) }}" class="ft-trip-card @if($index === 0) ft-trip-featured @endif reveal @if($index > 0) reveal-delay-{{ min($index, 3) }} @endif">
                        @if ($trip->cover_photo)
                            <img src="{{ $trip->cover_photo }}" alt="{{ $trip->name }}" />
                        @else
                            <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600&q=80" alt="" />
                        @endif
                        <div class="ft-trip-overlay">
                            <span class="ft-trip-flag">{{ $trip->flag }}</span>
                            <span class="ft-trip-status {{ $trip->status }}">{{ ucfirst($trip->status) }}</span>
                        </div>
                        <div class="ft-trip-body">
                            <h3>{{ $trip->name }}</h3>
                            @if ($index === 0 && $trip->description)
                                <p>{{ Str::limit($trip->description, 80) }}</p>
                            @endif
                            <div class="ft-trip-meta">
                                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> {{ $trip->routeStops->count() }} stops</span>
                                @if ($trip->start_date && $trip->end_date)
                                    <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> {{ $trip->start_date->diffInDays($trip->end_date) }} days</span>
                                @endif
                                @if ($trip->budget > 0)
                                    <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg> {{ $trip->currency }} {{ number_format($trip->budget) }}</span>
                                @endif
                            </div>
                            <div class="ft-trip-user">
                                <div class="ft-trip-avatar">{{ strtoupper(substr($trip->user->name ?? 'U', 0, 1)) }}</div>
                                <span>{{ $trip->user->name ?? 'Anonymous' }}</span>
                                <span class="ft-trip-likes">❤️ {{ $trip->likes->count() }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-muted-foreground">No public trips yet. Be the first to share your adventure!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         DESTINATIONS
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-destinations tight" id="destinations">
        <div class="wrap">
            <div class="sec-head">
                <div>
                    <div class="sec-title">Popular destinations</div>
                    <div class="sec-sub">Where our community loves to travel most.</div>
                </div>
            </div>

            <div class="ft-dest-grid">
                <a href="#" class="ft-dest-card ft-dest-lg reveal">
                    <img src="https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇳🇵</span>
                        <h3>Nepal</h3>
                        <span>342 trips</span>
                    </div>
                </a>
                <a href="#" class="ft-dest-card reveal reveal-delay-1">
                    <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇮🇩</span>
                        <h3>Bali</h3>
                        <span>218 trips</span>
                    </div>
                </a>
                <a href="#" class="ft-dest-card reveal reveal-delay-2">
                    <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?w=600&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇯🇵</span>
                        <h3>Japan</h3>
                        <span>189 trips</span>
                    </div>
                </a>
                <a href="#" class="ft-dest-card reveal reveal-delay-1">
                    <img src="https://images.unsplash.com/photo-1518684079-3c830dcef090?w=600&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇦🇪</span>
                        <h3>Dubai</h3>
                        <span>156 trips</span>
                    </div>
                </a>
                <a href="#" class="ft-dest-card reveal reveal-delay-2">
                    <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=600&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇨🇭</span>
                        <h3>Switzerland</h3>
                        <span>134 trips</span>
                    </div>
                </a>
                <a href="#" class="ft-dest-card reveal reveal-delay-3">
                    <img src="https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=600&q=80" alt="" />
                    <div class="ft-dest-overlay"></div>
                    <div class="ft-dest-body">
                        <span class="ft-dest-flag">🇮🇹</span>
                        <h3>Italy</h3>
                        <span>128 trips</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════
         TESTIMONIALS
    ═══════════════════════════════════════════════════ --}}
    <section class="ft-testimonials tight">
        <div class="wrap">
            <div class="sec-head" style="justify-content:center;text-align:center;flex-direction:column;align-items:center;">
                <span class="badge" style="background:var(--teal-soft);color:var(--teal);">Loved by travelers</span>
                <div class="sec-title" style="margin-top:12px;">What explorers say</div>
            </div>

            <div class="ft-test-grid">
                <div class="ft-test-card reveal">
                    <div class="ft-test-stars">★★★★★</div>
                    <p>"MyTrips completely changed how I document my travels. The route mapping feature is incredible — I can see every stop I've ever made on a single map."</p>
                    <div class="ft-test-user">
                        <div class="ft-test-avatar" style="background:var(--brand-soft);color:var(--brand);">A</div>
                        <div>
                            <strong>Aarav Sharma</strong>
                            <span>Traveled to 12 countries</span>
                        </div>
                    </div>
                </div>
                <div class="ft-test-card reveal reveal-delay-1">
                    <div class="ft-test-stars">★★★★★</div>
                    <p>"The expense tracker saved me so much hassle. I used to lose receipts and forget what I spent. Now everything is categorized automatically."</p>
                    <div class="ft-test-user">
                        <div class="ft-test-avatar" style="background:var(--coral-soft);color:var(--coral);">P</div>
                        <div>
                            <strong>Priya Gurung</strong>
                            <span>Budget traveler</span>
                        </div>
                    </div>
                </div>
                <div class="ft-test-card reveal reveal-delay-2">
                    <div class="ft-test-stars">★★★★★</div>
                    <p>"I love the journal feature. Writing notes with moods and colors makes looking back at trips so much more emotional and meaningful."</p>
                    <div class="ft-test-user">
                        <div class="ft-test-avatar" style="background:var(--teal-soft);color:var(--teal);">S</div>
                        <div>
                            <strong>Sita Magar</strong>
                            <span>Digital nomad</span>
                        </div>
                    </div>
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
                    <a href="#features">Features</a>
                    <a href="#how-it-works">How it works</a>
                    <a href="#trips">Explore trips</a>
                    <a href="#download">Download</a>
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


@endsection

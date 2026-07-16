@extends('layouts.frontend')

@section('title', $profileUser->name . ' — MyTrips')

@section('content')
<main class="ft-home">

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
        </div>
    </nav>

    <section class="tight" style="padding-top:48px;">
        <div class="wrap" style="max-width:880px;">
            <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:8px;margin-bottom:32px;">
                <img src="{{ $profileUser->profile?->avatar ?? \App\Models\UserProfile::DEFAULT_AVATAR }}" alt="{{ $profileUser->name }}"
                     style="width:96px;height:96px;border-radius:9999px;object-fit:cover;border:3px solid var(--surface);box-shadow:0 2px 12px rgba(15,23,42,0.08);" />
                <h1 style="font-family:var(--font-display);font-size:24px;font-weight:700;margin-top:8px;">{{ $profileUser->name }}</h1>
                @if ($profileUser->profile?->bio)
                    <p style="color:var(--text-muted);max-width:480px;font-size:14px;">{{ $profileUser->profile->bio }}</p>
                @endif

                <div style="display:flex;gap:28px;margin-top:12px;">
                    <div style="text-align:center;">
                        <div style="font-family:var(--font-display);font-weight:700;font-size:18px;">{{ $trips->count() }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">Public Trips</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-family:var(--font-display);font-weight:700;font-size:18px;">{{ $followersCount }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">Followers</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-family:var(--font-display);font-weight:700;font-size:18px;">{{ $followingCount }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">Following</div>
                    </div>
                </div>
            </div>

            <h2 style="font-family:var(--font-display);font-size:16px;font-weight:700;margin-bottom:16px;">Public Trips</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;padding-bottom:64px;">
                @forelse ($trips as $trip)
                    <a href="{{ url('/trip/' . $trip->id) }}" style="display:block;border:1px solid var(--border);border-radius:16px;overflow:hidden;background:var(--surface);text-decoration:none;color:inherit;">
                        <img src="{{ $trip->cover_photo ?? 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=400&q=80' }}" alt="" style="width:100%;height:130px;object-fit:cover;" />
                        <div style="padding:12px;">
                            <strong style="font-size:13px;">{{ $trip->name }}</strong>
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">{{ $trip->flag }} {{ $trip->destination }}</div>
                        </div>
                    </a>
                @empty
                    <p style="color:var(--text-muted);grid-column:1/-1;text-align:center;">No public trips yet.</p>
                @endforelse
            </div>
        </div>
    </section>

</main>
@endsection

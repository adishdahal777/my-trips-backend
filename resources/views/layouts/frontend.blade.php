<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="MyTrips — Track every route, expense, and memory. The modern trip-sharing app for explorers.">

    <title>@yield('title', 'MyTrips — Every Trip Tells a Story')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('mytrips-theme') === 'dark') {
            document.documentElement.classList.add('dark');
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>

    @stack('head-css')

    <style>
        /* ── Frontend Design Tokens ── */
        :root {
            --brand: #2563EB;
            --brand-hover: #1D4ED8;
            --brand-soft: rgba(37, 99, 235, 0.08);
            --coral: #F97316;
            --coral-soft: rgba(249, 115, 22, 0.08);
            --teal: #0D9488;
            --teal-soft: rgba(13, 148, 136, 0.08);

            --bg: #F6F5F2;
            --surface: #FFFFFF;
            --surface-2: #FAFAF7;
            --surface-3: #F2F1EC;
            --text: #1A1814;
            --text-soft: #4B4944;
            --text-muted: #8A877F;
            --border: #E7E4DC;
            --border-light: #F2F1EC;

            --font-body: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Outfit', ui-sans-serif, system-ui, sans-serif;

            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --r-xl: 22px;
            --r-pill: 999px;

            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.06);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.08);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.10);
        }

        .dark {
            --brand: #60A5FA;
            --brand-hover: #93C5FD;
            --brand-soft: rgba(96, 165, 250, 0.12);
            --coral: #FB923C;
            --coral-soft: rgba(251, 146, 60, 0.12);
            --teal: #2DD4BF;
            --teal-soft: rgba(45, 212, 191, 0.12);

            --bg: #0F1115;
            --surface: #1A1D24;
            --surface-2: #1E2128;
            --surface-3: #252830;
            --text: #F0EFED;
            --text-soft: #A8A5A0;
            --text-muted: #6B6862;
            --border: #2A2D35;
            --border-light: #22252D;

            --shadow-sm: 0 1px 2px rgba(0,0,0,0.2);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.3);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.35);
            --shadow-xl: 0 20px 60px rgba(0,0,0,0.4);
        }

        /* ── Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; -webkit-font-smoothing: antialiased; }
        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }
        img { display: block; max-width: 100%; height: auto; }
        a { color: inherit; text-decoration: none; }

        /* ── Scroll Animations ── */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        .reveal-scale {
            opacity: 0;
            transform: scale(0.92);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        /* ── Layout ── */
        .wrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .tight { padding: 0; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            border-radius: var(--r-pill);
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--brand);
            color: #fff;
        }
        .btn-primary:hover { background: var(--brand-hover); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(37,99,235,0.3); }
        .btn-secondary {
            background: var(--surface);
            color: var(--text);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { background: var(--surface-2); border-color: var(--text-muted); }
        .btn-ghost {
            background: transparent;
            color: var(--text-soft);
            padding: 10px 20px;
        }
        .btn-ghost:hover { color: var(--text); background: var(--surface-3); }
        .btn-lg { padding: 16px 36px; font-size: 15px; }
        .btn-sm { padding: 8px 18px; font-size: 13px; }

        /* ── Section Headers ── */
        .sec-head { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 32px; gap: 16px; }
        .sec-title {
            font-family: var(--font-display);
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text);
        }
        .sec-sub { font-size: 15px; color: var(--text-muted); margin-top: 6px; max-width: 480px; }
        .sec-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--brand);
            white-space: nowrap;
            transition: gap 0.2s ease;
        }
        .sec-link:hover { gap: 10px; }

        /* ── Badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            border-radius: var(--r-pill);
            background: var(--brand-soft);
            color: var(--brand);
        }

        /* ══════════════════════════════════════════════════════════════
           NAVIGATION
           ══════════════════════════════════════════════════════════════ */
        .ft-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 16px 0;
            transition: all 0.3s ease;
        }
        .ft-nav.scrolled {
            background: rgba(246, 245, 242, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid var(--border-light);
            padding: 10px 0;
        }
        .dark .ft-nav.scrolled {
            background: rgba(15, 17, 21, 0.85);
        }
        .ft-nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }
        .ft-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 20px;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .ft-nav.scrolled .ft-brand { color: var(--text); }
        .ft-brand-icon { flex-shrink: 0; }
        .ft-nav-links {
            display: flex;
            gap: 28px;
        }
        .ft-nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.8);
            transition: color 0.2s;
        }
        .ft-nav.scrolled .ft-nav-links a { color: var(--text-soft); }
        .ft-nav-links a:hover { color: #fff; }
        .ft-nav.scrolled .ft-nav-links a:hover { color: var(--text); }
        .ft-nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ft-nav-actions .btn-ghost { color: rgba(255,255,255,0.8); }
        .ft-nav.scrolled .ft-nav-actions .btn-ghost { color: var(--text-soft); }
        .ft-nav-actions .btn-primary { box-shadow: 0 2px 8px rgba(37,99,235,0.3); }
        .ft-mob-menu {
            display: none;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            padding: 8px;
        }
        .ft-nav.scrolled .ft-mob-menu { color: var(--text); }

        @media (max-width: 768px) {
            .ft-nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--surface);
                border-bottom: 1px solid var(--border);
                flex-direction: column;
                padding: 16px 24px;
                gap: 12px;
            }
            .ft-nav-links.open { display: flex; }
            .ft-nav-links a { color: var(--text) !important; }
            .ft-nav-actions .btn-ghost { display: none; }
            .ft-mob-menu { display: block; }
        }

        /* ══════════════════════════════════════════════════════════════
           HERO
           ══════════════════════════════════════════════════════════════ */
        .ft-hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }
        .ft-hero-bg {
            position: absolute;
            inset: 0;
        }
        .ft-hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .ft-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0.5) 50%, rgba(15,23,42,0.3) 100%);
        }
        .ft-hero-content {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            padding: 120px 0 80px;
        }
        .ft-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            margin-bottom: 20px;
            letter-spacing: 0.02em;
        }
        .ft-hero-title {
            font-family: var(--font-display);
            font-size: clamp(40px, 5.5vw, 72px);
            font-weight: 800;
            color: #fff;
            line-height: 1.05;
            letter-spacing: -0.03em;
            margin-bottom: 20px;
        }
        .ft-hero-desc {
            font-size: 17px;
            line-height: 1.7;
            color: rgba(255,255,255,0.75);
            max-width: 520px;
            margin-bottom: 32px;
        }
        .ft-hero-cta {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .ft-hero-cta .btn-primary {
            background: #fff;
            color: var(--text);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .ft-hero-cta .btn-primary:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        }
        .ft-hero-cta .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
        }
        .ft-hero-cta .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
        }

        /* Hero Floating Cards */
        .ft-hero-cards {
            display: flex;
            flex-direction: column;
            gap: 14px;
            perspective: 800px;
        }
        .ft-hero-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: var(--r-lg);
            padding: 12px;
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
        }
        .ft-hero-card:hover { transform: translateX(8px); }
        .ft-hero-card img {
            width: 64px;
            height: 64px;
            border-radius: var(--r-md);
            object-fit: cover;
            flex-shrink: 0;
        }
        .ft-hc-body {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .ft-hc-body strong { color: #fff; font-size: 14px; }
        .ft-hc-body span { color: rgba(255,255,255,0.6); font-size: 12px; }
        .ft-hc-status {
            display: inline-flex;
            padding: 2px 8px;
            border-radius: var(--r-pill);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            width: fit-content;
            margin-bottom: 2px;
        }
        .ft-hc-status.ongoing { background: rgba(16,185,129,0.2); color: #34D399; }
        .ft-hc-status.completed { background: rgba(96,165,250,0.2); color: #93C5FD; }
        .ft-hc-status.upcoming { background: rgba(251,191,36,0.2); color: #FCD34D; }

        .ft-hc-1 { transform: translateX(20px); }
        .ft-hc-2 { transform: translateX(0px); }
        .ft-hc-3 { transform: translateX(-20px); }

        .ft-hero-scroll {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            color: rgba(255,255,255,0.5);
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(8px); }
        }

        @media (max-width: 900px) {
            .ft-hero-content { grid-template-columns: 1fr; padding: 100px 0 60px; }
            .ft-hero-cards { display: none; }
        }

        /* ══════════════════════════════════════════════════════════════
           STATS
           ══════════════════════════════════════════════════════════════ */
        .ft-stats {
            padding: 48px 0;
            border-bottom: 1px solid var(--border-light);
        }
        .ft-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            text-align: center;
        }
        .ft-stat-num {
            font-family: var(--font-display);
            font-size: clamp(28px, 3.5vw, 42px);
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .ft-stat-label {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
        }
        @media (max-width: 600px) {
            .ft-stats-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
        }

        /* ══════════════════════════════════════════════════════════════
           FEATURES
           ══════════════════════════════════════════════════════════════ */
        .ft-features { padding: 80px 0; }
        .ft-features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 60px;
        }
        .ft-feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 28px 24px;
            transition: all 0.3s ease;
        }
        .ft-feature-card:hover {
            border-color: var(--brand);
            box-shadow: var(--shadow-md);
            transform: translateY(-4px);
        }
        .ft-fc-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--r-md);
            display: grid;
            place-items: center;
            margin-bottom: 18px;
        }
        .ft-feature-card h3 {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text);
        }
        .ft-feature-card p {
            font-size: 14px;
            line-height: 1.65;
            color: var(--text-muted);
        }
        @media (max-width: 900px) {
            .ft-features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 540px) {
            .ft-features-grid { grid-template-columns: 1fr; }
        }

        /* Features Showcase */
        .ft-features-showcase {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 48px;
        }
        .ft-fs-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--brand);
        }
        .ft-fs-content h2 {
            font-family: var(--font-display);
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 12px 0 16px;
            color: var(--text);
        }
        .ft-fs-content p {
            font-size: 15px;
            line-height: 1.7;
            color: var(--text-muted);
            max-width: 440px;
        }
        .ft-fs-stats {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-top: 28px;
        }
        .ft-fs-stat strong {
            display: block;
            font-size: 14px;
            color: var(--text);
        }
        .ft-fs-stat span {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Phone Mockup */
        .ft-fs-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .ft-phone-mockup {
            width: 260px;
            background: var(--surface);
            border: 2px solid var(--border);
            border-radius: 28px;
            padding: 8px;
            box-shadow: var(--shadow-xl);
        }
        .ft-phone-notch {
            width: 100px;
            height: 24px;
            background: var(--border);
            border-radius: 0 0 14px 14px;
            margin: 0 auto 8px;
        }
        .ft-phone-screen {
            background: var(--surface-2);
            border-radius: 20px;
            overflow: hidden;
        }
        .ft-phone-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
        }
        .ft-phone-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
        }
        .ft-phone-header strong { display: block; font-size: 13px; color: var(--text); }
        .ft-phone-header span { font-size: 11px; color: var(--text-muted); }
        .ft-phone-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .ft-phone-actions {
            display: flex;
            gap: 16px;
            padding: 10px 16px;
            font-size: 13px;
            color: var(--text-soft);
        }
        .ft-phone-text {
            padding: 0 16px 16px;
            font-size: 12px;
            line-height: 1.5;
            color: var(--text-muted);
        }

        @media (max-width: 900px) {
            .ft-features-showcase { grid-template-columns: 1fr; padding: 32px; }
            .ft-fs-visual { order: -1; }
        }

        /* ══════════════════════════════════════════════════════════════
           HOW IT WORKS
           ══════════════════════════════════════════════════════════════ */
        .ft-how { padding: 80px 0; background: var(--surface-2); }
        .ft-steps {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 0;
            margin-top: 48px;
        }
        .ft-step {
            text-align: center;
            max-width: 260px;
            padding: 0 20px;
        }
        .ft-step-num {
            font-family: var(--font-display);
            font-size: 48px;
            font-weight: 800;
            color: var(--border);
            line-height: 1;
            margin-bottom: 16px;
        }
        .ft-step-visual {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--surface);
            border: 1px solid var(--border);
            display: grid;
            place-items: center;
            margin: 0 auto 20px;
        }
        .ft-step h3 {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text);
        }
        .ft-step p {
            font-size: 14px;
            line-height: 1.65;
            color: var(--text-muted);
        }
        .ft-step-connector {
            display: flex;
            align-items: center;
            padding-top: 56px;
            flex-shrink: 0;
        }
        @media (max-width: 768px) {
            .ft-steps { flex-direction: column; align-items: center; gap: 24px; }
            .ft-step-connector { padding-top: 0; transform: rotate(90deg); }
        }

        /* ══════════════════════════════════════════════════════════════
           TRIPS
           ══════════════════════════════════════════════════════════════ */
        .ft-trips { padding: 80px 0; }
        .ft-trips-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .ft-trip-card {
            position: relative;
            border-radius: var(--r-lg);
            overflow: hidden;
            background: var(--surface);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .ft-trip-card:hover {
            border-color: var(--brand);
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        .ft-trip-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .ft-trip-overlay {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .ft-trip-flag {
            font-size: 24px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        .ft-trip-status {
            display: inline-flex;
            padding: 3px 10px;
            border-radius: var(--r-pill);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            backdrop-filter: blur(10px);
        }
        .ft-trip-status.ongoing { background: rgba(16,185,129,0.85); color: #fff; }
        .ft-trip-status.completed { background: rgba(37,99,235,0.85); color: #fff; }
        .ft-trip-status.upcoming { background: rgba(251,191,36,0.85); color: #1A1814; }
        .ft-trip-body {
            padding: 18px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .ft-trip-body h3 {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }
        .ft-trip-body p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 12px;
        }
        .ft-trip-meta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .ft-trip-meta span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .ft-trip-user {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-soft);
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border-light);
        }
        .ft-trip-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--brand-soft);
            color: var(--brand);
            display: grid;
            place-items: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .ft-trip-likes {
            margin-left: auto;
            font-size: 12px;
            color: var(--text-muted);
        }
        .ft-trip-featured {
            grid-row: span 2;
        }
        .ft-trip-featured img { height: 100%; min-height: 300px; }
        @media (max-width: 900px) {
            .ft-trips-grid { grid-template-columns: repeat(2, 1fr); }
            .ft-trip-featured { grid-row: span 1; }
            .ft-trip-featured img { height: 200px; min-height: unset; }
        }
        @media (max-width: 540px) {
            .ft-trips-grid { grid-template-columns: 1fr; }
        }

        /* ══════════════════════════════════════════════════════════════
           DESTINATIONS
           ══════════════════════════════════════════════════════════════ */
        .ft-destinations { padding: 80px 0; background: var(--surface-2); }
        .ft-dest-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: auto auto;
            gap: 16px;
        }
        .ft-dest-card {
            position: relative;
            border-radius: var(--r-lg);
            overflow: hidden;
            aspect-ratio: 16/10;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .ft-dest-card:hover { transform: scale(1.02); }
        .ft-dest-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .ft-dest-card:hover img { transform: scale(1.08); }
        .ft-dest-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 60%);
        }
        .ft-dest-body {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            color: #fff;
        }
        .ft-dest-flag { font-size: 28px; margin-bottom: 6px; display: block; }
        .ft-dest-body h3 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
        }
        .ft-dest-body span { font-size: 13px; opacity: 0.8; }
        .ft-dest-lg {
            grid-column: span 2;
            grid-row: span 2;
            aspect-ratio: auto;
        }
        .ft-dest-lg .ft-dest-body h3 { font-size: 28px; }
        @media (max-width: 768px) {
            .ft-dest-grid { grid-template-columns: repeat(2, 1fr); }
            .ft-dest-lg { grid-column: span 2; grid-row: span 1; aspect-ratio: 16/8; }
        }
        @media (max-width: 540px) {
            .ft-dest-grid { grid-template-columns: 1fr; }
            .ft-dest-lg { grid-column: span 1; }
        }

        /* ══════════════════════════════════════════════════════════════
           TESTIMONIALS
           ══════════════════════════════════════════════════════════════ */
        .ft-testimonials { padding: 80px 0; }
        .ft-test-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 12px;
        }
        .ft-test-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 28px 24px;
        }
        .ft-test-stars {
            color: #F59E0B;
            font-size: 16px;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }
        .ft-test-card p {
            font-size: 14px;
            line-height: 1.7;
            color: var(--text-soft);
            margin-bottom: 20px;
        }
        .ft-test-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ft-test-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }
        .ft-test-user strong { display: block; font-size: 14px; color: var(--text); }
        .ft-test-user span { font-size: 12px; color: var(--text-muted); }
        @media (max-width: 768px) {
            .ft-test-grid { grid-template-columns: 1fr; }
        }

        /* ══════════════════════════════════════════════════════════════
           CTA
           ══════════════════════════════════════════════════════════════ */
        .ft-cta { padding: 80px 0; }
        .ft-cta-card {
            position: relative;
            border-radius: var(--r-xl);
            overflow: hidden;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .ft-cta-bg {
            position: absolute;
            inset: 0;
        }
        .ft-cta-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .ft-cta-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15,23,42,0.9) 0%, rgba(15,23,42,0.7) 100%);
        }
        .ft-cta-content {
            position: relative;
            z-index: 2;
            padding: 60px 40px;
            max-width: 600px;
        }
        .ft-cta-content h2 {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }
        .ft-cta-content p {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255,255,255,0.75);
            margin-bottom: 32px;
        }
        .ft-cta-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .ft-cta-platforms {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
        }

        /* ══════════════════════════════════════════════════════════════
           FOOTER
           ══════════════════════════════════════════════════════════════ */
        .ft-footer {
            padding: 60px 0 32px;
            border-top: 1px solid var(--border-light);
        }
        .ft-footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .ft-footer-brand .ft-brand { color: var(--text); margin-bottom: 12px; }
        .ft-footer-brand p {
            font-size: 14px;
            line-height: 1.65;
            color: var(--text-muted);
            max-width: 280px;
        }
        .ft-footer-col h4 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text);
            margin-bottom: 16px;
        }
        .ft-footer-col a {
            display: block;
            font-size: 14px;
            color: var(--text-muted);
            padding: 4px 0;
            transition: color 0.2s;
        }
        .ft-footer-col a:hover { color: var(--text); }
        .ft-footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 24px;
            border-top: 1px solid var(--border-light);
            font-size: 13px;
            color: var(--text-muted);
        }
        .ft-footer-social {
            display: flex;
            gap: 16px;
        }
        .ft-footer-social a {
            color: var(--text-muted);
            transition: color 0.2s;
        }
        .ft-footer-social a:hover { color: var(--text); }
        @media (max-width: 768px) {
            .ft-footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
            .ft-footer-brand { grid-column: span 2; }
            .ft-footer-bottom { flex-direction: column; gap: 16px; text-align: center; }
        }
        @media (max-width: 540px) {
            .ft-footer-grid { grid-template-columns: 1fr; }
            .ft-footer-brand { grid-column: span 1; }
        }
    </style>
</head>

<body>
    @yield('content')

    <script>
        /* ── Theme Toggle ── */
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            html.classList.toggle('dark', !isDark);
            html.setAttribute('data-theme', isDark ? 'light' : 'dark');
            localStorage.setItem('mytrips-theme', isDark ? 'light' : 'dark');
            updateThemeIcons();
        }
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-dark').forEach(el => el.style.display = isDark ? 'inline' : 'none');
            document.querySelectorAll('.theme-light').forEach(el => el.style.display = isDark ? 'none' : 'inline');
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcons);

        /* ── Scroll Reveal ── */
        function initReveal() {
            const els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
            if (!els.length) return;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
            els.forEach(el => observer.observe(el));
        }
        document.addEventListener('DOMContentLoaded', initReveal);

        /* ── Nav Scroll ── */
        function initNavScroll() {
            const nav = document.querySelector('.ft-nav');
            if (!nav) return;
            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        nav.classList.toggle('scrolled', window.scrollY > 40);
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
        document.addEventListener('DOMContentLoaded', initNavScroll);
    </script>

    @stack('scripts')
</body>

</html>

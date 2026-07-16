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

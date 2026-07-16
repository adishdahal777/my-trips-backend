<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - MyTrips Admin</title>

    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <style>
        .custom-scrollbar { scrollbar-width: thin; scrollbar-color: #d4d4d4 transparent; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d4d4d4; border-radius: 4px; }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background text-foreground antialiased min-h-screen">

    <div id="mobileOverlay" onclick="closeMobileSidebar()"
         class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden backdrop-blur-sm"></div>

    @include('layouts.include.sidebar')

    <div id="mainWrapper" class="flex flex-col min-h-screen lg:ml-[260px]">
        @include('layouts.include.navbar')

        <main role="main" class="flex-1 p-5 lg:p-6">
            @yield('content')
        </main>
    </div>

    <script>
        function openMobileSidebar() {
            document.getElementById('appSidebar').classList.remove('-translate-x-full');
            document.getElementById('mobileOverlay').classList.remove('hidden');
        }
        function closeMobileSidebar() {
            document.getElementById('appSidebar').classList.add('-translate-x-full');
            document.getElementById('mobileOverlay').classList.add('hidden');
        }
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            html.classList.toggle('dark', !isDark);
            localStorage.setItem('theme', isDark ? 'light' : 'dark');
            updateThemeIcons();
        }
        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-dark-icon').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-light-icon').forEach(el => el.classList.toggle('hidden', isDark));
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>

    @stack('scripts')
</body>

</html>

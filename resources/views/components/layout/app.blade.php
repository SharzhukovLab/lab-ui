@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
        {{-- Favicon --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/branding/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/branding/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/branding/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#ff5c1f">
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            var dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (t === 'dark' || (!t && dark)) document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
<div class="lab-shell">
    <nav class="lab-nav">
        <div class="lab-nav-inner">
            <a href="{{ url('/dashboard') }}" class="lab-nav-brand">
                <span class="lab-nav-brand-title">{{ config('lab-ui.brand', "Sharzhukov's Laboratory") }}</span>
                <span class="lab-nav-brand-sub">{{ config('lab-ui.context', 'Account') }}</span>
            </a>
            <ul class="lab-nav-links">
                <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Overview</a></li>
                <li><a href="{{ url('/security') }}"  class="{{ request()->is('security')  ? 'active' : '' }}">Security</a></li>
                <li><a href="{{ url('/sessions') }}"  class="{{ request()->is('sessions')  ? 'active' : '' }}">Sessions</a></li>
            </ul>
            <div style="display:flex;align-items:center;gap:8px">
                <button type="button" class="lab-theme-toggle" onclick="toggleLabTheme()" aria-label="Toggle theme">
                    <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                    <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                </button>
                {{ $navActions ?? '' }}
            </div>
        </div>
    </nav>
    <main class="lab-main">
        {{ $slot }}
    </main>
</div>
<script>
    function toggleLabTheme() {
        var d = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', d ? 'dark' : 'light');
    }
</script>
@stack('scripts')
</body>
</html>
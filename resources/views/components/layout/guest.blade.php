@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="theme-color" content="#2563eb">
    <script>
        (function () {
            var t = localStorage.getItem('theme');
            var dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (t === 'dark' || (!t && dark)) document.documentElement.classList.add('dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;background:var(--lab-bg-sunken);">
    <div style="width:100%;max-width:400px;">
        <div style="text-align:center;margin-bottom:24px;">
            <a href="https://sharzhukov.com" class="lab-eyebrow">Back to site</a>
        </div>
        <div class="lab-card" style="padding:28px;">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
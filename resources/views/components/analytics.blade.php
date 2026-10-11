@props(['gaId' => null])

@php
    // Если не передан — берём из Setting (если модель существует)
    if ($gaId === null && class_exists(\App\Models\Setting::class)) {
        try { $gaId = \App\Models\Setting::get('analytics.ga_id'); } catch (\Throwable $e) { $gaId = null; }
    }
@endphp

@if($gaId)
<script>
(function() {
    var GA_ID = @json($gaId);
    var COOKIE_NAME = 'sharzhukov_cookie_consent';
    var loaded = false;

    function hasAnalyticsConsent() {
        var parts = document.cookie.split('; ');
        for (var i = 0; i < parts.length; i++) {
            var kv = parts[i].split('=');
            if (kv[0] === COOKIE_NAME) {
                try {
                    var parsed = JSON.parse(decodeURIComponent(kv.slice(1).join('=')));
                    return !!(parsed && parsed.analytics);
                } catch (e) { return false; }
            }
        }
        return false;
    }

    function loadGA() {
        if (loaded) return;
        loaded = true;

        var s = document.createElement('script');
        s.async = true;
        s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA_ID);
        document.head.appendChild(s);

        window.dataLayer = window.dataLayer || [];
        function gtag(){ dataLayer.push(arguments); }
        window.gtag = gtag;
        gtag('js', new Date());
        gtag('config', GA_ID, {
            anonymize_ip: true,
            cookie_flags: 'SameSite=Lax;Secure',
        });
    }

    // Публичный hook для cookie-consent
    window.labAnalyticsLoad = loadGA;

    // Если согласие уже дано — грузим сразу
    if (hasAnalyticsConsent()) loadGA();
})();
</script>
@endif
@props([
    'code'    => 404,
    'title'   => null,
    'message' => null,
    'marker'  => null,
    'hint'    => null,
    'actions' => null,
])

@php
    $code = (int) $code;

    $defaults = [
        404 => [
            'title'   => 'Lost in space',
            'message' => "This page doesn't exist or has been moved. Check the URL, or head back to familiar territory.",
            'hint'    => 'git checkout main',
            'marker'  => '// 404 · NOT FOUND',
            'actions' => [
                ['label' => '← Back to home',   'url' => '/',          'variant' => 'primary'],
                ['label' => 'Browse projects →', 'url' => '/projects', 'variant' => 'secondary'],
            ],
        ],
        500 => [
            'title'   => 'Something broke',
            'message' => "Our server tripped over its own feet. We've been notified — try again in a moment.",
            'hint'    => 'tail -f storage/logs/laravel.log',
            'marker'  => '// 500 · SERVER ERROR',
            'actions' => [
                ['label' => '← Back to home', 'url' => '/', 'variant' => 'primary'],
                ['label' => 'Report issue ↗', 'url' => 'https://github.com/SharzhukovLab/sharzhukov-main/issues/new', 'variant' => 'secondary', 'external' => true],
            ],
        ],
        403 => [
            'title'   => 'Access denied',
            'message' => "You don't have permission to be here. If that seems wrong, sign in or contact us.",
            'hint'    => 'sudo make me a sandwich',
            'marker'  => '// 403 · FORBIDDEN',
            'actions' => [
                ['label' => '← Back to home',  'url' => '/', 'variant' => 'primary'],
                ['label' => 'Sign in →',       'url' => 'https://account.sharzhukov.com/login', 'variant' => 'secondary'],
            ],
        ],
        503 => [
            'title'   => 'Down for maintenance',
            'message' => "We're doing some quick surgery. Back online shortly.",
            'hint'    => 'composer update && php artisan optimize:clear',
            'marker'  => '// 503 · MAINTENANCE',
            'actions' => [
                ['label' => '← Back to home', 'url' => '/', 'variant' => 'primary'],
            ],
        ],
    ];

    $d = $defaults[$code] ?? $defaults[404];
    $marker  = $marker  ?? $d['marker'];
    $title   = $title   ?? $d['title'];
    $message = $message ?? $d['message'];
    $hint    = $hint    ?? $d['hint'];
    $actions = $actions ?: $d['actions'];

    // request id для 500
    $requestId = null;
    if ($code >= 500) {
        $requestId = request()->header('X-Request-Id') ?: substr(md5(request()->fullUrl() . microtime()), 0, 12);
    }
@endphp

<section class="lab-error">
    <div class="lab-error-inner">
        <span class="brutal-marker">{{ $marker }}</span>

        <div class="lab-error-code-wrap" aria-hidden="true">
            <span class="lab-error-code">{{ str_pad((string) $code, 3, '0', STR_PAD_LEFT) }}</span>
            <span class="lab-error-code-shadow">{{ str_pad((string) $code, 3, '0', STR_PAD_LEFT) }}</span>
        </div>

        <h1 class="lab-error-title">{{ $title }}</h1>

        @if($message)
            <p class="lab-error-message">{{ $message }}</p>
        @endif

        @if($hint)
            <pre class="lab-error-hint"><span class="lab-error-hint-prompt">$</span> {{ $hint }}<span class="lab-error-cursor">_</span></pre>
        @endif

        <div class="lab-error-actions">
            @foreach($actions as $a)
                <a href="{{ $a['url'] }}"
                   class="lab-btn lab-btn--{{ $a['variant'] ?? 'primary' }}"
                   @if(!empty($a['external'])) target="_blank" rel="noopener" @endif>
                    {{ $a['label'] }}
                </a>
            @endforeach
        </div>

        @if($requestId)
            <p class="lab-error-request-id">
                <span class="lab-error-request-label">// REQUEST ID</span>
                <code>{{ $requestId }}</code>
            </p>
        @endif
    </div>
</section>

{{-- Halloween 404 Overlay --}}
@if(isset($code) && $code == 404)
<div class="hw-404-overlay">
    <div style="text-align: center;">
        <div style="font-size: 100px; line-height: 1; margin-bottom: 20px; animation: hw-ghost-float 3s infinite;">👻</div>
        <h1 style="font-size: 5rem; font-family: var(--font-mono); font-weight: 900; color: #ea580c; text-shadow: 4px 4px 0 #7c3aed; margin: 0;">404</h1>
        <h2 style="font-size: 1.5rem; text-transform: uppercase; margin-top: 10px; color: #f5f5f4; letter-spacing: 2px;">Vanished into the void</h2>
        <p style="color: #a8a29e; margin: 20px auto 30px; max-width: 400px;">The page you are looking for has been spirited away.</p>
        <a href="/" class="btn btn--primary" style="display: inline-block; padding: 14px 28px; background: #ea580c; color: white; font-weight: bold; text-decoration: none; border: 2px solid #ea580c; box-shadow: 4px 4px 0 #7c3aed; text-transform: uppercase; font-family: var(--font-mono);">Return to the living →</a>
    </div>
</div>
<style>
.hw-404-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: #0c0a09;
    z-index: 99999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
[data-halloween="on"] .hw-404-overlay {
    display: flex !important;
}
</style>
@endif
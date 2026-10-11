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
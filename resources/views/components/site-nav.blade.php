@props([
    'brandTitle'   => "SHARZHUKOV'S LAB",
    'brandSub'     => '// OPEN SOURCE',
    'brandUrl'     => '/',
    'items'        => [],
    'showAuth'     => true,
    'dashboardUrl' => 'https://account.sharzhukov.com/dashboard',
])

@php
    $brandHref    = \Illuminate\Support\Str::startsWith($brandUrl, ['http://','https://']) ? $brandUrl : url($brandUrl);
    $loginUrl     = 'https://account.sharzhukov.com/login?return=' . urlencode(url()->current());
    $me           = auth()->user();

    $accountBase  = 'https://account.sharzhukov.com';
    $mainBase     = 'https://sharzhukov.com';

    $normalize = function ($item) {
        $url        = $item['url']   ?? '#';
        $label      = $item['label'] ?? '';
        $isExternal = !empty($item['external']);
        $absUrl     = \Illuminate\Support\Str::startsWith($url, ['http://','https://']) ? $url : url($url);
        $pathOnly   = ltrim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        $isActive   = $item['active'] ?? ($pathOnly && $pathOnly !== '/' && request()->is($pathOnly . '*'));
        return compact('url','label','isExternal','absUrl','isActive');
    };
@endphp

<nav class="brutal-nav">
    <div class="brutal-nav-inner">
        <a href="{{ $brandHref }}" class="brutal-nav-brand">
            <img src="{{ asset('img/branding/core-white.png') }}" alt="Core" class="brutal-nav-logo">
            <div class="brutal-nav-brand-text">
                <span class="brutal-nav-brand-title">{{ $brandTitle }}</span>
                <span class="brutal-nav-brand-sub">{{ $brandSub }}</span>
            </div>
        </a>

        <ul class="brutal-nav-links">
            @foreach($items as $item)
                @php $n = $normalize($item); @endphp
                <li>
                    <a href="{{ $n['absUrl'] }}"
                       class="brutal-nav-link {{ $n['isActive'] ? 'active' : '' }}"
                       @if($n['isExternal']) target="_blank" rel="noopener" @endif>
                        {{ $n['label'] }}@if($n['isExternal']) ↗@endif
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="brutal-nav-actions">
            {{-- Extra (напр. поиск в wiki) --}}
            {{ $slot }}

            {{-- Notifications bell --}}
            <x-lab::navbell />

            {{-- Theme toggle --}}
            <button type="button" class="lab-theme-toggle" onclick="toggleLabTheme()" aria-label="Toggle theme">
                <svg class="icon-sun" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
                <svg class="icon-moon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>

            {{-- Auth: avatar + dropdown или SIGN IN --}}
            @if($showAuth)
                @if($me)
                    <div class="brutal-nav-user">
                        <a href="{{ $dashboardUrl }}" class="brutal-nav-avatar" title="My account" aria-haspopup="true">
                            @if($me->avatar_path)
                                <img src="{{ $me->avatar_url }}" alt="{{ $me->name }}">
                            @else
                                <span class="brutal-nav-avatar-fallback">{{ strtoupper(mb_substr($me->name ?? 'U', 0, 1)) }}</span>
                            @endif
                        </a>

                        {{-- User dropdown (desktop) --}}
                        <div class="brutal-nav-dropdown" role="menu">
                            <div class="brutal-nav-dropdown-header">
                                @if($me->avatar_path)
                                    <img src="{{ $me->avatar_url }}" alt="{{ $me->name }}">
                                @else
                                    <span class="brutal-nav-avatar-fallback">{{ strtoupper(mb_substr($me->name ?? 'U', 0, 1)) }}</span>
                                @endif
                                <div class="brutal-nav-dropdown-header-info">
                                    <div class="brutal-nav-dropdown-header-name">{{ $me->name }}</div>
                                    <div class="brutal-nav-dropdown-header-username">{{ $me->username }}</div>
                                </div>
                            </div>

                            <a class="brutal-nav-dropdown-item" href="{{ $accountBase }}/dashboard">Dashboard →</a>
                            <a class="brutal-nav-dropdown-item" href="{{ $accountBase }}/conversations">Messages →</a>
                            <a class="brutal-nav-dropdown-item" href="{{ $accountBase }}/notifications">Notifications →</a>

                            <div class="brutal-nav-dropdown-divider"></div>

                            @if($me->username)
                                <a class="brutal-nav-dropdown-item" href="{{ $mainBase }}/u/{{ $me->username }}">Public profile →</a>
                                <a class="brutal-nav-dropdown-item" href="{{ $mainBase }}/feed">Feed →</a>
                            @endif
                            <a class="brutal-nav-dropdown-item" href="{{ $accountBase }}/profile">Profile →</a>

                            <div class="brutal-nav-dropdown-divider"></div>

                            <form method="POST" action="{{ $accountBase }}/logout" class="brutal-nav-dropdown-item danger">
                                @csrf
                                <button type="submit">Sign out →</button>
                            </form>
                        </div>
                    </div>
                @else
                    <x-lab::button variant="primary" size="sm" href="{{ $loginUrl }}">SIGN IN →</x-lab::button>
                @endif
            @endif

            {{-- Burger --}}
            <button type="button" class="brutal-nav-burger" data-nav-toggle aria-label="Open menu" aria-expanded="false" aria-controls="brutal-nav-drawer">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
        </div>
    </div>

    <div class="brutal-nav-drawer" id="brutal-nav-drawer" data-nav-drawer data-open="false" aria-hidden="true">
        <div class="brutal-nav-drawer-backdrop" data-nav-close></div>
        <aside class="brutal-nav-drawer-panel" role="dialog" aria-modal="true" aria-label="Navigation">
            <button type="button" class="brutal-nav-drawer-close" data-nav-close aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            <div class="brutal-nav-drawer-brand">
                <img src="{{ asset('img/branding/core-white.png') }}" alt="Core">
                <div>
                    <span class="brutal-nav-brand-title">{{ $brandTitle }}</span>
                    <span class="brutal-nav-brand-sub">{{ $brandSub }}</span>
                </div>
            </div>

            {{-- User block in drawer (mobile) — collapsible --}}
            @if($me)
                <details class="brutal-nav-drawer-acc">
                    <summary class="brutal-nav-drawer-user">
                        @if($me->avatar_path)
                            <img src="{{ $me->avatar_url }}" alt="{{ $me->name }}">
                        @else
                            <span class="brutal-nav-avatar-fallback">{{ strtoupper(mb_substr($me->name ?? 'U', 0, 1)) }}</span>
                        @endif
                        <div class="brutal-nav-drawer-user-info">
                            <div class="brutal-nav-drawer-user-name">{{ $me->name }}</div>
                            <div class="brutal-nav-drawer-user-username">{{ $me->username }}</div>
                        </div>
                        <svg class="brutal-nav-drawer-acc-chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                    </summary>

                    <div class="brutal-nav-drawer-acc-body">
                        <a href="{{ $accountBase }}/dashboard"     class="brutal-nav-drawer-link">Dashboard →</a>
                        <a href="{{ $accountBase }}/conversations" class="brutal-nav-drawer-link">Messages →</a>
                        <a href="{{ $accountBase }}/notifications" class="brutal-nav-drawer-link">Notifications →</a>
                        @if($me->username)
                            <a href="{{ $mainBase }}/u/{{ $me->username }}" class="brutal-nav-drawer-link">Public profile →</a>
                            <a href="{{ $mainBase }}/feed" class="brutal-nav-drawer-link">Feed →</a>
                        @endif
                        <a href="{{ $accountBase }}/profile" class="brutal-nav-drawer-link">Profile →</a>

                        <form method="POST" action="{{ $accountBase }}/logout" class="brutal-nav-drawer-signout">
                            @csrf
                            <button type="submit">Sign out →</button>
                        </form>
                    </div>
                </details>
            @endif

            <div class="brutal-nav-drawer-divider"></div>

            @foreach($items as $item)
                @php $n = $normalize($item); @endphp
                <a href="{{ $n['absUrl'] }}"
                   class="brutal-nav-drawer-link {{ $n['isActive'] ? 'active' : '' }}"
                   @if($n['isExternal']) target="_blank" rel="noopener" @endif>
                    {{ $n['label'] }}@if($n['isExternal']) ↗@endif
                </a>
            @endforeach

            @isset($drawer)
                <div class="brutal-nav-drawer-extra">{{ $drawer }}</div>
            @endisset
        </aside>
    </div>
</nav>

@once
<script>
(function () {
    function closeDrawer() {
        var drawer = document.querySelector('.brutal-nav-drawer[data-open="true"]');
        if (!drawer) return;
        drawer.setAttribute('data-open', 'false');
        drawer.setAttribute('aria-hidden', 'true');
        var t = document.querySelector('[data-nav-toggle]');
        if (t) t.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }
    document.addEventListener('click', function (e) {
        var toggle = e.target.closest('[data-nav-toggle]');
        if (toggle) {
            e.preventDefault();
            var nav = toggle.closest('.brutal-nav');
            var drawer = nav.querySelector('[data-nav-drawer]');
            var open = drawer.getAttribute('data-open') === 'true';
            drawer.setAttribute('data-open', open ? 'false' : 'true');
            drawer.setAttribute('aria-hidden', open ? 'true' : 'false');
            toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
            document.body.style.overflow = open ? '' : 'hidden';
            return;
        }
        if (e.target.closest('[data-nav-close]')) { closeDrawer(); return; }
        var link = e.target.closest('.brutal-nav-drawer-link');
        if (link && !link.target) closeDrawer();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDrawer();
    });
})();
</script>
@endonce

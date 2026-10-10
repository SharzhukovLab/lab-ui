@props(['context' => 'main'])

@php
    use App\Models\EcosystemLink;
    use App\Models\Setting;

    // ── Ecosystem cards (4 сайта) ──
    $sites = [
        'main'    => ['label' => 'Main site',   'url' => 'https://main.sharzhukov.com',         'icon' => 'home',      'host' => 'main.sharzhukov.com'],
        'account' => ['label' => 'Account',     'url' => 'https://account-main.sharzhukov.com', 'icon' => 'user',      'host' => 'account-main.sharzhukov.com'],
        'wiki'    => ['label' => 'Wiki & Docs', 'url' => 'https://wiki-main.sharzhukov.com',    'icon' => 'book-open', 'host' => 'wiki-main.sharzhukov.com'],
        'go'      => ['label' => 'Short Links', 'url' => 'https://go-main.sharzhukov.com',      'icon' => 'link',      'host' => 'go-main.sharzhukov.com'],
    ];

    // ── Колонки ссылок из БД ──
    $cols = [
        'explore'   => 'Explore',
        'community' => 'Community',
        'account'   => 'Account',
        'legal'     => 'Legal',
    ];

    $links = [];
    foreach (array_keys($cols) as $group) {
        $links[$group] = EcosystemLink::query()
            ->where('group', $group)
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();
    }

    // ── Настройки из БД (с фоллбеком) ──
    $footerIntro = Setting::get('footer.intro')
        ?? "Sharzhukov's Laboratory is an open-source collective building tools for developers. All trademarks and product names are the property of their respective owners. Made in EU.";
    $footerCopy = Setting::get('footer.copyright')
        ?? "© " . date('Y') . " SHARZHUKOV'S LAB";
    $footerTagline = Setting::get('footer.tagline')
        ?? 'MADE IN EU · EST. 2024';
@endphp

<footer class="brutal-footer-v2">
    <div class="brutal-footer-inner">

        <p class="brutal-footer-intro">{{ $footerIntro }}</p>

        <hr class="brutal-footer-divider">

        <span class="brutal-marker" style="margin-bottom:8px;">// ECOSYSTEM</span>
        <div class="brutal-eco-grid">
            @foreach($sites as $key => $site)
                <a href="{{ $site['url'] }}" target="_blank" rel="noopener" class="brutal-eco-card">
                    <div class="brutal-eco-card-icon">
                        @switch($site['icon'])
                            @case('home')      <x-lucide-home />          @break
                            @case('user')      <x-lucide-user-circle />   @break
                            @case('book-open') <x-lucide-book-open />     @break
                            @case('link')      <x-lucide-link />          @break
                        @endswitch
                    </div>
                    <div class="brutal-eco-card-body">
                        <p class="brutal-eco-card-title">{{ $site['label'] }}</p>
                        <span class="brutal-eco-card-host">{{ $site['host'] }}</span>
                    </div>
                    <span class="brutal-eco-card-arrow">↗</span>
                </a>
            @endforeach
        </div>

        <hr class="brutal-footer-divider">

        <div class="brutal-footer-cols">
            @foreach($cols as $group => $title)
                <div class="brutal-footer-col">
                    <div class="brutal-footer-col-title">{{ $title }}</div>
                    <ul>
                        @foreach($links[$group] as $link)
                            <li>
                                <a href="{{ $link->url }}"
                                   @if($link->is_external) target="_blank" rel="noopener" @endif>
                                    {{ $link->label }}
                                </a>
                            </li>
                        @endforeach

                        {{-- Cookie settings — только в Legal (JS-действие, не URL) --}}
                        @if($group === 'legal')
                            <li>
                                <a href="#" onclick="event.preventDefault(); labCookieOpen && labCookieOpen(); return false;">
                                    Cookie settings
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endforeach
        </div>

        <hr class="brutal-footer-divider">

        <x-lab::newsletter-signup />

        <x-lab::contact-cta />

        <div class="brutal-footer-bottom">
            <span>{{ $footerCopy }}</span>
            <span>{{ $footerTagline }}</span>
        </div>
    </div>
</footer>

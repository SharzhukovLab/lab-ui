@props(['context' => 'main'])

@php
    $sites = [
        'main'    => ['label' => 'Main site',   'url' => 'https://main.sharzhukov.com',         'icon' => 'home',      'host' => 'main.sharzhukov.com'],
        'account' => ['label' => 'Account',     'url' => 'https://account-main.sharzhukov.com', 'icon' => 'user',      'host' => 'account-main.sharzhukov.com'],
        'wiki'    => ['label' => 'Wiki & Docs', 'url' => 'https://wiki-main.sharzhukov.com',    'icon' => 'book-open', 'host' => 'wiki-main.sharzhukov.com'],
        'go'      => ['label' => 'Short Links', 'url' => 'https://go-main.sharzhukov.com',      'icon' => 'link',      'host' => 'go-main.sharzhukov.com'],
    ];
@endphp

<footer class="brutal-footer-v2">
    <div class="brutal-footer-inner">

        <p class="brutal-footer-intro">
            Sharzhukov's Laboratory is an open-source collective building tools for developers. All trademarks and product names are the property of their respective owners. Made in EU.
        </p>

        <hr class="brutal-footer-divider">

        <span class="brutal-marker" style="margin-bottom:8px;">// ECOSYSTEM</span>
        <div class="brutal-eco-grid">
            @foreach($sites as $key => $site)
                <a href="{{ $site['url'] }}" target="_blank" rel="noopener" class="brutal-eco-card">
                    <div class="brutal-eco-card-icon">
                        @switch($site['icon'])
                            @case('home')
                                <x-lucide-home />
                                @break
                            @case('user')
                                <x-lucide-user-circle />
                                @break
                            @case('book-open')
                                <x-lucide-book-open />
                                @break
                            @case('link')
                                <x-lucide-link />
                                @break
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
            <div class="brutal-footer-col">
                <div class="brutal-footer-col-title">Products</div>
                <ul>
                    <li><a href="https://main.sharzhukov.com/projects">All projects</a></li>
                    <li><a href="https://main.sharzhukov.com/news">News</a></li>
                    <li><a href="https://wiki-main.sharzhukov.com">Wiki</a></li>
                    <li><a href="https://go-main.sharzhukov.com">Short links</a></li>
                    <li><a href="#" onclick="event.preventDefault(); labCookieOpen();">Cookie settings</a></li>
                </ul>
            </div>
            <div class="brutal-footer-col">
                <div class="brutal-footer-col-title">Community</div>
                <ul>
                    <li><a href="https://discord.gg/sharzhukov" target="_blank" rel="noopener">Discord</a></li>
                    <li><a href="https://t.me/sharzhukov" target="_blank" rel="noopener">Telegram</a></li>
                    <li><a href="https://github.com/SharzhukovLab" target="_blank" rel="noopener">GitHub</a></li>
                </ul>
            </div>
            <div class="brutal-footer-col">
                <div class="brutal-footer-col-title">Resources</div>
                <ul>
                    <li><a href="https://wiki-main.sharzhukov.com">Documentation</a></li>
                    <li><a href="https://main.sharzhukov.com/news">Blog</a></li>
                    <li><a href="https://account-main.sharzhukov.com/register">Sign up</a></li>
                    <li><a href="https://account-main.sharzhukov.com/login">Sign in</a></li>
                </ul>
            </div>
            <div class="brutal-footer-col">
                <div class="brutal-footer-col-title">Legal</div>
                <ul>
                    <li><a href="https://main.sharzhukov.com/privacy">Privacy</a></li>
                    <li><a href="https://main.sharzhukov.com/cookies">Cookies</a></li>
                    <li><a href="https://main.sharzhukov.com/terms">Terms</a></li>
                </ul>
            </div>
        </div>

        
        <hr class="brutal-footer-divider">

        <x-lab::newsletter-signup />
        <div class="brutal-footer-bottom">
            <span>© {{ date('Y') }} SHARZHUKOV'S LAB</span>
            <span>MADE IN EU · EST. 2026</span>
        </div>
    </div>
</footer>
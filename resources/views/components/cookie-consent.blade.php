<div id="cookie-consent" class="brutal-cookie" style="display:none;">
    <div class="brutal-cookie-inner">
        <div class="brutal-cookie-body">
            <span class="brutal-marker" style="margin-bottom:12px;">// COOKIES</span>
            <p class="brutal-cookie-text">
                We use cookies to improve your experience. Necessary cookies are always on. You can accept all, reject optional, or choose preferences.
            </p>
            <a href="https://main.sharzhukov.com/cookies" class="brutal-link-arrow" target="_blank">Cookie policy <span>→</span></a>
        </div>
        <div class="brutal-cookie-actions">
            <button type="button" class="lab-btn lab-btn--secondary" onclick="labCookiePreferences()">PREFERENCES</button>
            <button type="button" class="lab-btn lab-btn--secondary" onclick="labCookieAction('reject_all')">REJECT ALL</button>
            <button type="button" class="lab-btn lab-btn--primary" onclick="labCookieAction('accept_all')">ACCEPT ALL →</button>
        </div>
    </div>

    {{-- Preferences modal --}}
    <div id="cookie-prefs" class="brutal-cookie-prefs" style="display:none;">
        <div class="brutal-cookie-prefs-inner">
            <h3 style="margin:0 0 20px;font-family:var(--font-sans);font-weight:900;font-size:22px;letter-spacing:-0.02em;">Cookie preferences</h3>

            <div class="brutal-cookie-pref">
                <div>
                    <div class="brutal-cookie-pref-title">Necessary</div>
                    <div class="brutal-cookie-pref-desc">Required for site functionality. Cannot be disabled.</div>
                </div>
                <span class="brutal-badge brutal-badge--dark">ALWAYS ON</span>
            </div>

            <div class="brutal-cookie-pref">
                <div>
                    <div class="brutal-cookie-pref-title">Analytics</div>
                    <div class="brutal-cookie-pref-desc">Helps us understand how you use the site.</div>
                </div>
                <label class="brutal-toggle"><input type="checkbox" id="cookie-analytics"><span></span></label>
            </div>

            <div class="brutal-cookie-pref">
                <div>
                    <div class="brutal-cookie-pref-title">Marketing</div>
                    <div class="brutal-cookie-pref-desc">Used to show you relevant content.</div>
                </div>
                <label class="brutal-toggle"><input type="checkbox" id="cookie-marketing"><span></span></label>
            </div>

            <div style="display:flex;gap:12px;margin-top:24px;justify-content:flex-end;">
                <button type="button" class="lab-btn lab-btn--secondary" onclick="labCookieClosePrefs()">CANCEL</button>
                <button type="button" class="lab-btn lab-btn--primary" onclick="labCookieSavePrefs()">SAVE PREFERENCES →</button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var COOKIE_NAME = 'sharzhukov_cookie_consent';
    var STORAGE_KEY = 'sharzhukov_cookie_consent';
    var CONSENT_VERSION = '1.0';

    // Проверяем существующее согласие
    function hasConsent() {
        return document.cookie.split('; ').some(function(c) {
            return c.indexOf(COOKIE_NAME + '=') === 0;
        });
    }

    // Показать баннер если согласия нет
    window.addEventListener('DOMContentLoaded', function() {
        if (!hasConsent()) {
            document.getElementById('cookie-consent').style.display = 'block';
        }
    });

    // Отправить согласие на сервер
    function submitConsent(action, categories) {
        fetch('/api/cookie-consent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ action: action, categories: categories }),
        }).catch(function() {});

        // Сохраняем cookie на 1 год
        var expires = new Date();
        expires.setFullYear(expires.getFullYear() + 1);
        document.cookie = COOKIE_NAME + '=' + CONSENT_VERSION + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';

        // Скрываем баннер
        document.getElementById('cookie-consent').style.display = 'none';

        // Применяем категории (плейсхолдер)
        if (categories.analytics && window.labAnalyticsLoad) window.labAnalyticsLoad();
    }

    window.labCookieAction = function(action) {
        var categories = { necessary: true, analytics: false, marketing: false };
        if (action === 'accept_all') {
            categories = { necessary: true, analytics: true, marketing: true };
        }
        submitConsent(action, categories);
    };

    window.labCookiePreferences = function() {
        document.getElementById('cookie-consent').style.display = 'block';
        document.getElementById('cookie-prefs').style.display = 'flex';
    };

    // Публичная функция для вызова из footer (Cookie settings).
    // Открывает модалку Preferences, даже если баннер уже был закрыт.
    window.labCookieOpen = function() {
        document.getElementById('cookie-consent').style.display = 'block';
        document.getElementById('cookie-prefs').style.display = 'flex';
    };

    window.labCookieClosePrefs = function() {
        document.getElementById('cookie-prefs').style.display = 'none';
    };

    window.labCookieSavePrefs = function() {
        var categories = {
            necessary: true,
            analytics: document.getElementById('cookie-analytics').checked,
            marketing: document.getElementById('cookie-marketing').checked,
        };
        submitConsent('custom', categories);
        document.getElementById('cookie-prefs').style.display = 'none';
    };
})();
</script>
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
    var CONSENT_VERSION = '1.0';
    var COOKIE_DAYS = 365;

    function readCookie(name) {
        var parts = document.cookie.split('; ');
        for (var i = 0; i < parts.length; i++) {
            var kv = parts[i].split('=');
            if (kv[0] === name) return decodeURIComponent(kv.slice(1).join('='));
        }
        return null;
    }

    function writeCookie(name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + days * 24 * 60 * 60 * 1000);
        var secure = (location.protocol === 'https:') ? '; Secure' : '';
        document.cookie = name + '=' + encodeURIComponent(value) +
            '; expires=' + d.toUTCString() +
            '; path=/; SameSite=Lax' + secure;
    }

    function getSavedConsent() {
        var raw = readCookie(COOKIE_NAME);
        if (!raw) return null;
        try {
            var parsed = JSON.parse(raw);
            if (parsed && typeof parsed === 'object') return parsed;
        } catch (e) {
            return { necessary: true, analytics: false, marketing: false, action: 'legacy' };
        }
        return null;
    }

    function applyCategories(categories) {
        if (categories.analytics && typeof window.labAnalyticsLoad === 'function') {
            window.labAnalyticsLoad();
        }
        if (categories.marketing && typeof window.labMarketingLoad === 'function') {
            window.labMarketingLoad();
        }
    }

    function setTogglesFromCategories(categories) {
        var a = document.getElementById('cookie-analytics');
        var m = document.getElementById('cookie-marketing');
        if (a) a.checked = !!categories.analytics;
        if (m) m.checked = !!categories.marketing;
    }

    function submitConsent(action, categories) {
        var csrf = document.querySelector('meta[name="csrf-token"]');
        fetch('/api/cookie-consent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf ? csrf.content : '',
                'Accept': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify({ action: action, categories: categories, version: CONSENT_VERSION }),
        }).catch(function(){});

        var payload = {
            necessary: true,
            analytics: !!categories.analytics,
            marketing: !!categories.marketing,
            action: action,
            v: CONSENT_VERSION,
            t: Date.now(),
        };
        writeCookie(COOKIE_NAME, JSON.stringify(payload), COOKIE_DAYS);

        applyCategories(payload);

        var banner = document.getElementById('cookie-consent');
        if (banner) banner.style.display = 'none';
        var prefs = document.getElementById('cookie-prefs');
        if (prefs) prefs.style.display = 'none';
    }

    window.labCookieAction = function(action) {
        var categories = { necessary: true, analytics: false, marketing: false };
        if (action === 'accept_all') {
            categories = { necessary: true, analytics: true, marketing: true };
        }
        submitConsent(action, categories);
    };

    window.labCookiePreferences = function() {
        var saved = getSavedConsent();
        if (saved) {
            setTogglesFromCategories(saved);
        } else {
            setTogglesFromCategories({ analytics: false, marketing: false });
        }
        var b = document.getElementById('cookie-consent');
        var p = document.getElementById('cookie-prefs');
        if (b) b.style.display = 'block';
        if (p) p.style.display = 'flex';
    };

    window.labCookieOpen = window.labCookiePreferences;

    window.labCookieClosePrefs = function() {
        var p = document.getElementById('cookie-prefs');
        if (p) p.style.display = 'none';
        var b = document.getElementById('cookie-consent');
        if (getSavedConsent() && b) {
            b.style.display = 'none';
        }
    };

    window.labCookieSavePrefs = function() {
        var a = document.getElementById('cookie-analytics');
        var m = document.getElementById('cookie-marketing');
        var categories = {
            necessary: true,
            analytics: a ? a.checked : false,
            marketing: m ? m.checked : false,
        };
        submitConsent('custom', categories);
    };

    document.addEventListener('DOMContentLoaded', function() {
        var saved = getSavedConsent();
        var b = document.getElementById('cookie-consent');
        if (saved) {
            applyCategories(saved);
            if (b) b.style.display = 'none';
        } else {
            setTogglesFromCategories({ analytics: false, marketing: false });
            if (b) b.style.display = 'block';
        }
    });
})();
</script>

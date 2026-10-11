@auth
<div class="brutal-nav-bell" data-nav-bell>
    <button type="button" class="brutal-nav-bell-btn" aria-label="Notifications" data-nav-bell-toggle>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        <span class="brutal-nav-bell-badge" data-nav-bell-badge data-count="0"></span>
    </button>
    <div class="brutal-nav-bell-dropdown">
        <div class="brutal-nav-bell-head">
            <span class="brutal-nav-bell-head-title">// Notifications</span>
            <button type="button" class="brutal-nav-bell-mark-all" data-nav-bell-mark-all>Mark all read</button>
        </div>
        <div class="brutal-nav-bell-list" data-nav-bell-list>
            <div class="brutal-nav-bell-empty">Loading…</div>
        </div>
        <div class="brutal-nav-bell-foot">
            <a href="https://account.sharzhukov.com/notifications">View all →</a>
        </div>
    </div>
</div>

@once
<script>
(function () {
    var POLL_MS = 30000;
    var bell, badge, list, isOpen = false;
    function csrf() { var m = document.querySelector('meta[name="csrf-token"]'); return m ? m.content : ''; }

    function init() {
        bell = document.querySelector('[data-nav-bell]');
        if (!bell) return;
        badge = bell.querySelector('[data-nav-bell-badge]');
        list  = bell.querySelector('[data-nav-bell-list]');
        var toggle = bell.querySelector('[data-nav-bell-toggle]');
        if (toggle) toggle.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            isOpen = !isOpen;
            bell.setAttribute('data-open', isOpen ? 'true' : 'false');
            if (isOpen) loadRecent();
        });
        document.addEventListener('click', function (e) {
            if (!bell.contains(e.target)) { isOpen = false; bell.setAttribute('data-open', 'false'); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && isOpen) {
                isOpen = false;
                bell.setAttribute('data-open', 'false');
            }
        });
        var markAll = bell.querySelector('[data-nav-bell-mark-all]');
        if (markAll) markAll.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
                credentials: 'same-origin',
            }).then(function () { updateCount(0); loadRecent(); });
        });
        pollCount();
        setInterval(pollCount, POLL_MS);
    }
    function pollCount() {
        fetch('/api/notifications/unread-count', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (d) { if (d && typeof d.count === 'number') updateCount(d.count); })
            .catch(function () {});
    }
    function updateCount(n) {
        if (!badge) return;
        badge.setAttribute('data-count', n);
        badge.textContent = n > 99 ? '99+' : String(n);
    }
    function loadRecent() {
        if (!list) return;
        list.innerHTML = '<div class="brutal-nav-bell-empty">Loading…</div>';
        fetch('/api/notifications/recent', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function (r) { return r.ok ? r.json() : null; })
            .then(function (data) {
                if (!data) { list.innerHTML = '<div class="brutal-nav-bell-empty">Failed to load</div>'; return; }
                updateCount(data.unread || 0);
                var items = data.items || [];
                if (!items.length) { list.innerHTML = '<div class="brutal-nav-bell-empty">All caught up ✓</div>'; return; }
                list.innerHTML = items.map(function (n) {
                    var d = n.data || {};
                    var url = d.url || '#';
                    var title = d.title || 'Notification';
                    var msg = d.message || '';
                    var unread = n.read ? '0' : '1';
                    return '<a href="' + url + '" class="brutal-nav-bell-item" data-unread="' + unread + '">' +
                        '<div class="brutal-nav-bell-item-title">' + esc(title) + '<span class="brutal-nav-bell-item-time">' + esc(n.ago_short || '') + '</span></div>' +
                        (msg ? '<p class="brutal-nav-bell-item-msg">' + esc(msg) + '</p>' : '') +
                        '</a>';
                }).join('');
            }).catch(function () { list.innerHTML = '<div class="brutal-nav-bell-empty">Failed to load</div>'; });
    }
    function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
</script>
@endonce
@endauth
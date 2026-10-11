@props([
    'id'         => 'lab-modal',
    'title'      => null,
    'closeLabel' => 'Cancel',
    'closeable'  => true,   // разрешить закрытие по клику на backdrop
])

<div id="{{ $id }}" class="lab-modal" data-lab-modal data-open="false" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
    <div class="lab-modal-backdrop" data-lab-modal-backdrop></div>
    <div class="lab-modal-panel">
        <div class="lab-modal-header">
            @if($title)
                <h3 id="{{ $id }}-title" class="lab-modal-title">{{ $title }}</h3>
            @endif
            @if($closeable)
                <button type="button" class="lab-modal-close" data-lab-modal-close aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            @endif
        </div>
        <div class="lab-modal-body">{{ $slot }}</div>
        @isset($actions)
            <div class="lab-modal-actions">{{ $actions }}</div>
        @endisset
    </div>
</div>

@once
<script>
(function () {
    function open(id) {
        var m = document.getElementById(id);
        if (!m) return;
        m.setAttribute('data-open', 'true');
        document.body.classList.add('lab-modal-open');
    }
    function close(m) {
        if (!m) return;
        m.setAttribute('data-open', 'false');
        // если других открытых нет — снять lock
        if (!document.querySelector('.lab-modal[data-open="true"]')) {
            document.body.classList.remove('lab-modal-open');
        }
    }
    window.labModalOpen = open;
    window.labModalClose = function (id) { close(document.getElementById(id)); };

    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-lab-modal-close]')) {
            close(e.target.closest('.lab-modal'));
            return;
        }
        if (e.target.matches('[data-lab-modal-backdrop]')) {
            var m = e.target.closest('.lab-modal');
            // closeable-флаг не в data-атрибуте, значит закрываем всегда (если нет data-static)
            if (m && m.getAttribute('data-static') !== 'true') close(m);
            return;
        }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var m = document.querySelector('.lab-modal[data-open="true"]');
            if (m && m.getAttribute('data-static') !== 'true') close(m);
        }
    });
})();
</script>
@endonce
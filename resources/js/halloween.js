// Halloween — boot handled inline in <head>, this only handles easter eggs.

document.addEventListener('DOMContentLoaded', function () {
    if (document.documentElement.getAttribute('data-halloween') !== 'on') return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    if (!sessionStorage.getItem('hw-bats-shown')) {
        sessionStorage.setItem('hw-bats-shown', '1');
        setTimeout(function () { spawnBat(); setTimeout(spawnBat, 400); setTimeout(spawnBat, 900); }, 1200);
    }

    console.log(
        '%c🎃 Happy Halloween! %cThe Laboratory is open after dark.',
        'font-size:16px;color:#7c3aed;font-weight:bold;',
        'color:#f97316;'
    );
});

function spawnBat() {
    var b = document.createElement('div');
    b.className = 'hw-bat-fly';
    b.innerHTML = '<svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/></svg>';
    document.body.appendChild(b);
    setTimeout(function () { b.remove(); }, 6500);
}

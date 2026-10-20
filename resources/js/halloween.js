// Halloween — boot handled inline in <head>, this only handles easter eggs.

(function() {
    function addFavicon() {
        if (document.head.querySelector('link[data-hw-favicon]')) return;
        var l = document.createElement('link');
        l.rel = 'icon'; l.type = 'image/svg+xml';
        l.href = '/img/branding/halloween/favicon.svg';
        l.setAttribute('data-hw-favicon', '1');
        document.head.appendChild(l);
    }
    function rmFavicon() {
        var old = document.head.querySelector('link[data-hw-favicon]');
        if (old) old.remove();
    }
    window.toggleHalloween = function () {
        var html = document.documentElement;
        var next = html.getAttribute('data-halloween') === 'on' ? 'off' : 'on';
        if (next === 'on') { html.setAttribute('data-halloween', 'on'); addFavicon(); }
        else { html.removeAttribute('data-halloween'); rmFavicon(); }
        localStorage.setItem('hw-mode', next);
    };
})();

document.addEventListener('DOMContentLoaded', function () {
    if (document.documentElement.getAttribute('data-halloween') !== 'on') return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // 1. Подглядывающая тыква в углу
    if (!document.querySelector('.hw-peek')) {
        var peek = document.createElement('div');
        peek.className = 'hw-peek hw-peek--right';
        peek.innerHTML = '<svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="14" rx="7" ry="6"/><path d="M12 8v-2M12 6c-1-1-2-1-3 0"/><path d="M9 12l1 1-1 1M15 12l-1 1 1 1M11 16h2"/></svg>';
        document.body.appendChild(peek);
    }

    // 2. Летучая мышь на навигации
    var nav = document.querySelector('.brutal-nav') || document.querySelector('.lab-nav');
    if (nav && !nav.querySelector('.hw-nav-bat')) {
        var bat = document.createElement('div');
        bat.className = 'hw-nav-bat';
        bat.innerHTML = '<svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/></svg>';
        nav.style.position = 'relative';
        nav.appendChild(bat);
    }

    // 3. Стая мышей при первом заходе
    if (!sessionStorage.getItem('hw-bats-shown')) {
        sessionStorage.setItem('hw-bats-shown', '1');
        setTimeout(function () { spawnBat(); setTimeout(spawnBat, 400); setTimeout(spawnBat, 900); }, 1200);
    }

    // 4. Konami code (Candy rain)
    let konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
    let konamiIndex = 0;
    document.addEventListener('keydown', function(e) {
        if (e.key === konamiCode[konamiIndex] || e.key.toLowerCase() === konamiCode[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konamiCode.length) {
                triggerCandyRain();
                konamiIndex = 0;
            }
        } else {
            konamiIndex = 0;
        }
    });

    console.log(
        '%c🎃 Happy Halloween! %cTry the Konami code...',
        'font-size:16px;color:#ea580c;font-weight:bold;',
        'color:#7c3aed;'
    );
});

function spawnBat() {
    var b = document.createElement('div');
    b.className = 'hw-bat-fly';
    b.innerHTML = '<svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/></svg>';
    document.body.appendChild(b);
    setTimeout(function () { b.remove(); }, 6500);
}

function triggerCandyRain() {
    const emojis = ['🍬', '🍭', '🍫', '🍩'];
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            let c = document.createElement('div');
            c.className = 'hw-candy-fall';
            c.innerText = emojis[Math.floor(Math.random() * emojis.length)];
            c.style.left = Math.random() * 100 + 'vw';
            c.style.animationDuration = (Math.random() * 2 + 2) + 's';
            document.body.appendChild(c);
            setTimeout(() => c.remove(), 4000);
        }, i * 100);
    }
}

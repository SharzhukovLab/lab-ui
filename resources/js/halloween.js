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
        if (next === 'on') { html.setAttribute('data-halloween', 'on'); addFavicon(); injectDecorations(); }
        else { html.removeAttribute('data-halloween'); rmFavicon(); removeDecorations(); }
        localStorage.setItem('hw-mode', next);
    };
})();

document.addEventListener('DOMContentLoaded', function () {
    if (document.documentElement.getAttribute('data-halloween') !== 'on') return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    injectDecorations();
    
    setInterval(spawnLeaf, 2500);

    // Стая мышей при первом заходе
    if (!sessionStorage.getItem('hw-bats-shown')) {
        sessionStorage.setItem('hw-bats-shown', '1');
        setTimeout(function () { spawnBat(); setTimeout(spawnBat, 400); setTimeout(spawnBat, 900); }, 1200);
    }

    // Konami code (Candy rain)
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
        'font-size:16px;color:#f97316;font-weight:bold;',
        'color:#8b5cf6;'
    );
});

function injectDecorations() {
    if (document.querySelector('.hw-cobweb-screen')) return;

    var webSvg = '<svg viewBox="0 0 24 24" width="120" height="120" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M0 0 L24 0 L24 24 M0 0 L0 24 M0 0 L24 24 M0 0 L12 2 M0 0 L2 12 M0 0 L18 6 M0 0 L6 18"/></svg>';
    
    ['tl', 'tr', 'bl', 'br'].forEach(pos => {
        var web = document.createElement('div');
        web.className = 'hw-cobweb-screen hw-cobweb-' + pos;
        web.innerHTML = webSvg;
        document.body.appendChild(web);
    });

    // Подглядывающая тыква
    var peek = document.createElement('div');
    peek.className = 'hw-peek hw-peek--right';
    peek.innerHTML = '<svg width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="14" rx="7" ry="6"/><path d="M12 8v-2M12 6c-1-1-2-1-3 0"/><path d="M9 12l1 1-1 1M15 12l-1 1 1 1M11 16h2"/></svg>';
    document.body.appendChild(peek);

    // Подглядывающий призрак слева
    var ghost = document.createElement('div');
    ghost.className = 'hw-peek-ghost';
    ghost.innerHTML = '<svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 20V10a6 6 0 0 1 12 0v10l-2-2-2 2-2-2-2 2-2-2z"/><circle cx="10" cy="12" r=".8" fill="#8b5cf6"/><circle cx="14" cy="12" r=".8" fill="#8b5cf6"/></svg>';
    document.body.appendChild(ghost);

    // Мышь на навигации
    var nav = document.querySelector('.brutal-nav') || document.querySelector('.lab-nav');
    if (nav && !nav.querySelector('.hw-nav-bat')) {
        var bat = document.createElement('div');
        bat.className = 'hw-nav-bat';
        bat.innerHTML = '<svg viewBox="0 0 24 24" width="35" height="35" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/></svg>';
        nav.style.position = 'relative';
        nav.appendChild(bat);
    }
}

function removeDecorations() {
    document.querySelectorAll('.hw-cobweb-screen, .hw-peek, .hw-peek-ghost, .hw-nav-bat').forEach(el => el.remove());
}

function spawnBat() {
    var b = document.createElement('div');
    b.className = 'hw-bat-fly';
    b.innerHTML = '<svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/></svg>';
    document.body.appendChild(b);
    setTimeout(function () { b.remove(); }, 6500);
}


function spawnLeaf() {
    var leaf = document.createElement('div');
    leaf.className = 'hw-leaf';
    var size = Math.floor(Math.random() * 15) + 15;
    var left = Math.random() * 100;
    var duration = Math.random() * 4 + 4;
    
    leaf.innerHTML = `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9z"/><path d="M12 8v8M9 11l3-3 3 3"/></svg>`;
    
    leaf.style.left = left + 'vw';
    leaf.style.animationDuration = duration + 's';
    
    document.body.appendChild(leaf);
    setTimeout(() => leaf.remove(), duration * 1000);
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

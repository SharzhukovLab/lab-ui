// Halloween — boot handled inline in <head>, this only handles easter eggs.

document.addEventListener('DOMContentLoaded', function () {
    if (document.documentElement.getAttribute('data-halloween') !== 'on') return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    // 1. Стая мышей при первом заходе
    if (!sessionStorage.getItem('hw-bats-shown')) {
        sessionStorage.setItem('hw-bats-shown', '1');
        setTimeout(function () { spawnBat(); setTimeout(spawnBat, 400); setTimeout(spawnBat, 900); }, 1200);
    }

    // 2. Konami code (Candy rain)
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

    // 3. Console message
    console.log(
        '%c🎃 Happy Halloween! %cTry the Konami code...',
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

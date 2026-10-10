<div class="brutal-newsletter-form">
    <span class="brutal-marker" style="margin-bottom:14px;">// NEWSLETTER</span>
    <h3 style="font-family:var(--font-sans);font-weight:900;font-size:20px;letter-spacing:-0.02em;margin:0 0 8px;color:var(--lab-fg);">
        Lab notes in your inbox.
    </h3>
    <p style="color:var(--lab-fg-muted);font-size:13px;margin:0 0 16px;line-height:1.5;">
        Monthly digest — new projects, blog posts, behind-the-scenes. No spam.
    </p>

    <form id="newsletter-form" style="display:flex;gap:0;max-width:420px;" onsubmit="return labNewsletterSubmit(event)">
        @csrf
        <input type="email" name="email" required placeholder="you@example.com" style="flex:1;height:42px;padding:0 14px;border:2px solid var(--brutal-border);border-right:none;background:var(--lab-bg);color:var(--lab-fg);font-family:var(--font-mono);font-size:13px;outline:none;">
        <button type="submit" class="lab-btn lab-btn--primary" style="height:42px;padding:0 18px;font-family:var(--font-mono);font-size:11px;letter-spacing:0.06em;text-transform:uppercase;">
            SUBSCRIBE →
        </button>
    </form>

    <div id="newsletter-status" style="margin-top:12px;font-family:var(--font-mono);font-size:12px;font-weight:600;display:none;"></div>
</div>

<script>
function labNewsletterSubmit(e) {
    e.preventDefault();
    var form = e.target;
    var email = form.querySelector('input[name=email]').value;
    var csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    var status = document.getElementById('newsletter-status');

    status.style.display = 'block';
    status.style.color = 'var(--lab-fg-muted)';
    status.textContent = 'Sending...';

    fetch('/newsletter/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf,
        },
        credentials: 'same-origin',
        body: JSON.stringify({ email: email }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            if (data.message === 'already_subscribed') {
                status.style.color = 'var(--brutal-accent)';
                status.textContent = '✓ You are already subscribed';
            } else {
                status.style.color = 'var(--brutal-accent)';
                status.textContent = '✓ Check your inbox to confirm';
            }
            form.reset();
        } else {
            status.style.color = '#dc2626';
            status.textContent = '⚠ Something went wrong';
        }
    })
    .catch(() => {
        status.style.color = '#dc2626';
        status.textContent = '⚠ Network error';
    });

    return false;
}
</script>
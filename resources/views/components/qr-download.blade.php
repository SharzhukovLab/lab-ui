@props([
    'url',              // что кодировать
    'label' => null,    // подпись
    'size' => 220,      // размер preview (квадрат)
    'filename' => 'qr', // базовое имя
    'logo' => true,     // рисовать лого в центре
    'logoUrl' => '/img/branding/qr-logo.png',
])

<div class="qr-download"
     data-qr
     data-url="{{ $url }}"
     data-filename="{{ $filename }}"
     data-logo="{{ $logo ? '1' : '0' }}"
     data-logo-url="{{ $logoUrl }}"
     style="display:inline-flex;flex-direction:column;align-items:center;gap:16px;">

    {{-- Preview --}}
    <div class="qr-download__preview" style="
        display:inline-block;
        padding:14px;
        background:#ffffff;
        border:3px solid var(--brutal-border);
        box-shadow:6px 6px 0 var(--brutal-shadow);
        line-height:0;
    ">
        <canvas class="qr-download__canvas"
                width="{{ $size }}"
                height="{{ $size }}"
                style="display:block;"></canvas>
    </div>

    @if($label)
        <p style="margin:0;font-family:var(--font-mono);font-size:12px;color:var(--lab-fg-muted);text-align:center;word-break:break-all;max-width:280px;">
            {{ $label }}
        </p>
    @endif

    {{-- Actions --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">
        <button type="button" class="lab-btn lab-btn--primary lab-btn--sm" data-qr-download="png">
            DOWNLOAD PNG
        </button>
        <button type="button" class="lab-btn lab-btn--secondary lab-btn--sm" data-qr-download="svg">
            SVG
        </button>
        <button type="button" class="lab-btn lab-btn--secondary lab-btn--sm" data-qr-copy>
            COPY URL
        </button>
    </div>
</div>

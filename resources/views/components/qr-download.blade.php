@props([
    'url',           // что кодировать (обязательно)
    'label' => null, // подпись под QR (опционально)
    'size' => 220,   // размер превью QR
    'filename' => 'qr', // базовое имя для скачивания
])

<div class="qr-download" data-qr data-url="{{ $url }}" data-filename="{{ $filename }}">
    <div class="qr-download__preview" style="
        display:inline-block;
        padding:12px;
        background:#fff;
        border:2px solid var(--brutal-border);
        box-shadow:4px 4px 0 var(--brutal-shadow);
    ">
        {{-- canvas вставляется JS --}}
        <canvas class="qr-download__canvas" width="{{ $size }}" height="{{ $size }}" style="display:block;"></canvas>
    </div>

    @if($label)
        <p style="margin:10px 0 0;font-family:var(--font-mono);font-size:12px;color:var(--lab-fg-muted);text-align:center;">
            {{ $label }}
        </p>
    @endif

    <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
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

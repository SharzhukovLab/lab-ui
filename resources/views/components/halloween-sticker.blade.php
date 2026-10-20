@props(['name' => 'bat', 'position' => 'inline-right', 'size' => 48, 'heavy' => false])

@php
    $paths = [
        'bat'       => '<path d="M12 6c-1 0-2 1-2 3l-4-2 1 4-3 1 3 2 2 3 3-3 3 3 2-3 3-2-3-1 1-4-4 2c0-2-1-3-2-3z"/>',
        'skull'     => '<circle cx="12" cy="9" r="6"/><circle cx="10" cy="9" r="1.2" fill="currentColor"/><circle cx="14" cy="9" r="1.2" fill="currentColor"/><path d="M9 15h6v3H9z"/><path d="M10 15v3M14 15v3"/>',
        'pumpkin'   => '<ellipse cx="12" cy="14" rx="7" ry="6"/><path d="M12 8v-2M12 6c-1-1-2-1-3 0"/><path d="M9 12l1 1-1 1M15 12l-1 1 1 1M11 16h2"/>',
        'ghost'     => '<path d="M6 20V10a6 6 0 0 1 12 0v10l-2-2-2 2-2-2-2 2-2-2z"/><circle cx="10" cy="12" r=".8" fill="currentColor"/><circle cx="14" cy="12" r=".8" fill="currentColor"/>',
        'spider'    => '<circle cx="12" cy="12" r="2.5"/><path d="M12 9.5V6M12 14.5V18M9.5 12H6M14.5 12H18M9.8 9.8L7 7M14.2 9.8L17 7M9.8 14.2L7 17M14.2 14.2L17 17"/>',
        'cobweb'    => '<path d="M0 0h20M0 0v20M0 0l20 20M0 0c10 3 17 10 20 20M0 0c3 10 10 17 20 20"/>',
        'candle'    => '<rect x="10" y="10" width="4" height="9" rx="1"/><path d="M12 10V6M12 6c-1-1-1-3 0-4 1 1 1 3 0 4z"/>',
        'cat'       => '<path d="M5 12V8l2-2 2 2h6l2-2 2 2v4a5 5 0 0 1-5 5h-4a5 5 0 0 1-5-5z"/><circle cx="10" cy="11" r=".7" fill="currentColor"/><circle cx="14" cy="11" r=".7" fill="currentColor"/><path d="M11 14h2"/>',
        'tombstone' => '<path d="M6 20V10a6 6 0 0 1 12 0v10"/><path d="M6 20h12"/><path d="M10 14h4M12 12v4"/>',
        'candy'     => '<path d="M4 12l4-4 8 8 4-4-4 4-8-8-4 4z"/><circle cx="8" cy="12" r=".6" fill="currentColor"/>',
    ];
@endphp

<span class="hw-sticker hw-sticker--{{ $position }}"
      @if($heavy) data-heavy @endif
      aria-hidden="true">
    <svg xmlns="http://www.w3.org/2000/svg" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        {!! $paths[$name] ?? $paths['bat'] !!}
    </svg>
</span>

@props(['size' => 42])
<button
    type="button"
    class="lab-theme-toggle hw-toggle"
    onclick="toggleHalloween()"
    aria-label="Toggle Halloween mode"
    title="Halloween mode"
    style="width:{{ $size }}px;height:{{ $size }}px;display:inline-flex;align-items:center;justify-content:center;"
>
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         aria-hidden="true">
        <path d="M12 2c-4 0-7 3.5-7 8 0 2.5 1 4.5 2 5.5V19h10v-3.5c1-1 2-3 2-5.5 0-4.5-3-8-7-8z"/>
        <path d="M9 9l1.5 1.5L9 12"/>
        <path d="M15 9l-1.5 1.5L15 12"/>
        <path d="M10 15h4"/>
    </svg>
</button>

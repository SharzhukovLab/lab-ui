@props(['label' => null, 'name', 'type' => 'text', 'error' => null, 'help' => null])
<div>
    @if ($label)
        <label for="{{ $name }}" class="lab-label">{{ $label }}</label>
    @endif
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" {{ $attributes->class(['lab-input']) }}>
    @if ($error)
        <p class="lab-error">{{ $error }}</p>
    @elseif ($help)
        <p class="lab-help">{{ $help }}</p>
    @endif
</div>
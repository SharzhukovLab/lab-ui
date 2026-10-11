@props(['variant' => 'info'])

@php
    $allowed = ['success', 'danger', 'warning', 'info', 'accent'];
    $variant = in_array($variant, $allowed, true) ? $variant : 'info';
@endphp

<div {{ $attributes->class(['lab-alert', 'lab-alert--' . $variant]) }} role="alert">
    <div>{{ $slot }}</div>
</div>
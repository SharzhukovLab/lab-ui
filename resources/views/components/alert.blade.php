@props(['variant' => 'info'])
<div {{ $attributes->class(['lab-alert', 'lab-alert--'.$variant]) }}>
    <div>{{ $slot }}</div>
</div>
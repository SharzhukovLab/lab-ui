@props(['hoverable' => false, 'elevated' => false])
@php
    $classes = 'lab-card'.($hoverable ? ' lab-card--hoverable' : '').($elevated ? ' lab-card--elevated' : '');
@endphp
<div {{ $attributes->class([$classes]) }}>{{ $slot }}</div>
@props(['variant' => 'secondary', 'size' => 'md', 'href' => null, 'type' => 'button'])
@php
    $classes = 'lab-btn lab-btn--'.$variant.($size !== 'md' ? ' lab-btn--'.$size : '');
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$classes]) }}>{{ $slot }}</button>
@endif
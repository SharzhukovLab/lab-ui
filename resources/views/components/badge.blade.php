@props(['variant' => null])
@php $classes = 'lab-badge'.($variant ? ' lab-badge--'.$variant : ''); @endphp
<span {{ $attributes->class([$classes]) }}>{{ $slot }}</span>
@props([
    'text' => "All Hallows' Eve Edition — limited time. The Laboratory is open after dark.",
    'href' => '/projects',
    'cta'  => 'Explore →',
])
<div class="hw-banner" role="note">
    <span class="hw-banner__emoji" aria-hidden="true">🎃</span>
    <span>{{ $text }}</span>
    <a href="{{ $href }}" class="hw-banner__link">{{ $cta }}</a>
</div>

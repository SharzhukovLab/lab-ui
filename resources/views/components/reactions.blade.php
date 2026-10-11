@props([
    'subject',
    'subjectType' => null,
    'variant'     => 'inline', // inline | bar
])

@php
    $type = $subjectType ?? match (class_basename($subject)) {
        'News'        => 'news',
        'UserProject' => 'project',
        'WikiPage'    => 'wiki',
        default       => null,
    };
    $subjectId = $subject->getKey();
    $isAuthed  = auth()->check();
@endphp

@if($type)
<div
    class="lab-reactions lab-reactions--{{ $variant }}"
    data-reactions-root
    data-subject-type="{{ $type }}"
    data-subject-id="{{ $subjectId }}"
    data-api-index="{{ url('/api/reactions/' . $type . '/' . $subjectId) }}"
    data-api-toggle="{{ url('/api/reactions/toggle') }}"
    data-authed="{{ $isAuthed ? '1' : '0' }}"
    data-login-url="https://account.sharzhukov.com/login?return={{ urlencode(request()->fullUrl()) }}"
>
    @foreach(['like' => '👍', 'love' => '❤️', 'fire' => '🔥', 'rocket' => '🚀'] as $key => $emoji)
        <button
            type="button"
            class="lab-reaction"
            data-reaction="{{ $key }}"
            aria-pressed="false"
            title="{{ $key }}"
        >
            <span class="lab-reaction__emoji">{{ $emoji }}</span>
            <span class="lab-reaction__count" data-count-for="{{ $key }}">0</span>
        </button>
    @endforeach
</div>
@endif

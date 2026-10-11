@props(['user', 'following' => null, 'size' => 'md'])

@php
    $isFollowing = $following;
    if ($isFollowing === null) {
        $isFollowing = auth()->check() && auth()->id() !== $user->id
            ? auth()->user()->isFollowing($user)
            : false;
    }
    $isSelf = auth()->check() && auth()->id() === $user->id;
@endphp

@if ($isSelf)
    {{-- ничего на своём профиле --}}
@elseif (auth()->check())
    <button
        type="button"
        class="lab-follow-btn {{ $size === 'sm' ? 'lab-follow-btn--sm' : '' }}"
        data-follow-url="{{ route('follows.store', $user->username) }}"
        data-unfollow-url="{{ route('follows.destroy', $user->username) }}"
        data-following="{{ $isFollowing ? '1' : '0' }}"
        aria-pressed="{{ $isFollowing ? 'true' : 'false' }}"
    >
        <span class="lab-follow-btn__label">{{ $isFollowing ? 'FOLLOWING' : 'FOLLOW' }}</span>
    </button>
@else
    <a
        href="https://account.sharzhukov.com/login?return={{ urlencode(request()->fullUrl()) }}"
        class="lab-follow-btn {{ $size === 'sm' ? 'lab-follow-btn--sm' : '' }}"
    >
        <span class="lab-follow-btn__label">FOLLOW</span>
    </a>
@endif

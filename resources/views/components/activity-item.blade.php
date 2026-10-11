@props(['activity'])

@php
    $actor   = $activity->actor;
    $data    = $activity->data ?? [];
    $type    = $activity->type;

    $actorName = $actor?->name ?? 'Someone';
    $actorUrl  = $actor?->username ? "https://sharzhukov.com/u/{$actor->username}" : null;
    $avatar    = $actor?->avatar_url;

    // Иконка и глагол по типу
    [$icon, $verb] = match ($type) {
        'comment_created'  => ['💬', 'commented on'],
        'reaction_added'   => [match ($data['reaction'] ?? '') {
            'fire'   => '🔥',
            'love'   => '❤️',
            'rocket' => '🚀',
            default  => '👍',
        }, 'reacted to'],
        'user_followed'    => ['👤', 'started following'],
        'project_approved' => ['🚀', 'published a new project'],
        'wiki_published'   => ['📖', 'published a wiki page'],
        'news_published'   => ['📰', 'published news'],
        default            => ['•', 'did something with'],
    };

    // URL и название subject'а
    $subjectTitle = $data['title'] ?? null;
    $subjectSlug  = $data['slug']  ?? null;
    $subjectUrl   = null;

    // Для user_followed — subject это User
    if ($type === 'user_followed') {
        $subjectTitle = $data['followee_username'] ?? ($activity->subject?->name ?? 'someone');
        $subjectUrl   = $subjectTitle ? "https://sharzhukov.com/u/{$subjectTitle}" : null;
    } elseif ($subjectSlug) {
        $subjectUrl = match ($activity->subject_type) {
            'App\Models\News'        => "https://sharzhukov.com/news/{$subjectSlug}",
            'App\Models\UserProject' => "https://sharzhukov.com/projects/{$subjectSlug}",
            'App\Models\WikiPage'    => "https://wiki.sharzhukov.com/{$subjectSlug}",
            default                  => null,
        };
    }

    if (! $subjectTitle && $activity->subject) {
        $subjectTitle = $activity->subject->title ?? $activity->subject->name ?? null;
    }
@endphp

<article class="lab-activity-item" data-type="{{ $type }}">
    <div class="lab-activity-item__icon" aria-hidden="true">{{ $icon }}</div>

    <div class="lab-activity-item__body">
        <div class="lab-activity-item__line">
            @if($actorUrl)
                <a href="{{ $actorUrl }}" class="lab-activity-item__actor" target="_blank" rel="noopener">
                    {{ $actorName }}
                </a>
            @else
                <span class="lab-activity-item__actor">{{ $actorName }}</span>
            @endif
            <span class="lab-activity-item__verb">{{ $verb }}</span>
            @if($subjectUrl)
                <a href="{{ $subjectUrl }}" class="lab-activity-item__subject">{{ $subjectTitle }}</a>
            @elseif($subjectTitle)
                <span class="lab-activity-item__subject">{{ $subjectTitle }}</span>
            @endif
        </div>

        @if(!empty($data['excerpt']))
            <p class="lab-activity-item__excerpt">{{ \Illuminate\Support\Str::limit($data['excerpt'], 180) }}</p>
        @endif

        <time class="lab-activity-item__time" datetime="{{ $activity->created_at?->toIso8601String() }}">
            {{ $activity->created_at?->diffForHumans() }}
        </time>
    </div>
</article>

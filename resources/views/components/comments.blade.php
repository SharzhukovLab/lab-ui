@props([
    'subject',           // News | UserProject
    'subjectType' => null, // 'news' | 'project' — если null, выведем из класса
])

@php
    $type = $subjectType ?? match (class_basename($subject)) {
        'News'        => 'news',
        'UserProject' => 'project',
        default       => null,
    };
    $subjectId = $subject->getKey();
    $isAuthed  = auth()->check();
@endphp

@if($type)
<section
    class="lab-comments"
    data-comments-root
    data-subject-type="{{ $type }}"
    data-subject-id="{{ $subjectId }}"
    data-api-index="{{ url('/api/comments/' . $type . '/' . $subjectId) }}"
    data-api-store="{{ url('/api/comments') }}"
>
    <header class="lab-comments__head">
        <span class="brutal-marker">// COMMENTS</span>
        <h2 class="lab-comments__title">
            Discussion <span class="lab-comments__count" data-comments-count>0</span>
        </h2>
    </header>

    @auth
        <form class="lab-comments__form" data-comment-form>
            <textarea
                name="body"
                class="lab-comments__input"
                rows="3"
                maxlength="5000"
                placeholder="Your comment…"
                required
            ></textarea>
            <div class="lab-comments__form-foot">
                <span class="lab-comments__hint" data-comment-hint></span>
                <button type="submit" class="lab-btn lab-btn--primary lab-comments__submit">POST COMMENT →</button>
            </div>
        </form>
    @else
        <div class="lab-comments__login">
            <a href="https://account.sharzhukov.com/login?return={{ urlencode(request()->fullUrl()) }}"
               class="lab-btn lab-btn--secondary">
                LOGIN TO COMMENT →
            </a>
        </div>
    @endauth

    <div class="lab-comments__list" data-comments-list>
        <div class="lab-comments__empty">Loading…</div>
    </div>
</section>
@endif

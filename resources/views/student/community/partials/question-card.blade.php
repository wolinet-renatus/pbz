<div class="card border rounded-3 p-3 mb-2.5 bg-white shadow-none pbz-community-card" style="border-color: #e2e8f0; transition: border-color 0.15s ease, box-shadow 0.15s ease;">
    <!-- Author & Status Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
        <div class="d-flex align-items-center gap-2.5">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                 style="width: 34px; height: 34px; font-size: 12px; background: #006837;">
                @if($question->user && $question->user->profile_photo)
                    <img src="{{ asset('storage/' . $question->user->profile_photo) }}" alt="{{ $question->user->name }}"
                         class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                @else
                    {{ strtoupper(substr($question->user->name ?? 'U', 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="fw-bold text-dark" style="font-size: 13px; line-height: 1.2;">{{ $question->user->name ?? 'PBZ Scholar' }}</div>
                <div class="text-muted" style="font-size: 11px;">{{ $question->created_at->diffForHumans() }}</div>
            </div>
        </div>

        <div>
            @if($question->answers_count > 0)
                <span class="badge px-2 py-1 rounded-pill" style="background: #e0f2fe; color: #0099cc; font-size: 10.5px; font-weight: 700;">
                    <i class="fa-solid fa-comments me-1"></i> {{ $question->answers_count }} {{ Str::plural('Answer', $question->answers_count) }}
                </span>
            @else
                <span class="badge px-2 py-1 rounded-pill" style="background: #f1f5f9; color: #64748b; font-size: 10.5px; font-weight: 600;">
                    <i class="fa-regular fa-comment me-1"></i> Awaiting Answers
                </span>
            @endif
        </div>
    </div>

    <!-- Question Title -->
    <h5 class="fw-bold mb-1.5" style="font-size: 14px; line-height: 1.35;">
        <a href="{{ route('student.community.show', $question->id) }}" class="text-dark text-decoration-none pbz-question-link">
            {{ $question->title }}
        </a>
    </h5>

    <!-- Question Excerpt -->
    <p class="text-muted mb-2 text-truncate-2" style="font-size: 12.5px; line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
        {{ strip_tags($question->description) }}
    </p>

    <!-- Tag Chips -->
    @if(!empty($question->tags))
        <div class="d-flex flex-wrap gap-1.5 mb-2.5">
            @foreach($question->tags as $tag)
                <span class="badge px-2 py-0.5 rounded-pill" style="background: #f0fdf4; color: #006837; font-size: 10.5px; font-weight: 600; border: 1px solid #bbf7d0;">
                    #{{ $tag }}
                </span>
            @endforeach
        </div>
    @endif

    <!-- Card Footer Stats & Join Button -->
    <div class="pt-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #f1f5f9 !important;">
        <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 11.5px;">
            <span>
                <i class="fa-regular fa-eye me-1" style="color: #0099cc;"></i> {{ $question->views }} {{ __('student.views') }}
            </span>
            <span>
                <i class="fa-solid fa-arrow-up me-1 text-success"></i> {{ $question->votes_sum_vote ?? 0 }} {{ __('student.votes') }}
            </span>
        </div>

        <a href="{{ route('student.community.show', $question->id) }}" 
           class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
           style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
            Join Discussion <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
        </a>
    </div>
</div>
@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Community Discussion'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Back Button & Discussion Header Card -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <a href="{{ route('student.community.index') }}" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1.5" style="font-size: 12px; font-weight: 600;">
                        <i class="fa-solid fa-arrow-left"></i> {{ __('student.back_to_discussions') }}
                    </a>
                    
                    <button type="button" class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1.5"
                            data-bs-toggle="modal" data-bs-target="#askQuestionModal"
                            style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
                        <i class="fa-solid fa-plus"></i> {{ __('student.ask_question') }}
                    </button>
                </div>

                <h3 class="fw-bold mb-2" style="font-size: 1.25rem; color: #0f172a; line-height: 1.35;">{{ $question->title }}</h3>

                <div class="d-flex align-items-center gap-3 flex-wrap text-muted" style="font-size: 11.5px;">
                    <span><i class="fa-regular fa-clock me-1 text-primary"></i> {{ __('student.asked') }} <strong>{{ $question->created_at->diffForHumans() }}</strong></span>
                    <span><i class="fa-regular fa-eye me-1" style="color: #0099cc;"></i> {{ __('student.viewed') }} <strong>{{ $question->views }} {{ __('student.times') }}</strong></span>
                    <span><i class="fa-regular fa-comments me-1 text-success"></i> {{ __('student.answers') }} <strong>{{ $question->answers_count }}</strong></span>
                </div>
            </div>

            <!-- Question Detail & Voting Row -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex gap-3">
                    <!-- Voting Column -->
                    <div class="vote-widget d-flex flex-column align-items-center gap-1 flex-shrink-0" style="width: 44px;">
                        <button class="vote-btn p-1 {{ ($question->votes->where('user_id', Auth::id())->first()?->vote == 1) ? 'active' : '' }}" onclick="handleVote('question', {{ $question->id }}, 1, this)" title="Upvote">
                            <i class="fa-solid fa-caret-up" style="font-size: 26px;"></i>
                        </button>
                        <span class="vote-count fw-bold" style="font-size: 16px; color: #0f172a;">{{ $question->votes_sum_vote ?? 0 }}</span>
                        <button class="vote-btn p-1 {{ ($question->votes->where('user_id', Auth::id())->first()?->vote == -1) ? 'active' : '' }}" onclick="handleVote('question', {{ $question->id }}, -1, this)" title="Downvote">
                            <i class="fa-solid fa-caret-down" style="font-size: 26px;"></i>
                        </button>
                    </div>

                    <!-- Question Body -->
                    <div class="flex-grow-1">
                        <div class="question-body mb-3" style="font-size: 13.5px; line-height: 1.6; color: #334155;">
                            {!! nl2br(e($question->description)) !!}
                        </div>

                        <!-- Tags -->
                        @if(!empty($question->tags))
                            <div class="d-flex flex-wrap gap-1.5 mb-3">
                                @foreach($question->tags as $tag)
                                    <span class="badge px-2 py-0.5 rounded-pill" style="background: #f0fdf4; color: #006837; font-size: 10.5px; font-weight: 600; border: 1px solid #bbf7d0;">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Author Tag Box -->
                        <div class="d-flex justify-content-end">
                            <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                     style="width: 28px; height: 28px; font-size: 11px; background: #006837;">
                                    @if($question->user && $question->user->profile_photo)
                                        <img src="{{ asset('storage/' . $question->user->profile_photo) }}" alt="" class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                                    @else
                                        {{ strtoupper(substr($question->user->name ?? 'U', 0, 1)) }}
                                    @endif
                                </div>
                                <div style="font-size: 11.5px;">
                                    <div class="text-muted" style="font-size: 10px;">{{ __('student.asked') }} {{ $question->created_at->format('M d, Y') }}</div>
                                    <strong class="text-dark">{{ $question->user->name ?? 'PBZ Scholar' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answers Section -->
            <div class="mb-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="fw-bold mb-0" style="font-size: 14.5px; color: #0f172a;">
                        <i class="fa-solid fa-comments text-success me-1"></i> {{ $question->answers_count }} {{ __('student.answers') }}
                    </h5>
                </div>

                @forelse($question->answers as $answer)
                    <div class="card border rounded-3 p-3 mb-2.5 bg-white shadow-none position-relative" style="border-color: {{ $answer->is_accepted ? '#006837' : '#e2e8f0' }};">
                        @if($answer->is_accepted)
                            <div class="position-absolute top-0 end-0 m-2 badge px-2 py-0.5 rounded-pill" style="background: #006837; color: #fff; font-size: 10px; font-weight: 700;">
                                <i class="fa-solid fa-circle-check me-1"></i> {{ __('student.accepted_answer') }}
                            </div>
                        @endif

                        <div class="d-flex gap-3">
                            <!-- Voting for Answer -->
                            <div class="vote-widget d-flex flex-column align-items-center gap-1 flex-shrink-0" style="width: 40px;">
                                <button class="vote-btn p-1 {{ ($answer->votes->where('user_id', Auth::id())->first()?->vote == 1) ? 'active' : '' }}" onclick="handleVote('answer', {{ $answer->id }}, 1, this)">
                                    <i class="fa-solid fa-caret-up" style="font-size: 22px;"></i>
                                </button>
                                <span class="vote-count fw-bold" style="font-size: 15px; color: #0f172a;">{{ $answer->votes_sum_vote ?? 0 }}</span>
                                <button class="vote-btn p-1 {{ ($answer->votes->where('user_id', Auth::id())->first()?->vote == -1) ? 'active' : '' }}" onclick="handleVote('answer', {{ $answer->id }}, -1, this)">
                                    <i class="fa-solid fa-caret-down" style="font-size: 22px;"></i>
                                </button>

                                @if($answer->is_accepted)
                                    <div class="mt-2 text-success" title="Accepted Answer">
                                        <i class="fa-solid fa-circle-check" style="font-size: 20px;"></i>
                                    </div>
                                @elseif($question->user_id == Auth::id())
                                    <form action="{{ route('student.community.answers.accept', $answer->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="border-0 bg-transparent p-0 text-muted" title="Accept this answer">
                                            <i class="fa-regular fa-circle-check" style="font-size: 20px; transition: color 0.2s;"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Answer Content -->
                            <div class="flex-grow-1">
                                <div class="answer-body mb-3" style="font-size: 13px; line-height: 1.6; color: #334155;">
                                    {!! nl2br(e($answer->content)) !!}
                                </div>

                                <div class="d-flex justify-content-end">
                                    <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                             style="width: 26px; height: 26px; font-size: 10.5px; background: #0099cc;">
                                            @if($answer->user && $answer->user->profile_photo)
                                                <img src="{{ asset('storage/' . $answer->user->profile_photo) }}" alt="" class="w-100 h-100 rounded-circle" style="object-fit: cover;">
                                            @else
                                                {{ strtoupper(substr($answer->user->name ?? 'U', 0, 1)) }}
                                            @endif
                                        </div>
                                        <div style="font-size: 11.5px;">
                                            <div class="text-muted" style="font-size: 10px;">Answered {{ $answer->created_at->diffForHumans() }}</div>
                                            <strong class="text-dark">{{ $answer->user->name ?? 'PBZ Member' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card p-4 text-center rounded-3 bg-white border shadow-none mb-3" style="border-color: #e2e8f0;">
                        <p class="text-muted mb-0" style="font-size: 12.5px;">No answers posted yet. Be the first to share your academic or operational perspective!</p>
                    </div>
                @endforelse
            </div>

            <!-- Post Answer Form -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <h5 class="fw-bold mb-2 text-dark" style="font-size: 14px;">{{ __('student.your_answer') }}</h5>
                <form action="{{ route('student.community.answers.store', $question->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control rounded-2" name="content" rows="4" 
                                  placeholder="{{ __('student.answer_placeholder') }}" required 
                                  style="border-color: #cbd5e1; font-size: 12.5px; line-height: 1.5;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5"
                            style="background-color: #006837; border-color: #006837; font-size: 12px;">
                        <i class="fa-solid fa-paper-plane"></i> {{ __('student.post_answer') }}
                    </button>
                </form>
            </div>

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

@include('student.community.partials.ask-question-modal')

<style>
    .vote-btn {
        background: none;
        border: none;
        color: #94a3b8;
        padding: 0;
        transition: color 0.15s;
        line-height: 1;
    }
    .vote-btn:hover, .vote-btn.active {
        color: #006837;
    }
    .vote-btn.disabled {
        opacity: 0.5;
        pointer-events: none;
    }
</style>

@push('scripts')
<script>
    function handleVote(type, id, voteValue, btnElement) {
        const container = btnElement.closest('.vote-widget');
        const countSpan = container.querySelector('.vote-count');
        const allBtn = container.querySelectorAll('.vote-btn');
        
        let finalVote = voteValue;
        if (btnElement.classList.contains('active')) {
            finalVote = 0;
        }

        allBtn.forEach(btn => btn.classList.add('disabled'));

        $.ajax({
            url: `{{ url('student/community/vote') }}/${type}/${id}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                vote: finalVote
            },
            success: function(response) {
                if (response.success) {
                    let currentCount = parseInt(countSpan.textContent);
                    
                    allBtn.forEach(btn => {
                        if (btn.classList.contains('active')) {
                            const prevVote = btn.innerHTML.includes('caret-up') ? 1 : -1;
                            currentCount -= prevVote;
                            btn.classList.remove('active');
                        }
                    });

                    if (finalVote !== 0) {
                        btnElement.classList.add('active');
                        currentCount += finalVote;
                    }

                    countSpan.textContent = currentCount;
                    if (typeof ToastMagic !== 'undefined') {
                        ToastMagic.success(response.message);
                    }
                }
            },
            error: function(xhr) {
                if (typeof ToastMagic !== 'undefined') {
                    ToastMagic.error('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                allBtn.forEach(btn => btn.classList.remove('disabled'));
            }
        });
    }
</script>
@endpush
@endsection

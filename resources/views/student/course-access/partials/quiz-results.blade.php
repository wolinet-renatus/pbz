<div class="quiz-results-wrapper">
    <!-- Learning Navigation Action Bar (at top of quiz results) -->
    <div class="learning-nav-toolbar p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 shadow-none" style="border-color: #e2e8f0 !important;">
        <button type="button" id="prev-btn" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" style="font-size: 12.5px;">
            <i class="fa-solid fa-chevron-left" style="font-size: 10px;"></i> Previous
        </button>

        <div class="learning-item-counter fw-bold text-muted text-center" id="learning-item-counter" style="font-size: 12.5px;">
            <span id="current-item-indicator" class="text-dark">{{ $quiz->title }} (Results)</span>
        </div>

        <button type="button" id="next-btn" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
            Next <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
        </button>
    </div>

    <!-- Executive Assessment Performance Header Stage -->
    <div class="card border-0 rounded-3 overflow-hidden mb-3 text-white" style="background: #081226;">
        <div class="p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #1e293b; border: 1px solid #d4af37; color: #d4af37; font-size: 11.5px; font-weight: 700;">
                    <i class="fa-solid fa-award"></i> STATUTORY ASSESSMENT EVALUATION
                </div>

                @if ($attempt->passed)
                    <span class="badge fw-bold px-3 py-1.5 rounded-pill" style="background: #16a34a; color: #ffffff; font-size: 12.5px;">
                        <i class="fa-solid fa-circle-check me-1"></i> Passed &amp; Accredited
                    </span>
                @else
                    <span class="badge fw-bold px-3 py-1.5 rounded-pill" style="background: #dc2626; color: #ffffff; font-size: 12.5px;">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> Benchmark Not Met (Retake Required)
                    </span>
                @endif
            </div>

            <h2 class="fw-bold text-white mb-2" style="font-size: 1.5rem;">
                Quiz Results: {{ $quiz->title }}
            </h2>

            <!-- Results Score & Metrics Grid -->
            <div class="row g-3 my-2" style="max-width: 750px;">
                <div class="col-sm-4 col-12">
                    <div class="p-3 rounded-2 border h-100" style="background: #0f172a; border-color: #1e293b;">
                        <div class="text-white-50 mb-1" style="font-size: 12px;">Your Final Score</div>
                        <div class="fw-bold font-monospace {{ $attempt->passed ? 'text-success' : 'text-danger' }}" style="font-size: 1.8rem; line-height: 1.2;">
                            {{ $attempt->score }}%
                        </div>
                        <span class="text-white-50" style="font-size: 11px;">
                            {{ $attempt->passed ? 'Meets BOT Standard' : 'Below 80% Threshold' }}
                        </span>
                    </div>
                </div>

                <div class="col-sm-4 col-6">
                    <div class="p-3 rounded-2 border h-100" style="background: #0f172a; border-color: #1e293b;">
                        <div class="text-white-50 mb-1" style="font-size: 12px;">Passing Standard</div>
                        <div class="fw-bold font-monospace text-warning" style="font-size: 1.8rem; line-height: 1.2;">
                            {{ $quiz->passing_score }}%
                        </div>
                        <span class="text-white-50" style="font-size: 11px;">Statutory Benchmark</span>
                    </div>
                </div>

                <div class="col-sm-4 col-6">
                    <div class="p-3 rounded-2 border h-100" style="background: #0f172a; border-color: #1e293b;">
                        <div class="text-white-50 mb-1" style="font-size: 12px;">Correct Answers</div>
                        <div class="fw-bold font-monospace" style="color: #0099cc; font-size: 1.8rem; line-height: 1.2;">
                            {{ $correctAnswersCount ?? $attempt->answers->where('is_correct', true)->count() }}/{{ count($questionsData ?? []) }}
                        </div>
                        <span class="text-white-50" style="font-size: 11px;">Validated Questions</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Bar -->
            <div class="d-flex align-items-center gap-2 mt-4 flex-wrap">
                <button type="button" class="btn btn-warning fw-bold px-3.5 py-2 rounded-2 retake-quiz-btn d-inline-flex align-items-center gap-1.5"
                        data-quiz-id="{{ $quiz->id }}"
                        data-course-id="{{ $quiz->topic->course_id }}"
                        style="background-color: #d4af37; border-color: #d4af37; color: #081226; font-size: 13px;">
                    <i class="fa-solid fa-rotate-right"></i> Retake Assessment
                </button>

                @if ($attempt->passed)
                    <button type="button" class="btn btn-success fw-bold px-3.5 py-2 rounded-2 d-inline-flex align-items-center gap-1.5" 
                            onclick="if(typeof window.navigateItem === 'function') window.navigateItem('next');"
                            style="background-color: #006837; border-color: #006837; font-size: 13px;">
                        Advance to Next Module <i class="fa-solid fa-arrow-right"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Horizontal Question Review Stepper Card (Zero Down Below Scrolling!) -->
    <div class="card border rounded-3 bg-white mb-3 shadow-none overflow-hidden" style="border-color: #e2e8f0;">
        
        <!-- Horizontal Review Stepper Header Bar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #081226; border-color: #1e293b !important; color: #fff;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2 py-1 rounded-pill" style="background-color: #0099cc; color: #ffffff; font-size: 11px;">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Question Review Navigator
                </span>
                <span class="text-white-50 d-none d-sm-inline" style="font-size: 12px;">
                    Review statutory answers horizontally
                </span>
            </div>

            <!-- Horizontal Question Review Stepper Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap" id="review-question-pills">
                @foreach ($questionsData ?? [] as $index => $qData)
                    <button type="button" 
                            class="btn btn-sm review-step-btn {{ $index === 0 ? 'active' : '' }}" 
                            data-q-index="{{ $index }}"
                            id="review-pill-{{ $index }}"
                            style="font-size: 11.5px; border-radius: 20px; padding: 3px 11px; font-weight: 600; {{ $index === 0 ? 'background: #0099cc; color: #ffffff; border: 1px solid #0099cc;' : ($qData['is_correct'] ? 'background: #064e3b; color: #ffffff; border: 1px solid #059669;' : 'background: #450a0a; color: #ffffff; border: 1px solid #dc2626;') }}">
                        Q{{ $index + 1 }}
                        @if ($qData['is_correct'])
                            <i class="fa-solid fa-check ms-1 text-success" style="font-size: 10px;"></i>
                        @else
                            <i class="fa-solid fa-xmark ms-1 text-danger" style="font-size: 10px;"></i>
                        @endif
                    </button>
                @endforeach
            </div>

            <!-- Review Summary Stats -->
            <div class="text-white-50 font-monospace" style="font-size: 11.5px;">
                <span class="text-success fw-bold">{{ $correctAnswersCount ?? 0 }} Correct</span> &bull; 
                <span class="text-danger fw-bold">{{ count($questionsData ?? []) - ($correctAnswersCount ?? 0) }} Incorrect</span>
            </div>
        </div>

        <div class="card-body p-4 p-md-5" style="min-height: 340px;">
            <!-- Review Panes (Only 1 shown at a time) -->
            @foreach ($questionsData ?? [] as $index => $qData)
                <div class="review-question-pane {{ $index === 0 ? '' : 'd-none' }}" id="review-q-pane-{{ $index }}" data-q-index="{{ $index }}">
                    
                    <!-- Question Review Header -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom" style="border-color: #f1f5f9;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge fw-bold px-2.5 py-1 rounded-2" style="background: #0f172a; color: #ffffff; font-size: 12px;">
                                Question {{ $index + 1 }} of {{ count($questionsData ?? []) }}
                            </span>

                            @if ($qData['is_correct'])
                                <span class="badge px-2.5 py-1 rounded-pill" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; font-size: 11.5px;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Correct Answer
                                </span>
                            @else
                                <span class="badge px-2.5 py-1 rounded-pill" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; font-size: 11.5px;">
                                    <i class="fa-solid fa-circle-xmark me-1"></i> Incorrect Answer
                                </span>
                            @endif
                        </div>

                        <span class="text-muted" style="font-size: 12px;">
                            <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Bank of Tanzania Compliance Directive
                        </span>
                    </div>

                    <!-- Question Prompt -->
                    <h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem; line-height: 1.55; color: #0f172a;">
                        {{ $qData['question']->question }}
                    </h4>

                    <!-- Options List with Color Coding -->
                    <div class="d-flex flex-column gap-2.5">
                        @foreach ($qData['options'] as $option)
                            @php
                                $isCorrectAnswer = $option['is_correct'];
                                $isSelected = $option['is_selected'];
                                $isWrongSelection = $option['is_wrong'];
                            @endphp

                            <div class="p-3 rounded-2 border d-flex align-items-center justify-content-between flex-wrap gap-2"
                                 style="@if ($isCorrectAnswer) background: #f0fdf4; border-color: #16a34a !important; border-width: 1.5px; @elseif($isWrongSelection) background: #fef2f2; border-color: #dc2626 !important; border-width: 1.5px; @else background: #ffffff; border-color: #e2e8f0; @endif">
                                
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    @if ($isCorrectAnswer)
                                        <i class="fa-solid fa-circle-check text-success flex-shrink-0" style="font-size: 17px;"></i>
                                    @elseif($isWrongSelection)
                                        <i class="fa-solid fa-circle-xmark text-danger flex-shrink-0" style="font-size: 17px;"></i>
                                    @else
                                        <i class="fa-regular fa-circle text-muted flex-shrink-0" style="font-size: 16px;"></i>
                                    @endif

                                    <span style="font-size: 13.5px; @if ($isCorrectAnswer) color: #166534; font-weight: 600; @elseif($isWrongSelection) color: #991b1b; font-weight: 600; @else color: #334155; @endif">
                                        {{ $option['text'] }}
                                    </span>
                                </div>

                                <!-- Clarification Badges -->
                                <div class="flex-shrink-0">
                                    @if ($isSelected && $isCorrectAnswer)
                                        <span class="badge px-2.5 py-1 rounded-pill" style="background: #16a34a; color: #ffffff; font-size: 11px;">
                                            <i class="fa-solid fa-check me-1"></i> Your Correct Answer
                                        </span>
                                    @elseif($isCorrectAnswer)
                                        <span class="badge px-2.5 py-1 rounded-pill" style="background: #16a34a; color: #ffffff; font-size: 11px;">
                                            <i class="fa-solid fa-check me-1"></i> Correct Statutory Answer
                                        </span>
                                    @elseif($isWrongSelection)
                                        <span class="badge px-2.5 py-1 rounded-pill" style="background: #dc2626; color: #ffffff; font-size: 11px;">
                                            <i class="fa-solid fa-xmark me-1"></i> Your Selection
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Horizontal Review Toolbar (Bottom) -->
        <div class="card-footer bg-white border-top p-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #e2e8f0 !important;">
            <!-- Prev Question Button -->
            <button type="button" id="btn-review-prev-q" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" disabled style="font-size: 12.5px;">
                <i class="fa-solid fa-arrow-left"></i> Previous Question
            </button>

            <!-- Status / Counter Center -->
            <div class="text-muted text-center" style="font-size: 12.5px;">
                Reviewing <span id="review-current-q-indicator" class="fw-bold text-dark">Question 1</span> of {{ count($questionsData ?? []) }}
            </div>

            <!-- Next Question or Retake Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button type="button" id="btn-review-next-q" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
                    Next Question <i class="fa-solid fa-arrow-right"></i>
                </button>

                <button type="button" class="btn btn-sm btn-warning fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5 retake-quiz-btn"
                        data-quiz-id="{{ $quiz->id }}"
                        data-course-id="{{ $quiz->topic->course_id }}"
                        style="background-color: #d4af37; border-color: #d4af37; color: #081226; font-size: 12.5px;">
                    <i class="fa-solid fa-rotate-right"></i> Retake
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    // Pure Vanilla JS Horizontal Question Review Stepper (Zero vertical scroll down below)
    (function() {
        var currentReviewIndex = 0;
        var totalReviewQuestions = {{ count($questionsData ?? []) }};
        var panes = document.querySelectorAll('.review-question-pane');
        var pills = document.querySelectorAll('.review-step-btn');
        var prevBtn = document.getElementById('btn-review-prev-q');
        var nextBtn = document.getElementById('btn-review-next-q');
        var indicator = document.getElementById('review-current-q-indicator');

        function showReviewQuestion(index) {
            currentReviewIndex = parseInt(index);
            if (currentReviewIndex < 0) currentReviewIndex = 0;
            if (currentReviewIndex >= totalReviewQuestions) currentReviewIndex = totalReviewQuestions - 1;

            // Show active review pane, hide others
            panes.forEach(function(p) {
                p.classList.add('d-none');
            });
            var target = document.getElementById('review-q-pane-' + currentReviewIndex);
            if (target) target.classList.remove('d-none');

            // Update pills
            pills.forEach(function(pill) {
                var pIdx = parseInt(pill.getAttribute('data-q-index'));
                if (pIdx === currentReviewIndex) {
                    pill.style.background = '#0099cc';
                    pill.style.borderColor = '#0099cc';
                    pill.style.color = '#ffffff';
                } else {
                    // Check if question was correct or incorrect from check/cross icon
                    var hasCheck = pill.querySelector('.fa-check');
                    if (hasCheck) {
                        pill.style.background = '#064e3b';
                        pill.style.borderColor = '#059669';
                        pill.style.color = '#ffffff';
                    } else {
                        pill.style.background = '#450a0a';
                        pill.style.borderColor = '#dc2626';
                        pill.style.color = '#ffffff';
                    }
                }
            });

            // Update footer controls
            if (prevBtn) {
                prevBtn.disabled = (currentReviewIndex === 0);
            }
            if (nextBtn) {
                nextBtn.disabled = (currentReviewIndex === totalReviewQuestions - 1);
            }
            if (indicator) {
                indicator.textContent = 'Question ' + (currentReviewIndex + 1);
            }
        }

        // Pill click listeners
        pills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                var idx = this.getAttribute('data-q-index');
                showReviewQuestion(idx);
            });
        });

        // Prev / Next button listeners
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentReviewIndex > 0) {
                    showReviewQuestion(currentReviewIndex - 1);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentReviewIndex < totalReviewQuestions - 1) {
                    showReviewQuestion(currentReviewIndex + 1);
                }
            });
        }

        // Initial setup
        showReviewQuestion(0);
    })();
</script>

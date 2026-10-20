<div class="quiz-content-wrapper">
    <!-- Learning Navigation Action Bar (at top of quiz) -->
    <div class="learning-nav-toolbar p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 shadow-none" style="border-color: #e2e8f0 !important;">
        <button type="button" id="prev-btn" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" style="font-size: 12.5px;">
            <i class="fa-solid fa-chevron-left" style="font-size: 10px;"></i> Previous
        </button>

        <div class="learning-item-counter fw-bold text-muted text-center" id="learning-item-counter" style="font-size: 12.5px;">
            <span id="current-item-indicator" class="text-dark">{{ $quiz->title }}</span>
        </div>

        <button type="button" id="next-btn" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
            Next <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
        </button>
    </div>

    <!-- Executive Assessment Briefing Stage -->
    <div class="card border-0 rounded-3 overflow-hidden mb-3 text-white" style="background: #081226;">
        <div class="p-3.5 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2.5">
                <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #1e293b; border: 1px solid #d4af37; color: #d4af37; font-size: 11.5px; font-weight: 700;">
                    <i class="fa-solid fa-graduation-cap"></i> MANDATORY STATUTORY ASSESSMENT
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge px-2.5 py-1 rounded-pill" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; font-size: 11.5px;">
                        Pass Mark: <strong class="text-warning">{{ $quiz->passing_score }}%</strong>
                    </span>
                    @if ($quiz->time_limit)
                        <span class="badge px-2.5 py-1 rounded-pill" style="background: #0f172a; border: 1px solid #334155; color: #94a3b8; font-size: 11.5px;">
                            Time: <strong class="text-white">{{ str_pad($quiz->time_limit, 2, '0', STR_PAD_LEFT) }}:00</strong>
                        </span>
                    @endif
                </div>
            </div>

            <h2 class="fw-bold text-white mb-2" style="font-size: 1.35rem;">
                {{ $quiz->title }}
            </h2>

            <p class="text-white-50 mb-0" style="font-size: 13px; max-width: 850px; line-height: 1.6;">
                @if ($quiz->description)
                    {!! strip_tags($quiz->description) !!}
                @else
                    This formal knowledge evaluation assesses your direct application of Bank of Tanzania (BOT) prudential regulations, frontline AML/CFT protocols, structuring detection, and sovereign customer due diligence standards.
                @endif
            </p>
        </div>
    </div>

    <!-- Previous Attempt Summary Alert (if exists) -->
    @if ($previousAttempt)
        <div class="card border rounded-3 p-3 mb-3 bg-white" style="border-color: #e2e8f0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-2.5">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $previousAttempt->passed ? '#f0fdf4' : '#fef2f2' }}; color: {{ $previousAttempt->passed ? '#16a34a' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa-solid {{ $previousAttempt->passed ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark" style="font-size: 13px;">Previous Attempt Score: {{ $previousAttempt->score }}%</div>
                        <div class="text-muted" style="font-size: 11.5px;">
                            Status: <strong class="{{ $previousAttempt->passed ? 'text-success' : 'text-danger' }}">{{ $previousAttempt->passed ? 'Passed (Accredited)' : 'Needs Retake' }}</strong>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-outline-secondary view-results-btn rounded-2 px-3 py-1" data-attempt-id="{{ $previousAttempt->id }}" style="font-size: 12px;">
                    <i class="fa-solid fa-eye me-1"></i> Review Questions
                </button>
            </div>
        </div>
    @endif

    <!-- Horizontal Question Stepper Card (No Down Below Scrolling!) -->
    <div class="card border rounded-3 bg-white mb-3 shadow-none overflow-hidden" style="border-color: #e2e8f0;">
        
        <!-- Horizontal Question Stepper Header Bar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #081226; border-color: #1e293b !important; color: #fff;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2 py-1 rounded-pill" style="background-color: #0099cc; color: #ffffff; font-size: 11px;">
                    <i class="fa-solid fa-compass me-1"></i> Question Navigator
                </span>
                <span class="text-white-50 d-none d-sm-inline" style="font-size: 12px;">
                    Navigate questions horizontally
                </span>
            </div>

            <!-- Horizontal Question Stepper Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap" id="quiz-question-pills">
                @foreach ($quiz->questions as $index => $question)
                    <button type="button" 
                            class="btn btn-sm quiz-step-btn {{ $index === 0 ? 'active' : '' }}" 
                            data-q-index="{{ $index }}"
                            id="quiz-pill-{{ $index }}"
                            style="font-size: 11.5px; border-radius: 20px; padding: 3px 11px; font-weight: 600; {{ $index === 0 ? 'background: #0099cc; color: #ffffff; border: 1px solid #0099cc;' : 'background: #0f172a; color: #94a3b8; border: 1px solid #1e293b;' }}">
                        <span class="pill-q-text">Q{{ $index + 1 }}</span>
                        <i class="fa-solid fa-check ms-1 d-none pill-check-icon text-success" style="font-size: 10px;"></i>
                    </button>
                @endforeach
            </div>

            <!-- Answered Count Indicator -->
            <div class="text-white-50 font-monospace" style="font-size: 11.5px;">
                Answered: <span id="quiz-answered-count" class="text-warning fw-bold">0</span>/{{ $quiz->questions->count() }}
            </div>
        </div>

        <!-- Form wrapping the Questions Container -->
        <form id="quiz-form" data-quiz-id="{{ $quiz->id }}" data-course-id="{{ $quiz->topic->course_id }}">
            <input type="hidden" name="time_taken" id="time-taken" value="0">

            <div class="card-body p-4 p-md-5" style="min-height: 340px;">
                <!-- Question Carousel Panes (Only 1 active at a time) -->
                @foreach ($quiz->questions as $index => $question)
                    <div class="quiz-question-pane {{ $index === 0 ? '' : 'd-none' }}" id="quiz-q-pane-{{ $index }}" data-q-index="{{ $index }}">
                        
                        <!-- Question Header -->
                        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom" style="border-color: #f1f5f9;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge fw-bold px-2.5 py-1 rounded-2" style="background: #0f172a; color: #ffffff; font-size: 12px;">
                                    Question {{ $index + 1 }} of {{ $quiz->questions->count() }}
                                </span>
                                <span class="badge bg-light text-muted border px-2 py-0.5 rounded-pill" style="font-size: 11px;">
                                    {{ $question->type === 'true-false' ? 'True / False Directive' : 'Multiple Choice Directive' }}
                                </span>
                            </div>

                            <span class="text-muted" style="font-size: 12px;">
                                <i class="fa-solid fa-shield-halved me-1 text-primary"></i> BOT Regulatory Standard
                            </span>
                        </div>

                        <!-- Question Prompt Text -->
                        <h4 class="fw-bold text-dark mb-4" style="font-size: 1.15rem; line-height: 1.55; color: #0f172a;">
                            {{ $question->question }}
                        </h4>

                        <!-- Interactive Options List -->
                        <div class="d-flex flex-column gap-2.5 mb-4">
                            @foreach ($question->options as $optionIndex => $option)
                                <label class="p-3 rounded-2 border d-flex align-items-center gap-3 bg-white quiz-interactive-option" 
                                       style="border-color: #cbd5e1; cursor: pointer; transition: all 0.15s ease;">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}][selected_answer]" 
                                           value="{{ $optionIndex }}" 
                                           data-q-index="{{ $index }}"
                                           class="form-check-input mt-0 quiz-radio-input"
                                           style="width: 18px; height: 18px; cursor: pointer; flex-shrink: 0;">
                                    <span class="text-dark" style="font-size: 13.5px; line-height: 1.5;">
                                        {{ $option }}
                                    </span>
                                </label>
                            @endforeach
                            <input type="hidden" name="answers[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Horizontal Navigation Toolbar (Bottom) -->
            <div class="card-footer bg-white border-top p-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #e2e8f0 !important;">
                <!-- Prev Question Button -->
                <button type="button" id="btn-quiz-prev-q" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" disabled style="font-size: 12.5px;">
                    <i class="fa-solid fa-arrow-left"></i> Previous Question
                </button>

                <!-- Status / Counter Center -->
                <div class="text-muted text-center" style="font-size: 12.5px;">
                    <span id="quiz-current-q-indicator" class="fw-bold text-dark">Question 1</span> of {{ $quiz->questions->count() }}
                </div>

                <!-- Next Question or Submit Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="btn-quiz-next-q" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
                        Next Question <i class="fa-solid fa-arrow-right"></i>
                    </button>

                    <button type="submit" id="btn-quiz-submit" class="btn btn-sm btn-success fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5 {{ $quiz->questions->count() > 1 ? 'd-none' : '' }}" style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                        <i class="fa-solid fa-paper-plane"></i> Submit Assessment
                    </button>
                </div>
            </div>

        </form>
    </div>

    <!-- Floating Timer (if time limit enabled) -->
    @if ($quiz->time_limit)
        <div id="quiz-timer" class="position-fixed bottom-0 end-0 m-4 p-2.5 px-3.5 rounded-pill shadow-sm d-flex align-items-center gap-2" data-time-limit="{{ $quiz->time_limit }}" style="background: #081226; color: #ffffff; border: 1px solid #334155; z-index: 1050; font-size: 13px;">
            <i class="fa-solid fa-stopwatch text-warning"></i>
            <span class="fw-bold font-monospace floating-timer-text">{{ str_pad($quiz->time_limit, 2, '0', STR_PAD_LEFT) }}:00</span>
        </div>
    @endif
</div>

<style>
    .quiz-interactive-option:hover {
        background: #f8fafc !important;
        border-color: #0099cc !important;
    }
    .quiz-interactive-option:has(input:checked) {
        background: #f0fdf4 !important;
        border-color: #006837 !important;
        box-shadow: inset 0 0 0 1px #006837;
    }
</style>

<script>
    // Pure Vanilla JS Horizontal Question Stepper (Zero vertical scroll down below)
    (function() {
        var currentQIndex = 0;
        var totalQuestions = {{ $quiz->questions->count() }};
        var panes = document.querySelectorAll('.quiz-question-pane');
        var pills = document.querySelectorAll('.quiz-step-btn');
        var prevBtn = document.getElementById('btn-quiz-prev-q');
        var nextBtn = document.getElementById('btn-quiz-next-q');
        var submitBtn = document.getElementById('btn-quiz-submit');
        var indicator = document.getElementById('quiz-current-q-indicator');
        var answeredCounter = document.getElementById('quiz-answered-count');

        function showQuestion(index) {
            currentQIndex = parseInt(index);
            if (currentQIndex < 0) currentQIndex = 0;
            if (currentQIndex >= totalQuestions) currentQIndex = totalQuestions - 1;

            // Show active pane, hide others
            panes.forEach(function(p) {
                p.classList.add('d-none');
            });
            var target = document.getElementById('quiz-q-pane-' + currentQIndex);
            if (target) target.classList.remove('d-none');

            // Update pills
            pills.forEach(function(pill) {
                var pIdx = parseInt(pill.getAttribute('data-q-index'));
                if (pIdx === currentQIndex) {
                    pill.style.background = '#0099cc';
                    pill.style.borderColor = '#0099cc';
                    pill.style.color = '#ffffff';
                } else {
                    // Check if answered
                    var isAnswered = pill.querySelector('.pill-check-icon') && !pill.querySelector('.pill-check-icon').classList.contains('d-none');
                    if (isAnswered) {
                        pill.style.background = '#064e3b';
                        pill.style.borderColor = '#059669';
                        pill.style.color = '#ffffff';
                    } else {
                        pill.style.background = '#0f172a';
                        pill.style.borderColor = '#1e293b';
                        pill.style.color = '#94a3b8';
                    }
                }
            });

            // Update footer controls
            if (prevBtn) {
                prevBtn.disabled = (currentQIndex === 0);
            }
            if (indicator) {
                indicator.textContent = 'Question ' + (currentQIndex + 1);
            }

            if (currentQIndex === totalQuestions - 1) {
                // On last question, show submit button alongside or instead of next
                if (nextBtn) nextBtn.classList.add('d-none');
                if (submitBtn) submitBtn.classList.remove('d-none');
            } else {
                if (nextBtn) nextBtn.classList.remove('d-none');
                // Check if all answered, if all answered keep submit button available
                updateAnsweredCount();
            }
        }

        function updateAnsweredCount() {
            var checkedRadios = document.querySelectorAll('.quiz-radio-input:checked');
            var answeredTotal = checkedRadios.length;
            if (answeredCounter) answeredCounter.textContent = answeredTotal;

            // Update pill check icons
            pills.forEach(function(pill) {
                var pIdx = pill.getAttribute('data-q-index');
                var checkedInQ = document.querySelector('.quiz-radio-input[data-q-index="' + pIdx + '"]:checked');
                var checkIcon = pill.querySelector('.pill-check-icon');
                if (checkedInQ && checkIcon) {
                    checkIcon.classList.remove('d-none');
                }
            });

            // If all answered, show submit button even before reaching last question
            if (answeredTotal >= totalQuestions && submitBtn) {
                submitBtn.classList.remove('d-none');
            }
        }

        // Pill click listeners
        pills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                var idx = this.getAttribute('data-q-index');
                showQuestion(idx);
            });
        });

        // Prev / Next button listeners
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentQIndex > 0) {
                    showQuestion(currentQIndex - 1);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentQIndex < totalQuestions - 1) {
                    showQuestion(currentQIndex + 1);
                }
            });
        }

        // Radio change listener to track answered status and auto-advance
        document.querySelectorAll('.quiz-radio-input').forEach(function(radio) {
            radio.addEventListener('change', function() {
                updateAnsweredCount();
                var qIdx = parseInt(this.getAttribute('data-q-index'));
                var pill = document.getElementById('quiz-pill-' + qIdx);
                if (pill) {
                    var icon = pill.querySelector('.pill-check-icon');
                    if (icon) icon.classList.remove('d-none');
                }
            });
        });

        // Initial setup
        updateAnsweredCount();
        showQuestion(0);
    })();
</script>

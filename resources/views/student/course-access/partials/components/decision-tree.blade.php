@php
    $scenarioTitle = $data['scenarioTitle'] ?? $lesson->title ?? 'Branch Compliance Decision Branching Scenario';
    $initialDilemma = $data['initialDilemma'] ?? 'A customer arrives at the Stone Town PBZ counter carrying TZS 45,000,000 in uncounted physical cash bags, seeking immediate credit into a commercial account without import clearance, tax receipts, or invoices.';
    $step = $data['steps'][0] ?? [
        'prompt' => 'What is the mandatory frontline action under PBZ AML/CFT Standard Operating Procedures?',
        'options' => [
            [
                'text' => 'Process the cash transfer immediately without questions to preserve high-net-worth customer relationship.',
                'isCorrect' => false,
                'feedback' => 'CRITICAL BREACH: Violates BOT AMLA 2022 Section 17. Facilitating unverified cash above TZS 30M threshold incurs statutory institutional penalties up to TZS 500,000,000 and personal regulatory sanctions.',
                'penaltyScore' => -20
            ],
            [
                'text' => 'Decline the deposit rudely and tell the customer you are reporting them immediately to the police.',
                'isCorrect' => false,
                'feedback' => 'PROCEDURAL FAILURE: Tipping off the customer violates Section 20 of the Anti-Money Laundering Act. Officers must maintain professional composure and never alert suspects.',
                'penaltyScore' => -10
            ],
            [
                'text' => 'Initiate mandatory Large Cash Transaction Report (CTR), request Beneficial Ownership verification, and quietly notify Branch Compliance Officer.',
                'isCorrect' => true,
                'feedback' => 'REGULATORY EXCELLENCE: Fully compliant with BOT Prudential Guidelines and PBZ AML Directives. The compliance officer initiates Enhanced Due Diligence (EDD) without tipping off.',
                'penaltyScore' => 25
            ]
        ]
    ];
    $decisionId = 'decision_' . $lesson->id;
@endphp

<div class="interactive-component-wrapper mb-4">
    <div class="card border-0 rounded-3 overflow-hidden shadow-sm" style="background: #081226; color: #ffffff;">
        <!-- Top Toolbar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #1e293b !important; background: #060e1e;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2.5 py-1.5 rounded-pill" style="background-color: #d97706; color: #ffffff; font-size: 11.5px;">
                    <i class="fa-solid fa-sitemap me-1"></i> Interactive Compliance Dilemma
                </span>
                <span class="text-white-50 d-none d-md-inline" style="font-size: 12.5px;">
                    Branch Operational Simulation • BOT Compliance Engine
                </span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-white-50 small">Compliance Score:</span>
                    <span class="badge font-monospace px-2.5 py-1 rounded" id="{{ $decisionId }}_score_badge" style="background: #1e293b; color: #38bdf8; font-size: 13px;">
                        100 / 100 PTS
                    </span>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1" id="{{ $decisionId }}_reset" title="Restart Scenario" style="font-size: 11.5px; border-color: #334155; color: #94a3b8;">
                    <i class="fa-solid fa-rotate-left me-1"></i> Restart
                </button>
            </div>
        </div>

        <div class="p-4 p-md-5">
            <!-- Scenario Presentation Card -->
            <div class="p-4 rounded-3 mb-4" style="background: #0b1528; border: 1px solid #1e293b;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1 fw-bold" style="font-size: 11px;">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> INCIDENT SCENARIO
                    </span>
                    <span class="text-white-50 font-monospace small">PBZ-FRONT-DESK-{{ $lesson->id }}</span>
                </div>
                <h3 class="fw-bold text-white mb-2" style="font-size: 1.3rem;">
                    {{ $scenarioTitle }}
                </h3>
                <p class="text-white-50 mb-0" style="font-size: 13.5px; line-height: 1.7;">
                    {{ $initialDilemma }}
                </p>
            </div>

            <!-- Decision Prompt -->
            <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark fw-bold rounded-circle px-2 py-1" style="font-size: 11px;">Q</span>
                    <h5 class="fw-bold text-white mb-0" style="font-size: 14.5px;">
                        {{ $step['prompt'] }}
                    </h5>
                </div>

                <!-- Decision Choices List -->
                <div class="d-flex flex-column gap-3" id="{{ $decisionId }}_options_container">
                    @foreach ($step['options'] as $idx => $opt)
                        @php
                            $isCorrect = !empty($opt['isCorrect']);
                            $feedback = $opt['feedback'] ?? '';
                            $penalty = (int)($opt['penaltyScore'] ?? ($isCorrect ? 25 : -15));
                        @endphp
                        <div class="decision-option-card p-3.5 rounded-3 cursor-pointer" 
                            data-correct="{{ $isCorrect ? '1' : '0' }}" 
                            data-penalty="{{ $penalty }}"
                            data-feedback="{{ htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8') }}"
                            style="background: #0f1c33; border: 1.5px solid #1e3a66; transition: all 0.2s ease; cursor: pointer;">
                            <div class="d-flex align-items-start gap-3">
                                <span class="badge rounded-circle p-2 flex-shrink-0 d-flex align-items-center justify-content-center option-marker" 
                                    style="width: 28px; height: 28px; background: #1e293b; color: #38bdf8; font-weight: 700; font-size: 12px;">
                                    {{ chr(65 + $idx) }}
                                </span>
                                <div class="flex-grow-1">
                                    <div class="text-white fw-semibold mb-1 option-text" style="font-size: 13.5px;">
                                        {{ $opt['text'] }}
                                    </div>
                                    <div class="feedback-panel d-none mt-2 p-2.5 rounded" style="font-size: 12px; line-height: 1.6;">
                                        <!-- Feedback injected upon click -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Outcome Card (hidden until option chosen) -->
            <div class="p-4 rounded-3 d-none" id="{{ $decisionId }}_outcome_card" style="border: 1px solid #1e293b;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <h6 class="fw-bold mb-0" id="{{ $decisionId }}_outcome_heading" style="font-size: 14px;"></h6>
                    <span class="badge rounded-pill px-2.5 py-1" id="{{ $decisionId }}_outcome_pill"></span>
                </div>
                <p class="text-white-50 mb-3" id="{{ $decisionId }}_outcome_body" style="font-size: 13px;"></p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light px-3" id="{{ $decisionId }}_retry_btn">
                        <i class="fa-solid fa-arrow-rotate-left me-1"></i> Try Different Choice
                    </button>
                    <button type="button" class="btn btn-sm btn-primary px-3" id="{{ $decisionId }}_continue_btn" style="background-color: #0099cc; border-color: #0099cc;">
                        <i class="fa-solid fa-check me-1"></i> Confirm Decision &amp; Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initDecisionTree() {
        const container = document.getElementById('{{ $decisionId }}_options_container');
        if (!container) return;

        let currentScore = 100;
        const scoreBadge = document.getElementById('{{ $decisionId }}_score_badge');
        const outcomeCard = document.getElementById('{{ $decisionId }}_outcome_card');
        const outcomeHeading = document.getElementById('{{ $decisionId }}_outcome_heading');
        const outcomeBody = document.getElementById('{{ $decisionId }}_outcome_body');
        const outcomePill = document.getElementById('{{ $decisionId }}_outcome_pill');
        const cards = container.querySelectorAll('.decision-option-card');

        function updateScore(delta) {
            currentScore = Math.max(0, Math.min(100, currentScore + delta));
            if (scoreBadge) {
                scoreBadge.textContent = currentScore + ' / 100 PTS';
                scoreBadge.style.color = currentScore >= 80 ? '#4ade80' : currentScore >= 50 ? '#facc15' : '#ef4444';
            }
        }

        cards.forEach(card => {
            card.onclick = function() {
                // Disable other choices
                cards.forEach(c => {
                    c.style.pointerEvents = 'none';
                    c.style.opacity = '0.6';
                });
                this.style.opacity = '1';

                const isCorrect = this.getAttribute('data-correct') === '1';
                const penalty = parseInt(this.getAttribute('data-penalty')) || 0;
                const feedback = this.getAttribute('data-feedback');

                const marker = this.querySelector('.option-marker');
                const feedbackPanel = this.querySelector('.feedback-panel');

                if (isCorrect) {
                    this.style.borderColor = '#10b981';
                    this.style.background = '#064e3b';
                    if (marker) {
                        marker.style.background = '#10b981';
                        marker.style.color = '#ffffff';
                        marker.innerHTML = '<i class="fa-solid fa-check"></i>';
                    }
                    if (feedbackPanel) {
                        feedbackPanel.className = 'feedback-panel mt-2 p-2.5 rounded bg-dark border border-success text-success';
                        feedbackPanel.innerHTML = '<strong><i class="fa-solid fa-shield-check me-1"></i> REGULATORY APPROVAL:</strong> ' + feedback;
                    }
                    updateScore(penalty > 0 ? penalty : 25);

                    if (outcomeCard) {
                        outcomeCard.className = 'p-4 rounded-3 mt-3 bg-success-subtle border border-success text-success';
                        outcomeHeading.textContent = 'Decision Approved by BOT Compliance Framework';
                        outcomeHeading.className = 'fw-bold mb-0 text-success';
                        outcomePill.className = 'badge bg-success text-white px-2.5 py-1';
                        outcomePill.textContent = 'COMPLIANT';
                        outcomeBody.textContent = 'Your action accurately adheres to PBZ Standard Operating Procedures and prevents regulatory exposure.';
                        outcomeBody.className = 'text-success-emphasis mb-3';
                    }
                } else {
                    this.style.borderColor = '#ef4444';
                    this.style.background = '#450a0a';
                    if (marker) {
                        marker.style.background = '#ef4444';
                        marker.style.color = '#ffffff';
                        marker.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                    }
                    if (feedbackPanel) {
                        feedbackPanel.className = 'feedback-panel mt-2 p-2.5 rounded bg-dark border border-danger text-danger';
                        feedbackPanel.innerHTML = '<strong><i class="fa-solid fa-triangle-exclamation me-1"></i> STATUTORY VIOLATION:</strong> ' + feedback;
                    }
                    updateScore(penalty < 0 ? penalty : -15);

                    if (outcomeCard) {
                        outcomeCard.className = 'p-4 rounded-3 mt-3 bg-danger-subtle border border-danger text-danger';
                        outcomeHeading.textContent = 'Regulatory Breach Flagged Under BOT Mandate';
                        outcomeHeading.className = 'fw-bold mb-0 text-danger';
                        outcomePill.className = 'badge bg-danger text-white px-2.5 py-1';
                        outcomePill.textContent = 'BREACH';
                        outcomeBody.textContent = 'This procedural decision triggers an immediate escalation to the BOT Audit Matrix. Review the guidelines below and retry.';
                        outcomeBody.className = 'text-danger-emphasis mb-3';
                    }
                }

                if (outcomeCard) outcomeCard.classList.remove('d-none');
            };
        });

        const retryBtn = document.getElementById('{{ $decisionId }}_retry_btn');
        if (retryBtn) {
            retryBtn.onclick = function() {
                cards.forEach(c => {
                    c.style.pointerEvents = 'auto';
                    c.style.opacity = '1';
                    c.style.background = '#0f1c33';
                    c.style.borderColor = '#1e3a66';
                    const marker = c.querySelector('.option-marker');
                    if (marker) {
                        marker.style.background = '#1e293b';
                        marker.style.color = '#38bdf8';
                        marker.textContent = c.dataset.origMarker || marker.textContent;
                    }
                    const feedbackPanel = c.querySelector('.feedback-panel');
                    if (feedbackPanel) feedbackPanel.classList.add('d-none');
                });
                if (outcomeCard) outcomeCard.classList.add('d-none');
            };
        }

        const resetBtn = document.getElementById('{{ $decisionId }}_reset');
        if (resetBtn) {
            resetBtn.onclick = function() {
                currentScore = 100;
                if (scoreBadge) scoreBadge.textContent = '100 / 100 PTS';
                if (retryBtn) retryBtn.click();
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDecisionTree);
    } else {
        initDecisionTree();
    }
})();
</script>

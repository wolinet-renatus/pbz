@php
    $lessonId = $lesson->id;
    $contentType = $lesson->content_type ?? 'video';
    $componentData = is_array($lesson->component_data) ? $lesson->component_data : (json_decode($lesson->component_data ?? '{}', true) ?? []);

    $isLesson1 = ($lessonId == 4 || str_contains(strtolower($lesson->title), 'three stages') || str_contains(strtolower($lesson->title), '1.1'));
    $isLesson2 = ($lessonId == 5 || str_contains(strtolower($lesson->title), 'sanctions') || str_contains(strtolower($lesson->title), 'pep') || str_contains(strtolower($lesson->title), '1.2'));
    $isLesson3 = ($lessonId == 6 || str_contains(strtolower($lesson->title), 'smurfing') || str_contains(strtolower($lesson->title), 'structuring') || str_contains(strtolower($lesson->title), '2.1'));
@endphp

<div class="lesson-content-wrapper">
    @if ($contentType === 'interactive_chart')
        @include('student.course-access.partials.components.interactive-chart', ['lesson' => $lesson, 'data' => $componentData])
    @elseif ($contentType === 'calculator')
        @include('student.course-access.partials.components.calculator', ['lesson' => $lesson, 'data' => $componentData])
    @elseif ($contentType === 'decision_tree')
        @include('student.course-access.partials.components.decision-tree', ['lesson' => $lesson, 'data' => $componentData])
    @elseif ($contentType === 'embed_iframe')
        @include('student.course-access.partials.components.embed-iframe', ['lesson' => $lesson, 'data' => $componentData])
    @else
    <!-- Interactive PBZ Storyline & Multimedia Player Stage -->
    <div class="card border-0 rounded-3 overflow-hidden shadow-none mb-3 pbz-storyline-player" id="pbzStorylinePlayer" style="background: #081226; color: #ffffff;">
        
        <!-- Storyline Player Top Controls Bar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #1e293b !important; background: #060e1e;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2 py-1 rounded-pill" style="background-color: #0099cc; color: #ffffff; font-size: 11px;">
                    <i class="fa-solid fa-layer-group me-1"></i> PBZ Storyline Video Experience
                </span>
                <span class="text-white-50 d-none d-md-inline" style="font-size: 12px;">
                    Bank of Tanzania (BOT) Interactive Prudential Module
                </span>
            </div>

            <!-- Clip Navigation Pills -->
            <div class="d-flex align-items-center gap-1 flex-wrap" id="storyline-clip-pills">
                <button type="button" class="btn btn-sm btn-dark px-2.5 py-1 rounded-pill storyline-step-btn active" data-clip="1" style="font-size: 11.5px; border: 1px solid #0099cc; background: #0099cc; color: #fff;">
                    1. Scenario
                </button>
                <button type="button" class="btn btn-sm btn-dark px-2.5 py-1 rounded-pill storyline-step-btn" data-clip="2" style="font-size: 11.5px; border: 1px solid #1e293b; background: #0f172a; color: #94a3b8;">
                    2. Analysis
                </button>
                <button type="button" class="btn btn-sm btn-dark px-2.5 py-1 rounded-pill storyline-step-btn" data-clip="3" style="font-size: 11.5px; border: 1px solid #1e293b; background: #0f172a; color: #94a3b8;">
                    3. Live Flowchart
                </button>
                <button type="button" class="btn btn-sm btn-dark px-2.5 py-1 rounded-pill storyline-step-btn" data-clip="4" style="font-size: 11.5px; border: 1px solid #1e293b; background: #0f172a; color: #94a3b8;">
                    4. Decision Point
                </button>
                <button type="button" class="btn btn-sm btn-dark px-2.5 py-1 rounded-pill storyline-step-btn" data-clip="5" style="font-size: 11.5px; border: 1px solid #1e293b; background: #0f172a; color: #94a3b8;">
                    5. Directives
                </button>
            </div>
        </div>

        <!-- Storyline Interactive Main Canvas -->
        <div class="p-4 p-md-5 position-relative" style="min-height: 480px; display: flex; flex-direction: column; justify-content: space-between;">
            
            {{-- CLIP 1: THE SCENARIO --}}
            <div class="storyline-clip-pane" id="storyline-clip-1">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7 col-12">
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-3" style="background: #1e293b; border: 1px solid #d4af37; color: #d4af37; font-size: 11.5px; font-weight: 700;">
                            <i class="fa-solid fa-triangle-exclamation"></i> 
                            @if ($isLesson2)
                                SANCTIONS &amp; PEP INCIDENT • EXECUTIVE PRIVATE WEALTH
                            @elseif($isLesson3)
                                CONCURRENT BRANCH SMURFING • DAR ES SALAAM &amp; ZANZIBAR
                            @else
                                FLAGGED CASH DEPOSIT • STONE TOWN MAIN BRANCH
                            @endif
                        </div>
                        
                        <h2 class="fw-bold text-white mb-3" style="font-size: 1.65rem; line-height: 1.3;">
                            @if ($isLesson2)
                                Encountering a High-Risk Politically Exposed Person (PEP)
                            @elseif($isLesson3)
                                Detecting Smurfing &amp; Cash Structuring at Teller Counters
                            @else
                                Placement Stage: Unexplained Large Cash Deposit
                            @endif
                        </h2>
                        
                        <p class="text-white-50 mb-4" style="font-size: 14px; line-height: 1.7;">
                            @if ($isLesson2)
                                A high-ranking foreign government dignitary requests to establish an executive PBZ private wealth account with an upfront wire of <strong>USD $450,000</strong>. When requested for verification of ultimate beneficial ownership, the client declines and insists on diplomatic expedited courtesy.
                            @elseif($isLesson3)
                                Over a narrow 4-hour window, 6 separate individuals visit different PBZ branch counters across Dar es Salaam and Zanzibar, each depositing <strong>TZS 19,500,000</strong> in cash into the same newly opened commercial account to evade the single-transaction CTR threshold.
                            @else
                                A commercial representative arrives at the Stone Town PBZ counter carrying <strong>TZS 45,000,000</strong> in uncounted physical cash bags, seeking immediate credit into a dormant business account without commercial invoices, tax receipts, or import clearance declarations.
                            @endif
                        </p>

                        <!-- Key Note Indicators -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge px-3 py-2 rounded-2 fw-semibold" style="background: #0f172a; color: #f8fafc; font-size: 12px; border: 1px solid #334155;">
                                <i class="fa-solid fa-shield-halved me-1 text-warning"></i> BOT Statutory Rule: AMLA 2022
                            </span>
                            <span class="badge px-3 py-2 rounded-2 fw-semibold" style="background: #0f172a; color: #f8fafc; font-size: 12px; border: 1px solid #334155;">
                                <i class="fa-solid fa-clock-rotate-left me-1" style="color: #0099cc;"></i> Surveillance: Velocity Alert Active
                            </span>
                            <span class="badge px-3 py-2 rounded-2 fw-semibold" style="background: #0f172a; color: #f8fafc; font-size: 12px; border: 1px solid #334155;">
                                <i class="fa-solid fa-building-columns me-1" style="color: #4ade80;"></i> Sovereign PBZ Protocol
                            </span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-primary fw-bold px-4 py-2.5 rounded-2 d-inline-flex align-items-center gap-2 btn-next-clip" data-target-clip="2" style="background-color: #0099cc; border-color: #0099cc; font-size: 13.5px;">
                                Explore Stage Analysis <i class="fa-solid fa-arrow-right"></i>
                            </button>
                            <button type="button" class="btn btn-outline-light px-3 py-2.5 rounded-2 btn-play-narration" style="font-size: 13px; border-color: #334155;" title="Listen to Narration">
                                <i class="fa-solid fa-volume-high me-1 text-info"></i> Listen
                            </button>
                        </div>
                    </div>

                    <!-- Right Graphic Simulation Card -->
                    <div class="col-lg-5 col-12">
                        <div class="p-3.5 rounded-3 border" style="background: #0f172a; border-color: #1e293b !important;">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2" style="border-color: #1e293b !important;">
                                <span class="fw-bold text-white-50" style="font-size: 12px;">PBZ SURVEILLANCE RADAR</span>
                                <span class="badge rounded-pill px-2 py-0.5" style="background-color: #dc2626; color: #fff; font-size: 10px;">HIGH RISK FLAG</span>
                            </div>

                            <div class="d-flex flex-column gap-2 mb-3" style="font-size: 12.5px;">
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #1e293b;">
                                    <span class="text-white-50">Transaction Value:</span>
                                    <span class="fw-bold font-monospace" style="color: #d4af37;">
                                        @if ($isLesson2) USD 450,000 @elseif($isLesson3) 6 x TZS 19.5M (TZS 117M) @else TZS 45,000,000 @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #1e293b;">
                                    <span class="text-white-50">Reporting Trigger:</span>
                                    <span class="fw-bold text-white">
                                        @if ($isLesson2) PEP Tier 1 &amp; Sanctions Screening @elseif($isLesson3) Aggregate Structuring > 30M @else CTR Threshold Exceeded @endif
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #1e293b;">
                                    <span class="text-white-50">KYC Status:</span>
                                    <span class="fw-bold" style="color: #ef4444;">Beneficial Owner Unverified</span>
                                </div>
                            </div>

                            <div class="p-2.5 rounded text-white-50 text-center" style="background: #060e1e; font-size: 11.5px; border: 1px dashed #334155;">
                                <i class="fa-solid fa-circle-info me-1" style="color: #0099cc;"></i> Frontline officers must enforce verification before funds authorization.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CLIP 2: THE REGULATORY ANALYSIS --}}
            <div class="storyline-clip-pane d-none" id="storyline-clip-2">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6 col-12">
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-3" style="background: #0f172a; border: 1px solid #0099cc; color: #0099cc; font-size: 11.5px; font-weight: 700;">
                            <i class="fa-solid fa-magnifying-glass-chart"></i> STAGE 2 • REGULATORY AUDIT &amp; ANALYSIS
                        </div>
                        <h2 class="fw-bold text-white mb-3" style="font-size: 1.55rem;">
                            @if ($isLesson2)
                                PEP Risk Classification &amp; Sanctions Screening
                            @elseif($isLesson3)
                                Deconstructing Smurfing &amp; Structuring Modus Operandi
                            @else
                                Obfuscating the Audit Trail (The Layering Mechanism)
                            @endif
                        </h2>
                        <p class="text-white-50 mb-4" style="font-size: 14px; line-height: 1.65;">
                            @if ($isLesson2)
                                Under Bank of Tanzania guidelines, Politically Exposed Persons carry inherent exposure to illicit enrichment and foreign sanctions exposure. Statutory compliance mandates that PBZ verify the verified source of wealth and obtain Executive Committee sign-off.
                            @elseif($isLesson3)
                                Smurfing relies on multiple runners conducting split deposits beneath the TZS 30,000,000 reporting threshold. PBZ's real-time transaction engine aggregates customer tax identification numbers across all island and mainland branches.
                            @else
                                Once physical cash enters the bank, launderers execute high-speed serial transfers across diverse corporate accounts, foreign exchange bureaus, and offshore destinations to sever the audit trail from the originating predicate crime.
                            @endif
                        </p>

                        <!-- Key Principles Box -->
                        <div class="d-flex flex-column gap-2.5 mb-4">
                            <div class="p-2.5 rounded border d-flex align-items-center gap-3" style="background: #0f172a; border-color: #1e293b;">
                                <div style="width: 28px; height: 28px; border-radius: 6px; background: #006837; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0;">
                                    A
                                </div>
                                <div style="font-size: 12.5px;">
                                    <strong class="text-white">Statutory Obligation:</strong>
                                    <span class="text-white-50">
                                        @if ($isLesson2) Mandatory Enhanced Due Diligence (EDD) and Senior Executive sign-off. @elseif($isLesson3) Centralized aggregation triggers mandatory STR within 24 hours. @else Mandatory Currency Transaction Report (CTR) filing under Section 14 AMLA. @endif
                                    </span>
                                </div>
                            </div>
                            <div class="p-2.5 rounded border d-flex align-items-center gap-3" style="background: #0f172a; border-color: #1e293b;">
                                <div style="width: 28px; height: 28px; border-radius: 6px; background: #0099cc; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0;">
                                    B
                                </div>
                                <div style="font-size: 12.5px;">
                                    <strong class="text-white">Strict Confidentiality:</strong>
                                    <span class="text-white-50">Section 28 of Tanzanian AML Directives strictly prohibits tipping off the customer.</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary text-white-50 px-3 py-2 rounded-2 btn-next-clip" data-target-clip="1" style="font-size: 13px;">
                                <i class="fa-solid fa-arrow-left me-1"></i> Back
                            </button>
                            <button type="button" class="btn btn-primary fw-bold px-4 py-2 rounded-2 btn-next-clip" data-target-clip="3" style="background-color: #0099cc; border-color: #0099cc; font-size: 13px;">
                                View Interactive Flowchart <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <!-- Key Notes Display Card -->
                        <div class="p-3.5 rounded-3 border" style="background: #090e17; border-color: #1e293b;">
                            <div class="text-white-50 mb-3 fw-bold" style="font-size: 11.5px; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-book-bookmark me-1.5 text-warning"></i> STATUTORY KEY DIRECTIVES &amp; PRUDENTIAL CRITERIA
                            </div>
                            
                            <div class="d-flex flex-column gap-2">
                                <div class="p-2.5 rounded" style="background: #0f172a; border-left: 3px solid #0099cc;">
                                    <div class="text-white fw-bold" style="font-size: 12px;">1. Verification Before Settlement</div>
                                    <div class="text-white-50" style="font-size: 11px;">Beneficial ownership must be established using certified government registries (BRELA / BPRA).</div>
                                </div>
                                <div class="p-2.5 rounded" style="background: #0f172a; border-left: 3px solid #d4af37;">
                                    <div class="text-white fw-bold" style="font-size: 12px;">2. Source of Wealth Documentation</div>
                                    <div class="text-white-50" style="font-size: 11px;">Audited financial statements, tax clearance, or approved corporate distributions are mandatory.</div>
                                </div>
                                <div class="p-2.5 rounded" style="background: #0f172a; border-left: 3px solid #006837;">
                                    <div class="text-white fw-bold" style="font-size: 12px;">3. Direct Escalation to Compliance</div>
                                    <div class="text-white-50" style="font-size: 11px;">Frontline tellers must notify the Branch Compliance Officer within 2 hours of detection.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CLIP 3: ANIMATED SVG FLOWCHART --}}
            <div class="storyline-clip-pane d-none" id="storyline-clip-3">
                <div class="row align-items-center g-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #0f172a; border: 1px solid #006837; color: #4ade80; font-size: 11.5px; font-weight: 700;">
                                <i class="fa-solid fa-diagram-project"></i> STAGE 3 • LIVE ANIMATED BANKING FLOWCHART
                            </div>
                            <span class="text-white-50" style="font-size: 12px;">
                                <i class="fa-solid fa-circle-dot text-success me-1"></i> Live SVG Money Trail Simulation
                            </span>
                        </div>

                        <!-- Animated SVG Stage Box -->
                        <div class="p-3 p-md-4 rounded-3 border overflow-hidden position-relative" style="background: #060e1e; border-color: #1e293b;">
                            
                            @if ($isLesson1)
                                {{-- SVG Flowchart for Lesson 1.1: Placement -> Layering -> Integration --}}
                                <div class="svg-container text-center py-2" style="max-width: 900px; margin: 0 auto;">
                                    <svg viewBox="0 0 850 260" class="w-100" style="height: auto; max-height: 280px;" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <filter id="glow-cyan" x="-20%" y="-20%" width="140%" height="140%">
                                                <feDropShadow dx="0" dy="0" stdDeviation="3" flood-color="#0099cc"/>
                                            </filter>
                                            <filter id="glow-gold" x="-20%" y="-20%" width="140%" height="140%">
                                                <feDropShadow dx="0" dy="0" stdDeviation="3" flood-color="#d4af37"/>
                                            </filter>
                                            <filter id="glow-green" x="-20%" y="-20%" width="140%" height="140%">
                                                <feDropShadow dx="0" dy="0" stdDeviation="3" flood-color="#006837"/>
                                            </filter>
                                        </defs>

                                        <!-- Animated Connecting Lines -->
                                        <!-- Line 1: Placement -> Layering -->
                                        <line x1="180" y1="130" x2="350" y2="130" stroke="#0099cc" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />
                                        <!-- Line 2: Layering -> Integration -->
                                        <line x1="490" y1="130" x2="660" y2="130" stroke="#006837" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />
                                        
                                        <!-- Traveling Data Packets -->
                                        <circle r="5" fill="#d4af37">
                                            <animateMotion path="M 180,130 L 350,130" dur="2s" repeatCount="indefinite" />
                                        </circle>
                                        <circle r="5" fill="#4ade80">
                                            <animateMotion path="M 490,130 L 660,130" dur="2s" repeatCount="indefinite" />
                                        </circle>

                                        <!-- NODE 1: PLACEMENT -->
                                        <g transform="translate(40, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#d4af37" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#d4af37" font-size="11" font-weight="bold" text-anchor="middle">1. PLACEMENT</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#d4af37" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#d4af37" font-size="16" text-anchor="middle">TZS</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Physical Cash Bags</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Stone Town Counter</text>
                                        </g>

                                        <!-- NODE 2: LAYERING -->
                                        <g transform="translate(350, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#0099cc" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#0099cc" font-size="11" font-weight="bold" text-anchor="middle">2. LAYERING</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#0099cc" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#0099cc" font-size="14" text-anchor="middle">NET</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Split Wire Network</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Offshore FX Conduits</text>
                                        </g>

                                        <!-- NODE 3: INTEGRATION -->
                                        <g transform="translate(660, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#006837" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#4ade80" font-size="11" font-weight="bold" text-anchor="middle">3. INTEGRATION</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#006837" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#4ade80" font-size="14" text-anchor="middle">ASSET</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Commercial Assets</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Hotels &amp; Real Estate</text>
                                        </g>

                                        <!-- Subtitle Warning -->
                                        <text x="425" y="235" fill="#94a3b8" font-size="11" text-anchor="middle">
                                            BOT Statutory Rule: Frontline intervention at Step 1 prevents irreversible legitimization at Step 3.
                                        </text>
                                    </svg>
                                </div>

                            @elseif ($isLesson2)
                                {{-- SVG Flowchart for Lesson 1.2: Sanctions Radar & PEP Onboarding Gate --}}
                                <div class="svg-container text-center py-2" style="max-width: 900px; margin: 0 auto;">
                                    <svg viewBox="0 0 850 260" class="w-100" style="height: auto; max-height: 280px;" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Connecting Lines -->
                                        <line x1="180" y1="130" x2="350" y2="130" stroke="#0099cc" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />
                                        <line x1="490" y1="130" x2="660" y2="130" stroke="#d4af37" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />

                                        <!-- Traveling Packet -->
                                        <circle r="5" fill="#0099cc">
                                            <animateMotion path="M 180,130 L 350,130" dur="1.8s" repeatCount="indefinite" />
                                        </circle>
                                        <circle r="5" fill="#d4af37">
                                            <animateMotion path="M 490,130 L 660,130" dur="1.8s" repeatCount="indefinite" />
                                        </circle>

                                        <!-- NODE 1: PEP APPLICANT -->
                                        <g transform="translate(40, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#d4af37" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#d4af37" font-size="11" font-weight="bold" text-anchor="middle">1. PEP APPLICANT</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#d4af37" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#d4af37" font-size="14" text-anchor="middle">PEP</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">USD $450,000</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Private Wealth Request</text>
                                        </g>

                                        <!-- NODE 2: SANCTIONS RADAR -->
                                        <g transform="translate(350, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#0099cc" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#0099cc" font-size="11" font-weight="bold" text-anchor="middle">2. SCREENING RADAR</text>
                                            <!-- Rotating Radar Circle -->
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#0099cc" stroke-width="1.5" />
                                            <line x1="70" y1="65" x2="88" y2="52" stroke="#4ade80" stroke-width="2" class="svg-radar-sweep" />
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">UN / OFAC / BOT</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Watchlist Fuzzy Match</text>
                                        </g>

                                        <!-- NODE 3: SENIOR GOVERNANCE -->
                                        <g transform="translate(660, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#006837" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#4ade80" font-size="11" font-weight="bold" text-anchor="middle">3. GOVERNANCE GATE</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#006837" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#4ade80" font-size="14" text-anchor="middle">EDD</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Executive Approval</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Source of Wealth Audit</text>
                                        </g>

                                        <text x="425" y="235" fill="#94a3b8" font-size="11" text-anchor="middle">
                                            Bank of Tanzania Circular: High-risk PEP onboarding without Managing Director sign-off is null and void.
                                        </text>
                                    </svg>
                                </div>

                            @elseif ($isLesson3)
                                {{-- SVG Flowchart for Lesson 2.1: Smurfing Multi-Branch Clustering --}}
                                <div class="svg-container text-center py-2" style="max-width: 900px; margin: 0 auto;">
                                    <svg viewBox="0 0 850 260" class="w-100" style="height: auto; max-height: 280px;" xmlns="http://www.w3.org/2000/svg">
                                        <!-- 3 Left Branch Lines feeding into center -->
                                        <line x1="170" y1="70" x2="380" y2="130" stroke="#0099cc" stroke-width="2" stroke-dasharray="5,3" class="svg-animated-flow" />
                                        <line x1="170" y1="130" x2="380" y2="130" stroke="#0099cc" stroke-width="2" stroke-dasharray="5,3" class="svg-animated-flow" />
                                        <line x1="170" y1="190" x2="380" y2="130" stroke="#0099cc" stroke-width="2" stroke-dasharray="5,3" class="svg-animated-flow" />

                                        <!-- Center to Alert -->
                                        <line x1="520" y1="130" x2="680" y2="130" stroke="#dc2626" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />

                                        <!-- Traveling Packets -->
                                        <circle r="4" fill="#0099cc">
                                            <animateMotion path="M 170,70 L 380,130" dur="1.5s" repeatCount="indefinite" />
                                        </circle>
                                        <circle r="4" fill="#0099cc">
                                            <animateMotion path="M 170,130 L 380,130" dur="1.5s" repeatCount="indefinite" />
                                        </circle>
                                        <circle r="4" fill="#0099cc">
                                            <animateMotion path="M 170,190 L 380,130" dur="1.5s" repeatCount="indefinite" />
                                        </circle>
                                        <circle r="6" fill="#ef4444">
                                            <animateMotion path="M 520,130 L 680,130" dur="1.5s" repeatCount="indefinite" />
                                        </circle>

                                        <!-- LEFT MULTI-BRANCH NODES -->
                                        <g transform="translate(30, 45)">
                                            <rect width="140" height="42" rx="6" fill="#0f172a" stroke="#334155" stroke-width="1.5" />
                                            <text x="70" y="20" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">Branch 1: Stone Town</text>
                                            <text x="70" y="34" fill="#d4af37" font-size="9" text-anchor="middle">TZS 19.5M Cash</text>
                                        </g>
                                        <g transform="translate(30, 108)">
                                            <rect width="140" height="42" rx="6" fill="#0f172a" stroke="#334155" stroke-width="1.5" />
                                            <text x="70" y="20" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">Branch 2: Kariakoo</text>
                                            <text x="70" y="34" fill="#d4af37" font-size="9" text-anchor="middle">TZS 19.5M Cash</text>
                                        </g>
                                        <g transform="translate(30, 172)">
                                            <rect width="140" height="42" rx="6" fill="#0f172a" stroke="#334155" stroke-width="1.5" />
                                            <text x="70" y="20" fill="#ffffff" font-size="10" font-weight="bold" text-anchor="middle">Branch 3: Mwanakwerekwe</text>
                                            <text x="70" y="34" fill="#d4af37" font-size="9" text-anchor="middle">TZS 19.5M Cash</text>
                                        </g>

                                        <!-- CENTER PBZ AGGREGATION ENGINE -->
                                        <g transform="translate(380, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#0099cc" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#0099cc" font-size="10" font-weight="bold" text-anchor="middle">CORE BANKING</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#0099cc" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#0099cc" font-size="12" text-anchor="middle">AGG</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="10.5" font-weight="bold" text-anchor="middle">Total: TZS 117M</text>
                                            <text x="70" y="122" fill="#ef4444" font-size="9" font-weight="bold" text-anchor="middle">Breached 30M Limit</text>
                                        </g>

                                        <!-- RIGHT AUTOMATED ALERT -->
                                        <g transform="translate(680, 60)">
                                            <rect width="140" height="140" rx="10" fill="#0f172a" stroke="#dc2626" stroke-width="2" />
                                            <rect width="140" height="32" rx="10" fill="#1e293b" />
                                            <text x="70" y="21" fill="#ef4444" font-size="10" font-weight="bold" text-anchor="middle">AML TRIGGER</text>
                                            <circle cx="70" cy="65" r="22" fill="#1e293b" stroke="#dc2626" stroke-width="1.5" />
                                            <text x="70" y="70" fill="#ef4444" font-size="12" text-anchor="middle">STR</text>
                                            <text x="70" y="105" fill="#ffffff" font-size="10.5" font-weight="bold" text-anchor="middle">Mandatory STR</text>
                                            <text x="70" y="122" fill="#94a3b8" font-size="9" text-anchor="middle">Report to FIU Tanzania</text>
                                        </g>

                                        <text x="425" y="240" fill="#94a3b8" font-size="11" text-anchor="middle">
                                            Structuring Detection: Distributed deposits beneath the threshold trigger cumulative statutory reporting.
                                        </text>
                                    </svg>
                                </div>

                            @else
                                {{-- Default General Compliance Flowchart for any other module --}}
                                <div class="svg-container text-center py-2" style="max-width: 900px; margin: 0 auto;">
                                    <svg viewBox="0 0 850 240" class="w-100" style="height: auto; max-height: 260px;" xmlns="http://www.w3.org/2000/svg">
                                        <line x1="200" y1="120" x2="380" y2="120" stroke="#0099cc" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />
                                        <line x1="520" y1="120" x2="700" y2="120" stroke="#006837" stroke-width="3" stroke-dasharray="6,4" class="svg-animated-flow" />
                                        <circle r="5" fill="#0099cc"><animateMotion path="M 200,120 L 380,120" dur="2s" repeatCount="indefinite" /></circle>
                                        <circle r="5" fill="#4ade80"><animateMotion path="M 520,120 L 700,120" dur="2s" repeatCount="indefinite" /></circle>

                                        <g transform="translate(60, 50)">
                                            <rect width="140" height="130" rx="8" fill="#0f172a" stroke="#0099cc" stroke-width="1.5" />
                                            <rect width="140" height="28" rx="8" fill="#1e293b" />
                                            <text x="70" y="18" fill="#0099cc" font-size="10" font-weight="bold" text-anchor="middle">1. IDENTIFICATION</text>
                                            <text x="70" y="70" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Frontline Verification</text>
                                            <text x="70" y="95" fill="#94a3b8" font-size="9" text-anchor="middle">KYC &amp; National ID</text>
                                        </g>
                                        <g transform="translate(380, 50)">
                                            <rect width="140" height="130" rx="8" fill="#0f172a" stroke="#d4af37" stroke-width="1.5" />
                                            <rect width="140" height="28" rx="8" fill="#1e293b" />
                                            <text x="70" y="18" fill="#d4af37" font-size="10" font-weight="bold" text-anchor="middle">2. SURVEILLANCE</text>
                                            <text x="70" y="70" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Risk Profiling</text>
                                            <text x="70" y="95" fill="#94a3b8" font-size="9" text-anchor="middle">Velocity &amp; Watchlist</text>
                                        </g>
                                        <g transform="translate(700, 50)">
                                            <rect width="140" height="130" rx="8" fill="#0f172a" stroke="#006837" stroke-width="1.5" />
                                            <rect width="140" height="28" rx="8" fill="#1e293b" />
                                            <text x="70" y="18" fill="#4ade80" font-size="10" font-weight="bold" text-anchor="middle">3. RESOLUTION</text>
                                            <text x="70" y="70" fill="#ffffff" font-size="11" font-weight="bold" text-anchor="middle">Statutory Reporting</text>
                                            <text x="70" y="95" fill="#94a3b8" font-size="9" text-anchor="middle">BOT &amp; Internal Audit</text>
                                        </g>
                                    </svg>
                                </div>
                            @endif

                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-outline-secondary text-white-50 px-3 py-2 rounded-2 btn-next-clip" data-target-clip="2" style="font-size: 13px;">
                                <i class="fa-solid fa-arrow-left me-1"></i> Back to Analysis
                            </button>
                            <button type="button" class="btn btn-warning fw-bold px-4 py-2 rounded-2 btn-next-clip" data-target-clip="4" style="background-color: #d4af37; border-color: #d4af37; color: #072818; font-size: 13px;">
                                Enter Decision Checkpoint <i class="fa-solid fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CLIP 4: INTERACTIVE COMPLIANCE DECISION --}}
            <div class="storyline-clip-pane d-none" id="storyline-clip-4">
                <div class="max-w-700">
                    <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-2.5" style="background: #1e293b; border: 1px solid #d4af37; color: #d4af37; font-size: 11.5px; font-weight: 700;">
                        <i class="fa-solid fa-circle-question"></i> COMPLIANCE DECISION CHECKPOINT
                    </div>
                    <h3 class="fw-bold text-white mb-2" style="font-size: 1.35rem;">
                        @if ($isLesson2)
                            How Must You Handle the Foreign PEP Request?
                        @elseif($isLesson3)
                            What is the Frontline Protocol for Smurfing Couriers?
                        @else
                            How Must a PBZ Banking Officer Act in this Scenario?
                        @endif
                    </h3>
                    <p class="text-white-50 mb-3.5" style="font-size: 13.5px;">
                        @if ($isLesson2)
                            The foreign official demands instant VIP approval for the USD $450,000 transfer, warning that refusal will cause loss of prestigious business. Choose the compliant action:
                        @elseif($isLesson3)
                            A cashier notices the fourth individual depositing TZS 19,500,000 in physical notes to the identical corporate account within 2 hours. What should the teller do?
                        @else
                            The client visits the branch asking why their TZS 45,000,000 wire transfer is undergoing review. Select the legally compliant course of action under BOT guidelines:
                        @endif
                    </p>

                    <!-- Interactive Options -->
                    <div class="d-flex flex-column gap-2 mb-3.5">
                        @if ($isLesson2)
                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong1" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option A:</strong> Accept the deposit immediately under VIP executive waiver, promising to gather beneficial owner documents in the subsequent quarterly audit.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="correct" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option B:</strong> Politely withhold onboarding approval, initiate statutory Enhanced Due Diligence (EDD), and escalate the file for formal Managing Director / Executive Committee sign-off as required by BOT Section 19.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong2" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option C:</strong> Inform the client that they are flagged on a secret foreign intelligence watchlist and instruct them to leave the building immediately.
                                </span>
                            </label>
                        @elseif($isLesson3)
                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong1" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option A:</strong> Interrogate the courier in the middle of the banking hall and accuse them of smurfing for an organized syndicate.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="correct" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option B:</strong> Complete standard teller receipting without tipping off the courier, discreetly capture depositor ID details, and immediately trigger an urgent internal Suspicious Transaction Report (STR) with branch operations.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong2" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option C:</strong> Ignore the pattern because each individual deposit is strictly below the TZS 30M statutory reporting threshold.
                                </span>
                            </label>
                        @else
                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong1" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option A:</strong> Inform the client that an AML investigation was initiated and ask them to produce receipts immediately.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="correct" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option B:</strong> Politely explain standard processing timelines, never disclose the AML inquiry (Strict No-Tipping-Off Rule), and file a Suspicious Transaction Report (STR) internally.
                                </span>
                            </label>

                            <label class="p-3 rounded-2 border d-flex align-items-center gap-3 compliance-option-card" style="background: #0f172a; border-color: #1e293b; cursor: pointer;">
                                <input type="radio" name="dilemma_choice" value="wrong2" class="form-check-input mt-0">
                                <span style="font-size: 13px;" class="text-white">
                                    <strong>Option C:</strong> Waive the documentation request because the depositor is a VIP corporate customer.
                                </span>
                            </label>
                        @endif
                    </div>

                    <!-- Dynamic Decision Feedback Box -->
                    <div id="decision-feedback" class="p-3 rounded-2 mb-3 d-none" style="font-size: 13px;"></div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary text-white-50 px-3 py-2 rounded-2 btn-next-clip" data-target-clip="3" style="font-size: 13px;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Back
                        </button>
                        <button type="button" id="btn-validate-decision" class="btn btn-primary fw-bold px-4 py-2 rounded-2" style="background-color: #0099cc; border-color: #0099cc; font-size: 13px;">
                            Validate Decision <i class="fa-solid fa-check ms-1"></i>
                        </button>
                        <button type="button" id="btn-to-clip-5" class="btn btn-success fw-bold px-4 py-2 rounded-2 d-none btn-next-clip" data-target-clip="5" style="background-color: #006837; border-color: #006837; font-size: 13px;">
                            Proceed to Certification Summary <i class="fa-solid fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- CLIP 5: CERTIFICATION SUMMARY & TAKEAWAYS --}}
            <div class="storyline-clip-pane d-none" id="storyline-clip-5">
                <div class="max-w-750">
                    <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill mb-2.5" style="background: #0f172a; border: 1px solid #006837; color: #4ade80; font-size: 11.5px; font-weight: 700;">
                        <i class="fa-solid fa-award"></i> SOVEREIGN BANKING DIRECTIVES SUMMARY
                    </div>
                    <h2 class="fw-bold text-white mb-2" style="font-size: 1.55rem;">
                        @if ($isLesson2)
                            PEP &amp; Sanctions Governance Takeaways
                        @elseif($isLesson3)
                            Structuring &amp; Smurfing Detection Directives
                        @else
                            The Three Stages of Financial Crime Takeaways
                        @endif
                    </h2>
                    <p class="text-white-50 mb-3.5" style="font-size: 13.5px;">
                        You have explored the operational dynamics and statutory compliance obligations for People's Bank of Zanzibar:
                    </p>

                    <div class="row g-2 mb-4">
                        <div class="col-md-4 col-12">
                            <div class="p-3 rounded-2 h-100 border" style="background: #0f172a; border-color: #1e293b;">
                                <div class="fw-bold mb-1" style="color: #d4af37; font-size: 13px;">
                                    @if ($isLesson2) 1. Screening @elseif($isLesson3) 1. Smurfing Pattern @else 1. Placement @endif
                                </div>
                                <div class="text-white-50" style="font-size: 11.5px;">
                                    @if ($isLesson2)
                                        Screen all accounts against BOT, UN, and OFAC sanctions lists prior to funds receipt.
                                    @elseif($isLesson3)
                                        Multiple sub-threshold deposits within 24 hours trigger mandatory cumulative CTR.
                                    @else
                                        Physical cash entry into the banking perimeter. Mandatory CTR filing on deposits &gt; TZS 30M.
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="p-3 rounded-2 h-100 border" style="background: #0f172a; border-color: #1e293b;">
                                <div class="fw-bold mb-1" style="color: #0099cc; font-size: 13px;">
                                    @if ($isLesson2) 2. EDD Mandate @elseif($isLesson3) 2. Branch Aggregation @else 2. Layering @endif
                                </div>
                                <div class="text-white-50" style="font-size: 11.5px;">
                                    @if ($isLesson2)
                                        Tier 1 PEPs require independent Source of Wealth audit and Executive Committee approval.
                                    @elseif($isLesson3)
                                        Unified core banking monitors customer tax IDs across all island and mainland branches.
                                    @else
                                        Complex multi-tier wire transfers, shell entities, and FX bureaus to sever audit trails.
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="p-3 rounded-2 h-100 border" style="background: #0f172a; border-color: #1e293b;">
                                <div class="fw-bold mb-1" style="color: #4ade80; font-size: 13px;">
                                    @if ($isLesson2) 3. Continuous Monitoring @elseif($isLesson3) 3. No Tipping Off @else 3. Integration @endif
                                </div>
                                <div class="text-white-50" style="font-size: 11.5px;">
                                    @if ($isLesson2)
                                        Approved PEP accounts remain under enhanced automated quarterly transaction audits.
                                    @elseif($isLesson3)
                                        Never interrogate couriers directly; file internal STR silently to safeguard staff and data.
                                    @else
                                        Absorption into legitimate real estate or corporate equity. Tipping off is a criminal offense.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2.5 align-items-center">
                        <button type="button" class="btn btn-outline-secondary text-white-50 px-3 py-2 rounded-2 btn-next-clip" data-target-clip="4" style="font-size: 13px;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Review Decision
                        </button>
                        <button type="button" id="btn-storyline-complete-advance" class="btn btn-success fw-bold px-4 py-2.5 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #006837; border-color: #006837; font-size: 13.5px;">
                            <i class="fa-solid fa-circle-check"></i> Complete Lesson &amp; Advance to Next
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Video Player Scrubber & Narration Controller Bar (Bottom) -->
        <div class="p-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #060e1e; border-color: #1e293b !important;">
            <div class="d-flex align-items-center gap-3">
                <!-- Play/Pause Auto-Scrubber -->
                <button type="button" id="btn-storyline-playpause" class="btn btn-sm btn-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #0099cc; border: none; color: #fff;" title="Auto-Play Storyline">
                    <i class="fa-solid fa-play" id="playpause-icon" style="font-size: 13px; margin-left: 2px;"></i>
                </button>

                <!-- Voice Narration Button with Visualizer -->
                <button type="button" id="btn-toggle-narration" class="btn btn-sm btn-dark px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-2" style="border: 1px solid #334155; background: #0f172a; color: #ffffff; font-size: 12px;">
                    <i class="fa-solid fa-volume-high text-info" id="narration-speaker-icon"></i>
                    <span id="narration-status-text">Narration: Voice On</span>
                    <span class="audio-wave-visualizer d-none" id="audio-wave-bars">
                        <span class="bar bar-1"></span>
                        <span class="bar bar-2"></span>
                        <span class="bar bar-3"></span>
                        <span class="bar bar-4"></span>
                    </span>
                </button>

                <div class="text-white-50 font-monospace d-none d-sm-block" id="storyline-time-display" style="font-size: 11.5px;">
                    Clip <span id="current-clip-num" class="text-white fw-bold">1</span> of 5
                </div>
            </div>

            <!-- Animated Scrubber Track -->
            <div class="flex-grow-1 mx-2" style="max-width: 400px; min-width: 140px;">
                <div class="progress rounded-pill" style="height: 6px; background-color: #1e293b; cursor: pointer;" id="storyline-progress-track">
                    <div class="progress-bar rounded-pill" id="storyline-progress-bar" role="progressbar" style="width: 20%; background-color: #0099cc; transition: width 0.3s ease;"></div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="badge px-2.5 py-1 rounded-pill" style="background: #0f172a; color: #94a3b8; border: 1px solid #1e293b; font-size: 11px;">
                    <i class="fa-solid fa-tv me-1 text-info"></i> HD 1080p Interactive
                </span>
            </div>
        </div>

    </div>
    @endif

    <!-- Navigation Action Bar (directly beneath the stage) -->
    <div class="learning-nav-toolbar p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 shadow-none" style="border-color: #e2e8f0 !important;">
        <button type="button" id="prev-btn" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" style="font-size: 12.5px;">
            <i class="fa-solid fa-chevron-left" style="font-size: 10px;"></i> Previous
        </button>

        <div class="learning-item-counter fw-bold text-muted text-center" id="learning-item-counter" style="font-size: 12.5px;">
            <span id="current-item-indicator" class="text-dark">{{ $lesson->title }}</span>
        </div>

        <button type="button" id="next-btn" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
            Next <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
        </button>
    </div>

    <!-- Lesson Title & Mark-Complete Action Bar -->
    <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0 !important;">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex align-items-center flex-wrap gap-2 mb-1.5">
                    <span class="badge bg-light text-muted border px-2 py-0.5 rounded-pill" style="font-size: 11px;">
                        {{ $lesson->topic->title ?? 'Curriculum' }}
                    </span>
                    @if ($lesson->formatted_duration)
                        <span class="badge bg-light text-muted border px-2 py-0.5 rounded-pill" style="font-size: 11px;">
                            <i class="fa-regular fa-clock me-1 text-success"></i> {{ $lesson->formatted_duration }} min
                        </span>
                    @endif
                    <span class="badge bg-success-subtle text-success border border-success px-2 py-0.5 rounded-pill" style="font-size: 11px;">
                        <i class="fa-solid fa-shield-halved me-1"></i> BOT Compliance Standard
                    </span>
                </div>

                <h4 class="fw-bold mb-0" id="current-item-title" style="font-size: 1.15rem; color: #0f172a;">
                    {{ $lesson->title }}
                </h4>
            </div>

            <!-- Mark Complete Action Button -->
            <div class="flex-shrink-0">
                <button id="mark-complete-btn" class="btn btn-sm fw-bold rounded-2 px-3 py-2 d-inline-flex align-items-center gap-1.5"
                    data-lesson-id="{{ $lesson->id }}"
                    data-course-id="{{ $lesson->topic->course_id }}"
                    @if ($progress && $progress->is_completed)
                        disabled style="background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; cursor: default; font-size: 13px;"
                    @else
                        style="background-color: #006837; border-color: #006837; color: #ffffff; font-size: 13px;"
                    @endif>
                    @if ($progress && $progress->is_completed)
                        <i class="fa-solid fa-circle-check"></i> Completed
                    @else
                        <i class="fa-solid fa-check"></i> Mark as Complete
                    @endif
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Tabbed Content: Overview, Discussion, Resources, Notes -->
    <div class="card border rounded-3 bg-white shadow-none" style="border-color: #e2e8f0 !important;">
        <!-- Tab Navigation Bar -->
        <div class="card-header bg-white border-bottom px-3 pt-2 pb-0" style="border-color: #e2e8f0 !important;">
            <ul class="nav nav-tabs border-0 gap-1" id="lessonTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-3 py-2.5 fw-bold border-0 border-bottom border-2" id="tab-overview-btn" data-bs-toggle="tab" data-bs-target="#tab-overview-pane" type="button" role="tab" style="font-size: 13px; color: #006837; border-color: #006837 !important;">
                        <i class="fa-solid fa-align-left me-1.5"></i> Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-3 py-2.5 fw-bold border-0 border-bottom border-2 text-muted" id="tab-discussion-btn" data-bs-toggle="tab" data-bs-target="#tab-discussion-pane" type="button" role="tab" style="font-size: 13px; border-color: transparent !important;" onclick="if(typeof loadDiscussions === 'function') loadDiscussions();">
                        <i class="fa-regular fa-comments me-1.5"></i> Discussion Forum
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-3 py-2.5 fw-bold border-0 border-bottom border-2 text-muted" id="tab-resources-btn" data-bs-toggle="tab" data-bs-target="#tab-resources-pane" type="button" role="tab" style="font-size: 13px; border-color: transparent !important;">
                        <i class="fa-regular fa-folder-open me-1.5"></i> Resources
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-3 py-2.5 fw-bold border-0 border-bottom border-2 text-muted" id="tab-notes-btn" data-bs-toggle="tab" data-bs-target="#tab-notes-pane" type="button" role="tab" style="font-size: 13px; border-color: transparent !important;">
                        <i class="fa-regular fa-note-sticky me-1.5"></i> My Notes
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Panes -->
        <div class="card-body p-4">
            <div class="tab-content" id="lessonTabContent">
                <!-- Overview Pane with Horizontal Sub-Sections -->
                <div class="tab-pane fade show active" id="tab-overview-pane" role="tabpanel">
                    
                    <!-- Horizontal Sub-Nav Stepper Pills for Lesson Sections -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom" style="border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-1.5 flex-wrap" id="lesson-overview-pills">
                            <button type="button" class="btn btn-sm overview-substep-btn active" data-substep="1" id="substep-pill-1" style="font-size: 11.5px; border-radius: 20px; padding: 4px 13px; font-weight: 600; background: #006837; color: #ffffff; border: 1px solid #006837;">
                                1. Module Scope
                            </button>
                            <button type="button" class="btn btn-sm overview-substep-btn" data-substep="2" id="substep-pill-2" style="font-size: 11.5px; border-radius: 20px; padding: 4px 13px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                                2. {{ $isLesson1 ? 'The Three Stages' : ($isLesson2 ? 'Sanctions & PEP Criteria' : ($isLesson3 ? 'Smurfing Patterns' : 'Core Directives')) }}
                            </button>
                            <button type="button" class="btn btn-sm overview-substep-btn" data-substep="3" id="substep-pill-3" style="font-size: 11.5px; border-radius: 20px; padding: 4px 13px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                                3. Frontline Red Flags
                            </button>
                            <button type="button" class="btn btn-sm overview-substep-btn" data-substep="4" id="substep-pill-4" style="font-size: 11.5px; border-radius: 20px; padding: 4px 13px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                                4. Mandatory Reporting &amp; Faculty
                            </button>
                        </div>

                        <span class="text-muted font-monospace" style="font-size: 11.5px;">
                            Section <span id="overview-current-step-num" class="fw-bold text-dark">1</span> of 4
                        </span>
                    </div>

                    <!-- SUB-STEP 1: Module Scope & Framework -->
                    <div class="overview-substep-pane" id="overview-substep-1">
                        <div class="p-3.5 rounded-3 border mb-3" style="background: #f8fafc; border-color: #e2e8f0;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div style="width: 32px; height: 32px; border-radius: 6px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <h5 class="fw-bold text-success mb-0" style="font-size: 14.5px;">PBZ AML/CFT Compliance Learning Module</h5>
                            </div>
                            <p class="mb-0 text-muted" style="font-size: 13.5px; line-height: 1.65;">
                                This module covers the core anatomy of financial crime and establishes the mandatory detection standards required of all People's Bank of Zanzibar personnel under the Anti-Money Laundering Act.
                            </p>
                        </div>

                        <!-- Regulatory Standard Badge Card -->
                        <div class="p-3 rounded-2 border d-flex align-items-center gap-3" style="background: #ffffff; border-color: #e2e8f0 !important;">
                            <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0;">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">Bank of Tanzania (BOT) Regulatory Standard</div>
                                <div class="text-muted" style="font-size: 12px;">This curriculum is benchmarked to BOT circulars, AML/CFT compliance frameworks, and PBZ sovereign banking guidelines.</div>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-STEP 2: The Three Lifecycle Stages / Core Directives -->
                    <div class="overview-substep-pane d-none" id="overview-substep-2">
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 14px;">
                            1. The Three Lifecycle Stages of Money Laundering
                        </h5>
                        <p class="text-muted mb-3" style="font-size: 13px; line-height: 1.6;">
                            Money laundering is the illicit process of disguising the origins of illegally obtained proceeds to make them appear legitimate. FATF and the Bank of Tanzania (BOT) identify three distinct stages:
                        </p>

                        <div class="row g-2.5">
                            <div class="col-md-4 col-12">
                                <div class="card h-100 border p-3 rounded-3" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                    <span class="badge fw-bold px-2 py-0.5 rounded-pill mb-2 align-self-start" style="background: #16a34a; color: #fff; font-size: 10.5px;">Stage 1</span>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">Placement</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        The physical entry of illicit cash into the formal financial system. Tellers encounter this through excessive cash deposits or currency exchanges.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="card h-100 border p-3 rounded-3" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                    <span class="badge fw-bold px-2 py-0.5 rounded-pill mb-2 align-self-start" style="background: #0099cc; color: #fff; font-size: 10.5px;">Stage 2</span>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">Layering</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        Concealing the audit trail through rapid, complex cross-border transfers, multiple shell companies, offshore accounts, and bank intermediaries.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="card h-100 border p-3 rounded-3" style="background: #fefce8; border-color: #fef08a !important;">
                                    <span class="badge fw-bold px-2 py-0.5 rounded-pill mb-2 align-self-start" style="background: #d4af37; color: #081226; font-size: 10.5px;">Stage 3</span>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">Integration</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        The cleansed funds re-enter the mainstream economy as legitimate investments: luxury beachfront resorts in Zanzibar, corporate real estate, or commercial assets.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-STEP 3: Frontline Red Flags for PBZ Branch Staff -->
                    <div class="overview-substep-pane d-none" id="overview-substep-3">
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 14px;">
                            2. Frontline Red Flags for PBZ Branch Staff
                        </h5>
                        <p class="text-muted mb-3" style="font-size: 13px;">
                            Frontline counter officers and relationship managers must maintain active vigilance for the following key indicators:
                        </p>

                        <div class="row g-2.5">
                            <div class="col-md-4 col-12">
                                <div class="p-3 rounded-3 border h-100" style="background: #ffffff; border-color: #e2e8f0;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fa-solid fa-triangle-exclamation text-warning" style="font-size: 15px;"></i>
                                        <strong class="text-dark" style="font-size: 12.5px;">Unusual Cash Volumes</strong>
                                    </div>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        Customers depositing amounts consistently just below the mandatory TZS 20,000,000 or TZS 30,000,000 statutory reporting threshold.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="p-3 rounded-3 border h-100" style="background: #ffffff; border-color: #e2e8f0;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fa-solid fa-user-shield text-primary" style="font-size: 15px;"></i>
                                        <strong class="text-dark" style="font-size: 12.5px;">Reluctance to Disclose</strong>
                                    </div>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        Reluctance or refusal to provide audited financials, national identification (NIDA / Zanzibar Resident ID), or beneficial ownership details.
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="p-3 rounded-3 border h-100" style="background: #ffffff; border-color: #e2e8f0;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fa-solid fa-users text-danger" style="font-size: 15px;"></i>
                                        <strong class="text-dark" style="font-size: 12.5px;">Third-Party Conductors</strong>
                                    </div>
                                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.55;">
                                        Unrelated third parties repeatedly depositing cash or endorsing cheques into corporate accounts without formal authorization.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SUB-STEP 4: Mandatory Reporting Obligation & Faculty -->
                    <div class="overview-substep-pane d-none" id="overview-substep-4">
                        <div class="p-3.5 rounded-3 border mb-3" style="background: #eff6ff; border-color: #bfdbfe;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fa-solid fa-circle-exclamation text-primary" style="font-size: 16px;"></i>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 13.5px;">Mandatory Reporting Obligation</h6>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 12.5px; line-height: 1.6;">
                                If you detect any transaction exhibiting layering or placement anomalies, do NOT tip off the customer. Immediately submit an Internal Suspicious Activity Report (SAR) via the PBZ Compliance Intranet within 24 hours.
                            </p>
                        </div>

                        <!-- Instructor Info Snippet -->
                        <div class="d-flex align-items-center gap-3 p-3 rounded-2 border" style="background: #ffffff; border-color: #e2e8f0 !important;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #006837; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 700; flex-shrink: 0;">
                                PBZ
                            </div>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">PBZ Academy Faculty</div>
                                <div class="text-muted" style="font-size: 12px;">People's Bank of Zanzibar — Executive Learning &amp; Development</div>
                            </div>
                        </div>
                    </div>

                    <!-- Overview Sub-Section Horizontal Controls -->
                    <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top" style="border-color: #e2e8f0;">
                        <button type="button" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" id="btn-prev-substep" disabled style="font-size: 12px;">
                            <i class="fa-solid fa-arrow-left"></i> Previous Section
                        </button>

                        <button type="button" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" id="btn-next-substep" style="background-color: #006837; border-color: #006837; font-size: 12px;">
                            Next Section <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>

                </div>

                <!-- Discussion Forum Pane -->
                <div class="tab-pane fade" id="tab-discussion-pane" role="tabpanel">
                    <div id="forum-container">
                        <div class="text-center py-4 text-muted">
                            <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                            <div style="font-size: 13px;">Loading discussions...</div>
                        </div>
                    </div>
                </div>

                <!-- Resources Pane -->
                <div class="tab-pane fade" id="tab-resources-pane" role="tabpanel">
                    <div class="d-flex flex-column gap-2.5">
                        <div class="p-3 rounded-2 border d-flex align-items-center justify-content-between" style="border-color: #e2e8f0; background: #f8fafc;">
                            <div class="d-flex align-items-center gap-2.5">
                                <i class="fa-solid fa-file-pdf text-danger" style="font-size: 20px;"></i>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 13px;">PBZ AML/CFT Compliance Handbook 2026.pdf</div>
                                    <div class="text-muted" style="font-size: 11.5px;">Official Regulatory Reference • 2.4 MB</div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-2 px-3" style="font-size: 12px;">
                                <i class="fa-solid fa-download me-1"></i> Download
                            </a>
                        </div>
                        <div class="p-3 rounded-2 border d-flex align-items-center justify-content-between" style="border-color: #e2e8f0; background: #f8fafc;">
                            <div class="d-flex align-items-center gap-2.5">
                                <i class="fa-solid fa-file-lines text-primary" style="font-size: 20px; color: #0099cc !important;"></i>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size: 13px;">Bank of Tanzania Anti-Money Laundering Directives.pdf</div>
                                    <div class="text-muted" style="font-size: 11.5px;">Statutory Document • 1.8 MB</div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-secondary rounded-2 px-3" style="font-size: 12px;">
                                <i class="fa-solid fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notes Pane -->
                <div class="tab-pane fade" id="tab-notes-pane" role="tabpanel">
                    <div class="mb-3">
                        <label for="student-lesson-notes" class="form-label fw-bold text-dark" style="font-size: 13px;">
                            Personal Lesson Notes
                        </label>
                        <textarea id="student-lesson-notes" class="form-control rounded-2 p-3" rows="6" placeholder="Take private notes during this lesson. Your notes are automatically saved to your browser..." style="font-size: 13px; border-color: #cbd5e1;"></textarea>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span id="notes-save-status" class="text-muted" style="font-size: 12px;">
                            <i class="fa-solid fa-cloud-arrow-up me-1 text-success"></i> Auto-saved locally
                        </span>
                        <button type="button" class="btn btn-sm btn-primary rounded-2 px-3 py-1.5 fw-semibold" style="background-color: #0099cc; border-color: #0099cc; font-size: 12px;" onclick="saveStudentNotes({{ $lesson->id }})">
                            Save Notes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animated SVG Flowchart Keyframes */
    @keyframes svgFlowDash {
        from {
            stroke-dashoffset: 20;
        }
        to {
            stroke-dashoffset: 0;
        }
    }
    .svg-animated-flow {
        animation: svgFlowDash 1.2s linear infinite;
    }

    @keyframes radarSweepAngle {
        0% { transform: rotate(0deg); transform-origin: 70px 65px; }
        100% { transform: rotate(360deg); transform-origin: 70px 65px; }
    }
    .svg-radar-sweep {
        animation: radarSweepAngle 2s linear infinite;
    }

    /* Equalizer Sound Waves */
    .audio-wave-visualizer {
        display: inline-flex;
        align-items: flex-end;
        gap: 2px;
        height: 14px;
        vertical-align: middle;
    }
    .audio-wave-visualizer .bar {
        width: 2.5px;
        background: #0099cc;
        border-radius: 1px;
        animation: wavePulse 0.8s ease-in-out infinite alternate;
    }
    .audio-wave-visualizer .bar-1 { height: 4px; animation-delay: 0.1s; }
    .audio-wave-visualizer .bar-2 { height: 12px; animation-delay: 0.3s; }
    .audio-wave-visualizer .bar-3 { height: 8px; animation-delay: 0.2s; }
    .audio-wave-visualizer .bar-4 { height: 14px; animation-delay: 0.4s; }
    @keyframes wavePulse {
        0% { height: 3px; }
        100% { height: 14px; }
    }
</style>

<script>
    // Pure Vanilla JS for Storyline Clip Switching, Auto-Scrubber, Audio Narration
    (function() {
        var currentClip = 1;
        var totalClips = 5;
        var autoPlayInterval = null;
        var isPlaying = false;
        var speechSynth = window.speechSynthesis;
        var currentUtterance = null;
        var isNarrating = false;

        // Clip narration scripts tailored to the lesson
        var isL1 = {{ $isLesson1 ? 'true' : 'false' }};
        var isL2 = {{ $isLesson2 ? 'true' : 'false' }};
        var isL3 = {{ $isLesson3 ? 'true' : 'false' }};

        var narrationTexts = {
            1: isL2 ? "In this scenario, a foreign senior official requests to establish a private wealth account with four hundred and fifty thousand dollars, while declining to verify beneficial ownership."
                    : (isL3 ? "Over a four-hour window, six separate customers make cash deposits of nineteen point five million shillings each to the same corporate account across different branches to evade reporting."
                            : "At the Stone Town branch counter, a representative seeks to deposit forty-five million shillings in physical cash bags into a dormant account without commercial invoices."),
            2: isL2 ? "Under Bank of Tanzania directives, Politically Exposed Persons present inherent corruption risks requiring mandatory Enhanced Due Diligence and Senior Management sign-off."
                    : (isL3 ? "This is cash structuring or smurfing. Launderers split large funds to evade the thirty million statutory threshold. PBZ unified core banking aggregates customer IDs across all branches."
                            : "In the layering stage, launderers execute multiple split transfers across business entities and foreign exchange bureaus to sever the audit trail from the criminal origin."),
            3: isL2 ? "Observe the live screening radar: the account applicant is matched against United Nations and Bank of Tanzania watchlists, routing the application through the executive governance gate."
                    : (isL3 ? "Observe the multi-branch flow: deposits from Stone Town, Kariakoo, and Mwanakwerekwe converge into PBZ core banking, triggering an automatic Suspicious Transaction Report."
                            : "Observe the money trail from cash vault placement to wire layering, culminating in commercial real estate integration where detection becomes nearly impossible."),
            4: isL2 ? "Now, evaluate your compliance decision. How must you respond to the foreign official demanding an urgent VIP onboarding waiver?"
                    : (isL3 ? "Now, evaluate your frontline protocol. What should a PBZ cashier do upon detecting repeated structuring deposits?"
                            : "Now, evaluate your statutory duty under Bank of Tanzania regulations when a customer questions an AML review delay."),
            5: isL2 ? "Key takeaways: Always screen against sanctions watchlists, verify the source of wealth, enforce Senior Management sign-off, and never bypass controls for VIP individuals."
                    : (isL3 ? "Key directives: Watch for structured amounts just below reporting limits, observe rapid branch-hopping behaviors, and rely on PBZ's unified AML reporting portal."
                            : "Key takeaways: Frontline tellers are PBZ's primary defense shield. Never tip off account holders and always file internal reports within statutory deadlines.")
        };

        var stepBtns = document.querySelectorAll('.storyline-step-btn');
        var clipPanes = document.querySelectorAll('.storyline-clip-pane');
        var progressBar = document.getElementById('storyline-progress-bar');
        var currentClipNumEl = document.getElementById('current-clip-num');
        var playPauseBtn = document.getElementById('btn-storyline-playpause');
        var playPauseIcon = document.getElementById('playpause-icon');
        var narrationBtn = document.getElementById('btn-toggle-narration');
        var narrationStatusText = document.getElementById('narration-status-text');
        var audioWaveBars = document.getElementById('audio-wave-bars');
        var narrationSpeakerIcon = document.getElementById('narration-speaker-icon');

        function speakText(text) {
            if (!speechSynth) return;
            speechSynth.cancel();
            if (!text) return;

            currentUtterance = new SpeechSynthesisUtterance(text);
            currentUtterance.rate = 1.0;
            currentUtterance.pitch = 1.0;

            currentUtterance.onstart = function() {
                isNarrating = true;
                if (audioWaveBars) audioWaveBars.classList.remove('d-none');
                if (narrationSpeakerIcon) narrationSpeakerIcon.className = 'fa-solid fa-volume-high text-success';
                if (narrationStatusText) narrationStatusText.textContent = 'Speaking...';
            };

            currentUtterance.onend = function() {
                isNarrating = false;
                if (audioWaveBars) audioWaveBars.classList.add('d-none');
                if (narrationSpeakerIcon) narrationSpeakerIcon.className = 'fa-solid fa-volume-high text-info';
                if (narrationStatusText) narrationStatusText.textContent = 'Voice Ready';
            };

            currentUtterance.onerror = function() {
                isNarrating = false;
                if (audioWaveBars) audioWaveBars.classList.add('d-none');
                if (narrationStatusText) narrationStatusText.textContent = 'Voice Ready';
            };

            speechSynth.speak(currentUtterance);
        }

        function activateClip(clipNum, shouldSpeak) {
            currentClip = parseInt(clipNum);
            clipPanes.forEach(function(pane) {
                pane.classList.add('d-none');
            });

            var targetPane = document.getElementById('storyline-clip-' + currentClip);
            if (targetPane) {
                targetPane.classList.remove('d-none');
            }

            stepBtns.forEach(function(btn) {
                if (btn.getAttribute('data-clip') == currentClip) {
                    btn.classList.add('active');
                    btn.style.backgroundColor = '#0099cc';
                    btn.style.borderColor = '#0099cc';
                    btn.style.color = '#ffffff';
                } else {
                    btn.classList.remove('active');
                    btn.style.backgroundColor = '#0f172a';
                    btn.style.borderColor = '#1e293b';
                    btn.style.color = '#94a3b8';
                }
            });

            if (progressBar) {
                progressBar.style.width = (currentClip * 20) + '%';
            }
            if (currentClipNumEl) {
                currentClipNumEl.textContent = currentClip;
            }

            if (shouldSpeak && narrationTexts[currentClip]) {
                speakText(narrationTexts[currentClip]);
            }
        }

        stepBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                stopAutoPlay();
                var cNum = this.getAttribute('data-clip');
                activateClip(cNum, isNarrating);
            });
        });

        document.querySelectorAll('.btn-next-clip').forEach(function(btn) {
            btn.addEventListener('click', function() {
                stopAutoPlay();
                var cNum = this.getAttribute('data-target-clip');
                activateClip(cNum, isNarrating);
            });
        });

        // Narration toggle
        if (narrationBtn) {
            narrationBtn.addEventListener('click', function() {
                if (isNarrating) {
                    if (speechSynth) speechSynth.cancel();
                    isNarrating = false;
                    if (audioWaveBars) audioWaveBars.classList.add('d-none');
                    if (narrationStatusText) narrationStatusText.textContent = 'Voice Paused';
                    if (narrationSpeakerIcon) narrationSpeakerIcon.className = 'fa-solid fa-volume-xmark text-muted';
                } else {
                    isNarrating = true;
                    if (narrationSpeakerIcon) narrationSpeakerIcon.className = 'fa-solid fa-volume-high text-info';
                    if (narrationTexts[currentClip]) {
                        speakText(narrationTexts[currentClip]);
                    }
                }
            });
        }

        // Play / Pause Auto Presentation
        function startAutoPlay() {
            isPlaying = true;
            if (playPauseIcon) playPauseIcon.className = 'fa-solid fa-pause';
            if (playPauseBtn) playPauseBtn.style.backgroundColor = '#d4af37';
            
            // Speak current clip
            speakText(narrationTexts[currentClip]);

            autoPlayInterval = setInterval(function() {
                if (currentClip < totalClips) {
                    activateClip(currentClip + 1, true);
                } else {
                    stopAutoPlay();
                }
            }, 8500);
        }

        function stopAutoPlay() {
            isPlaying = false;
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
                autoPlayInterval = null;
            }
            if (playPauseIcon) playPauseIcon.className = 'fa-solid fa-play';
            if (playPauseBtn) playPauseBtn.style.backgroundColor = '#0099cc';
        }

        if (playPauseBtn) {
            playPauseBtn.addEventListener('click', function() {
                if (isPlaying) {
                    stopAutoPlay();
                    if (speechSynth) speechSynth.cancel();
                } else {
                    startAutoPlay();
                }
            });
        }

        // Decision validation
        var valBtn = document.getElementById('btn-validate-decision');
        if (valBtn) {
            valBtn.addEventListener('click', function() {
                var selected = document.querySelector('input[name="dilemma_choice"]:checked');
                var feedbackBox = document.getElementById('decision-feedback');
                var advanceBtn = document.getElementById('btn-to-clip-5');

                if (!selected) {
                    feedbackBox.className = 'p-3 rounded-2 mb-3 bg-warning-subtle text-dark border border-warning';
                    feedbackBox.innerHTML = '<strong>Please select an option first</strong> to evaluate your compliance action.';
                    feedbackBox.classList.remove('d-none');
                    return;
                }

                if (selected.value === 'correct') {
                    feedbackBox.className = 'p-3 rounded-2 mb-3 bg-success-subtle text-success border border-success fw-medium';
                    feedbackBox.innerHTML = '<div class="fw-bold fs-6 mb-1"><i class="fa-solid fa-circle-check me-1"></i> CORRECT STATUTORY ACTION!</div>Under Bank of Tanzania AML Regulations, complying with mandatory protocols (discreet reporting, EDD sign-off, and strict no-tipping-off) protects PBZ Bank and adheres to sovereign directives.';
                    feedbackBox.classList.remove('d-none');
                    if (advanceBtn) advanceBtn.classList.remove('d-none');
                    this.classList.add('d-none');
                    speakText("Excellent. Your decision strictly complies with Bank of Tanzania statutory guidelines.");
                } else {
                    feedbackBox.className = 'p-3 rounded-2 mb-3 bg-danger-subtle text-danger border border-danger';
                    feedbackBox.innerHTML = '<div class="fw-bold fs-6 mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> NON-COMPLIANT CHOICE</div>Tipping-off, granting unauthorized VIP documentation waivers, or confronting couriers are severe regulatory violations under BOT directives. Please select the legally compliant response.';
                    feedbackBox.classList.remove('d-none');
                    speakText("Non compliant choice. Please select the legally compliant response.");
                }
            });
        }

        // Complete & advance
        var finishAdvanceBtn = document.getElementById('btn-storyline-complete-advance');
        if (finishAdvanceBtn) {
            finishAdvanceBtn.addEventListener('click', function() {
                if (speechSynth) speechSynth.cancel();
                var markBtn = document.getElementById('mark-complete-btn');
                if (markBtn && !markBtn.disabled) {
                    markBtn.click();
                }
                setTimeout(function() {
                    var nextBtn = document.getElementById('next-btn');
                    if (nextBtn) {
                        nextBtn.click();
                    }
                }, 400);
            });
        }

        // Horizontal Overview Sub-Step Navigation
        var currentSubstep = 1;
        var totalSubsteps = 4;
        var substepPills = document.querySelectorAll('.overview-substep-btn');
        var substepPanes = document.querySelectorAll('.overview-substep-pane');
        var prevSubstepBtn = document.getElementById('btn-prev-substep');
        var nextSubstepBtn = document.getElementById('btn-next-substep');
        var curStepNum = document.getElementById('overview-current-step-num');

        function activateSubstep(stepNum) {
            currentSubstep = parseInt(stepNum);
            if (currentSubstep < 1) currentSubstep = 1;
            if (currentSubstep > totalSubsteps) currentSubstep = totalSubsteps;

            substepPanes.forEach(function(pane) {
                pane.classList.add('d-none');
            });
            var targetPane = document.getElementById('overview-substep-' + currentSubstep);
            if (targetPane) targetPane.classList.remove('d-none');

            substepPills.forEach(function(pill) {
                if (parseInt(pill.getAttribute('data-substep')) === currentSubstep) {
                    pill.style.background = '#006837';
                    pill.style.borderColor = '#006837';
                    pill.style.color = '#ffffff';
                } else {
                    pill.style.background = '#f8fafc';
                    pill.style.borderColor = '#cbd5e1';
                    pill.style.color = '#64748b';
                }
            });

            if (curStepNum) curStepNum.textContent = currentSubstep;
            if (prevSubstepBtn) prevSubstepBtn.disabled = (currentSubstep === 1);
            if (nextSubstepBtn) {
                nextSubstepBtn.disabled = (currentSubstep === totalSubsteps);
            }
        }

        substepPills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                var s = this.getAttribute('data-substep');
                activateSubstep(s);
            });
        });

        if (prevSubstepBtn) {
            prevSubstepBtn.addEventListener('click', function() {
                if (currentSubstep > 1) {
                    activateSubstep(currentSubstep - 1);
                }
            });
        }

        if (nextSubstepBtn) {
            nextSubstepBtn.addEventListener('click', function() {
                if (currentSubstep < totalSubsteps) {
                    activateSubstep(currentSubstep + 1);
                }
            });
        }

        // Tab styling
        var tabButtons = document.querySelectorAll('#lessonTabs button[data-bs-toggle="tab"]');
        tabButtons.forEach(function(btn) {
            btn.addEventListener('shown.bs.tab', function(e) {
                tabButtons.forEach(function(b) {
                    b.classList.remove('border-bottom');
                    b.classList.add('text-muted');
                    b.style.borderColor = 'transparent';
                });
                e.target.classList.remove('text-muted');
                e.target.classList.add('border-bottom');
                e.target.style.borderColor = '#006837';
            });
        });

        // Notes local saving
        var noteKey = 'pbz_notes_lesson_{{ $lesson->id }}';
        var notesEl = document.getElementById('student-lesson-notes');
        var statusEl = document.getElementById('notes-save-status');
        if (notesEl) {
            var saved = localStorage.getItem(noteKey);
            if (saved) notesEl.value = saved;
            notesEl.addEventListener('input', function() {
                localStorage.setItem(noteKey, this.value);
                if (statusEl) statusEl.innerHTML = '<i class="fa-solid fa-check text-success me-1"></i> Saved';
            });
        }
    })();

    function saveStudentNotes(id) {
        var el = document.getElementById('student-lesson-notes');
        if (el) {
            localStorage.setItem('pbz_notes_lesson_' + id, el.value);
            var st = document.getElementById('notes-save-status');
            if (st) st.innerHTML = '<span class="text-success fw-bold"><i class="fa-solid fa-check me-1"></i> Saved!</span>';
        }
    }
</script>

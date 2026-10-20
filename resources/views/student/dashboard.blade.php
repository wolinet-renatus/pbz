@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => __('student.dashboard') ?? 'Dashboard'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">

            <!-- PBZ Automated Compliance & Countdown Alert Banner (Submarine Blue & Cyan) -->
            <div class="alert d-flex align-items-center justify-content-between p-3 mb-3 rounded-3 shadow-sm border" style="background: linear-gradient(135deg, #091a2e 0%, #0d2847 50%, #0c3358 100%); color: #ffffff; border-left: 4px solid #00c0f3 !important; border-color: rgba(56, 189, 248, 0.25) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="fs-4" style="color: #00d2ff;"><i class="fa-solid fa-scale-balanced"></i></div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0 text-white fw-bold" style="font-size: 13.5px;">Bank of Tanzania (BOT) Compliance Engine Active</h6>
                            <span class="badge rounded-pill" style="background: rgba(0, 210, 255, 0.15); color: #38bdf8; border: 1px solid rgba(0, 210, 255, 0.35); font-size: 10px; font-weight: 700;">AUDIT TRACKING</span>
                        </div>
                        <p class="mb-0 text-white-50" style="font-size: 12px;">
                            Statutory AML/CFT &amp; KYC countdowns active for {{ Auth::user()->branch->name ?? 'Zanzibar Branch' }}. Complete modules before deadline to avoid managerial escalation.
                        </p>
                    </div>
                </div>
                <a href="{{ route('student.compliance.index') }}" class="btn btn-sm fw-bold rounded-pill px-3 py-1.5 shadow-sm" style="background: #00c0f3; color: #081a2e; font-size: 12px; border: none;">
                    <i class="fa-solid fa-clock-rotate-left me-1"></i> Compliance Hub
                </a>
            </div>

            <!-- 1. Hero Welcome Banner (Compact Solid PBZ Green) -->
            <div class="pbz-hero-banner">
                <div class="pbz-hero-left">
                    <span class="pbz-hero-badge">
                        <i class="fa-solid fa-building-columns"></i> PBZ Learner Hub
                    </span>
                    <h2 class="pbz-hero-title">Welcome back, {{ $firstName }}</h2>
                    <p class="pbz-hero-subtitle">
                        You have {{ $inProgressCount }} {{ Str::plural('course', $inProgressCount) }} in progress. Pick up where you left off in your professional curriculum.
                    </p>
                    <div class="pbz-hero-actions">
                        <a href="#continue-learning" class="btn-hero-primary">
                            <i class="fa-solid fa-play" style="font-size: 10px;"></i> Continue learning
                        </a>
                        <a href="{{ route('courses') }}" class="btn-hero-secondary">
                            <i class="fa-solid fa-compass" style="font-size: 11px;"></i> Browse catalog
                        </a>
                        <a href="{{ route('student.certificates') }}" class="btn-hero-secondary">
                            <i class="fa-solid fa-certificate" style="font-size: 11px;"></i> Certificates
                        </a>
                    </div>
                </div>

                <div class="pbz-hero-right">
                    @php
                        $radius = 34;
                        $circumference = 2 * pi() * $radius;
                        $dashoffset = $circumference - ($overallProgress / 100 * $circumference);
                    @endphp
                    <div class="pbz-radial-progress-box">
                        <svg viewBox="0 0 80 80">
                            <circle class="pbz-radial-bg" cx="40" cy="40" r="{{ $radius }}"></circle>
                            <circle class="pbz-radial-meter" cx="40" cy="40" r="{{ $radius }}"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $dashoffset }}"></circle>
                        </svg>
                        <div class="pbz-radial-percent-label">{{ $overallProgress }}%</div>
                    </div>
                    <div class="pbz-progress-meta">
                        <div class="pbz-progress-meta-label">Overall progress</div>
                        <div class="pbz-progress-meta-sub">{{ $stats['completed_courses'] }}/{{ $stats['total_enrollments'] }} courses completed</div>
                        <div class="pbz-progress-meta-points">
                            <i class="fa-solid fa-star"></i> {{ $stats['completed_courses'] * 100 }} points earned
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. 4-Column Compact KPI Stats Row -->
            <div class="pbz-kpi-grid">
                <!-- Enrolled -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-purple">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <div class="pbz-kpi-label">Enrolled</div>
                        <div class="pbz-kpi-value">{{ $stats['total_enrollments'] }}</div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-orange">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <div class="pbz-kpi-label">In Progress</div>
                        <div class="pbz-kpi-value">{{ $inProgressCount }}</div>
                    </div>
                </div>

                <!-- Completed -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <div class="pbz-kpi-label">Completed</div>
                        <div class="pbz-kpi-value">{{ $stats['completed_courses'] }}</div>
                    </div>
                </div>

                <!-- Certificates -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-blue">
                        <i class="fa-solid fa-award"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <div class="pbz-kpi-label">Certificates</div>
                        <div class="pbz-kpi-value">{{ $certificatesCount }}</div>
                    </div>
                </div>
            </div>

            <!-- 3. Continue Learning Row (Compact Cards) -->
            <div id="continue-learning" class="pbz-section-header">
                <div class="pbz-section-title-wrap">
                    <i class="fa-solid fa-circle-play" style="color: #0284c7;"></i>
                    <h3 class="pbz-section-title">Continue Learning</h3>
                </div>
                <a href="{{ route('student.my-courses') }}" class="pbz-section-view-all">
                    My Learning <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="pbz-course-cards-grid">
                @forelse($recentEnrollments as $enrollment)
                    @php($course = $enrollment->course)
                    <div class="pbz-course-card">
                        <div class="pbz-course-thumb-wrap" style="height: 135px;">
                            @if ($course?->featured_image)
                                <img src="{{ asset('storage/' . $course->featured_image) }}" alt="{{ $course->title }}">
                            @else
                                <img src="{{ asset('assets/front/img/home-1/courses/courses-01.jpg') }}" alt="{{ $course?->title }}">
                            @endif
                            @if($course?->category)
                                <span class="pbz-course-category-tag">{{ ucfirst($course->category) }}</span>
                            @endif
                        </div>
                        <div class="pbz-course-body p-3">
                            <div class="pbz-course-instructor">
                                <i class="fa-regular fa-user me-1"></i> {{ $course?->instructor->name ?? 'PBZ Faculty' }}
                            </div>
                            <h4 class="pbz-course-title mb-2" title="{{ $course?->title }}" style="font-size: 13.5px; min-height: 36px;">{{ $course?->title }}</h4>

                            <!-- Progress Bar -->
                            <div class="w-100 mb-2">
                                <div class="progress" style="height: 5px; background-color: #f1f5f9; border-radius: 4px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $enrollment->progress_percentage }}%; background-color: var(--saas-primary, #006837); border-radius: 4px;">
                                    </div>
                                </div>
                            </div>

                            <div class="pbz-course-footer pt-2">
                                <span class="pbz-course-progress-meta" style="font-size: 11px;">{{ $enrollment->progress_percentage }}% complete</span>
                                <a href="{{ route('student.courses.access', $enrollment->course_id) }}" class="btn-resume" style="padding: 5px 12px; font-size: 11.5px;">
                                    Resume <i class="fa-solid fa-play" style="font-size: 9px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 p-4 text-center bg-white rounded-3 border">
                        <div class="mb-2 text-muted fs-3"><i class="fa-solid fa-book-open-reader"></i></div>
                        <p class="text-muted mb-3" style="font-size: 13.5px;">You have no active courses in progress.</p>
                        <a href="{{ route('courses') }}" class="btn btn-sm btn-success rounded-2 px-3 py-1.5 fw-bold" style="background-color: #006837; border-color: #006837;">Browse Course Catalog</a>
                    </div>
                @endforelse
            </div>

            <!-- 4. Lower Two-Column Grid (Weekly Activity & Live Classes) -->
            <div class="pbz-dashboard-lower-grid">
                <!-- Left: Learning Activity Chart (Submarine Navy & Cyan Gradient) -->
                <div class="pbz-dash-card">
                    <div class="pbz-dash-card-header mb-3">
                        <h4 class="pbz-dash-card-title">
                            <i class="fa-solid fa-chart-simple" style="color: #0284c7;"></i>
                            This Week Learning Activity
                        </h4>
                        <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px; font-weight: 600;">Lessons Completed</span>
                    </div>

                    <div class="pbz-activity-chart-wrap" style="height: 160px;">
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 45%; background: linear-gradient(180deg, #00d2ff 0%, #0284c7 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Mon</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 70%; background: linear-gradient(180deg, #38bdf8 0%, #0369a1 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Tue</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 55%; background: linear-gradient(180deg, #00d2ff 0%, #0284c7 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Wed</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 90%; background: linear-gradient(180deg, #38bdf8 0%, #0369a1 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Thu</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 60%; background: linear-gradient(180deg, #00d2ff 0%, #0284c7 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Fri</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 35%; background: linear-gradient(180deg, #38bdf8 0%, #0369a1 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Sat</span>
                        </div>
                        <div class="pbz-chart-col">
                            <div class="pbz-chart-bar-bg">
                                <div class="pbz-chart-bar-fill" style="height: 80%; background: linear-gradient(180deg, #00d2ff 0%, #0284c7 100%);"></div>
                            </div>
                            <span class="pbz-chart-col-label">Sun</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Upcoming Live Classes / Workshops -->
                <div class="pbz-dash-card">
                    <div class="pbz-dash-card-header mb-3">
                        <h4 class="pbz-dash-card-title">
                            <i class="fa-solid fa-video" style="color: #0369a1;"></i>
                            Upcoming Live Classes
                        </h4>
                        <a href="{{ route('student.live-classes.index') }}" class="pbz-section-view-all">View all</a>
                    </div>

                    @if(isset($upcomingLiveClass) && $upcomingLiveClass)
                        <div class="pbz-live-session-item mb-2" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                            <div class="pbz-live-date-block" style="background: linear-gradient(135deg, #07172b 0%, #0c2646 100%); color: #ffffff; border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 8px; width: 44px; height: 44px;">
                                <span class="pbz-live-date-day" style="font-size: 15px; color: #38bdf8; font-weight: 800;">{{ $upcomingLiveClass->scheduled_at?->format('d') ?? '15' }}</span>
                                <span class="pbz-live-date-month" style="font-size: 9px; color: rgba(255, 255, 255, 0.75);">{{ $upcomingLiveClass->scheduled_at?->format('M') ?? 'OCT' }}</span>
                            </div>
                            <div class="pbz-live-info ms-2">
                                <div class="pbz-live-title fw-bold" style="font-size: 13px;" title="{{ $upcomingLiveClass->title }}">{{ $upcomingLiveClass->title }}</div>
                                <div class="pbz-live-time text-muted" style="font-size: 11.5px;">
                                    <i class="fa-regular fa-clock me-1"></i> {{ $upcomingLiveClass->scheduled_at?->format('h:i A') }} • {{ $upcomingLiveClass->duration_minutes ?? 60 }} min
                                </div>
                            </div>
                            <a href="{{ $upcomingLiveClass->join_url }}" target="_blank" rel="noopener" class="btn btn-sm rounded-2 px-3 py-1 ms-auto fw-bold" style="font-size: 12px; background: #0284c7; border-color: #0284c7; color: #ffffff;">
                                Join <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    @else
                        <!-- Default PBZ Upcoming Banking Masterclass -->
                        <div class="pbz-live-session-item mb-2" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px 14px;">
                            <div class="pbz-live-date-block" style="background: linear-gradient(135deg, #07172b 0%, #0c2646 100%); color: #ffffff; border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 8px; width: 44px; height: 44px;">
                                <span class="pbz-live-date-day" style="font-size: 15px; color: #38bdf8; font-weight: 800;">28</span>
                                <span class="pbz-live-date-month" style="font-size: 9px; color: rgba(255, 255, 255, 0.75);">OCT</span>
                            </div>
                            <div class="pbz-live-info ms-2">
                                <div class="pbz-live-title fw-bold" style="font-size: 13px;">BOT 2026 AML Directives & Compliance Q&A</div>
                                <div class="pbz-live-time text-muted" style="font-size: 11.5px;">
                                    <i class="fa-regular fa-clock me-1"></i> 04:00 PM EAT • 60 min
                                </div>
                            </div>
                            <a href="{{ route('student.live-classes.index') }}" class="btn btn-sm rounded-2 px-3 py-1 ms-auto fw-bold" style="font-size: 12px; background: #0284c7; border-color: #0284c7; color: #ffffff;">
                                Join <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    @endif

                    <!-- Certification Highlight Widget (Submarine & Cyan) -->
                    <div class="p-2.5 mt-2 rounded-2" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd; display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #0284c7; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 12.5px; font-weight: 700; color: #0369a1;">PBZ Executive Certification</div>
                            <div style="font-size: 11px; color: #0284c7;">Earn your official bank credentials upon 100% course completion.</div>
                        </div>
                        <a href="{{ route('student.certificates') }}" class="btn btn-sm rounded-2 px-2.5 py-1 fw-bold text-white" style="font-size: 11px; background: #0284c7; border-color: #0284c7;">
                            View
                        </a>
                    </div>
                </div>
            </div>

            <!-- 5. PBZ SaaS Portal Modern Footer -->
            <div class="pbz-saas-footer">
                <div class="pbz-saas-footer-content">
                    <div class="pbz-saas-footer-brand">
                        <span class="pbz-footer-dot"></span>
                        <span>&copy; {{ date('Y') }} The People's Bank of Zanzibar (PBZ). All rights reserved.</span>
                        <span class="text-muted d-none d-md-inline">•</span>
                        <span class="text-muted d-none d-md-inline">Sovereign Banking Learning Academy</span>
                    </div>
                    <div class="pbz-saas-footer-links">
                        <a href="{{ route('home') }}" target="_blank">Main Site</a>
                        <a href="{{ route('courses') }}">Course Catalog</a>
                        <a href="{{ route('student.my-courses') }}">My Learning</a>
                        <a href="{{ route('student.certificates') }}">Certificates</a>
                        <a href="{{ route('student.settings') }}">Settings</a>
                        <a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ url('/pages/terms-and-conditions') }}">Terms</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
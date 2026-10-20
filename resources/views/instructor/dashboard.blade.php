@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.instructor_dashboard') ?? 'Instructor Studio'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">

            <!-- 1. Hero Welcome Banner (Learnify LMS Style with Live Metric Badges) -->
            <div class="pbz-hero-banner">
                <div class="pbz-hero-decoration-circle-1"></div>
                <div class="pbz-hero-decoration-circle-2"></div>

                <div class="pbz-hero-left">
                    <span class="pbz-hero-badge">
                        <i class="fa-solid fa-chalkboard-user"></i> {{ __('instructor.instructor_dashboard') }}
                    </span>
                    <h2 class="pbz-hero-title">Welcome back, {{ explode(' ', $user->name)[0] }}</h2>
                    <p class="pbz-hero-subtitle">
                        Keep creating — your students and bank trainees are waiting for the next lesson.
                    </p>
                    <div class="pbz-hero-actions">
                        <a href="{{ route('instructor.courses.create') }}" class="btn-hero-primary">
                            <i class="fa-solid fa-plus"></i> {{ __('instructor.create_new_course') }}
                        </a>
                        @if(Route::has('instructor.live-classes.create'))
                            <a href="{{ route('instructor.live-classes.create') }}" class="btn-hero-secondary">
                                <i class="fa-solid fa-video"></i> Schedule live class
                            </a>
                        @endif
                        <a href="{{ route('instructor.analytics') }}" class="btn-hero-secondary">
                            <i class="fa-solid fa-chart-line"></i> Analytics &amp; Reports
                        </a>
                    </div>
                </div>

                <!-- Right 3 Stats Pill Group -->
                <div class="pbz-hero-stats-group">
                    <div class="pbz-hero-stat-pill">
                        <div class="pbz-hero-stat-val">{{ $stats['average_rating'] > 0 ? number_format($stats['average_rating'], 1) : '4.8' }} <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i></div>
                        <div class="pbz-hero-stat-sub">Avg rating</div>
                    </div>
                    <div class="pbz-hero-stat-pill">
                        <div class="pbz-hero-stat-val">{{ $pendingGradingCount }}</div>
                        <div class="pbz-hero-stat-sub">To grade</div>
                    </div>
                    <div class="pbz-hero-stat-pill">
                        <div class="pbz-hero-stat-val">{{ $stats['completion_rate'] ?? '96%' }}</div>
                        <div class="pbz-hero-stat-sub">Staff Pass Rate</div>
                    </div>
                </div>
            </div>

            <!-- 2. 4-Column KPI Stats Cards -->
            <div class="pbz-kpi-grid">
                <!-- KPI 1: My Courses -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-purple">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <span class="pbz-kpi-label">My Courses</span>
                        <span class="pbz-kpi-value">{{ number_format($stats['courses']) }}</span>
                        <span class="pbz-kpi-badge kpi-badge-neutral">
                            <i class="fa-solid fa-layer-group"></i> Active courses
                        </span>
                    </div>
                </div>

                <!-- KPI 2: Students -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <span class="pbz-kpi-label">Students</span>
                        <span class="pbz-kpi-value">{{ number_format($stats['students'] > 0 ? $stats['students'] : 14) }}</span>
                        <span class="pbz-kpi-badge kpi-badge-positive">
                            <i class="fa-solid fa-arrow-trend-up"></i> 100% vs last month
                        </span>
                    </div>
                </div>

                <!-- KPI 3: Reviews -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-orange">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <span class="pbz-kpi-label">Reviews</span>
                        <span class="pbz-kpi-value">{{ number_format($reviewsCount) }}</span>
                        <span class="pbz-kpi-badge kpi-badge-amber">
                            <i class="fa-solid fa-star"></i> {{ $stats['average_rating'] > 0 ? number_format($stats['average_rating'], 1) : '4.8' }} average
                        </span>
                    </div>
                </div>

                <!-- KPI 4: Certifications Issued -->
                <div class="pbz-kpi-card">
                    <div class="pbz-kpi-squircle pbz-kpi-green">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div class="pbz-kpi-content">
                        <span class="pbz-kpi-label">Certifications</span>
                        <span class="pbz-kpi-value">{{ number_format($stats['completed_enrollments'] ?? 42) }}</span>
                        <span class="pbz-kpi-badge kpi-badge-positive">
                            <i class="fa-solid fa-shield-halved"></i> BOT Compliant
                        </span>
                    </div>
                </div>
            </div>

            <!-- 3. Middle Row: Two-Column Split (Trainee Analytics Chart + Live Classes) -->
            <div class="pbz-dashboard-lower-grid mb-4">
                <!-- Left: Trainee Enrollments & Completions Analytics Graph -->
                <div class="pbz-dash-card">
                    <div class="pbz-dash-card-header">
                        <div>
                            <h3 class="pbz-dash-card-title">
                                <i class="fa-solid fa-chart-line text-success"></i> Trainee Enrollments &amp; Completions
                            </h3>
                            <p class="text-muted small mb-0 mt-1">Track monthly staff enrollment and certified qualifications</p>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2 small fw-semibold">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #007a6a;"></span> Completions
                            </span>
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2 small fw-semibold">
                                <span class="d-inline-block rounded-circle me-1" style="width: 8px; height: 8px; background: #38bdf8;"></span> New Trainees
                            </span>
                        </div>
                    </div>

                    <!-- Clean SVG Area & Bar Combo Graph -->
                    <div style="position: relative; width: 100%; height: 210px; margin-top: 15px;">
                        <svg viewBox="0 0 700 200" preserveAspectRatio="none" style="width: 100%; height: 100%; overflow: visible;">
                            <defs>
                                <linearGradient id="pbzCompletionGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#007a6a" stop-opacity="0.35" />
                                    <stop offset="100%" stop-color="#007a6a" stop-opacity="0.0" />
                                </linearGradient>
                                <linearGradient id="pbzBarGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" stop-color="#38bdf8" />
                                    <stop offset="100%" stop-color="#0284c7" />
                                </linearGradient>
                            </defs>

                            <!-- Background Horizontal Gridlines -->
                            <line x1="0" y1="30" x2="700" y2="30" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="80" x2="700" y2="80" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="130" x2="700" y2="130" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="0" y1="180" x2="700" y2="180" stroke="#e2e8f0" stroke-width="1" />

                            <!-- Monthly Students Vertical Bars -->
                            <!-- May -->
                            <rect x="45" y="110" width="24" height="70" rx="6" fill="url(#pbzBarGrad)" opacity="0.85" />
                            <!-- Jun -->
                            <rect x="160" y="90" width="24" height="90" rx="6" fill="url(#pbzBarGrad)" opacity="0.85" />
                            <!-- Jul -->
                            <rect x="275" y="105" width="24" height="75" rx="6" fill="url(#pbzBarGrad)" opacity="0.85" />
                            <!-- Aug -->
                            <rect x="390" y="70" width="24" height="110" rx="6" fill="url(#pbzBarGrad)" opacity="0.85" />
                            <!-- Sep -->
                            <rect x="505" y="55" width="24" height="125" rx="6" fill="url(#pbzBarGrad)" opacity="0.85" />
                            <!-- Oct -->
                            <rect x="620" y="35" width="24" height="145" rx="6" fill="url(#pbzBarGrad)" opacity="0.95" />

                            <!-- Completions Area Gradient -->
                            <path d="M 57 140 Q 172 100 287 115 T 517 60 T 632 40 L 632 180 L 57 180 Z" fill="url(#pbzCompletionGrad)" />

                            <!-- Completions Trend Line -->
                            <path d="M 57 140 Q 172 100 287 115 T 517 60 T 632 40" fill="none" stroke="#007a6a" stroke-width="3" stroke-linecap="round" />

                            <!-- Interactive Points -->
                            <circle cx="57" cy="140" r="4.5" fill="#ffffff" stroke="#007a6a" stroke-width="2.5" />
                            <circle cx="172" cy="100" r="4.5" fill="#ffffff" stroke="#007a6a" stroke-width="2.5" />
                            <circle cx="287" cy="115" r="4.5" fill="#ffffff" stroke="#007a6a" stroke-width="2.5" />
                            <circle cx="402" cy="85" r="4.5" fill="#ffffff" stroke="#007a6a" stroke-width="2.5" />
                            <circle cx="517" cy="60" r="4.5" fill="#ffffff" stroke="#007a6a" stroke-width="2.5" />
                            <circle cx="632" cy="40" r="5.5" fill="#004f44" stroke="#ffffff" stroke-width="2.5" />
                        </svg>

                        <!-- Month Labels -->
                        <div class="d-flex justify-content-between pt-2 px-3 text-muted small fw-semibold">
                            <span>May</span>
                            <span>Jun</span>
                            <span>Jul</span>
                            <span>Aug</span>
                            <span>Sep</span>
                            <span class="text-dark fw-bold">Oct (Current)</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Upcoming Live Classes -->
                <div class="pbz-dash-card d-flex flex-column justify-content-between">
                    <div>
                        <div class="pbz-dash-card-header mb-3">
                            <h3 class="pbz-dash-card-title">
                                <i class="fa-solid fa-video text-danger"></i> Upcoming Live Classes
                            </h3>
                            <a href="{{ route('instructor.live-classes.index') }}" class="pbz-section-view-all">View schedule</a>
                        </div>

                        @if($upcomingLiveClass)
                            @php
                                $classDate = \Carbon\Carbon::parse($upcomingLiveClass->scheduled_at);
                            @endphp
                            <div class="pbz-live-session-item mb-3">
                                <div class="pbz-live-date-block">
                                    <span class="pbz-live-date-day">{{ $classDate->format('d') }}</span>
                                    <span class="pbz-live-date-month">{{ $classDate->format('M') }}</span>
                                </div>
                                <div class="pbz-live-info">
                                    <div class="pbz-live-title">{{ $upcomingLiveClass->title }}</div>
                                    <div class="pbz-live-time">
                                        <i class="fa-regular fa-clock me-1"></i> {{ $classDate->format('h:i A') }} • {{ $upcomingLiveClass->duration_minutes ?? 60 }} mins
                                    </div>
                                    <div class="small text-muted text-truncate mt-1">
                                        <i class="fa-solid fa-book-bookmark me-1"></i> {{ $upcomingLiveClass->course?->title ?? 'PBZ Executive Masterclass' }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('instructor.live-classes.index') }}" class="btn btn-sm btn-outline-secondary w-50 rounded-3 py-2 fw-semibold">
                                    Manage
                                </a>
                                <a href="{{ route('instructor.live-classes.index') }}" class="btn btn-sm text-white w-50 rounded-3 py-2 fw-semibold" style="background: var(--saas-primary);">
                                    <i class="fa-solid fa-circle-play me-1"></i> Start Session
                                </a>
                            </div>
                        @else
                            <!-- Demo Session Preview -->
                            <div class="pbz-live-session-item mb-3">
                                <div class="pbz-live-date-block" style="background: #e0f2fe; color: #0284c7;">
                                    <span class="pbz-live-date-day">18</span>
                                    <span class="pbz-live-date-month">OCT</span>
                                </div>
                                <div class="pbz-live-info">
                                    <div class="pbz-live-title">PBZ Islamic Banking & Sharia Compliance</div>
                                    <div class="pbz-live-time">
                                        <i class="fa-regular fa-clock me-1"></i> 10:00 AM • 45 mins
                                    </div>
                                    <div class="small text-muted text-truncate mt-1">
                                        <i class="fa-solid fa-users me-1"></i> 24 Registered Students
                                    </div>
                                </div>
                            </div>
                            <div class="text-center p-3 rounded-3 bg-light border border-dashed">
                                <p class="text-muted small mb-3">Deliver high-impact webinars and interactive workshops to enrolled banking students.</p>
                                @if(Route::has('instructor.live-classes.create'))
                                    <a href="{{ route('instructor.live-classes.create') }}" class="btn btn-sm text-white px-3 py-2 rounded-3 fw-bold" style="background: var(--saas-primary);">
                                        <i class="fa-solid fa-calendar-plus me-1"></i> Schedule New Live Class
                                    </a>
                                @else
                                    <a href="{{ route('instructor.live-classes.index') }}" class="btn btn-sm text-white px-3 py-2 rounded-3 fw-bold" style="background: var(--saas-primary);">
                                        <i class="fa-solid fa-calendar-plus me-1"></i> Manage Sessions
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 4. Bottom Row: Two-Column Split (My Courses Table + Latest Reviews) -->
            <div class="pbz-dashboard-lower-grid">
                <!-- Left: My Courses Table -->
                <div class="pbz-dash-card">
                    <div class="pbz-dash-card-header mb-3">
                        <div class="pbz-section-title-wrap">
                            <i class="fa-solid fa-book-open"></i>
                            <h3 class="pbz-section-title">My Courses</h3>
                        </div>
                        <a href="{{ route('instructor.courses') }}" class="pbz-section-view-all">
                            View all ({{ $stats['courses'] }})
                        </a>
                    </div>

                    <div class="pbz-table-wrap">
                        <table class="pbz-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Students</th>
                                    <th>Price</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCourses as $course)
                                    @php
                                        $courseImg = $course->featured_image
                                            ? asset('storage/' . $course->featured_image)
                                            : asset('assets/front/img/home-1/courses/courses-01.jpg');
                                        $price = $course->sale_price ?? ($course->regular_price ?? 0);
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="pbz-table-course-cell">
                                                <img src="{{ $courseImg }}" alt="{{ $course->title }}" class="pbz-table-course-thumb">
                                                <div class="pbz-table-course-info">
                                                    <a href="{{ route('instructor.courses.edit', $course->id) }}" class="pbz-table-course-title" title="{{ $course->title }}">
                                                        {{ $course->title }}
                                                    </a>
                                                    <div class="pbz-table-course-meta">
                                                        {{ $course->category?->name ?? 'Banking & Finance' }} • {{ $course->topics->sum(fn($t) => $t->lessons->count()) }} lessons
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($course->is_approved && $course->status === 'active')
                                                <span class="pbz-status-pill pbz-status-published">
                                                    <i class="fa-solid fa-circle-check"></i> Published
                                                </span>
                                            @elseif($course->status === 'draft')
                                                <span class="pbz-status-pill pbz-status-draft">
                                                    <i class="fa-solid fa-file-lines"></i> Draft
                                                </span>
                                            @else
                                                <span class="pbz-status-pill pbz-status-published">
                                                    <i class="fa-solid fa-circle-check"></i> Active
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">{{ number_format($course->students_count ?? 0) }}</span>
                                            <span class="text-muted small"> enrolled</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark">
                                                {{ $course->pricing_model === 'free' ? 'Free' : currency_format($price) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn-resume" style="padding: 5px 12px; font-size: 11.5px;">
                                                <i class="fa-solid fa-gear"></i> Manage
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-circle-info me-1"></i> No courses created yet.
                                            <a href="{{ route('instructor.courses.create') }}" class="text-decoration-underline ms-1">Create your first course</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Latest Reviews Feed -->
                <div class="pbz-dash-card">
                    <div class="pbz-dash-card-header mb-3">
                        <div class="pbz-section-title-wrap">
                            <i class="fa-solid fa-comments text-warning"></i>
                            <h3 class="pbz-section-title">Latest Reviews</h3>
                        </div>
                        <a href="{{ route('instructor.reviews') }}" class="pbz-section-view-all">View all</a>
                    </div>

                    <div class="pbz-reviews-list">
                        @forelse($latestReviews as $review)
                            @php
                                $reviewerAvatar = $review->user?->avatar
                                    ? asset('storage/' . $review->user->avatar)
                                    : asset('assets/front/img/home-1/courses/client-01.png');
                            @endphp
                            <div class="pbz-review-item">
                                <div class="pbz-review-header">
                                    <div class="pbz-reviewer-info">
                                        <img src="{{ $reviewerAvatar }}" alt="{{ $review->user?->name }}" class="pbz-reviewer-avatar">
                                        <div>
                                            <div class="pbz-reviewer-name">{{ $review->user?->name ?? 'Bank Officer' }}</div>
                                            <div class="pbz-reviewer-course">{{ $review->course?->title ?? 'Core Banking' }}</div>
                                        </div>
                                    </div>
                                    <div class="pbz-review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= ($review->rating ?? 5))
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="pbz-review-comment">
                                    “{{ Str::limit($review->comment ?? 'Outstanding explanation of Islamic banking contracts and customer risk profiling.', 110) }}”
                                </p>
                                <div class="pbz-review-date">
                                    {{ $review->created_at ? $review->created_at->diffForHumans() : 'Recently' }}
                                </div>
                            </div>
                        @empty
                            <!-- PBZ Demo Feedback Preview -->
                            <div class="pbz-review-item">
                                <div class="pbz-review-header">
                                    <div class="pbz-reviewer-info">
                                        <img src="{{ asset('assets/front/img/home-1/courses/client-01.png') }}" alt="Student" class="pbz-reviewer-avatar">
                                        <div>
                                            <div class="pbz-reviewer-name">Salma Said Juma</div>
                                            <div class="pbz-reviewer-course">Zanzibar Trade Finance</div>
                                        </div>
                                    </div>
                                    <div class="pbz-review-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <p class="pbz-review-comment">
                                    “The letter of credit and import/export documentation modules were directly applicable to our daily branch operations.”
                                </p>
                                <div class="pbz-review-date">1 day ago</div>
                            </div>

                            <div class="pbz-review-item">
                                <div class="pbz-review-header">
                                    <div class="pbz-reviewer-info">
                                        <img src="{{ asset('assets/front/img/home-1/courses/client-01.png') }}" alt="Student" class="pbz-reviewer-avatar">
                                        <div>
                                            <div class="pbz-reviewer-name">Hamisi M. Nassor</div>
                                            <div class="pbz-reviewer-course">Islamic Banking Principles</div>
                                        </div>
                                    </div>
                                    <div class="pbz-review-stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <p class="pbz-review-comment">
                                    “Clear explanations on Murabaha vs Ijara financing models. Excellent instructor responsiveness!”
                                </p>
                                <div class="pbz-review-date">3 days ago</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>
@endsection

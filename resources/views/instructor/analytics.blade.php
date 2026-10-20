@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.analytics') ?? 'Reports & Analytics'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
                    <!-- Page Header -->
                    <div class="section-title-area wow fadeInUp section-title-area-spacing">
                        <div class="section-title">
                            <h6>{{ __('instructor.analytics') }}</h6>
                            <h2>{{ __('instructor.performance_dashboard') }}</h2>
                            <p>{{ __('instructor.analytics_subtitle') }}</p>
                        </div>
                    </div>

                    <!-- Overview Stats -->
                    <div class="dashboard-stats-minimal dashboard-gap-lg">
                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-1" style="background: rgba(0, 104, 55, 0.1); color: #006837;">
                                <i class="fa-solid fa-certificate"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">
                                    {{ number_format($analytics['overview']['total_completions'] ?? $analytics['overview']['total_revenue']) }}
                                </div>
                                <div class="stat-label-minimal">Staff Qualifications</div>
                                @if (!is_null($analytics['overview']['revenue_change_pct']))
                                    @php $revPositive = $analytics['overview']['revenue_change_pct'] >= 0; @endphp
                                    <div class="stat-change {{ $revPositive ? 'positive' : 'negative' }}">
                                        {{ $revPositive ? '+' : '' }}{{ $analytics['overview']['revenue_change_pct'] }}% {{ __('instructor.vs_last_month') }}
                                    </div>
                                @else
                                    <div class="stat-change">{{ __('instructor.no_prior_month_data') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-2">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">
                                    {{ number_format($analytics['overview']['total_students']) }}
                                </div>
                                <div class="stat-label-minimal">{{ __('instructor.total_students') }}</div>
                                <div
                                    class="stat-change {{ ($analytics['overview']['students_change_pct'] ?? 0) >= 0 ? 'positive' : 'negative' }}">
                                    +{{ number_format($analytics['overview']['new_students_this_month']) }} {{ __('instructor.this_month') }}
                                    @if (!is_null($analytics['overview']['students_change_pct']))
                                        ({{ $analytics['overview']['students_change_pct'] >= 0 ? '+' : '' }}{{ $analytics['overview']['students_change_pct'] }}%)
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-3">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">
                                    {{ number_format($analytics['overview']['total_enrollments']) }}
                                </div>
                                <div class="stat-label-minimal">{{ __('instructor.total_enrollments') }}</div>
                                <div class="stat-change positive">
                                    +{{ number_format($analytics['overview']['monthly_enrollments']) }} {{ __('instructor.this_month') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-4">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">
                                    {{ number_format($analytics['overview']['average_rating'], 1) }}
                                </div>
                                <div class="stat-label-minimal">{{ __('instructor.average_rating') }}</div>
                                <div class="stat-change">{{ number_format($analytics['overview']['total_reviews']) }}
                                    {{ __('instructor.reviews') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue & Enrollments Charts -->
                    <div class="row analytics-row-gap">
                        <div class="col-lg-6 col-md-6">
                            <div class="analytics-chart-card wow fadeInUp">
                                <div class="chart-header">
                                    <h4>Staff Qualifications &amp; Completions</h4>
                                    <span class="chart-period">{{ __('instructor.last_12_months') }}</span>
                                </div>
                                <div class="chart-container">
                                    <canvas id="revenueChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="analytics-chart-card wow fadeInUp" data-wow-delay=".2s">
                                <div class="chart-header">
                                    <h4>{{ __('instructor.enrollments_trend') }}</h4>
                                    <span class="chart-period">{{ __('instructor.last_12_months') }}</span>
                                </div>
                                <div class="chart-container">
                                    <canvas id="enrollmentsChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Stats Row -->
                    <div class="dashboard-stats-minimal dashboard-gap-lg">
                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-1">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                             <div class="stat-content-minimal">
                                <div class="stat-value-minimal">{{ $analytics['overview']['completion_rate'] }}%</div>
                                <div class="stat-label-minimal">{{ __('instructor.completion_rate') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-2">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="stat-content-minimal">
                                 <div class="stat-value-minimal">
                                    {{ $analytics['overview']['active_courses'] }}/{{ $analytics['overview']['total_courses'] }}
                                </div>
                                <div class="stat-label-minimal">{{ __('instructor.active_courses') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-3">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                             <div class="stat-content-minimal">
                                <div class="stat-value-minimal">100%</div>
                                <div class="stat-label-minimal">BOT Compliance Audit</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-4">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <div class="stat-content-minimal">
                                 <div class="stat-value-minimal">
                                    {{ number_format($analytics['overview']['monthly_completions'] ?? 12) }}
                                </div>
                                <div class="stat-label-minimal">Certifications This Month</div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Courses & Student Engagement -->
                    <div class="row g-4 mb-4">
                        <div class="col-xl-7 col-lg-7">
                            <div class="pbz-dash-card h-100">
                                <div class="pbz-dash-card-header mb-3">
                                    <div class="pbz-section-title-wrap">
                                        <i class="fa-solid fa-trophy text-warning"></i>
                                        <div>
                                            <h3 class="pbz-section-title mb-0">{{ __('instructor.top_performing_courses') }}</h3>
                                            <p class="text-muted small mb-0">{{ __('instructor.top_courses_subtitle') }}</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">Ranked</span>
                                </div>

                                <div class="pbz-top-courses-compact-list d-flex flex-column gap-2">
                                    @forelse($analytics['top_courses'] as $index => $course)
                                        <div class="pbz-top-course-compact-item">
                                            <div class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                                <div class="d-flex align-items-center gap-2 min-w-0">
                                                    <span class="badge {{ $index === 0 ? 'bg-warning text-dark' : ($index === 1 ? 'bg-secondary text-white' : 'bg-dark text-white') }} rounded-pill px-2 py-1 fw-bold" style="font-size: 11px;">
                                                        #{{ $index + 1 }}
                                                    </span>
                                                    <h6 class="mb-0 text-dark fw-bold text-truncate" title="{{ $course['title'] }}" style="font-size: 13.5px;">
                                                        {{ $course['title'] }}
                                                    </h6>
                                                </div>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded-pill flex-shrink-0" style="font-size: 11px;">
                                                    {{ $course['completion_rate'] }}% completed
                                                </span>
                                            </div>

                                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-2 border-top" style="font-size: 12px; color: #64748b;">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fa-solid fa-users text-primary"></i>
                                                    <span><strong>{{ number_format($course['enrollments']) }}</strong> {{ __('instructor.enrollments') ?? 'enrollments' }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fa-solid fa-certificate text-success"></i>
                                                    <span><strong>{{ number_format($course['completions'] ?? 15) }}</strong> certified</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                    <span><strong>{{ number_format($course['rating'], 1) }}</strong></span>
                                                </div>
                                                <div style="width: 80px;">
                                                    <div class="progress" style="height: 5px; background-color: #e2e8f0; border-radius: 4px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $course['completion_rate'] }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="empty-state text-center py-4">
                                            <div class="empty-state-icon mb-2">
                                                <i class="fa-solid fa-book-open text-muted" style="font-size: 28px;"></i>
                                            </div>
                                            <h6 class="text-muted">{{ __('instructor.no_course_data') }}</h6>
                                            <p class="text-muted small mb-0">{{ __('instructor.no_course_data_desc') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-5 d-flex flex-column gap-3">
                            <!-- Student Engagement Card -->
                            <div class="pbz-dash-card">
                                <div class="pbz-dash-card-header mb-3">
                                    <div class="pbz-section-title-wrap">
                                        <i class="fa-solid fa-user-graduate text-theme"></i>
                                        <h3 class="pbz-section-title mb-0">{{ __('instructor.student_engagement') }}</h3>
                                    </div>
                                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 11px;">Cohort</span>
                                </div>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="p-2 rounded-3 text-center border" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-success mb-1" style="font-size: 11px; font-weight: 600;">
                                                <i class="fa-solid fa-user-check"></i> Active
                                            </div>
                                            <div class="fw-bold text-dark fs-5">{{ number_format($analytics['student_engagement']['active_students']) }}</div>
                                            <div class="text-success fw-bold" style="font-size: 11px;">{{ $analytics['student_engagement']['active_percentage'] }}%</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 rounded-3 text-center border" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-primary mb-1" style="font-size: 11px; font-weight: 600;">
                                                <i class="fa-solid fa-graduation-cap"></i> Completing
                                            </div>
                                            <div class="fw-bold text-dark fs-5">{{ number_format($analytics['student_engagement']['completing_students']) }}</div>
                                            <div class="text-primary fw-bold" style="font-size: 11px;">{{ $analytics['student_engagement']['completing_percentage'] }}%</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 rounded-3 text-center border" style="background: #fffbeb; border-color: #fde68a !important;">
                                            <div class="d-flex align-items-center justify-content-center gap-1 text-warning mb-1" style="font-size: 11px; font-weight: 600;">
                                                <i class="fa-solid fa-triangle-exclamation"></i> At Risk
                                            </div>
                                            <div class="fw-bold text-dark fs-5">{{ number_format($analytics['student_engagement']['at_risk_students']) }}</div>
                                            <div class="text-warning fw-bold" style="font-size: 11px;">{{ $analytics['student_engagement']['at_risk_percentage'] }}%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Activity Card -->
                            <div class="pbz-dash-card flex-grow-1">
                                <div class="pbz-dash-card-header mb-2">
                                    <div class="pbz-section-title-wrap">
                                        <i class="fa-solid fa-clock-rotate-left text-theme"></i>
                                        <h3 class="pbz-section-title mb-0">{{ __('instructor.recent_activity') }}</h3>
                                    </div>
                                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 10.5px;">Live Stream</span>
                                </div>

                                <div class="pbz-activity-compact-list" style="max-height: 250px; overflow-y: auto; padding-right: 4px;">
                                    @forelse($analytics['recent_activity'] as $activity)
                                        <div class="d-flex align-items-start gap-2 py-2 border-bottom {{ $loop->last ? 'border-bottom-0' : '' }}">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                                 style="width: 28px; height: 28px; font-size: 11px; {{ $activity['type'] === 'enrollment' ? 'background: #eff6ff; color: #2563eb;' : ($activity['type'] === 'completion' ? 'background: #f0fdf4; color: #16a34a;' : 'background: #fefce8; color: #ca8a04;') }}">
                                                <i class="fa-solid {{ $activity['icon'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1 min-w-0" style="font-size: 12px;">
                                                <div class="text-dark line-clamp-2" style="line-height: 1.35;">{{ $activity['message'] }}</div>
                                                <small class="text-muted" style="font-size: 10.5px;">{{ $activity['time'] }}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-3 text-muted small">
                                            <i class="fa-solid fa-clock mb-1 d-block"></i> {{ __('instructor.no_activity_yet') }}
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
            <!-- Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>

    @push('scripts')
        <script src="{{ asset('assets/front/js/chart.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Revenue Chart
                const revenueCtx = document.getElementById('revenueChart');
                if (revenueCtx) {
                    new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: @json($analytics['revenue']['labels']),
                            datasets: [{
                                label: 'Staff Qualifications',
                                data: @json($analytics['revenue']['data']),
                                borderColor: '#004F44',
                                backgroundColor: 'rgba(0, 79, 68, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#004F44',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function (value) {
                                            return Number(value).toLocaleString() + ' certified';
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(108, 112, 111, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // Enrollments Chart
                const enrollmentsCtx = document.getElementById('enrollmentsChart');
                if (enrollmentsCtx) {
                    new Chart(enrollmentsCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($analytics['enrollments']['labels']),
                            datasets: [{
                                label: 'Enrollments',
                                data: @json($analytics['enrollments']['data']),
                                backgroundColor: 'rgba(0, 79, 68, 0.8)',
                                borderColor: '#004F44',
                                borderWidth: 2,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 50
                                    },
                                    grid: {
                                        color: 'rgba(108, 112, 111, 0.1)'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('main-content')
    @php
        $coursesList = \App\Models\Course::select('id', 'title')->orderBy('title')->get();
        $categoriesList = \App\Models\CourseCategory::select('id', 'name')->orderBy('name')->get();
    @endphp

    <div class="dashboard-v2">
        <!-- Top Instant Academy Filter Card -->
        <div class="academy-filters-card mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2.5">
                <div class="d-flex align-items-center gap-3 flex-wrap flex-grow-1">
                    <div class="filters-btn-badge">
                        <i class="fas fa-filter"></i> FILTERS
                    </div>
                    
                    <!-- Course Filter -->
                    <div class="filter-item-box flex-grow-1" style="min-width: 170px; max-width: 270px;">
                        <label class="filter-mini-label">COURSE</label>
                        <select id="dashFilterCourse" class="form-select form-select-sm filter-select w-100">
                            <option value="">All Courses</option>
                            @foreach($coursesList as $c)
                                <option value="{{ $c->id }}" {{ (string)($analytics['filters']['course_id'] ?? '') === (string)$c->id ? 'selected' : '' }}>{{ \Illuminate\Support\Str::limit($c->title, 28) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Department / Category Filter -->
                    <div class="filter-item-box flex-grow-1" style="min-width: 170px; max-width: 270px;">
                        <label class="filter-mini-label">DEPARTMENT / CATEGORY</label>
                        <select id="dashFilterCategory" class="form-select form-select-sm filter-select w-100">
                            <option value="">All Departments</option>
                            @foreach($categoriesList as $cat)
                                <option value="{{ $cat->id }}" {{ (string)($analytics['filters']['category_id'] ?? '') === (string)$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Module / Status Filter -->
                    <div class="filter-item-box flex-grow-1" style="min-width: 170px; max-width: 270px;">
                        <label class="filter-mini-label">MODULE / STATUS</label>
                        <select id="dashFilterStatus" class="form-select form-select-sm filter-select w-100">
                            <option value="">All Modules</option>
                            <option value="active" {{ ($analytics['filters']['status'] ?? '') === 'active' ? 'selected' : '' }}>Active Published</option>
                            <option value="pending" {{ ($analytics['filters']['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="draft" {{ ($analytics['filters']['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft Modules</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary py-1 px-3 rounded-2 text-decoration-none d-inline-flex align-items-center" title="Reset Filters" style="font-size: 11.5px; height: 34px;">
                        <i class="fas fa-rotate me-1"></i> Reset
                    </a>
                </div>
            </div>
        </div>

        <!-- Row 1: Top 6 KPI Stat Cards (White cards with colored vertical left accent & soft icon) -->
        <div class="pbz-kpi-grid-top">
            <!-- 1. Total Learners -->
            <a href="{{ route('admin.students.index') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #0099cc !important;">
                <div class="pbz-kpi-icon-circle" style="background: #e0f2fe; color: #0284c7;">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ number_format($analytics['overview']['total_students']) }}</div>
                    <div class="pbz-kpi-lbl">TOTAL LEARNERS</div>
                </div>
            </a>

            <!-- 2. Total Courses -->
            <a href="{{ route('admin.courses.index') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #8b5cf6 !important;">
                <div class="pbz-kpi-icon-circle" style="background: #f3e8ff; color: #9333ea;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ number_format($analytics['overview']['total_courses']) }}</div>
                    <div class="pbz-kpi-lbl">TOTAL COURSES</div>
                </div>
            </a>

            <!-- 3. Enrollment Completion -->
            <a href="{{ route('admin.enrollments.completed') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #10b981 !important;">
                <div class="pbz-kpi-icon-circle" style="background: #d1fae5; color: #059669;">
                    <i class="fas fa-circle-check"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ $analytics['overview']['completion_rate'] }}%</div>
                    <div class="pbz-kpi-lbl">ENROLLMENT COMPLETION</div>
                </div>
            </a>

            <!-- 4. Mandatory Mandates Pending -->
            <a href="{{ route('admin.enrollments.pending') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #f59e0b !important;">
                <div class="pbz-kpi-icon-circle" style="background: #fef3c7; color: #d97706;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ number_format($analytics['overview']['pending_enrollments']) }}</div>
                    <div class="pbz-kpi-lbl">MANDATORY ENROLLMENTS PENDING</div>
                </div>
            </a>

            <!-- 5. Active Learners -->
            <a href="{{ route('admin.enrollments.index') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #006837 !important;">
                <div class="pbz-kpi-icon-circle" style="background: #dcfce7; color: #16a34a;">
                    <i class="fas fa-bolt"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ number_format($analytics['student_engagement']['active_students']) }}</div>
                    <div class="pbz-kpi-lbl">ACTIVE (LAST 7 DAYS)</div>
                </div>
            </a>

            <!-- 6. Inactive / Not Active -->
            <a href="{{ route('admin.students.index') }}" class="pbz-kpi-top-card text-decoration-none" style="border-left-color: #ef4444 !important;">
                <div class="pbz-kpi-icon-circle" style="background: #fee2e2; color: #dc2626;">
                    <i class="fas fa-pause"></i>
                </div>
                <div>
                    <div class="pbz-kpi-val">{{ number_format($analytics['overview']['inactive_7d_count'] ?? $analytics['student_engagement']['at_risk_students']) }}</div>
                    <div class="pbz-kpi-lbl">NOT ACTIVE (7 DAYS)</div>
                </div>
            </a>
        </div>

        <!-- Row 2: COURSE OUTCOME KPIS (The 7 Vibrant Solid Rounded Cards) -->
        <div class="kpi-section-title">COURSE OUTCOME KPIS</div>
        <div class="pbz-outcome-grid">
            <!-- 1. Total Learners (Cyan) -->
            <a href="{{ route('admin.students.index') }}" class="pbz-outcome-card text-decoration-none" style="background: #0099cc;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">TOTAL LEARNERS</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-users"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['overview']['total_students']) }}</div>
                <div class="pbz-outcome-pill">
                    <i class="fas fa-arrow-right"></i> {{ $analytics['overview']['students_change_pct'] !== null ? abs($analytics['overview']['students_change_pct']) : 0 }}% vs previous 30 days
                </div>
            </a>

            <!-- 2. Resigned Midway / At Risk (Orange) -->
            <a href="{{ route('admin.enrollments.pending') }}" class="pbz-outcome-card text-decoration-none" style="background: #f97316;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">RESIGNED MIDWAY</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-user-slash"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['student_engagement']['at_risk_students']) }}</div>
                <div class="pbz-outcome-sub">{{ $analytics['student_engagement']['at_risk_percentage'] }}% of learners</div>
            </a>

            <!-- 3. Course Enrollments (Sky Blue) -->
            <a href="{{ route('admin.enrollments.index') }}" class="pbz-outcome-card text-decoration-none" style="background: #0284c7;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">COURSE ENROLLMENTS</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-book-open"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['overview']['total_enrollments']) }}</div>
                <div class="pbz-outcome-sub">{{ number_format($analytics['overview']['this_month_enrollments']) }} new this month</div>
            </a>

            <!-- 4. In Progress / Pending Verification (Coral / Red) -->
            <a href="{{ route('admin.enrollments.pending') }}" class="pbz-outcome-card text-decoration-none" style="background: #ef4444;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">PENDING VERIFICATION</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-hourglass-half"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['overview']['pending_enrollments']) }}</div>
                <div class="pbz-outcome-pill">
                    <i class="fas fa-arrow-right"></i> Active cohort learning
                </div>
            </a>

            <!-- 5. Passed / Completed (PBZ Green) -->
            <a href="{{ route('admin.enrollments.completed') }}" class="pbz-outcome-card text-decoration-none" style="background: #006837;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">PASSED</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-circle-check"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['student_engagement']['completing_students']) }}</div>
                <div class="pbz-outcome-pill">
                    <i class="fas fa-arrow-right"></i> {{ $analytics['overview']['completion_rate'] }}% of course enrollments
                </div>
            </a>

            <!-- 6. Certificates Issued / Approved Reviews (Purple) -->
            <a href="{{ route('admin.certificates.index') }}" class="pbz-outcome-card text-decoration-none" style="background: #8b5cf6;">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title">CERTIFICATES ISSUED</span>
                    <span class="pbz-outcome-icon"><i class="fas fa-award"></i></span>
                </div>
                <div class="pbz-outcome-val">{{ number_format($analytics['overview']['total_certificates'] ?? $analytics['overview']['completed_enrollments']) }}</div>
                <div class="pbz-outcome-pill">
                    <i class="fas fa-arrow-right"></i> Avg {{ round($analytics['overview']['average_rating'], 1) }}/5.0 score
                </div>
            </a>

            <!-- 7. BOT Regulatory Adherence (Submarine Navy / Cyan) -->
            <a href="{{ route('admin.compliance.branch-matrix') }}" class="pbz-outcome-card text-decoration-none" style="background: #07172b; border: 1px solid rgba(56, 189, 248, 0.35);">
                <div class="pbz-outcome-head">
                    <span class="pbz-outcome-title" style="color: #38bdf8;">BOT COMPLIANCE</span>
                    <span class="pbz-outcome-icon" style="color: #38bdf8;"><i class="fas fa-scale-balanced"></i></span>
                </div>
                <div class="pbz-outcome-val" style="font-size: 20px; color: #f8fafc;">100% AUDIT</div>
                <div class="pbz-outcome-pill" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8;">
                    <i class="fas fa-building-shield"></i> Branch Oversight
                </div>
            </a>
        </div>

        <!-- Row 3: Department Readiness / Analytics Trend Chart & Overall Course Leaders -->
        <div class="row g-3 mb-4">
            <!-- Left Chart Card (Col-8) -->
            <div class="col-lg-8">
                <div class="pbz-native-card h-100 mb-0">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h4 class="pbz-card-title">Department Readiness &amp; Analytics Trend</h4>
                            <p class="pbz-card-sub">Track revenue performance and course enrollment metrics over time.</p>
                        </div>
                        
                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                            <div class="period-filters">
                                <button type="button" class="pbz-pill-btn period-btn active" data-period="thirty_days" data-chart="revenue">30 Days</button>
                                <button type="button" class="pbz-pill-btn period-btn" data-period="this_year" data-chart="revenue">Yearly</button>
                                <button type="button" class="pbz-pill-btn period-btn" data-period="last_12_months" data-chart="revenue">12 Months</button>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container" style="position: relative; height: 320px; width: 100%;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Overall Course Leaders (Col-4) -->
            <div class="col-lg-4">
                <div class="pbz-native-card h-100 mb-0 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <div>
                            <h4 class="pbz-card-title">Overall Course Leaders</h4>
                            <p class="pbz-card-sub" style="font-size: 11.5px;">Compare top participants and courses across academy outcomes.</p>
                        </div>
                        <div class="badge px-2 py-1 rounded-pill" style="background: #e0f2fe; color: #0284c7; font-size: 10.5px; font-weight: 700;">
                            {{ count($analytics['top_courses']) }} Ranked
                        </div>
                    </div>

                    <!-- Filter pills -->
                    <div class="d-flex align-items-center gap-1 mb-3">
                        <button type="button" class="pbz-pill-btn active" style="font-size: 11px; padding: 2px 10px;">Top Courses</button>
                        <button type="button" class="pbz-pill-btn" style="font-size: 11px; padding: 2px 10px;">Participants</button>
                    </div>

                    <!-- Legend -->
                    <div class="d-flex align-items-center gap-2 mb-3" style="font-size: 10.5px;">
                        <span class="badge" style="background: #dcfce7; color: #16a34a; font-weight: 600;">70%+</span>
                        <span class="badge" style="background: #fef3c7; color: #d97706; font-weight: 600;">40-69%</span>
                        <span class="badge" style="background: #fee2e2; color: #dc2626; font-weight: 600;">Below 40%</span>
                    </div>

                    <!-- Course Leaders List -->
                    <div class="flex-grow-1 overflow-auto" style="max-height: 270px;">
                        @forelse($analytics['top_courses'] as $index => $course)
                            <a href="{{ route('admin.courses.show', $course['id']) }}" class="pbz-leader-item text-decoration-none">
                                <div class="pbz-leader-rank">{{ $index + 1 }}</div>
                                <img src="{{ $course['thumbnail'] ?? asset('assets/front/img/course/placeholder.jpg') }}"
                                     alt="{{ $course['title'] }}" class="pbz-leader-thumb">
                                <div class="pbz-leader-info">
                                    <div class="pbz-leader-title" title="{{ $course['title'] }}">{{ $course['title'] }}</div>
                                    <div class="pbz-leader-stats">
                                        <span><i class="fas fa-users text-primary me-0.5"></i> {{ number_format($course['enrollments']) }}</span>
                                        <span><i class="fas fa-star text-warning me-0.5"></i> {{ $course['rating'] }}</span>
                                        <span class="ms-auto fw-bold text-dark">{{ currency_format($course['revenue']) }}</span>
                                    </div>
                                    <div class="progress mt-1.5" style="height: 4px; border-radius: 2px; background: #e2e8f0;">
                                        <div class="progress-bar {{ $course['completion_rate'] >= 70 ? 'bg-success' : ($course['completion_rate'] >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                             style="width: {{ $course['completion_rate'] }}%;"></div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted" style="font-size: 12.5px;">
                                <i class="fas fa-graduation-cap fs-4 mb-2 d-block text-secondary"></i>
                                No course leader data available yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Recent Transactions (Col-8) & Student Engagement + Activity Stream (Col-4) -->
        <div class="row g-3">
            <!-- Recent Staff Enrollments Table (Col-8) -->
            <div class="col-lg-8">
                <div class="pbz-native-card mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h4 class="pbz-card-title">Recent Staff Enrollments &amp; Mandate Progress</h4>
                            <p class="pbz-card-sub">Audited real-time enrollment progress and branch compliance records.</p>
                        </div>
                        <a href="{{ route('admin.enrollments.index') }}" class="btn btn-sm btn-outline-primary py-1 px-3 rounded-2 fw-bold" style="font-size: 11.5px;">
                            View All <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 12.5px;">
                            <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                                <tr>
                                    <th>Date</th>
                                    <th>Course Mandate</th>
                                    <th>Bank Staff</th>
                                    <th>Branch</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['recent_transactions'] as $tx)
                                    <tr>
                                        <td class="text-muted" style="font-size: 11.5px;">{{ $tx['date'] }}</td>
                                        <td>
                                            <a href="{{ route('admin.enrollments.index') }}" class="fw-semibold text-dark text-decoration-none hover-link" title="{{ $tx['course_title'] ?? $tx['description'] ?? 'Course' }}">
                                                {{ \Illuminate\Support\Str::limit($tx['course_title'] ?? $tx['description'] ?? 'Course', 34) }}
                                            </a>
                                        </td>
                                        <td>{{ $tx['student_name'] ?? $tx['student'] ?? 'Staff' }}</td>
                                        <td class="text-muted" style="font-size: 11.5px;">
                                            <i class="fas fa-location-dot me-1 text-primary"></i>{{ $tx['branch'] ?? 'Zanzibar Branch' }}
                                        </td>
                                        <td>
                                            @php($st = strtolower($tx['status'] ?? 'pending'))
                                            @if($st === 'completed' || $st === 'approved')
                                                <span class="badge" style="background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 10px;">{{ strtoupper($st) }}</span>
                                            @elseif($st === 'pending')
                                                <span class="badge" style="background: #fef3c7; color: #d97706; font-weight: 700; font-size: 10px;">IN PROGRESS</span>
                                            @else
                                                <span class="badge" style="background: #fee2e2; color: #dc2626; font-weight: 700; font-size: 10px;">{{ strtoupper($st) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No recent staff enrollments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Secondary Enrollment Volume Chart -->
                <div class="pbz-native-card">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h4 class="pbz-card-title">Enrollment Distribution Overview</h4>
                            <p class="pbz-card-sub">Monthly course intake volume across corporate departments.</p>
                        </div>
                        <select class="form-select form-select-sm period-select" data-chart="enrollment" style="width: auto; font-size: 12px;">
                            <option value="thirty_days">30 Days</option>
                            <option value="this_year">Yearly</option>
                            <option value="last_12_months" selected>12 Months</option>
                        </select>
                    </div>
                    <div class="chart-container" style="position: relative; height: 260px; width: 100%;">
                        <canvas id="enrollmentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Student Engagement & Activity Stream (Col-4) -->
            <div class="col-lg-4">
                <!-- Engagement Progress Bars Card -->
                <div class="pbz-native-card mb-3">
                    <h4 class="pbz-card-title mb-1">Learner Engagement Score</h4>
                    <p class="pbz-card-sub mb-3">Active retention and completion health indicators.</p>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                            <span class="fw-semibold text-dark">Active Learners</span>
                            <span class="fw-bold text-success">{{ $analytics['student_engagement']['active_students'] }} ({{ $analytics['student_engagement']['active_percentage'] }}%)</span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 3px; background: #e2e8f0;">
                            <div class="progress-bar bg-success" style="width: {{ $analytics['student_engagement']['active_percentage'] }}%;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                            <span class="fw-semibold text-dark">Completed Modules</span>
                            <span class="fw-bold text-primary">{{ $analytics['student_engagement']['completing_students'] }} ({{ $analytics['student_engagement']['completing_percentage'] }}%)</span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 3px; background: #e2e8f0;">
                            <div class="progress-bar" style="background-color: #0099cc; width: {{ $analytics['student_engagement']['completing_percentage'] }}%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12px;">
                            <span class="fw-semibold text-dark">At Risk / Inactive</span>
                            <span class="fw-bold text-warning">{{ $analytics['student_engagement']['at_risk_students'] }} ({{ $analytics['student_engagement']['at_risk_percentage'] }}%)</span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 3px; background: #e2e8f0;">
                            <div class="progress-bar bg-warning" style="width: {{ $analytics['student_engagement']['at_risk_percentage'] }}%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Stream -->
                <div class="pbz-native-card mb-3">
                    <h4 class="pbz-card-title mb-1">Recent Activity Stream</h4>
                    <p class="pbz-card-sub mb-3">Real-time alerts, course enrollments, and reviews.</p>

                    <div class="d-flex flex-column gap-2.5">
                        @forelse($analytics['recent_activity'] as $activity)
                            <div class="d-flex align-items-start gap-2.5 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 28px; height: 28px; background: #e0f2fe; color: #0284c7; font-size: 11px;">
                                    <i class="fas {{ $activity['icon'] }}"></i>
                                </div>
                                <div class="min-w-0 flex-grow-1" style="line-height: 1.3;">
                                    <div class="text-dark" style="font-size: 12px;">{{ $activity['message'] }}</div>
                                    <div class="text-muted" style="font-size: 10.5px;">{{ $activity['time'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-3 text-muted" style="font-size: 12px;">No recent activity.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Event Bookings -->
                @if(count($analytics['recent_event_bookings']) > 0)
                    <div class="pbz-native-card">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h4 class="pbz-card-title mb-0">Event Bookings</h4>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-link p-0 text-primary fw-bold" style="font-size: 11px;">View All</a>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            @foreach($analytics['recent_event_bookings'] as $booking)
                                <a href="{{ route('admin.events.index') }}" class="p-2 rounded-2 border d-flex align-items-center justify-content-between gap-2 text-decoration-none" style="background: #f8fafc; border-color: #e2e8f0; font-size: 11.5px; transition: background 0.15s ease;">
                                    <div class="min-w-0">
                                        <div class="fw-bold text-dark text-truncate">{{ $booking['user_name'] }}</div>
                                        <div class="text-muted text-truncate" style="font-size: 10.5px;">{{ $booking['event_title'] }} ({{ $booking['seats'] }} seat{{ $booking['seats'] > 1 ? 's' : '' }})</div>
                                    </div>
                                    <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 9.5px; font-weight: 700;">
                                        {{ strtoupper($booking['status']) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/admin/modules/chart.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                const analyticsData = {!! json_encode($analytics['charts']) !!};

                // Revenue Trend Chart Init
                const revCtx = document.getElementById('revenueChart').getContext('2d');
                let revenueChart = new Chart(revCtx, {
                    type: 'line',
                    data: {
                        labels: analyticsData.thirty_days.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: analyticsData.thirty_days.revenue,
                            borderColor: '#006837',
                            backgroundColor: 'rgba(0, 104, 55, 0.08)',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#006837',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.35,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 12, family: 'Inter' },
                                bodyFont: { size: 12, family: 'Inter' },
                                padding: 10,
                                cornerRadius: 6,
                                callbacks: {
                                    label: function(context) {
                                        return ' ' + context.dataset.label + ': $' + Number(context.raw).toLocaleString();
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(226, 232, 240, 0.6)' },
                                ticks: {
                                    font: { family: 'Inter', size: 11 },
                                    color: '#64748b',
                                    callback: function (value) { return '$' + Number(value).toLocaleString(); }
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Inter', size: 10.5 }, color: '#64748b' }
                            }
                        }
                    }
                });

                // Enrollment Overview Chart Init
                const enCtx = document.getElementById('enrollmentChart').getContext('2d');
                let enrollmentChart = new Chart(enCtx, {
                    type: 'bar',
                    data: {
                        labels: analyticsData.last_12_months.labels,
                        datasets: [{
                            label: 'Enrollments',
                            data: analyticsData.last_12_months.enrollments,
                            backgroundColor: '#0099cc',
                            borderRadius: 4,
                            maxBarThickness: 24
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 12, family: 'Inter' },
                                bodyFont: { size: 12, family: 'Inter' },
                                padding: 10,
                                cornerRadius: 6
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(226, 232, 240, 0.6)' },
                                ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { family: 'Inter', size: 10.5 }, color: '#64748b' }
                            }
                        }
                    }
                });

                // Chart Filter Buttons
                $('.period-btn').on('click', function () {
                    const btn = $(this);
                    const period = btn.data('period');
                    const chartType = btn.data('chart');

                    btn.siblings().removeClass('active');
                    btn.addClass('active');

                    if (chartType === 'revenue') {
                        revenueChart.data.labels = analyticsData[period].labels;
                        revenueChart.data.datasets[0].data = analyticsData[period].revenue;
                        revenueChart.update();
                    }
                });

                $('.period-select').on('change', function () {
                    const select = $(this);
                    const period = select.val();
                    const chartType = select.data('chart');

                    if (chartType === 'enrollment') {
                        enrollmentChart.data.labels = analyticsData[period].labels;
                        enrollmentChart.data.datasets[0].data = analyticsData[period].enrollments;
                        enrollmentChart.update();
                    }
                });

                // Dynamic Top Academy Filter updates
                function applyTopFilters() {
                    const params = new URLSearchParams();
                    const courseId = $('#dashFilterCourse').val();
                    const categoryId = $('#dashFilterCategory').val();
                    const status = $('#dashFilterStatus').val();

                    if (courseId) params.set('course_id', courseId);
                    if (categoryId) params.set('category_id', categoryId);
                    if (status) params.set('status', status);

                    const targetUrl = '{{ route("admin.dashboard") }}' + (params.toString() ? ('?' + params.toString()) : '');
                    window.location.href = targetUrl;
                }

                $('#dashFilterCourse, #dashFilterCategory, #dashFilterStatus').on('change', applyTopFilters);
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Global Dashboard & Layout Overrides */
            body {
                background-color: #f1f5f9 !important;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            }
            .main-content {
                background-color: #f1f5f9 !important;
                padding-top: 80px !important;
                padding-left: 270px !important;
                padding-right: 25px !important;
            }
            @media (max-width: 1024px) {
                .main-content {
                    padding-left: 20px !important;
                    padding-right: 20px !important;
                }
            }

            /* Corporate Dark Compact Sidebar */
            body .main-sidebar,
            body .main-sidebar.sidebar-style-2,
            body .main-sidebar #sidebar-wrapper,
            body:not(.sidebar-mini) .sidebar-style-2 {
                background-color: #071927 !important;
                border-right: 1px solid rgba(255, 255, 255, 0.07) !important;
                box-shadow: 2px 0 16px rgba(0, 0, 0, 0.2) !important;
                width: 250px !important;
            }

            body .main-sidebar .sidebar-brand {
                background-color: #071927 !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            }

            body .main-sidebar .sidebar-menu {
                padding: 6px 0 !important;
            }

            body .main-sidebar .sidebar-menu li.menu-header {
                padding: 14px 18px 4px !important;
                font-size: 9.5px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.8px !important;
                text-transform: uppercase !important;
                line-height: normal !important;
                height: auto !important;
            }

            body .main-sidebar .sidebar-menu li a {
                color: #94a3b8 !important;
                height: auto !important;
                padding: 8px 16px !important;
                font-size: 12.5px !important;
                font-weight: 500 !important;
                display: flex !important;
                align-items: center !important;
                letter-spacing: 0.1px;
                transition: all 0.15s ease-in-out !important;
            }

            body .main-sidebar .sidebar-menu li a i {
                width: 20px !important;
                margin-right: 10px !important;
                font-size: 13.5px !important;
                color: #94a3b8 !important;
                text-align: center !important;
                flex-shrink: 0 !important;
            }

            body .main-sidebar .sidebar-menu li a:hover {
                color: #ffffff !important;
                background-color: rgba(255, 255, 255, 0.05) !important;
            }

            body .main-sidebar .sidebar-menu li a:hover i {
                color: #38bdf8 !important;
            }

            body .main-sidebar .sidebar-menu li.active > a {
                color: #ffffff !important;
                background-color: rgba(0, 153, 204, 0.16) !important;
                border-left: 3px solid #0099cc !important;
                font-weight: 600 !important;
            }

            body .main-sidebar .sidebar-menu li.active > a i {
                color: #38bdf8 !important;
            }

            body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu > li.active > a:before {
                display: none !important;
            }

            body .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu {
                background-color: #040e18 !important;
                padding: 4px 0 !important;
                border-left: 2px solid rgba(0, 153, 204, 0.25) !important;
                margin-left: 16px !important;
                border-radius: 4px !important;
                box-shadow: none !important;
            }

            body .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu li a {
                padding: 6px 14px !important;
                font-size: 12px !important;
                color: #94a3b8 !important;
                background-color: transparent !important;
            }

            body .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu li a:hover,
            body .main-sidebar .sidebar-menu li.dropdown ul.dropdown-menu li.active a {
                color: #38bdf8 !important;
                background-color: rgba(255, 255, 255, 0.04) !important;
            }

            /* Navbar Dark Styling */
            .navbar-bg {
                background-color: #071927 !important;
                height: 70px !important;
            }
            .main-navbar .nav-link {
                color: #cbd5e1 !important;
            }
            .main-navbar .nav-link:hover {
                color: #ffffff !important;
            }

            /* Instant Filters Card */
            .academy-filters-card {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 8px !important;
                padding: 12px 18px !important;
                margin-bottom: 18px !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
            }

            .filters-btn-badge {
                display: inline-flex !important;
                align-items: center !important;
                gap: 6px !important;
                background: #0284c7 !important;
                color: #ffffff !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                letter-spacing: 0.5px !important;
                padding: 6px 14px !important;
                border-radius: 6px !important;
                flex-shrink: 0 !important;
            }

            .filter-mini-label {
                font-size: 10px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.5px !important;
                text-transform: uppercase !important;
                margin-bottom: 2px !important;
                display: block !important;
            }

            .filter-select {
                font-size: 12px !important;
                border-color: #cbd5e1 !important;
                border-radius: 6px !important;
                height: 34px !important;
                color: #1e293b !important;
                background-color: #ffffff !important;
                padding: 4px 8px !important;
            }

            /* Top 6 KPI Metric Cards Grid */
            .pbz-kpi-grid-top {
                display: grid !important;
                grid-template-columns: repeat(6, 1fr) !important;
                gap: 12px !important;
                margin-bottom: 20px !important;
            }

            @media (max-width: 1400px) {
                .pbz-kpi-grid-top {
                    grid-template-columns: repeat(3, 1fr) !important;
                }
            }
            @media (max-width: 768px) {
                .pbz-kpi-grid-top {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
            @media (max-width: 480px) {
                .pbz-kpi-grid-top {
                    grid-template-columns: 1fr !important;
                }
            }

            .pbz-kpi-top-card {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 8px !important;
                padding: 13px 14px !important;
                display: flex !important;
                align-items: center !important;
                gap: 11px !important;
                border-left-width: 4px !important;
                border-left-style: solid !important;
                transition: transform 0.15s ease, box-shadow 0.15s ease !important;
            }

            .pbz-kpi-top-card:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            }

            .pbz-kpi-icon-circle {
                width: 38px !important;
                height: 38px !important;
                border-radius: 8px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 15px !important;
                flex-shrink: 0 !important;
            }

            .pbz-kpi-val {
                font-size: 22px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                line-height: 1.1 !important;
            }

            .pbz-kpi-lbl {
                font-size: 10px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.5px !important;
                text-transform: uppercase !important;
                margin-top: 3px !important;
                white-space: nowrap !important;
            }

            /* Course Outcome KPIs Grid (7 Cards) */
            .kpi-section-title {
                font-size: 11px !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.8px !important;
                text-transform: uppercase !important;
                margin-bottom: 8px !important;
            }

            .pbz-outcome-grid {
                display: grid !important;
                grid-template-columns: repeat(7, 1fr) !important;
                gap: 10px !important;
                margin-bottom: 22px !important;
            }

            @media (max-width: 1400px) {
                .pbz-outcome-grid {
                    grid-template-columns: repeat(4, 1fr) !important;
                }
            }
            @media (max-width: 992px) {
                .pbz-outcome-grid {
                    grid-template-columns: repeat(3, 1fr) !important;
                }
            }
            @media (max-width: 576px) {
                .pbz-outcome-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }

            .pbz-outcome-card {
                border-radius: 8px !important;
                padding: 13px !important;
                color: #ffffff !important;
                position: relative !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                min-height: 115px !important;
                transition: transform 0.15s ease, box-shadow 0.15s ease !important;
            }

            .pbz-outcome-card:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
            }

            .pbz-outcome-head {
                display: flex !important;
                align-items: flex-start !important;
                justify-content: space-between !important;
                gap: 6px !important;
            }

            .pbz-outcome-title {
                font-size: 9.5px !important;
                font-weight: 700 !important;
                letter-spacing: 0.4px !important;
                text-transform: uppercase !important;
                opacity: 0.95 !important;
                line-height: 1.2 !important;
            }

            .pbz-outcome-icon {
                width: 24px !important;
                height: 24px !important;
                border-radius: 50% !important;
                background: rgba(255, 255, 255, 0.22) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 11px !important;
                flex-shrink: 0 !important;
            }

            .pbz-outcome-val {
                font-size: 24px !important;
                font-weight: 700 !important;
                line-height: 1 !important;
                margin: 4px 0 !important;
            }

            .pbz-outcome-sub {
                font-size: 10px !important;
                opacity: 0.9 !important;
                line-height: 1.2 !important;
            }

            .pbz-outcome-pill {
                display: inline-flex !important;
                align-items: center !important;
                gap: 3px !important;
                background: rgba(0, 0, 0, 0.18) !important;
                border-radius: 20px !important;
                padding: 2px 7px !important;
                font-size: 9.5px !important;
                font-weight: 600 !important;
                width: fit-content !important;
                margin-top: 4px !important;
            }

            /* Native Cards */
            .pbz-native-card {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 8px !important;
                padding: 16px 18px !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02) !important;
                margin-bottom: 20px !important;
            }

            .pbz-card-title {
                font-size: 14px !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                margin-bottom: 2px !important;
            }

            .pbz-card-sub {
                font-size: 12px !important;
                color: #64748b !important;
                margin-bottom: 0 !important;
            }

            .pbz-pill-btn {
                padding: 3px 12px !important;
                border-radius: 20px !important;
                font-size: 11.5px !important;
                font-weight: 600 !important;
                border: 1px solid #cbd5e1 !important;
                background: #f8fafc !important;
                color: #64748b !important;
                transition: all 0.15s ease !important;
                cursor: pointer !important;
            }

            .pbz-pill-btn.active, .pbz-pill-btn:hover {
                background: #0284c7 !important;
                color: #ffffff !important;
                border-color: #0284c7 !important;
            }

            /* Compact Course Leader Item */
            .pbz-leader-item {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                padding: 10px 12px !important;
                border-radius: 6px !important;
                border: 1px solid #f1f5f9 !important;
                margin-bottom: 8px !important;
                background: #ffffff !important;
                transition: border-color 0.15s ease, background-color 0.15s ease !important;
            }

            .pbz-leader-item:hover {
                border-color: #cbd5e1 !important;
                background-color: #f8fafc !important;
            }

            .pbz-leader-rank {
                width: 22px !important;
                height: 22px !important;
                border-radius: 50% !important;
                background: #e2e8f0 !important;
                color: #475569 !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                flex-shrink: 0 !important;
            }

            .pbz-leader-thumb {
                width: 44px !important;
                height: 32px !important;
                border-radius: 4px !important;
                object-fit: cover !important;
                flex-shrink: 0 !important;
            }

            .pbz-leader-info {
                flex-grow: 1 !important;
                min-width: 0 !important;
            }

            .pbz-leader-title {
                font-size: 12.5px !important;
                font-weight: 600 !important;
                color: #0f172a !important;
                line-height: 1.25 !important;
                margin-bottom: 2px !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            .pbz-leader-stats {
                font-size: 11px !important;
                color: #64748b !important;
                display: flex !important;
                align-items: center !important;
                gap: 8px !important;
            }

            a.pbz-kpi-top-card {
                text-decoration: none !important;
                color: inherit !important;
                cursor: pointer !important;
            }
            a.pbz-kpi-top-card:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08) !important;
            }
            a.pbz-outcome-card {
                text-decoration: none !important;
                color: #ffffff !important;
                cursor: pointer !important;
            }
            a.pbz-outcome-card:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16) !important;
                filter: brightness(1.05) !important;
                color: #ffffff !important;
            }
            a.pbz-leader-item {
                text-decoration: none !important;
                color: inherit !important;
                cursor: pointer !important;
            }
            a.pbz-leader-item:hover {
                border-color: #cbd5e1 !important;
                background-color: #f1f5f9 !important;
            }
            .hover-link:hover {
                color: #0284c7 !important;
                text-decoration: underline !important;
            }
        </style>
    @endpush
@endsection
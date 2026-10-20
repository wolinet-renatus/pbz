@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.assignments') ?? 'Assignment Details'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <!-- Top Navigation Bar -->
            <div class="pbz-submission-topbar">
                <div>
                    <a href="{{ route('instructor.assignments.index') }}" class="pbz-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>{{ __('instructor.back_to_assignments') }}</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-size-13">
                        <i class="fa-solid fa-graduation-cap text-primary me-1"></i>
                        {{ optional($assignment->topic->course)->title ?? __('instructor.unknown_course') }}
                    </span>
                    @if(optional($assignment->topic)->title)
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill font-size-13">
                            <i class="fa-solid fa-folder-tree me-1"></i>
                            {{ $assignment->topic->title }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Page Title Area -->
            <div class="section-title-area mb-3">
                <div class="section-title mb-0">
                    <h6 style="color: var(--saas-primary, #004f44); font-size: 13px; font-weight: 700; margin-bottom: 3px;">{{ __('instructor.assignments') }}</h6>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ $assignment->title }}</h2>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">{{ __('instructor.review_grade_subtitle') }}</p>
                </div>
            </div>

            <!-- Assignment Overview & Metrics Card (Mobile-First) -->
            <div class="pbz-assignment-detail-card">
                <!-- KPI Metrics Grid -->
                <div class="pbz-assignment-kpi-grid">
                    <div class="pbz-assignment-kpi-card pbz-kpi-total">
                        <div class="pbz-assignment-kpi-icon">
                            <i class="fa-solid fa-inbox"></i>
                        </div>
                        <div class="pbz-assignment-kpi-details">
                            <span class="pbz-assignment-kpi-label">{{ __('instructor.total_submissions') }}</span>
                            <span class="pbz-assignment-kpi-num">{{ $assignment->submissions_count }}</span>
                        </div>
                    </div>

                    <div class="pbz-assignment-kpi-card pbz-kpi-pending">
                        <div class="pbz-assignment-kpi-icon">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <div class="pbz-assignment-kpi-details">
                            <span class="pbz-assignment-kpi-label">{{ __('instructor.status_pending') }}</span>
                            <span class="pbz-assignment-kpi-num">{{ $assignment->pending_submissions_count }}</span>
                        </div>
                    </div>

                    <div class="pbz-assignment-kpi-card pbz-kpi-graded">
                        <div class="pbz-assignment-kpi-icon">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                        <div class="pbz-assignment-kpi-details">
                            <span class="pbz-assignment-kpi-label">{{ __('instructor.graded') }}</span>
                            <span class="pbz-assignment-kpi-num">{{ $assignment->graded_submissions_count }}</span>
                        </div>
                    </div>

                    <div class="pbz-assignment-kpi-card pbz-kpi-returned">
                        <div class="pbz-assignment-kpi-icon">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <div class="pbz-assignment-kpi-details">
                            <span class="pbz-assignment-kpi-label">{{ __('instructor.returned') }}</span>
                            <span class="pbz-assignment-kpi-num">{{ $assignment->returned_submissions_count }}</span>
                        </div>
                    </div>
                </div>

                <!-- Assignment Instructions Box -->
                @if ($assignment->instructions || $assignment->description)
                    <div class="pbz-assignment-instructions-card">
                        <div class="pbz-assignment-instructions-header" data-bs-toggle="collapse" data-bs-target="#assignmentBriefCollapse" aria-expanded="true">
                            <span>
                                <i class="fa-solid fa-circle-info text-primary me-2"></i>
                                {{ $assignment->instructions ? __('instructor.instructions') : __('instructor.description_label') }}
                            </span>
                            <i class="fa-solid fa-chevron-down font-size-12 text-muted"></i>
                        </div>
                        <div id="assignmentBriefCollapse" class="collapse show">
                            <div class="pbz-assignment-instructions-body">
                                {!! $assignment->instructions ?: $assignment->description !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Filters Bar (Native Mobile-First) -->
            <div class="pbz-filter-card">
                <form method="GET" action="{{ route('instructor.assignments.show', $assignment->id) }}">
                    <div class="pbz-filter-grid">
                        <!-- Status Selector -->
                        <div class="pbz-filter-item">
                            <select id="status-filter" name="status" class="pbz-select">
                                <option value="">{{ __('instructor.select') }} (All Statuses)</option>
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $statusFilter === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Box -->
                        <div class="pbz-filter-item-search">
                            <div class="position-relative">
                                <input type="search" id="submission-search" name="search" class="pbz-input pe-5"
                                    value="{{ $searchTerm }}" placeholder="{{ __('instructor.search_student_placeholder') }}">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="pbz-filter-actions-row d-flex gap-2">
                            <button type="submit" class="pbz-filter-btn">
                                <i class="fa-solid fa-filter"></i>
                                {{ __('instructor.apply_filters') }}
                            </button>
                            @if ($statusFilter || $searchTerm)
                                <a href="{{ route('instructor.assignments.show', $assignment->id) }}" class="pbz-reset-btn">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    {{ __('instructor.reset') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <!-- Submissions Container -->
            @if ($submissions->isNotEmpty())
                <!-- Desktop Table View (>= 768px) -->
                <div class="pbz-dash-card p-0 d-none d-md-block mb-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="students-table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ __('instructor.student_col') }}</th>
                                    <th>{{ __('instructor.submitted') }}</th>
                                    <th>{{ __('instructor.status_col') }}</th>
                                    <th>{{ __('instructor.grade') }}</th>
                                    <th class="text-end">{{ __('instructor.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($submissions as $submission)
                                    <tr>
                                        <td>
                                            <div class="student-table-info d-flex align-items-center gap-3">
                                                <div class="pbz-student-avatar" style="width: 38px; height: 38px; border-radius: 10px;">
                                                    <img src="{{ $submission->user->profile_photo ? asset('storage/' . $submission->user->profile_photo) : asset('assets/front/img/home-1/courses/client-01.png') }}"
                                                        alt="{{ $submission->user->name }}">
                                                </div>
                                                <div class="student-details">
                                                    <div class="fw-bold text-dark font-size-14">{{ $submission->user->name }}</div>
                                                    <small class="text-muted font-size-12">{{ $submission->user->email ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-dark fw-medium font-size-13">
                                                {{ optional($submission->submitted_at)->format('M d, Y') ?? '—' }}
                                            </span>
                                            <small class="text-muted d-block font-size-11">
                                                {{ optional($submission->submitted_at)->format('h:i A') ?? '' }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="pbz-status-pill {{ $statusClasses[$submission->status] ?? 'pending' }}">
                                                @if($submission->status === 'graded')
                                                    <i class="fa-solid fa-check"></i>
                                                @elseif($submission->status === 'returned')
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                @else
                                                    <i class="fa-solid fa-hourglass-half"></i>
                                                @endif
                                                {{ $statusOptions[$submission->status] ?? ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($submission->grade !== null)
                                                <span class="fw-bold font-size-14" style="color: var(--saas-primary, #004f44);">
                                                    {{ $submission->grade }}%
                                                </span>
                                            @else
                                                <span class="text-muted font-size-13">{{ __('instructor.not_graded') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('instructor.assignments.submissions.show', $submission->id) }}"
                                                class="pbz-action-review-btn" title="{{ __('instructor.review_submission') }}">
                                                <i class="fa-solid fa-clipboard-check"></i>
                                                <span>{{ __('instructor.review_submission') }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Cards View (< 768px) -->
                <div class="pbz-submission-mobile-list d-block d-md-none mb-4">
                    @foreach($submissions as $submission)
                        <div class="pbz-sub-card">
                            <div class="pbz-sub-card-top">
                                <div class="pbz-sub-card-user">
                                    <div class="pbz-sub-card-avatar">
                                        <img src="{{ $submission->user->profile_photo ? asset('storage/' . $submission->user->profile_photo) : asset('assets/front/img/home-1/courses/client-01.png') }}"
                                            alt="{{ $submission->user->name }}">
                                    </div>
                                    <div>
                                        <h5 class="pbz-sub-card-name">{{ $submission->user->name }}</h5>
                                        <small class="text-muted font-size-11">{{ $submission->user->email ?? 'Student' }}</small>
                                    </div>
                                </div>
                                <span class="pbz-status-pill {{ $statusClasses[$submission->status] ?? 'pending' }}">
                                    {{ $statusOptions[$submission->status] ?? ucfirst($submission->status) }}
                                </span>
                            </div>

                            <div class="pbz-sub-card-info">
                                <div class="pbz-sub-card-date">
                                    <i class="fa-regular fa-calendar-check text-muted"></i>
                                    <span>{{ optional($submission->submitted_at)->format('M d, Y h:i A') ?? '—' }}</span>
                                </div>
                                <div class="pbz-sub-card-grade">
                                    {{ $submission->grade !== null ? $submission->grade . '%' : 'Not graded' }}
                                </div>
                            </div>

                            <a href="{{ route('instructor.assignments.submissions.show', $submission->id) }}"
                                class="pbz-action-review-btn w-100">
                                <i class="fa-solid fa-clipboard-check"></i>
                                <span>{{ __('instructor.review_submission') }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="pbz-dash-card text-center py-5 mb-4">
                    <div style="width: 64px; height: 64px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px;">
                        <i class="fa-solid fa-inbox"></i>
                    </div>
                    <h4 class="fw-bold text-dark font-size-17 mb-1">{{ __('instructor.no_submissions_yet') }}</h4>
                    <p class="text-muted font-size-13 mb-3 mx-auto" style="max-width: 420px;">{{ __('instructor.no_submissions_desc') }}</p>
                    @if ($statusFilter || $searchTerm)
                        <a href="{{ route('instructor.assignments.show', $assignment->id) }}" class="pbz-reset-btn">
                            <i class="fa-solid fa-rotate-left"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            @endif

            <!-- Pagination -->
            @if ($submissions->hasPages())
                <div class="table-pagination mt-4 mb-4">
                    <div class="pagination-info text-muted font-size-13">
                        {{ __('instructor.showing_submissions', ['from' => $submissions->firstItem(), 'to' => $submissions->lastItem(), 'total' => $submissions->total()]) }}
                    </div>
                    <div class="pagination-links d-flex gap-1">
                        @if ($submissions->onFirstPage())
                            <span class="pagination-btn disabled">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $submissions->previousPageUrl() }}" class="pagination-btn">
                                <i class="fa-solid fa-chevron-left"></i>
                            </a>
                        @endif

                        <div class="pagination-numbers d-flex gap-1">
                            @foreach ($submissions->getUrlRange(max(1, $submissions->currentPage() - 2), min($submissions->lastPage(), $submissions->currentPage() + 2)) as $page => $url)
                                @if ($page == $submissions->currentPage())
                                    <span class="pagination-number active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        @if ($submissions->hasMorePages())
                            <a href="{{ $submissions->nextPageUrl() }}" class="pagination-btn">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-btn disabled">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>
@endsection

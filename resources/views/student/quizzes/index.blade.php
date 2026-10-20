@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Quiz Attempts'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-graduation-cap"></i> BOT MANDATORY EVALUATIONS
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">My Assessment Attempts</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Monitor your compliance test attempts, passing marks, and statutory question reviews.</p>
                    </div>

                    <!-- Mini KPI Badges -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-circle-question" style="color: #0099cc; font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Total:</span> <strong class="text-dark">{{ $summary['total_attempts'] }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check text-success" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Passed:</span> <strong class="text-dark">{{ $summary['passed_attempts'] }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Failed:</span> <strong class="text-dark">{{ $summary['failed_attempts'] }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-percent text-warning" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Avg:</span> <strong class="text-dark">{{ $summary['average_score'] !== null ? $summary['average_score'] . '%' : '—' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compact Filter Toolbar -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <form method="GET" action="{{ route('student.quiz-attempts') }}" class="row g-2 align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12px;"></i>
                            <input type="search" name="search" class="form-control form-control-sm ps-5 rounded-2"
                                   value="{{ $searchTerm }}" placeholder="Search by quiz title..." style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <select name="course_id" class="form-select form-select-sm rounded-2" style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                            <option value="">All Enrolled Courses</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ $selectedCourseId === $course->id ? 'selected' : '' }}>
                                    {{ Str::limit($course->title, 32) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-6">
                        <select name="status" class="form-select form-select-sm rounded-2" style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ $statusFilter === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-12 d-flex gap-1.5">
                        <button type="submit" class="btn btn-sm btn-primary fw-bold rounded-2 flex-grow-1" style="background-color: #006837; border-color: #006837; font-size: 12.5px; height: 35px;">
                            <i class="fa-solid fa-filter me-1"></i> Filter
                        </button>
                        @if ($selectedCourseId || $statusFilter || $searchTerm)
                            <a href="{{ route('student.quiz-attempts') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5" title="Reset Filters" style="font-size: 12.5px; height: 35px;">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Native Compact Cards Grid (Mobile First, Compact & Less Scrolling) -->
            <div class="row g-3 mb-3">
                @forelse($attempts as $attempt)
                    @php
                        $isPassed = str_contains(strtolower($attempt->status_label ?? ''), 'pass');
                    @endphp
                    <div class="col-xl-6 col-12">
                        <div class="card border rounded-3 bg-white h-100 shadow-none p-3.5 pbz-quiz-attempt-card" style="border-color: #e2e8f0; transition: border-color 0.15s ease;">
                            
                            <!-- Card Header -->
                            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: {{ $isPassed ? '#f0fdf4' : '#fef2f2' }}; color: {{ $isPassed ? '#16a34a' : '#dc2626' }}; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                                        <i class="fa-solid {{ $isPassed ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="fw-bold mb-0 text-truncate text-dark" style="font-size: 13.5px;" title="{{ $attempt->quiz_title }}">
                                            {{ $attempt->quiz_title }}
                                        </h5>
                                        <span class="text-muted text-truncate d-block" style="font-size: 11.5px;">
                                            <i class="fa-solid fa-graduation-cap me-1 text-primary"></i> {{ $attempt->course_title }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <span class="badge px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 10.5px; {{ $isPassed ? 'background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;' : 'background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca;' }}">
                                    {{ $attempt->status_label }}
                                </span>
                            </div>

                            <!-- Score & Metrics Strip -->
                            <div class="p-2 rounded-2 border d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3" style="background: #f8fafc; border-color: #e2e8f0; font-size: 12px;">
                                <div>
                                    <span class="text-muted">Score:</span> 
                                    <strong class="font-monospace {{ $isPassed ? 'text-success' : 'text-danger' }}" style="font-size: 14px;">{{ $attempt->score }}%</strong>
                                </div>
                                <div>
                                    <span class="text-muted">Time:</span> 
                                    <strong class="text-dark">{{ $attempt->time_taken_formatted ?? '—' }}</strong>
                                </div>
                                <div>
                                    <span class="text-muted">Completed:</span> 
                                    <strong class="text-dark">{{ $attempt->completed_at_formatted ?? '—' }}</strong>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #f1f5f9;">
                                <span class="text-muted font-monospace" style="font-size: 11px;">
                                    Attempt #{{ $attempt->id }}
                                </span>

                                <div class="d-flex align-items-center gap-1.5">
                                    @if(isset($attempt->course_id) && $attempt->course_id)
                                        <a href="{{ route('student.courses.access', $attempt->course_id) }}" 
                                           class="btn btn-sm btn-outline-secondary px-2.5 py-1 rounded-2" 
                                           style="font-size: 11.5px;">
                                            <i class="fa-solid fa-rotate-right me-1"></i> Retake
                                        </a>
                                    @endif
                                    <a href="{{ isset($attempt->course_id) && $attempt->course_id ? route('student.courses.access', $attempt->course_id) : '#' }}" 
                                       class="btn btn-sm btn-primary fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
                                       style="background-color: #0099cc; border-color: #0099cc; font-size: 11.5px;">
                                        Review <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                            <div class="mx-auto mb-3" style="width: 50px; height: 50px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-clipboard-question"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">No Quiz Attempts Found</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">You have not completed any compliance quizzes matching your filter criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($attempts->hasPages())
                <div class="d-flex justify-content-center mb-3">
                    {{ $attempts->links() }}
                </div>
            @endif

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

<style>
    .pbz-quiz-attempt-card:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
</style>
@endsection

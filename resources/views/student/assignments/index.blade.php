@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Assignments'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-file-contract"></i> PRACTICAL REGULATORY DOSSIERS
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">Course Assignments &amp; Case Studies</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Submit and review regulatory memos, branch compliance assessments, and audit case studies.</p>
                    </div>

                    <!-- Mini KPI Cards -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-clipboard-list text-success" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Total:</span> <strong class="text-dark">{{ $summary['total_submissions'] }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check" style="color: #0099cc; font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Graded:</span> <strong class="text-dark">{{ $summary['graded_assignments'] }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-hourglass-half text-warning" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">In Review:</span> <strong class="text-dark">{{ $summary['pending_assignments'] + $summary['returned_assignments'] }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compact Filter Toolbar -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <form method="GET" action="{{ route('student.assignments') }}" class="row g-2 align-items-center">
                    <div class="col-md-4 col-12">
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12px;"></i>
                            <input type="search" name="search" class="form-control form-control-sm ps-5 rounded-2"
                                   value="{{ $searchTerm }}" placeholder="Search by assignment title..." style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
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
                            <a href="{{ route('student.assignments') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5" title="Reset Filters" style="font-size: 12.5px; height: 35px;">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Native Compact Cards Grid (Mobile First, Less Vertical Scrolling) -->
            <div class="row g-3 mb-3">
                @forelse($assignments as $assignment)
                    <div class="col-xl-6 col-12">
                        <div class="card border rounded-3 bg-white h-100 shadow-none p-3.5 pbz-assignment-card" style="border-color: #e2e8f0; transition: border-color 0.15s ease;">
                            
                            <!-- Card Header -->
                            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-2">
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
                                        <i class="fa-solid fa-file-lines"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <h5 class="fw-bold mb-0 text-truncate text-dark" style="font-size: 13.5px;" title="{{ $assignment->title }}">
                                            {{ $assignment->title }}
                                        </h5>
                                        <span class="text-muted text-truncate d-block" style="font-size: 11.5px;">
                                            <i class="fa-solid fa-graduation-cap me-1 text-success"></i> {{ optional($assignment->topic->course)->title ?? 'Banking Certification' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <span class="badge px-2.5 py-1 rounded-pill" style="font-size: 10.5px; 
                                    @if(str_contains(strtolower($assignment->student_submission['status_class'] ?? ''), 'success') || str_contains(strtolower($assignment->student_submission['status_label'] ?? ''), 'graded'))
                                        background-color: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;
                                    @elseif(str_contains(strtolower($assignment->student_submission['status_label'] ?? ''), 'submitted') || str_contains(strtolower($assignment->student_submission['status_label'] ?? ''), 'pending'))
                                        background-color: #eff6ff; color: #0099cc; border: 1px solid #bfdbfe;
                                    @else
                                        background-color: #fffbeb; color: #d97706; border: 1px solid #fde68a;
                                    @endif">
                                    {{ $assignment->student_submission['status_label'] ?? 'Pending Submission' }}
                                </span>
                            </div>

                            <!-- Short Description -->
                            @if ($assignment->short_description)
                                <p class="text-muted mb-2.5" style="font-size: 12px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $assignment->short_description }}
                                </p>
                            @endif

                            <!-- Compact Metrics Pill Row -->
                            <div class="p-2 rounded-2 border d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3" style="background: #f8fafc; border-color: #e2e8f0; font-size: 11.5px;">
                                <div>
                                    <span class="text-muted">Grade:</span> 
                                    <strong class="text-dark">{{ $assignment->student_submission['grade'] !== null ? $assignment->student_submission['grade'] . '%' : 'Pending' }}</strong>
                                </div>
                                <div>
                                    <span class="text-muted">Submitted:</span> 
                                    <strong class="text-dark">{{ $assignment->student_submission['submitted_at'] ?? 'Not yet' }}</strong>
                                </div>
                                <div>
                                    <span class="text-muted">Attachments:</span> 
                                    <strong class="text-dark">{{ $assignment->files_count }} files</strong>
                                </div>
                            </div>

                            <!-- Action Bar -->
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: #f1f5f9;">
                                <span class="text-muted" style="font-size: 11px;">
                                    <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Confidential STR Protocol
                                </span>

                                <a href="{{ route('student.courses.access', optional($assignment->topic)->course_id) }}" 
                                   class="btn btn-sm btn-primary fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
                                   style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
                                    Access Dossier <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                            <div class="mx-auto mb-3" style="width: 50px; height: 50px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">No Assignments Found</h5>
                            <p class="text-muted mb-0" style="font-size: 13px;">There are no case studies or assignments matching your filter criteria.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($assignments->hasPages())
                <div class="d-flex justify-content-center mb-3">
                    {{ $assignments->links() }}
                </div>
            @endif

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

<style>
    .pbz-assignment-card:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
</style>
@endsection

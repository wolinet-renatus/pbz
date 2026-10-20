@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'My Courses'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-graduation-cap"></i> SOVEREIGN LEARNING ACADEMY
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">My Enrolled Courses</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Track your accredited PBZ banking certifications and continue active lessons.</p>
                    </div>

                    <!-- Mini KPI Badges -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-book-bookmark text-success" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Enrolled:</span> <strong class="text-dark">{{ $enrollments->total() }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-clock-rotate-left" style="color: #0099cc; font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">In Progress:</span> <strong class="text-dark">{{ $enrollments->where('status', 'approved')->count() }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-award text-warning" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Completed:</span> <strong class="text-dark">{{ $enrollments->where('status', 'completed')->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instant Real-Time Search & Status Filter Toolbar -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2.5">
                    
                    <!-- Search Input -->
                    <div class="position-relative flex-grow-1" style="max-width: 380px; min-width: 220px;">
                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12.5px;"></i>
                        <input type="text" id="courseRealtimeSearch" class="form-control form-control-sm ps-5 rounded-2" placeholder="Search course by title or category..." style="font-size: 12.5px; border-color: #cbd5e1; height: 36px;">
                    </div>

                    <!-- Status Filter Pills -->
                    <div class="d-flex align-items-center gap-1.5 flex-wrap" id="courseFilterPills">
                        <button type="button" class="btn btn-sm course-filter-pill active" data-filter="all" style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #006837; color: #fff; border: 1px solid #006837;">
                            All ({{ $enrollments->total() }})
                        </button>
                        <button type="button" class="btn btn-sm course-filter-pill" data-filter="in_progress" style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            In Progress
                        </button>
                        <button type="button" class="btn btn-sm course-filter-pill" data-filter="completed" style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            Completed
                        </button>
                    </div>

                </div>
            </div>

            <!-- Compact Courses Grid (Minimized Card Size, Mobile First) -->
            <div class="row g-3" id="myCoursesGrid">
                @forelse($enrollments as $enrollment)
                    <div class="col-xl-4 col-md-6 col-12 course-item-wrapper" 
                         data-title="{{ strtolower($enrollment['course_title']) }}"
                         data-category="{{ strtolower($enrollment['course_category'] ?? '') }}"
                         data-status="{{ $enrollment['is_completed'] ? 'completed' : 'in_progress' }}">
                        
                        <div class="card border rounded-3 bg-white h-100 shadow-none overflow-hidden pbz-course-card-compact" style="border-color: #e2e8f0; transition: border-color 0.15s ease;">
                            
                            <!-- Minimized Thumbnail Header (110px max height) -->
                            <div class="position-relative overflow-hidden" style="height: 115px; background: #081226;">
                                @if ($enrollment['featured_image'])
                                    <img src="{{ asset('storage/' . $enrollment['featured_image']) }}" 
                                         alt="{{ $enrollment['course_title'] }}" 
                                         class="w-100 h-100" style="object-fit: cover; opacity: 0.88;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: #0f172a; color: #0099cc;">
                                        <i class="fa-solid fa-building-columns fs-2"></i>
                                    </div>
                                @endif

                                <!-- Category Badge Overlay -->
                                <span class="badge position-absolute top-0 start-0 m-2 fw-semibold px-2 py-1 rounded-pill" style="background-color: #006837; color: #ffffff; font-size: 10px;">
                                    {{ $enrollment['course_category'] ?? 'Banking Academy' }}
                                </span>

                                <!-- Status Badge Overlay -->
                                @if ($enrollment['is_completed'])
                                    <span class="badge position-absolute top-0 end-0 m-2 fw-semibold px-2 py-1 rounded-pill" style="background-color: #16a34a; color: #ffffff; font-size: 10px;">
                                        <i class="fa-solid fa-circle-check me-0.5"></i> Completed
                                    </span>
                                @else
                                    <span class="badge position-absolute top-0 end-0 m-2 fw-semibold px-2 py-1 rounded-pill" style="background-color: #0099cc; color: #ffffff; font-size: 10px;">
                                        <i class="fa-solid fa-spinner me-0.5"></i> {{ $enrollment['progress_percentage'] }}% Complete
                                    </span>
                                @endif
                            </div>

                            <!-- Compact Card Body -->
                            <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                                <div>
                                    <h5 class="fw-bold mb-1.5 text-truncate-2" style="font-size: 13.5px; line-height: 1.4; color: #0f172a; min-height: 38px;" title="{{ $enrollment['course_title'] }}">
                                        {{ $enrollment['course_title'] }}
                                    </h5>

                                    <div class="d-flex align-items-center justify-content-between text-muted mb-2.5" style="font-size: 11.5px;">
                                        <span>
                                            <i class="fa-regular fa-file-lines me-1 text-primary"></i> {{ $enrollment['lesson_count'] }} Lessons
                                        </span>
                                        <span>
                                            <i class="fa-regular fa-user me-1 text-success"></i> {{ $enrollment['instructor_name'] }}
                                        </span>
                                    </div>

                                    <!-- Progress Bar Line -->
                                    <div class="progress rounded-pill mb-3" style="height: 5px; background: #e2e8f0;">
                                        <div class="progress-bar rounded-pill" role="progressbar" 
                                             style="width: {{ $enrollment['progress_percentage'] }}%; background-color: {{ $enrollment['is_completed'] ? '#16a34a' : '#0099cc' }};" 
                                             aria-valuenow="{{ $enrollment['progress_percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="pt-2 border-top d-flex align-items-center justify-content-between" style="border-color: #f1f5f9 !important;">
                                    <span class="font-monospace text-muted" style="font-size: 11px;">
                                        @if ($enrollment['enrolled_at'])
                                            {{ $enrollment['enrolled_at']->format('M d, Y') }}
                                        @else
                                            Active Access
                                        @endif
                                    </span>

                                    <a href="{{ $enrollment['course_id'] ? route('student.courses.access', $enrollment['course_id']) : '#' }}" 
                                       class="btn btn-sm fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
                                       style="font-size: 11.5px; {{ $enrollment['is_completed'] ? 'background-color: #006837; border-color: #006837; color: #fff;' : 'background-color: #0099cc; border-color: #0099cc; color: #fff;' }}">
                                        @if ($enrollment['is_completed'])
                                            Review <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                                        @else
                                            Continue <i class="fa-solid fa-play" style="font-size: 9px;"></i>
                                        @endif
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                            <div class="mx-auto mb-3" style="width: 50px; height: 50px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">No Courses Enrolled</h5>
                            <p class="text-muted mb-3" style="font-size: 13px;">You have not enrolled in any professional banking courses yet.</p>
                            <div>
                                <a href="{{ route('courses') }}" class="btn btn-sm btn-success fw-bold px-4 py-2 rounded-2" style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                                    Browse Course Catalog
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Empty Search State Placeholder -->
            <div id="noSearchCourses" class="card p-4 text-center rounded-3 bg-white border shadow-none d-none mt-2" style="border-color: #e2e8f0;">
                <div class="text-muted mb-1 fs-5"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="fw-bold text-dark" style="font-size: 13.5px;">No matching courses found</div>
                <div class="text-muted" style="font-size: 12px;">Try adjusting your keyword or status filter.</div>
            </div>

            <!-- Pagination -->
            @if ($enrollments->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $enrollments->links() }}
                </div>
            @endif

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

<style>
    .pbz-course-card-compact:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Real-Time Search & Status Filtering (Instant Client-Side)
    (function() {
        var searchInput = document.getElementById('courseRealtimeSearch');
        var filterPills = document.querySelectorAll('.course-filter-pill');
        var courseItems = document.querySelectorAll('.course-item-wrapper');
        var emptyNotice = document.getElementById('noSearchCourses');
        var currentFilter = 'all';

        function applyFilters() {
            var query = (searchInput ? searchInput.value : '').toLowerCase().trim();
            var visibleCount = 0;

            courseItems.forEach(function(item) {
                var title = item.getAttribute('data-title') || '';
                var category = item.getAttribute('data-category') || '';
                var status = item.getAttribute('data-status') || '';

                var matchesQuery = !query || title.indexOf(query) !== -1 || category.indexOf(query) !== -1;
                var matchesStatus = (currentFilter === 'all') || (status === currentFilter);

                if (matchesQuery && matchesStatus) {
                    item.classList.remove('d-none');
                    visibleCount++;
                } else {
                    item.classList.add('d-none');
                }
            });

            if (emptyNotice) {
                if (visibleCount === 0 && courseItems.length > 0) {
                    emptyNotice.classList.remove('d-none');
                } else {
                    emptyNotice.classList.add('d-none');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        filterPills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                filterPills.forEach(function(p) {
                    p.classList.remove('active');
                    p.style.background = '#f8fafc';
                    p.style.borderColor = '#cbd5e1';
                    p.style.color = '#64748b';
                });

                this.classList.add('active');
                this.style.background = '#006837';
                this.style.borderColor = '#006837';
                this.style.color = '#ffffff';

                currentFilter = this.getAttribute('data-filter');
                applyFilters();
            });
        });
    })();
</script>
@endsection

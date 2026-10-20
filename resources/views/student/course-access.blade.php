@extends('layouts.student')

@push('styles')
    <link href="{{ asset('assets/front/css/video-js.css') }}" rel="stylesheet" />
    <style>
        /* PBZ Sovereign Learning Workbench Styles */
        .pbz-learning-content-area {
            background-color: #f8fafc;
            min-height: calc(100vh - 65px);
        }

        .chapter-header {
            transition: background-color 0.15s ease;
        }
        .chapter-header:hover {
            background-color: #f1f5f9 !important;
        }

        .chapter-section.collapsed .chapter-content {
            display: none !important;
        }

        .curriculum-item {
            transition: all 0.15s ease;
        }
        .curriculum-item:hover:not(.locked) {
            background-color: #f8fafc !important;
        }
        .curriculum-item.active {
            background-color: #f0f9ff !important;
            border-left: 3px solid #0099cc !important;
        }

        /* Video Container responsive behavior */
        .video-iframe, #video-player-container iframe {
            border-radius: 10px;
        }

        /* Discussion forum styles */
        .forum-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            margin-bottom: 12px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .forum-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .reply-card {
            border-left: 3px solid #006837;
            background: #f8fafc;
        }

        @media (max-width: 991px) {
            .learning-nav-toolbar {
                flex-direction: column;
                align-items: stretch !important;
                text-align: center;
            }
            .learning-nav-toolbar .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Learning'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area pbz-learning-content-area p-3 p-md-4">

            <!-- Course Header Bar -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div class="d-flex align-items-center gap-2.5 min-w-0">
                    <a href="{{ route('student.my-courses') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5 py-1.5 flex-shrink-0" title="Back to My Courses" style="font-size: 13px;">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h3 class="fw-bold mb-0 text-truncate" style="font-size: 1.15rem; color: #0f172a;" title="{{ $course->title }}">
                        {{ $course->title }}
                    </h3>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted fw-semibold font-monospace" style="font-size: 13px;">
                        <span id="header-completed-count" class="fw-bold text-dark">{{ $completedLessonsCount }}</span>/<span id="header-total-count">{{ $totalLessonsCount }}</span> lessons
                    </span>
                </div>
            </div>

            <!-- Full-width Solid Progress Bar Line -->
            <div class="progress mb-4 rounded-pill" style="height: 5px; background: #e2e8f0;">
                <div class="progress-bar" id="course-progress-line" role="progressbar" 
                     style="width: {{ $courseProgressPercent }}%; background-color: #0099cc;" 
                     aria-valuenow="{{ $courseProgressPercent }}" aria-valuemin="0" aria-valuemax="100">
                </div>
            </div>

            <!-- Two-Column Learning Grid (Mobile First) -->
            <div class="row g-4">
                <!-- Left Primary Stage: Video Player / Quiz / Content -->
                <div class="col-xl-8 col-lg-8 col-12">
                    @if (isset($isCompleted) && $isCompleted)
                        <div class="mb-3">
                            @include('student.course-access.partials.completion-notice', [
                                'course' => $course,
                            ])
                        </div>
                    @endif

                    <div id="main-content">
                        @if ($currentItem)
                            @if ($currentItemType === 'lesson')
                                @include('student.course-access.partials.lesson-content', [
                                    'lesson' => $currentItem,
                                    'progress' => $userProgress[$currentItem->id] ?? null,
                                    'videoData' => $initialLessonVideoData ?? null,
                                    'course' => $course,
                                ])
                            @elseif($currentItemType === 'quiz')
                                @if ($initialQuizPassed ?? false)
                                    @include('student.course-access.partials.quiz-results', $initialQuizResultsData ?? [])
                                @else
                                    @include('student.course-access.partials.quiz-content', [
                                        'quiz' => $currentItem,
                                        'previousAttempt' => $userQuizAttempts[$currentItem->id] ?? null,
                                    ])
                                @endif
                            @elseif($currentItemType === 'assignment')
                                @include('student.course-access.partials.assignment-content', [
                                    'assignment' => $currentItem,
                                    'submission' => $userAssignmentSubmissions[$currentItem->id] ?? null,
                                ])
                            @endif
                        @else
                            <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0 !important;">
                                <div class="mx-auto mb-3" style="width: 54px; height: 54px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Curriculum Being Prepared</h5>
                                <p class="text-muted mb-3" style="font-size: 13.5px;">The lessons and materials for this course are currently being finalized.</p>
                                <div>
                                    <a href="{{ route('student.my-courses') }}" class="btn btn-sm btn-success fw-bold px-3 py-1.5 rounded-2" style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Back to My Courses
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Curriculum Sidebar: Course Content & More -->
                <div class="col-xl-4 col-lg-4 col-12">
                    <div id="course-sidebar">
                        @include('student.course-access.partials.sidebar')
                    </div>
                </div>
            </div>

            <!-- PBZ SaaS Portal Modern Footer -->
            <div class="pbz-saas-footer mt-5">
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="{{ asset('assets/front/js/video.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/videojs-http-streaming.min.js') }}"></script>
    <script>
        const courseId = {{ $course->id }};
        const courseAccessBaseUrl = "{{ url('/student/courses/' . $course->id) }}";
        const appBaseUrl = "{{ url('/') }}";
        window.courseId = courseId;
        window.courseAccessBaseUrl = courseAccessBaseUrl;
        window.appBaseUrl = appBaseUrl;
        let currentItemId = {{ $currentItem->id ?? 0 }};
        let currentItemType = '{{ $currentItemType }}';
        let videoPlayer = null;

        // Reactive delegation for next / prev buttons
        $(document).on('click', '#next-btn', function(e) {
            e.preventDefault();
            if (typeof window.navigateItem === 'function') {
                window.navigateItem('next');
            } else if (typeof navigateItem === 'function') {
                navigateItem('next');
            }
        });

        $(document).on('click', '#prev-btn', function(e) {
            e.preventDefault();
            if (typeof window.navigateItem === 'function') {
                window.navigateItem('previous');
            } else if (typeof navigateItem === 'function') {
                navigateItem('previous');
            }
        });

        // Curriculum Real-Time Search Filter
        $(document).on('input', '#curriculum-search-input', function() {
            const query = $(this).val().toLowerCase().trim();
            $('.curriculum-item').each(function() {
                const title = $(this).find('.curriculum-item-title').text().toLowerCase();
                if (title.indexOf(query) !== -1 || query === '') {
                    $(this).removeClass('d-none');
                } else {
                    $(this).addClass('d-none');
                }
            });
            // If searching, expand all sections
            if (query !== '') {
                $('.chapter-section').removeClass('collapsed');
                $('.chapter-content').removeClass('d-none');
                $('.chapter-toggle-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
            }
        });

        // Accordion Toggle Handler
        $(document).on('click', '.chapter-header', function(e) {
            if ($(e.target).hasClass('chapter-progress')) return;
            const section = $(this).closest('.chapter-section');
            const content = section.find('.chapter-content');
            const icon = $(this).find('.chapter-toggle-icon');

            section.toggleClass('collapsed');
            content.toggleClass('d-none');

            if (section.hasClass('collapsed')) {
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            } else {
                icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            }
        });
    </script>
    <script src="{{ asset('assets/front/js/student/course-access.js') }}"></script>
@endpush

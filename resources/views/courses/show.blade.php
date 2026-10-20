@extends('layouts.app')

@section('breadcrumb')
    <!-- Sleek Minimal Breadcrumb Bar (Zero Bloat) -->
    <div class="pbz-minimal-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="pbz-breadcrumb-list">
                    <li class="pbz-breadcrumb-item">
                        <a href="{{ route('home') }}"><i class="fa-solid fa-house font-size-11 me-1"></i> {{ __('frontend.home') ?? 'Home' }}</a>
                    </li>
                    <li class="pbz-breadcrumb-sep"><i class="fa-solid fa-chevron-right font-size-9"></i></li>
                    <li class="pbz-breadcrumb-item">
                        <a href="{{ route('courses') }}">{{ __('frontend.courses') ?? 'Courses' }}</a>
                    </li>
                    @if ($course->category)
                        <li class="pbz-breadcrumb-sep"><i class="fa-solid fa-chevron-right font-size-9"></i></li>
                        <li class="pbz-breadcrumb-item">
                            <a href="{{ route('courses', ['category' => $course->category]) }}">{{ ucfirst($course->category) }}</a>
                        </li>
                    @endif
                    <li class="pbz-breadcrumb-sep"><i class="fa-solid fa-chevron-right font-size-9"></i></li>
                    <li class="pbz-breadcrumb-item active" aria-current="page">
                        {{ \Illuminate\Support\Str::limit($course->title, 40) }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* ==========================================================================
   PBZ Modern Course Details Page (Zero Scroll & Minimal Hero)
   ========================================================================== */

/* 1. Minimal Breadcrumb */
.pbz-minimal-breadcrumb {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 6px 0;
    font-size: 12px;
}
.pbz-breadcrumb-list {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    margin: 0;
    padding: 0;
    list-style: none;
}
.pbz-breadcrumb-item a {
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}
.pbz-breadcrumb-item a:hover {
    color: #004f44;
}
.pbz-breadcrumb-item.active {
    color: #0f172a;
    font-weight: 600;
}
.pbz-breadcrumb-sep {
    color: #cbd5e1;
    display: flex;
    align-items: center;
}

/* 2. Main Section Spacing */
.pbz-course-detail-section {
    padding: 14px 0 40px;
    background: #ffffff;
}

/* 3. Compact Course Header Info */
.pbz-course-header {
    margin-bottom: 12px;
}
.pbz-course-badges-row {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 6px;
}
.pbz-badge-category {
    background: rgba(0, 79, 68, 0.08);
    color: #004f44;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.pbz-rating-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    font-weight: 700;
    color: #b45309;
    background: #fef3c7;
    padding: 2px 8px;
    border-radius: 12px;
}
.pbz-course-title {
    font-size: 19px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
    margin-bottom: 6px;
}
.pbz-course-meta-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    font-size: 12px;
    color: #64748b;
}
.pbz-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* 4. Compact Course Enrollment Card */
.pbz-course-enroll-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 16px;
}
.pbz-sticky-card {
    position: sticky;
    top: 85px;
}
.pbz-card-media {
    position: relative;
    width: 100%;
    height: 135px;
    background: #0f172a;
    overflow: hidden;
}
.pbz-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.pbz-play-overlay-btn {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.35);
    color: #ffffff;
    font-size: 38px;
    text-decoration: none;
    transition: all 0.2s ease;
}
.pbz-play-overlay-btn:hover {
    background: rgba(0, 79, 68, 0.55);
    color: #ffffff;
    transform: scale(1.05);
}
.pbz-card-body {
    padding: 14px 16px;
}
.pbz-price-box {
    display: flex;
    align-items: baseline;
    gap: 8px;
    margin-bottom: 10px;
}
.pbz-main-price {
    font-size: 21px;
    font-weight: 800;
    color: #004f44;
    line-height: 1;
}
.pbz-old-price {
    font-size: 13px;
    color: #94a3b8;
    text-decoration: line-through;
}
.pbz-btn-enroll {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    background: #004f44;
    color: #ffffff;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0, 79, 68, 0.2);
}
.pbz-btn-enroll:hover {
    background: #003830;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(0, 79, 68, 0.25);
}
.pbz-btn-enrolled {
    background: #15803d;
}
.pbz-btn-enrolled:hover {
    background: #166534;
}
.pbz-guarantee-note {
    font-size: 11px;
    color: #64748b;
    text-align: center;
    margin-top: 8px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}
.pbz-specs-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
    border-top: 1px solid #f1f5f9;
    padding-top: 10px;
}
.pbz-spec-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 12px;
}
.pbz-spec-label {
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}
.pbz-spec-val {
    font-weight: 700;
    color: #0f172a;
}

/* 5. Mobile Quick Snapshot Pills */
.pbz-mobile-quick-pills {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 6px;
    margin-top: 10px;
    margin-bottom: 4px;
}
.pbz-mobile-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 11.5px;
}
.pbz-mobile-pill i {
    color: #004f44;
}
.pbz-mobile-pill span {
    font-weight: 600;
    color: #1e293b;
}

/* 6. Compact Tabs & Content */
.pbz-course-nav-tabs {
    display: flex;
    gap: 4px;
    border-bottom: 2px solid #f1f5f9;
    margin-bottom: 14px;
    padding-bottom: 0;
    overflow-x: auto;
    white-space: nowrap;
}
.pbz-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border: none;
    background: transparent;
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s ease;
    text-decoration: none;
}
.pbz-tab-btn:hover {
    color: #004f44;
}
.pbz-tab-btn.active {
    color: #004f44;
    border-bottom-color: #004f44;
}

/* 7. Curriculum Accordion */
.pbz-curriculum-accordion .accordion-item {
    border: 1px solid #e2e8f0;
    border-radius: 10px !important;
    overflow: hidden;
    margin-bottom: 8px;
}
.pbz-curriculum-accordion .accordion-button {
    background: #f8fafc;
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
    padding: 10px 14px;
    box-shadow: none;
}
.pbz-curriculum-accordion .accordion-button:not(.collapsed) {
    background: #f1f5f9;
    color: #004f44;
}
.pbz-curriculum-accordion .accordion-body {
    padding: 0;
}
.pbz-lesson-list {
    list-style: none;
    padding: 0;
    margin: 0;
}
.pbz-lesson-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 12.5px;
}
.pbz-lesson-item:last-child {
    border-bottom: none;
}

/* 8. Mobile Sticky Bottom Floating Action Bar */
.pbz-mobile-floating-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    padding: 8px 14px;
    box-shadow: 0 -3px 12px rgba(0, 0, 0, 0.08);
    display: none;
    z-index: 1040;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.pbz-floating-price-wrap {
    display: flex;
    flex-direction: column;
}
.pbz-floating-price-label {
    font-size: 10px;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 600;
}
.pbz-floating-price-val {
    font-size: 16px;
    font-weight: 800;
    color: #004f44;
    line-height: 1.1;
}

@media (max-width: 991px) {
    .pbz-course-title {
        font-size: 18px;
    }
    .pbz-card-media {
        height: 125px;
    }
    .pbz-mobile-floating-bar {
        display: flex;
    }
    .pbz-course-detail-section {
        padding-bottom: 75px;
    }
}
</style>
@endpush

@section('content')
@php
    $rawPrice = $course->sale_price ?? $course->regular_price;
    $priceDisplay = $course->pricing_model === 'free' ? __('frontend.free') : currency_format($rawPrice ?? 0);
    $hasIntroVideo = !empty($course->intro_video);
    $introVideoUrl = $hasIntroVideo ? asset('storage/' . $course->intro_video) : '';
    $featuredImageUrl = $course->featured_image ? asset('storage/' . $course->featured_image) : asset('assets/front/img/inner/courses-details/courses-details.jpg');
@endphp

    <!-- Course Details Section Start -->
    <section class="pbz-course-detail-section">
        <div class="container">
            <!-- Compact Course Header -->
            <div class="pbz-course-header">
                <!-- Badges Row -->
                <div class="pbz-course-badges-row">
                    @if ($course->category)
                        <span class="pbz-badge-category">
                            {{ ucfirst($course->category) }}
                        </span>
                    @endif

                    @if ($totalReviews > 0)
                        <span class="pbz-rating-pill">
                            <i class="fa-solid fa-star text-warning"></i>
                            <span>{{ $averageRating }}</span>
                            <span class="text-muted fw-normal">({{ $totalReviews }})</span>
                        </span>
                    @endif

                    @if ($course->is_live_course)
                        <span class="badge bg-danger rounded-pill px-2 py-1 font-size-11">
                            <i class="fas fa-broadcast-tower me-1"></i> {{ __('frontend.live') }}
                        </span>
                    @endif

                    @if ($courseStartDate)
                        <span class="badge bg-light text-dark border rounded-pill px-2 py-1 font-size-11">
                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                            {{ __('frontend.starts_in') }}: 
                            <span class="countdown-timer fw-bold text-primary" data-date="{{ $courseStartDate->format('Y-m-d H:i:s') }}">
                                <span class="countdown-days">0</span>d
                                <span class="countdown-hours">0</span>h
                                <span class="countdown-minutes">0</span>m
                                <span class="countdown-seconds">0</span>s
                            </span>
                        </span>
                    @endif
                </div>

                <!-- Course Title -->
                <h1 class="pbz-course-title">
                    {{ $course->title }}
                </h1>

                <!-- Meta Row -->
                <div class="pbz-course-meta-row">
                    @if ($course->instructor)
                        <div class="pbz-meta-item">
                            <i class="fa-regular fa-user text-primary"></i>
                            <span>{{ __('frontend.instructor') }}: <strong class="text-dark">{{ $course->instructor->name }}</strong></span>
                        </div>
                    @endif

                    @if ($course->language)
                        <div class="pbz-meta-item">
                            <i class="fa-solid fa-globe text-primary"></i>
                            <span>{{ ucfirst($course->language) }}</span>
                        </div>
                    @endif

                    @if ($course->schedule_date)
                        <div class="pbz-meta-item">
                            <i class="fa-regular fa-calendar text-primary"></i>
                            <span>{{ $course->schedule_date->format('d M, Y') }}</span>
                        </div>
                    @endif

                    <div class="pbz-meta-item">
                        <i class="fa-solid fa-certificate text-primary"></i>
                        <span>Accredited Certificate</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Top Action & Snapshot Card (Zero Scroll on Mobile) -->
            <div class="d-block d-lg-none mb-3">
                <div class="pbz-course-enroll-card">
                    <div class="pbz-card-media">
                        <img src="{{ $featuredImageUrl }}" alt="{{ $course->title }}">
                        @if ($hasIntroVideo)
                            <a href="javascript:void(0)" class="intro-video-play-btn pbz-play-overlay-btn"
                                data-intro-video="{{ $introVideoUrl }}" title="Play Course Preview">
                                <i class="fa-solid fa-circle-play"></i>
                            </a>
                        @endif
                    </div>
                    <div class="pbz-card-body">
                        <div class="pbz-price-box">
                            <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background: #e6f4ea; color: #137333; font-size: 0.85rem;">
                                <i class="fa-solid fa-building-columns me-1"></i> PBZ STAFF: 100% FREE
                            </span>
                            @if ($course->curriculum_type === 'islamic_amana')
                                <div class="mt-2 text-start">
                                    <span class="badge" style="background: #006837; color: #F9ED27; font-size: 0.72rem; font-weight: 700;">
                                        <i class="fa-solid fa-moon me-1 text-warning"></i> PBZ Islamic (Amana) • Shariah Board Certified
                                    </span>
                                </div>
                            @elseif(!empty($course->compliance_category))
                                <div class="mt-2 text-start">
                                    <span class="badge" style="background: #081226; color: #F9ED27; font-size: 0.72rem; font-weight: 700;">
                                        <i class="fa-solid fa-scale-balanced me-1 text-warning"></i> Bank of Tanzania (BOT) Statutory Compliance
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- CTA Button -->
                        @if ($isEnrolled)
                            <a href="{{ route('student.courses.access', $course->id) }}" class="pbz-btn-enroll pbz-btn-enrolled">
                                <i class="fas fa-play-circle me-1"></i> Continue Learning
                            </a>
                        @elseif(auth()->check())
                            <a href="{{ route('courses.enroll.direct', $course->id) }}" class="pbz-btn-enroll">
                                <i class="fa-solid fa-graduation-cap me-1"></i> Enroll in Training (Free)
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="pbz-btn-enroll">
                                <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> PBZ Staff Login to Enroll
                            </a>
                        @endif

                        <!-- Mobile Quick Specs 4-Pill Grid -->
                        <div class="pbz-mobile-quick-pills">
                            @if ($totalDuration > 0)
                                @php
                                    $h = floor($totalDuration / 60);
                                    $m = $totalDuration % 60;
                                @endphp
                                <div class="pbz-mobile-pill">
                                    <i class="fa-regular fa-clock"></i>
                                    <span>{{ $h > 0 ? "{$h}h {$m}m" : "{$m}m" }}</span>
                                </div>
                            @endif
                            <div class="pbz-mobile-pill">
                                <i class="fa-solid fa-book-open"></i>
                                <span>{{ $lessonCount }} {{ __('frontend.lessons') }}</span>
                            </div>
                            @if ($course->difficulty)
                                <div class="pbz-mobile-pill">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <span>{{ ucfirst($course->difficulty) }}</span>
                                </div>
                            @endif
                            <div class="pbz-mobile-pill">
                                <i class="fa-solid fa-award"></i>
                                <span>Certificate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Layout Grid (g-3 for tighter fitness) -->
            <div class="row g-3">
                <!-- Left Column: Content Tabs & Details (Starts Immediately without giant media cover) -->
                <div class="col-lg-8">
                    <!-- Modern Compact Tabs Navigation -->
                    <div class="pbz-course-nav-tabs" role="tablist">
                        <button type="button" class="pbz-tab-btn active" data-bs-toggle="tab" data-bs-target="#CourseTab" role="tab">
                            <i class="fa-solid fa-circle-info font-size-12"></i>
                            <span>{{ __('frontend.course_info') }}</span>
                        </button>
                        <button type="button" class="pbz-tab-btn" data-bs-toggle="tab" data-bs-target="#CurriculumTab" role="tab">
                            <i class="fa-solid fa-list-ul font-size-12"></i>
                            <span>{{ __('frontend.curriculum') }}</span>
                            <span class="badge bg-light text-dark border font-size-10 ms-1">{{ $lessonCount }}</span>
                        </button>
                        <button type="button" class="pbz-tab-btn" data-bs-toggle="tab" data-bs-target="#InstructorsTab" role="tab">
                            <i class="fa-solid fa-user-tie font-size-12"></i>
                            <span>{{ __('frontend.instructors') }}</span>
                        </button>
                        @if ($totalReviews > 0 || $canReview)
                            <button type="button" class="pbz-tab-btn" data-bs-toggle="tab" data-bs-target="#ReviewsTab" role="tab">
                                <i class="fa-solid fa-star font-size-12"></i>
                                <span>{{ __('frontend.all_reviews') }}</span>
                                @if($totalReviews > 0)
                                    <span class="badge bg-light text-dark border font-size-10 ms-1">{{ $totalReviews }}</span>
                                @endif
                            </button>
                        @endif
                    </div>

                    <!-- Tabs Content Panels -->
                    <div class="tab-content">
                        <!-- Tab 1: Course Info / Description -->
                        <div id="CourseTab" class="tab-pane fade show active" role="tabpanel">
                            <div class="description-content">
                                <h3 class="font-size-16 fw-bold mb-2">{{ __('frontend.description') }}</h3>
                                <div class="mb-3 text-secondary leading-normal font-size-13">
                                    {!! $course->description ?? '<p>' . __('frontend.no_description') . '</p>' !!}
                                </div>

                                @if ($course->objectives)
                                    <h3 class="font-size-15 fw-bold mt-3 mb-2">{{ __('frontend.what_learn') }}</h3>
                                    @php
                                        $objectives = array_filter(array_map('trim', explode("\n", $course->objectives)));
                                        $midPoint = ceil(count($objectives) / 2);
                                        $firstColumn = array_slice($objectives, 0, $midPoint);
                                        $secondColumn = array_slice($objectives, $midPoint);
                                    @endphp
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <ul class="list-unstyled mb-0 d-flex flex-column gap-1">
                                                @foreach ($firstColumn as $objective)
                                                    <li class="d-flex align-items-start gap-2 font-size-13 text-dark">
                                                        <i class="fa-solid fa-circle-check text-success mt-1 font-size-12"></i>
                                                        <span>{{ $objective }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @if (count($secondColumn) > 0)
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0 d-flex flex-column gap-1">
                                                    @foreach ($secondColumn as $objective)
                                                        <li class="d-flex align-items-start gap-2 font-size-13 text-dark">
                                                            <i class="fa-solid fa-circle-check text-success mt-1 font-size-12"></i>
                                                            <span>{{ $objective }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($course->requirements)
                                    <h3 class="font-size-15 fw-bold mt-3 mb-2">{{ __('frontend.requirements') }}</h3>
                                    <div class="p-2 px-3 bg-light rounded-3 text-secondary font-size-13 mb-3">
                                        {!! nl2br(e($course->requirements)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tab 2: Curriculum -->
                        <div id="CurriculumTab" class="tab-pane fade" role="tabpanel">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h3 class="font-size-16 fw-bold mb-0">{{ __('frontend.course_curriculum') }}</h3>
                                <span class="text-muted font-size-12">{{ $course->topics->count() }} topics • {{ $lessonCount }} lessons</span>
                            </div>

                            <div class="pbz-curriculum-accordion accordion" id="courseCurriculumAccordion">
                                @forelse ($course->topics as $topicIndex => $topic)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTopic{{ $topic->id }}">
                                            <button class="accordion-button {{ $topicIndex === 0 ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseTopic{{ $topic->id }}"
                                                aria-expanded="{{ $topicIndex === 0 ? 'true' : 'false' }}"
                                                aria-controls="collapseTopic{{ $topic->id }}">
                                                <div class="d-flex align-items-center justify-content-between w-100 me-2">
                                                    <span>{{ $topic->title }}</span>
                                                    <small class="text-muted font-size-11 fw-normal">
                                                        {{ $topic->lessons->count() }} {{ \Illuminate\Support\Str::plural('lesson', $topic->lessons->count()) }}
                                                    </small>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapseTopic{{ $topic->id }}"
                                            class="accordion-collapse collapse {{ $topicIndex === 0 ? 'show' : '' }}"
                                            aria-labelledby="headingTopic{{ $topic->id }}"
                                            data-bs-parent="#courseCurriculumAccordion">
                                            <div class="accordion-body">
                                                <ul class="pbz-lesson-list">
                                                    @foreach ($topic->lessons as $lesson)
                                                        <li class="pbz-lesson-item">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-circle-play text-primary font-size-13"></i>
                                                                <span class="text-dark fw-medium">{{ $lesson->title }}</span>
                                                                @if ($lesson->is_live)
                                                                    <span class="badge bg-danger ms-1 font-size-9">
                                                                        <i class="fas fa-broadcast-tower me-1"></i> LIVE
                                                                    </span>
                                                                @endif
                                                                @if ($lesson->is_preview)
                                                                    <span class="badge bg-info ms-1 font-size-9">PREVIEW</span>
                                                                @endif
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($lesson->is_preview && (($lesson->video_type === 'url' && $lesson->video_url) || ($lesson->video_type === 'upload' && $lesson->video_path)))
                                                                    <a href="javascript:void(0)" class="lesson-preview-play badge bg-primary-subtle text-primary border text-decoration-none px-2 py-1"
                                                                        data-video-type="{{ $lesson->video_type }}"
                                                                        data-video-url="{{ $lesson->video_type === 'url' ? $lesson->video_url : asset('storage/' . $lesson->video_path) }}"
                                                                        data-lesson-title="{{ $lesson->title }}">
                                                                        <i class="fa-solid fa-play font-size-9 me-1"></i> Preview
                                                                    </a>
                                                                @else
                                                                    <i class="fa-solid fa-lock text-muted font-size-11" title="Locked content"></i>
                                                                @endif
                                                                @if ($lesson->duration)
                                                                    <span class="text-muted font-size-11">{{ gmdate('i:s', $lesson->duration * 60) }}</span>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                    @foreach ($topic->quizzes as $quiz)
                                                        <li class="pbz-lesson-item">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-circle-question text-warning font-size-13"></i>
                                                                <span class="text-dark fw-medium">Quiz: {{ $quiz->title }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-lock text-muted font-size-11"></i>
                                                                @if ($quiz->time_limit)
                                                                    <span class="text-muted font-size-11">{{ $quiz->time_limit }} min</span>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                    @foreach ($topic->assignments as $assignment)
                                                        <li class="pbz-lesson-item">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fa-solid fa-clipboard-list text-info font-size-13"></i>
                                                                <span class="text-dark fw-medium">Assignment: {{ $assignment->title }}</span>
                                                                @if ($assignment->files->count() > 0)
                                                                    <span class="badge bg-secondary-subtle text-secondary font-size-9">{{ $assignment->files->count() }} files</span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <i class="fa-solid fa-lock text-muted font-size-11"></i>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info py-2 font-size-13">
                                        <p class="mb-0">{{ __('frontend.no_curriculum') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tab 3: Instructors -->
                        <div id="InstructorsTab" class="tab-pane fade" role="tabpanel">
                            <h3 class="font-size-16 fw-bold mb-2">{{ __('frontend.instructors') }}</h3>
                            @if ($course->instructor)
                                <div class="p-3 bg-light rounded-3 border d-flex gap-3 align-items-start flex-wrap flex-md-nowrap">
                                    <div class="flex-shrink-0">
                                        @if ($course->instructor->profile_photo)
                                            <img src="{{ asset('storage/' . $course->instructor->profile_photo) }}"
                                                alt="{{ $course->instructor->name }}" style="width: 65px; height: 65px; border-radius: 12px; object-fit: cover; border: 2px solid #004f44;">
                                        @else
                                            <img src="{{ asset('assets/front/img/inner/courses-details/courses-01.png') }}"
                                                alt="{{ $course->instructor->name }}" style="width: 65px; height: 65px; border-radius: 12px; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-size-15 fw-bold text-dark mb-1">{{ $course->instructor->name }}</h4>
                                        @if ($course->instructor->specialization)
                                            <p class="text-primary font-size-12 fw-semibold mb-1">{{ $course->instructor->specialization }}</p>
                                        @endif
                                        <p class="text-secondary font-size-13 mb-2">
                                            {{ $course->instructor->bio ?: __('frontend.instr_fallback_bio') }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info py-2 font-size-13">
                                    <p class="mb-0">{{ __('frontend.instr_not_available') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Tab 4: Reviews -->
                        @if ($totalReviews > 0 || $canReview)
                            <div id="ReviewsTab" class="tab-pane fade" role="tabpanel">
                                <h3 class="font-size-16 fw-bold mb-2">{{ __('frontend.course_reviews') }}</h3>

                                @if ($totalReviews > 0)
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <div class="row align-items-center g-3">
                                            <div class="col-md-4 text-center border-end-md">
                                                <div class="font-size-36 fw-bold text-dark">{{ $averageRating }}</div>
                                                <div class="text-warning mb-1 font-size-12">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star{{ $i <= round($averageRating) ? '' : ' text-black-50' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="text-muted font-size-12">{{ $totalReviews }} {{ __('frontend.all_reviews') }}</span>
                                            </div>
                                            <div class="col-md-8">
                                                @for ($rating = 5; $rating >= 1; $rating--)
                                                    @php
                                                        $count = $ratingDistribution[$rating] ?? 0;
                                                        $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                                    @endphp
                                                    <div class="d-flex align-items-center gap-2 mb-1">
                                                        <span class="font-size-11 fw-semibold text-muted" style="width: 40px;">{{ $rating }} star</span>
                                                        <div class="progress flex-grow-1" style="height: 6px;">
                                                            <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <span class="font-size-11 text-muted" style="width: 30px; text-align: right;">{{ $count }}</span>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Review Form for Enrolled Students -->
                                @if ($canReview && !$userReview)
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h4 class="font-size-14 fw-bold mb-2">{{ __('frontend.write_review') }}</h4>
                                        <form action="{{ route('courses.reviews.store', $course->id) }}" method="POST" id="reviewForm">
                                            @csrf
                                            <div class="mb-2">
                                                <label class="form-label font-size-12 fw-semibold">Your Rating <span class="text-danger">*</span></label>
                                                <div class="rating-input d-flex gap-2 font-size-20 cursor-pointer">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star rating-star" data-rating="{{ $i }}" style="color: #cbd5e1;"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="ratingInput" value="" required>
                                                <small class="text-danger d-none" id="ratingError">{{ __('frontend.select_rating_error') }}</small>
                                            </div>
                                            <div class="mb-2">
                                                <label for="comment" class="form-label font-size-12 fw-semibold">{{ __('frontend.your_review') }}</label>
                                                <textarea name="comment" id="comment" class="form-control font-size-13" rows="3" placeholder="{{ __('frontend.share_experience') }}"></textarea>
                                            </div>
                                            <button type="submit" class="theme-btn py-1 px-3 font-size-12" id="submitReviewBtn">
                                                <i class="fa-solid fa-paper-plane me-1"></i> {{ __('frontend.submit_review') }}
                                            </button>
                                        </form>
                                    </div>
                                @elseif($canReview && $userReview)
                                    <div class="p-3 bg-light rounded-3 border mb-3">
                                        <h4 class="font-size-14 fw-bold mb-2">{{ __('frontend.your_review') }}</h4>
                                        <form action="{{ route('courses.reviews.update', [$course->id, $userReview->id]) }}" method="POST" id="reviewForm">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-2">
                                                <label class="form-label font-size-12 fw-semibold">Your Rating <span class="text-danger">*</span></label>
                                                <div class="rating-input d-flex gap-2 font-size-20 cursor-pointer">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star rating-star" data-rating="{{ $i }}" style="color: {{ $i <= $userReview->rating ? '#f59e0b' : '#cbd5e1' }};"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="rating" id="ratingInput" value="{{ $userReview->rating }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="comment" class="form-label font-size-12 fw-semibold">{{ __('frontend.your_review') }}</label>
                                                <textarea name="comment" id="comment" class="form-control font-size-13" rows="3">{{ $userReview->comment }}</textarea>
                                            </div>
                                            <button type="submit" class="theme-btn py-1 px-3 font-size-12">
                                                <i class="fa-solid fa-save me-1"></i> {{ __('frontend.update_review') }}
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <!-- Reviews List -->
                                @if ($totalReviews > 0)
                                    <div class="d-flex flex-column gap-2 mt-2">
                                        @foreach ($reviews as $review)
                                            <div class="p-2 px-3 bg-white border rounded-3">
                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-circle overflow-hidden bg-light" style="width: 30px; height: 30px;">
                                                            <img src="{{ $review->user->profile_photo ? asset('storage/' . $review->user->profile_photo) : asset('assets/front/img/home-1/courses/client-01.png') }}"
                                                                alt="{{ $review->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark font-size-12">{{ $review->user->name }}</div>
                                                            <small class="text-muted font-size-10">{{ $review->created_at->format('M d, Y') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="text-warning font-size-11">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : ' text-black-50' }}"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                @if ($review->comment)
                                                    <p class="font-size-12 text-secondary mb-0">{{ $review->comment }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Desktop Sticky Compact Card (With reduced 135px cover) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="pbz-course-enroll-card pbz-sticky-card">
                        <!-- Compact 135px Media Cover -->
                        <div class="pbz-card-media">
                            <img src="{{ $featuredImageUrl }}" alt="{{ $course->title }}">
                            @if ($hasIntroVideo)
                                <a href="javascript:void(0)" class="intro-video-play-btn pbz-play-overlay-btn"
                                    data-intro-video="{{ $introVideoUrl }}" title="Play Course Preview">
                                    <i class="fa-solid fa-circle-play"></i>
                                </a>
                            @endif
                        </div>

                        <div class="pbz-card-body">
                            <!-- Corporate Access Block -->
                            <div class="pbz-price-box">
                                <span class="badge rounded-pill px-3 py-1.5 fw-bold" style="background: #e6f4ea; color: #137333; font-size: 0.9rem;">
                                    <i class="fa-solid fa-building-columns me-1"></i> PBZ STAFF: 100% FREE
                                </span>
                                @if ($course->curriculum_type === 'islamic_amana')
                                    <div class="mt-2 text-start">
                                        <span class="badge" style="background: #006837; color: #F9ED27; font-size: 0.72rem; font-weight: 700;">
                                            <i class="fa-solid fa-moon me-1 text-warning"></i> PBZ Islamic (Amana) • Shariah Board Certified
                                        </span>
                                    </div>
                                @elseif(!empty($course->compliance_category))
                                    <div class="mt-2 text-start">
                                        <span class="badge" style="background: #081226; color: #F9ED27; font-size: 0.72rem; font-weight: 700;">
                                            <i class="fa-solid fa-scale-balanced me-1 text-warning"></i> Bank of Tanzania (BOT) Statutory Compliance
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Primary CTA Button -->
                            @if ($isEnrolled)
                                <a href="{{ route('student.courses.access', $course->id) }}" class="pbz-btn-enroll pbz-btn-enrolled">
                                    <i class="fas fa-play-circle me-1"></i> Continue Learning
                                </a>
                            @elseif(auth()->check())
                                <a href="{{ route('courses.enroll.direct', $course->id) }}" class="pbz-btn-enroll">
                                    <i class="fa-solid fa-graduation-cap me-1"></i> Enroll in Training (Free)
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="pbz-btn-enroll">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-1"></i> PBZ Staff Login to Enroll
                                </a>
                            @endif

                            <div class="pbz-guarantee-note">
                                <i class="fa-solid fa-shield-halved text-success"></i>
                                <span>Accredited BOT Certificate & Full Access</span>
                            </div>

                            <!-- Compact Course Specs List -->
                            <ul class="pbz-specs-list">
                                @if ($totalDuration > 0)
                                    @php
                                        $hours = floor($totalDuration / 60);
                                        $minutes = $totalDuration % 60;
                                    @endphp
                                    <li class="pbz-spec-item">
                                        <span class="pbz-spec-label"><i class="fa-regular fa-clock"></i> {{ __('frontend.total_duration') }}</span>
                                        <span class="pbz-spec-val">{{ $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m" }}</span>
                                    </li>
                                @endif
                                <li class="pbz-spec-item">
                                    <span class="pbz-spec-label"><i class="fa-solid fa-book-open"></i> {{ __('frontend.lessons') }}</span>
                                    <span class="pbz-spec-val">{{ $lessonCount }}</span>
                                </li>
                                <li class="pbz-spec-item">
                                    <span class="pbz-spec-label"><i class="fa-solid fa-users"></i> {{ __('frontend.students') }}</span>
                                    <span class="pbz-spec-val">{{ $course->max_students ? __('frontend.max') . ' ' . $course->max_students : __('frontend.unlimited') }}</span>
                                </li>
                                @if ($course->difficulty)
                                    <li class="pbz-spec-item">
                                        <span class="pbz-spec-label"><i class="fa-solid fa-layer-group"></i> {{ __('frontend.skill_level') }}</span>
                                        <span class="pbz-spec-val">{{ ucfirst($course->difficulty) }}</span>
                                    </li>
                                @endif
                                @if ($course->language)
                                    <li class="pbz-spec-item">
                                        <span class="pbz-spec-label"><i class="fa-solid fa-globe"></i> {{ __('frontend.language') }}</span>
                                        <span class="pbz-spec-val">{{ ucfirst($course->language) }}</span>
                                    </li>
                                @endif
                                <li class="pbz-spec-item">
                                    <span class="pbz-spec-label"><i class="fa-solid fa-certificate"></i> {{ __('frontend.certifications') }}</span>
                                    <span class="pbz-spec-val text-success">{{ __('frontend.yes') }}</span>
                                </li>
                                @if ($course->schedule_date)
                                    <li class="pbz-spec-item">
                                        <span class="pbz-spec-label"><i class="fa-regular fa-calendar-check"></i> {{ __('frontend.start_date') }}</span>
                                        <span class="pbz-spec-val">{{ $course->schedule_date->format('d M, Y') }}</span>
                                    </li>
                                @endif
                            </ul>

                            <!-- Share Icons -->
                            <div class="d-flex align-items-center justify-content-between pt-2 mt-2 border-top font-size-11">
                                <span class="text-muted fw-semibold">{{ __('frontend.share') }}:</span>
                                <div class="d-flex gap-2">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="fab fa-facebook-f text-primary font-size-10"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($course->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="fab fa-twitter text-info font-size-10"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($course->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                        <i class="fab fa-whatsapp text-success font-size-10"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Floating Sticky Action Bar (Guarantees Zero Scroll Anywhere on Mobile) -->
    <div class="pbz-mobile-floating-bar d-lg-none">
        <div class="pbz-floating-price-wrap">
            <span class="pbz-floating-price-label">Corporate Access</span>
            <span class="pbz-floating-price-val text-success">FREE STAFF ACCESS</span>
        </div>
        <div>
            @if ($isEnrolled)
                <a href="{{ route('student.courses.access', $course->id) }}" class="pbz-btn-enroll pbz-btn-enrolled py-1 px-3 font-size-12">
                    <i class="fas fa-play-circle me-1"></i> Continue
                </a>
            @elseif(auth()->check())
                <a href="{{ route('courses.enroll.direct', $course->id) }}" class="pbz-btn-enroll py-1 px-3 font-size-12">
                    <i class="fa-solid fa-graduation-cap me-1"></i> Enroll Free
                </a>
            @else
                <a href="{{ route('login') }}" class="pbz-btn-enroll py-1 px-3 font-size-12">
                    Staff Login
                </a>
            @endif
        </div>
    </div>

    <!-- Video Modal for Previews -->
    <div id="lessonVideoModal" class="modal fade" tabindex="-1" aria-labelledby="lessonVideoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-dark text-white py-2 px-3">
                    <h5 class="modal-title font-size-15" id="lessonVideoModalTitle">{{ __('frontend.lesson_preview') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-black">
                    <div id="lessonVideoContainer">
                        <video id="lessonVideoPlayer" controls style="width: 100%; max-height: 480px;" class="d-none">
                            Your browser does not support the video tag.
                        </video>
                        <div id="lessonVideoIframe" class="d-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Intro Video Modal -->
    <div id="introVideoModal" class="modal fade" tabindex="-1" aria-labelledby="introVideoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-dark text-white py-2 px-3">
                    <h5 class="modal-title font-size-15" id="introVideoModalTitle">{{ __('frontend.course_intro') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-black">
                    <div id="introVideoContainer">
                        <video id="introVideoPlayer" controls style="width: 100%; max-height: 480px;">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const videoModal = new bootstrap.Modal(document.getElementById('lessonVideoModal'));
                const videoPlayer = document.getElementById('lessonVideoPlayer');
                const videoIframe = document.getElementById('lessonVideoIframe');
                const modalTitle = document.getElementById('lessonVideoModalTitle');

                $('.lesson-preview-play').on('click', function(e) {
                    e.preventDefault();
                    const videoType = $(this).data('video-type');
                    const videoUrl = $(this).data('video-url');
                    const lessonTitle = $(this).data('lesson-title');

                    modalTitle.textContent = lessonTitle || 'Lesson Preview';

                    if (videoType === 'url') {
                        let embedUrl = videoUrl;
                        if (videoUrl.includes('youtube.com/watch')) {
                            embedUrl = videoUrl.replace('watch?v=', 'embed/').split('&')[0];
                        } else if (videoUrl.includes('youtu.be/')) {
                            embedUrl = videoUrl.replace('youtu.be/', 'youtube.com/embed/');
                        } else if (videoUrl.includes('vimeo.com/')) {
                            const vimeoId = videoUrl.split('vimeo.com/')[1].split('?')[0];
                            embedUrl = 'https://player.vimeo.com/video/' + vimeoId;
                        }

                        videoPlayer.classList.add('d-none');
                        videoIframe.classList.remove('d-none');
                        videoIframe.innerHTML = '<iframe src="' + embedUrl +
                            '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen style="width: 100%; height: 480px;"></iframe>';
                    } else {
                        videoIframe.classList.add('d-none');
                        videoPlayer.classList.remove('d-none');
                        videoPlayer.src = videoUrl;
                    }

                    videoModal.show();
                });

                $('#lessonVideoModal').on('hidden.bs.modal', function() {
                    videoPlayer.pause();
                    videoPlayer.src = '';
                    videoIframe.innerHTML = '';
                });

                const introVideoModal = new bootstrap.Modal(document.getElementById('introVideoModal'));
                const introVideoPlayer = document.getElementById('introVideoPlayer');

                $('.intro-video-play-btn').on('click', function(e) {
                    e.preventDefault();
                    const introVideoUrl = $(this).data('intro-video');
                    introVideoPlayer.src = introVideoUrl;
                    introVideoModal.show();
                });

                $('#introVideoModal').on('hidden.bs.modal', function() {
                    introVideoPlayer.pause();
                    introVideoPlayer.src = '';
                });

                // Star rating functionality
                $('.rating-star').on('click', function() {
                    const rating = $(this).data('rating');
                    const container = $(this).closest('.rating-input');
                    const input = container.siblings('#ratingInput');

                    input.val(rating);

                    container.find('.rating-star').each(function() {
                        const starRating = $(this).data('rating');
                        if (starRating <= rating) {
                            $(this).css('color', '#FFAE5D');
                        } else {
                            $(this).css('color', '#ddd');
                        }
                    });
                });

                $('.rating-star').on('mouseenter', function() {
                    const rating = $(this).data('rating');
                    const container = $(this).closest('.rating-input');

                    container.find('.rating-star').each(function() {
                        const starRating = $(this).data('rating');
                        if (starRating <= rating) {
                            $(this).css('color', '#FFAE5D');
                        } else {
                            $(this).css('color', '#ddd');
                        }
                    });
                });

                $('.rating-input').on('mouseleave', function() {
                    const input = $(this).siblings('#ratingInput');
                    const currentRating = parseInt(input.val()) || 0;

                    $(this).find('.rating-star').each(function() {
                        const starRating = $(this).data('rating');
                        if (starRating <= currentRating) {
                            $(this).css('color', '#FFAE5D');
                        } else {
                            $(this).css('color', '#ddd');
                        }
                    });
                });

                // Validate rating before form submission
                $('#reviewForm').on('submit', function(e) {
                    const rating = $('#ratingInput').val();
                    if (!rating || rating === '' || rating === '0') {
                        e.preventDefault();
                        $('#ratingError').removeClass('d-none');
                        ToastMagic?.error('{{ __('frontend.select_rating_error') }}');
                        return false;
                    }
                    $('#ratingError').addClass('d-none');
                });

                // Countdown timer
                const countdownTimer = $('.countdown-timer');
                if (countdownTimer.length > 0) {
                    const targetDate = new Date(countdownTimer.data('date')).getTime();

                    const updateCountdown = function() {
                        const now = new Date().getTime();
                        const distance = targetDate - now;

                        if (distance < 0) {
                            countdownTimer.closest('span').html(
                                '<i class="fas fa-calendar-alt me-1"></i> Course has started');
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        countdownTimer.find('.countdown-days').text(days);
                        countdownTimer.find('.countdown-hours').text(hours);
                        countdownTimer.find('.countdown-minutes').text(minutes);
                        countdownTimer.find('.countdown-seconds').text(seconds);
                    };

                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                }
            });
        </script>
    @endpush

@endsection

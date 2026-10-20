@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
<!-- Authentic PBZ Website Inspired Hero Section (Compact, Floating Poster, Cyan & Islamic Green) -->
<section class="home-hero-pbz py-4 py-lg-4.5 position-relative overflow-hidden border-bottom">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-4">
            <!-- Left Column: High-impact copy, deep green CTA, fast search & glass stats -->
            <div class="col-lg-6 col-12">
                <div class="hero-left-content">
                    <!-- Eyebrow with PBZ signature leading rule -->
                    <div class="d-flex align-items-center gap-2 mb-2 text-white fw-semibold" style="font-size: 0.78rem; letter-spacing: 0.05em;">
                        <span class="hero-eyebrow-rule" style="display: inline-block; width: 28px; height: 2px; background: rgba(255, 255, 255, 0.85);"></span>
                        <span class="text-uppercase text-white text-opacity-95">Secure. Certified. Sovereign.</span>
                    </div>

                    <!-- Heading -->
                    <h1 class="hero-main-heading fw-bold text-white mb-2" style="letter-spacing: -0.02em; line-height: 1.15; font-size: 2.3rem;">
                        {{ $hero['heading'] ?? "PBZ LEARNING ACADEMY" }}
                    </h1>

                    <!-- Subtitle -->
                    <p class="hero-subtext text-white text-opacity-90 mb-3" style="font-size: 0.92rem; line-height: 1.5; max-width: 520px;">
                        {{ $hero['description'] ?? "Empowering banking practitioners across 34 branches in Zanzibar and Mainland Tanzania with BOT regulatory compliance, PBZ Amana Islamic banking, and cybersecurity defense." }}
                    </p>

                    <!-- CTAs Row: Signature PBZ Deep Green Button + Profile Link -->
                    <div class="d-flex flex-wrap align-items-center gap-2.5 mb-3">
                        <a href="{{ route('courses') }}" class="btn btn-pbz-green rounded-pill px-4 py-2 fw-bold text-white shadow-sm d-inline-flex align-items-center gap-2" style="background-color: #006837; border: 1px solid #00522c; font-size: 0.86rem;">
                            <span>Explore Curricula</span>
                            <i class="fa-solid fa-arrow-right" style="font-size: 0.76rem;"></i>
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="font-size: 0.86rem; border-color: rgba(255, 255, 255, 0.65);">
                            <span>Academy Profile</span>
                        </a>
                    </div>

                    <!-- Compact Fast Search Pill -->
                    <div class="hero-search-wrapper mb-2.5" style="max-width: 480px;">
                        <form action="{{ route('courses') }}" method="GET" class="d-flex align-items-center bg-white p-1.5 rounded-pill shadow-sm">
                            <i class="fa-solid fa-magnifying-glass text-muted ms-3 me-2" style="font-size: 0.85rem;"></i>
                            <input type="text" name="search" class="form-control form-control-sm border-0 shadow-none px-1" placeholder="Search courses, AML/CFT, Islamic banking..." style="font-size: 0.84rem;">
                            <button type="submit" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold text-white text-nowrap" style="background-color: #006837; font-size: 0.8rem;">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Popular Tags (Glassmorphic White Pills) -->
                    <div class="hero-quick-tags d-flex flex-wrap align-items-center gap-1.5 mb-3" style="font-size: 0.74rem;">
                        <span class="text-white text-opacity-80 fw-semibold">Popular:</span>
                        <a href="{{ route('courses', ['search' => 'AML']) }}" class="badge rounded-pill text-decoration-none px-2.5 py-1" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35);">
                            AML / CFT &amp; KYC
                        </a>
                        <a href="{{ route('courses', ['search' => 'Islamic']) }}" class="badge rounded-pill text-decoration-none px-2.5 py-1" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35);">
                            PBZ Amana Islamic
                        </a>
                        <a href="{{ route('courses', ['search' => 'Cyber']) }}" class="badge rounded-pill text-decoration-none px-2.5 py-1" style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35);">
                            Cyber Defense
                        </a>
                    </div>

                    <!-- Glassmorphic Stats Strip -->
                    <div class="hero-stats-strip d-flex flex-wrap align-items-center gap-2 gap-sm-2.5 pt-2.5" style="border-top: 1px solid rgba(255, 255, 255, 0.25);">
                        <div class="stat-pill-glass d-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <i class="fa-solid fa-graduation-cap" style="color: #FFA729; font-size: 0.85rem;"></i>
                            <div>
                                <span class="fw-bold text-white d-block leading-none" style="font-size: 0.85rem;">{{ number_format($stats['courses']) }}+</span>
                                <span class="text-white text-opacity-80" style="font-size: 0.65rem;">Modules</span>
                            </div>
                        </div>

                        <div class="stat-pill-glass d-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <i class="fa-solid fa-user-graduate text-white" style="font-size: 0.85rem;"></i>
                            <div>
                                <span class="fw-bold text-white d-block leading-none" style="font-size: 0.85rem;">{{ number_format($stats['students']) }}+</span>
                                <span class="text-white text-opacity-80" style="font-size: 0.65rem;">Learners</span>
                            </div>
                        </div>

                        <div class="stat-pill-glass d-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <i class="fa-solid fa-chalkboard-user" style="color: #FFA729; font-size: 0.85rem;"></i>
                            <div>
                                <span class="fw-bold text-white d-block leading-none" style="font-size: 0.85rem;">{{ number_format($stats['instructors']) }}+</span>
                                <span class="text-white text-opacity-80" style="font-size: 0.65rem;">Faculty</span>
                            </div>
                        </div>

                        <div class="stat-pill-glass d-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25);">
                            <i class="fa-solid fa-shield-halved text-white" style="font-size: 0.85rem;"></i>
                            <div>
                                <span class="fw-bold text-white d-block leading-none" style="font-size: 0.85rem;">34 Branches</span>
                                <span class="text-white text-opacity-80" style="font-size: 0.65rem;">Nationwide</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Authentic PBZ Floating Tilted Poster Card with White L-Corner Accent -->
            <div class="col-lg-6 col-12 d-flex justify-content-center justify-content-lg-end position-relative">
                <div class="pbz-floating-poster-container position-relative">
                    <!-- White Right-Angled L-Bracket at Bottom-Left (As on pbzbank.co.tz) -->
                    <div class="pbz-floating-l-bracket"></div>

                    <!-- The Tilted Floating Card -->
                    <div class="card pbz-floating-poster-card shadow-lg overflow-hidden position-relative">
                        <!-- Top Header Bar inside the Poster -->
                        <div class="p-2.5 px-3 bg-white d-flex align-items-center justify-content-between border-bottom">
                            <!-- PBZ Bank Dual Brand Logo -->
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('assets/front/img/logo/pbz-logo.png') }}" alt="PBZ Bank Logo" style="height: 32px; width: auto;" onerror="this.src='{{ asset('assets/front/img/logo/logo.png') }}'">
                            </div>

                            <!-- Official Circular Seal Emblem -->
                            <div>
                                <img src="{{ asset('assets/front/img/logo/pbz-icon.png') }}" alt="PBZ Official Crest" class="rounded-circle shadow-2xs border" style="width: 36px; height: 36px;">
                            </div>
                        </div>

                        <!-- Poster Photo Slider Container: Dynamic Sliding & Updating -->
                        <div class="pbz-poster-slider position-relative overflow-hidden" style="height: 235px; background: #002b24;">
                            <!-- Slide 1: Tanzanian Male Banker with Tablet -->
                            <div class="pbz-poster-slide active" data-slide-index="0">
                                <img src="{{ asset('assets/front/img/home-1/hero/pbz-poster-banker-landscape.jpg') }}" alt="PBZ Academy Executive" class="w-100 h-100 object-fit-cover" style="object-position: center 15%;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2.5 text-white slide-overlay" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 38, 32, 0.92) 100%);">
                                    <span class="badge rounded-pill px-2 py-0.5 mb-1" style="background: #FFA729; color: #002b24; font-size: 0.65rem; font-weight: 700;">EXECUTIVE BANKING</span>
                                    <div class="fw-bold text-white mb-0" style="font-size: 0.95rem; letter-spacing: -0.01em; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                                        PBZ LEARNING ACADEMY
                                    </div>
                                    <div class="small fw-semibold fst-italic" style="color: #FFA729; font-size: 0.74rem;">
                                        For your professional excellence
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2: Tanzanian Female Banker in Modern Office -->
                            <div class="pbz-poster-slide" data-slide-index="1">
                                <img src="{{ asset('assets/front/img/home-1/hero/pbz-poster-female-landscape.jpg') }}" alt="PBZ Amana Specialist" class="w-100 h-100 object-fit-cover" style="object-position: center 20%;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2.5 text-white slide-overlay" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 38, 32, 0.92) 100%);">
                                    <span class="badge rounded-pill px-2 py-0.5 mb-1" style="background: #10b981; color: #ffffff; font-size: 0.65rem; font-weight: 700;">ISLAMIC FINANCE</span>
                                    <div class="fw-bold text-white mb-0" style="font-size: 0.95rem; letter-spacing: -0.01em; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                                        PBZ AMANA BANKING
                                    </div>
                                    <div class="small fw-semibold fst-italic" style="color: #FFA729; font-size: 0.74rem;">
                                        Shariah-certified finance &amp; contracts
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3: Executive Boardroom / Lecture Hall -->
                            <div class="pbz-poster-slide" data-slide-index="2">
                                <img src="{{ asset('assets/front/img/home-1/hero/pbz-poster-academy-landscape.jpg') }}" alt="PBZ Academy Boardroom" class="w-100 h-100 object-fit-cover" style="object-position: center center;">
                                <div class="position-absolute bottom-0 start-0 w-100 p-2.5 text-white slide-overlay" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 38, 32, 0.92) 100%);">
                                    <span class="badge rounded-pill px-2 py-0.5 mb-1" style="background: #3b82f6; color: #ffffff; font-size: 0.65rem; font-weight: 700;">BOT COMPLIANCE</span>
                                    <div class="fw-bold text-white mb-0" style="font-size: 0.95rem; letter-spacing: -0.01em; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                                        BOT REGULATORY EXCELLENCE
                                    </div>
                                    <div class="small fw-semibold fst-italic" style="color: #FFA729; font-size: 0.74rem;">
                                        Empowering 34 branches nationwide
                                    </div>
                                </div>
                            </div>

                            <!-- Mini Progress Dots inside Card -->
                            <div class="pbz-slide-dots position-absolute bottom-0 end-0 m-2 d-flex align-items-center gap-1" style="z-index: 5;">
                                <button type="button" class="pbz-dot-indicator active" data-dot-index="0" aria-label="Slide 1"></button>
                                <button type="button" class="pbz-dot-indicator" data-dot-index="1" aria-label="Slide 2"></button>
                                <button type="button" class="pbz-dot-indicator" data-dot-index="2" aria-label="Slide 3"></button>
                            </div>
                        </div>

                        <!-- Poster Bottom Ribbon: Contact & Choice Slogan -->
                        <div class="p-2 px-3 bg-white d-flex align-items-center justify-content-between text-dark" style="font-size: 0.68rem;">
                            <span class="text-muted fw-semibold text-uppercase tracking-wider">
                                THE PEOPLE'S BANK, THE PEOPLE'S CHOICE
                            </span>
                            <span class="fw-bold text-primary d-flex align-items-center gap-1">
                                <i class="fa-solid fa-headset text-warning"></i>
                                <span>0800 750 075</span>
                            </span>
                        </div>
                    </div>

                    <!-- Floating Translucent Arrow Controls on Right Edge (Interactive & Connected to Slider) -->
                    <div class="pbz-floating-slider-arrows d-none d-sm-flex flex-column gap-2 position-absolute">
                        <button type="button" class="btn btn-sm pbz-slider-circle-btn" id="pbzSliderPrev" aria-label="Previous slide">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm pbz-slider-circle-btn" id="pbzSliderNext" aria-label="Next slide">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Compact Categories Grid Section -->
<section class="home-categories-section py-4 bg-light-subtle border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">ACADEMY DISCIPLINES</span>
                <h4 class="fw-bold text-dark m-0" style="font-size: 1.25rem;">Browse by Category</h4>
            </div>
            <a href="{{ route('courses') }}" class="text-decoration-none small text-primary fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                All Categories <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-2.5">
            @forelse($topCategories as $category)
                <div class="col">
                    <a href="{{ route('courses', ['category' => $category['slug']]) }}" class="category-compact-card text-decoration-none d-flex flex-column align-items-center justify-content-center p-2.5 rounded-2 bg-white border text-center h-100 shadow-2xs">
                        <div class="cat-icon-circle rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center mb-1.5" style="width: 36px; height: 36px; font-size: 0.85rem;">
                            <i class="{{ $category['icon_class'] }}"></i>
                        </div>
                        <span class="cat-name fw-bold text-dark text-truncate w-100" style="font-size: 0.78rem;" title="{{ $category['name'] }}">
                            {{ $category['name'] }}
                        </span>
                        <span class="cat-count text-muted" style="font-size: 0.68rem;">
                            {{ $category['courses_count'] }} {{ Str::plural('course', $category['courses_count']) }}
                        </span>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center py-2 text-muted small m-0">No categories found.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Compact Featured Courses Section (Exact 3-per-row layout) -->
<section class="home-courses-section py-4.5">
    <div class="container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3.5">
            <div>
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">FEATURED PROGRAMS</span>
                <h3 class="fw-bold text-dark m-0" style="font-size: 1.45rem;">Popular Banking Courses</h3>
            </div>
            <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                <span>View All Courses</span>
                <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <!-- 3 Cards Per Row Grid -->
        <div class="row g-3 g-lg-3.5">
            @forelse($featuredCourses as $index => $course)
                @php
                    $lessonCount = $course->topics ? $course->topics->sum(function ($topic) {
                        return $topic->lessons ? $topic->lessons->count() : 0;
                    }) : ($course->lessons_count ?? 0);

                    $totalDuration = $course->topics ? $course->topics->sum(function ($topic) {
                        return $topic->lessons ? $topic->lessons->sum(function ($lesson) {
                            return (int) ($lesson->duration ?? 0);
                        }) : 0;
                    }) : 0;

                    $formattedDuration = null;
                    if ($totalDuration > 0) {
                        $hours = floor($totalDuration / 60);
                        $mins = $totalDuration % 60;
                        $formattedDuration = ($hours > 0 ? $hours . 'h ' : '') . ($mins > 0 ? $mins . 'm' : ($hours === 0 ? '0m' : ''));
                    } else {
                        $formattedDuration = 'Self-paced';
                    }

                    $isFree = $course->getAttribute('is_free');
                    $displayPrice = $isFree ? __('frontend.free') : currency_format($course->getAttribute('display_price'));
                    $hasDiscount = (!$isFree && $course->regular_price > 0 && $course->sale_price > 0 && $course->regular_price > $course->sale_price);
                    $discountPercent = $hasDiscount ? round((($course->regular_price - $course->sale_price) / $course->regular_price) * 100) : 0;
                    $originalPrice = ($hasDiscount) ? currency_format($course->regular_price) : null;

                    $ratingVal = number_format($course->average_rating ?? 5.0, 1);
                    $studentsCount = $course->students_count ?? 0;
                    $difficulty = ucfirst($course->difficulty ?: 'All Levels');

                    $thumbUrl = $course->getAttribute('display_image');
                    $instructorPhoto = $course->getAttribute('instructor_avatar');
                    $instructorName = optional($course->instructor)->name ?? __('frontend.instructor');
                    $categoryName = $course->getAttribute('display_category');
                @endphp

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card course-compact-card border h-100 shadow-sm rounded-3 overflow-hidden bg-white d-flex flex-column">
                        <!-- Thumbnail (145px compact height) -->
                        <div class="course-thumb-box position-relative overflow-hidden" style="height: 145px; background: #f1f5f9;">
                            <a href="{{ route('courses.show', $course->id) }}" class="d-block w-100 h-100 text-decoration-none">
                                <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" class="course-thumb-img w-100 h-100 object-fit-cover" loading="lazy">
                            </a>

                            <!-- Category Badge (Top-Left) -->
                            @if ($categoryName)
                                <div class="position-absolute top-0 start-0 m-2.5 z-2" style="max-width: 65%;">
                                    <span class="badge bg-white text-dark shadow-sm border rounded-pill px-2.5 py-1 text-truncate d-inline-block mw-100" style="font-size: 0.72rem; font-weight: 600; letter-spacing: 0.01em;">
                                        {{ ucfirst($categoryName) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Discount / Status Badge (Top-Right) -->
                            <div class="position-absolute top-0 end-0 m-2.5 z-2">
                                @if ($course->is_live_course)
                                    <span class="badge bg-danger shadow-sm rounded-pill px-2.5 py-1 fw-bold" style="font-size: 0.7rem;">
                                        <i class="fas fa-broadcast-tower me-1"></i> LIVE
                                    </span>
                                @elseif ($hasDiscount)
                                    <span class="badge bg-danger shadow-sm rounded-pill px-2 py-1 fw-bold" style="font-size: 0.72rem;">
                                        -{{ $discountPercent }}%
                                    </span>
                                @elseif ($isFree)
                                    <span class="badge bg-emerald shadow-sm rounded-pill px-2 py-1 fw-bold text-white" style="font-size: 0.7rem; background-color: #10b981;">
                                        FREE
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Content Body -->
                        <div class="card-body p-3 d-flex flex-column flex-grow-1">
                            <!-- Stars & Students Count Row -->
                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                <div class="d-flex align-items-center gap-1.5">
                                    <span class="text-warning rating-stars d-inline-flex gap-0.5" style="font-size: 0.76rem;">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="fa-solid fa-star"></i>
                                        @endfor
                                    </span>
                                    <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $ratingVal }}</span>
                                </div>
                                <span class="text-muted" style="font-size: 0.75rem;">
                                    {{ $studentsCount }} {{ Str::plural('student', $studentsCount) }}
                                </span>
                            </div>

                            <!-- Course Title (Clamped to 2 lines) -->
                            <h6 class="course-card-title fw-bold mb-2">
                                <a href="{{ route('courses.show', $course->id) }}" class="text-dark text-decoration-none hover-primary" title="{{ $course->title }}">
                                    {{ $course->title }}
                                </a>
                            </h6>

                            <!-- Instructor Row -->
                            <div class="d-flex align-items-center gap-2 mb-2.5">
                                @if ($instructorPhoto)
                                    <img src="{{ $instructorPhoto }}" alt="{{ $instructorName }}" class="rounded-circle object-fit-cover flex-shrink-0 border" style="width: 22px; height: 22px;">
                                @else
                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-size: 10px;">
                                        {{ strtoupper(substr($instructorName, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-muted text-truncate" style="font-size: 0.78rem; font-weight: 500;">
                                    {{ $instructorName }}
                                </span>
                            </div>

                            <!-- Specs Row -->
                            <div class="course-specs-bar d-flex align-items-center justify-content-between text-muted small py-1.5 px-2 mb-2.5 rounded-2 bg-light border" style="font-size: 0.73rem;">
                                <span class="d-flex align-items-center gap-1 text-truncate">
                                    <i class="fa-regular fa-circle-play text-primary" style="font-size: 0.75rem;"></i>
                                    <span>{{ $lessonCount }} lessons</span>
                                </span>
                                <span class="d-flex align-items-center gap-1 text-truncate">
                                    <i class="fa-regular fa-clock text-primary" style="font-size: 0.75rem;"></i>
                                    <span>{{ $formattedDuration }}</span>
                                </span>
                                <span class="d-flex align-items-center gap-1 text-truncate">
                                    <i class="fa-solid fa-signal text-primary" style="font-size: 0.7rem;"></i>
                                    <span>{{ $difficulty }}</span>
                                </span>
                            </div>

                            <!-- Perk Row -->
                            <div class="d-flex align-items-center gap-1 text-success small fw-semibold mb-3 mt-auto" style="font-size: 0.72rem;">
                                <i class="fa-solid fa-circle-check" style="font-size: 0.75rem;"></i>
                                <span>Free with All-Access Banking Pass</span>
                            </div>

                            <!-- Footer: Price & View Button -->
                            <div class="d-flex align-items-center justify-content-between pt-2.5 border-top mt-auto">
                                <div class="d-flex align-items-baseline gap-1.5">
                                    <span class="fw-bold text-dark fs-6" style="letter-spacing: -0.01em;">
                                        {{ $displayPrice }}
                                    </span>
                                    @if ($originalPrice)
                                        <del class="text-muted small" style="font-size: 0.75rem;">{{ $originalPrice }}</del>
                                    @endif
                                </div>

                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-outline-primary px-3 py-1 rounded-2 fw-semibold" style="font-size: 0.78rem; transition: all 0.2s ease;">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-3 text-center">
                    <p class="text-muted small m-0">{{ __('frontend.no_courses_yet') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Compact Bundles Section (Only if bundles exist) -->
@if(isset($featuredBundles) && $featuredBundles->isNotEmpty())
<section class="home-bundles-section py-4 bg-light border-top border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-3.5">
            <div>
                <span class="text-uppercase fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em; color: #006837;">PBZ QUALIFICATION TRACKS</span>
                <h4 class="fw-bold text-dark m-0" style="font-size: 1.35rem;">Curated Banking Diplomas &amp; Learning Paths</h4>
            </div>
            <a href="{{ route('bundles.index') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.78rem; border-color: #006837; color: #006837;">
                View All Diplomas
            </a>
        </div>

        <div class="row g-3">
            @foreach($featuredBundles as $bundle)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card bundle-compact-card border h-100 shadow-sm rounded-3 overflow-hidden bg-white">
                        <div class="position-relative" style="height: 135px; background: #e6f4ea;">
                            <img src="{{ $bundle->thumbnail ?? asset('assets/front/img/home-1/courses/courses-01.jpg') }}" alt="{{ $bundle->title }}" class="w-100 h-100 object-fit-cover">
                            <span class="badge shadow-sm position-absolute top-0 start-0 m-2 rounded-pill px-2.5 py-1" style="background: #006837; color: #F9ED27; font-size: 0.7rem; font-weight: 700;">
                                <i class="fa-solid fa-layer-group me-1"></i> {{ $bundle->courses()->count() }} Courses Included
                            </span>
                        </div>
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.88rem;">
                                <a href="{{ route('bundles.show', $bundle->id) }}" class="text-dark text-decoration-none hover-primary">{{ $bundle->title }}</a>
                            </h6>
                            <p class="text-muted small mb-2.5" style="font-size: 0.76rem; line-height: 1.35; height: 2.7em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ Str::limit(strip_tags($bundle->description ?? ''), 90) }}
                            </p>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top mt-auto">
                                <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #e6f4ea; color: #137333; font-size: 0.74rem;">
                                    <i class="fa-solid fa-building-columns me-1"></i> FREE STAFF ACCESS
                                </span>
                                <a href="{{ route('bundles.show', $bundle->id) }}" class="btn btn-sm btn-primary px-3 py-1 rounded-2 fw-semibold" style="font-size: 0.76rem; background-color: #006837; border-color: #006837;">
                                    Explore Diploma
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Compact Why PBZ Academy / Key Pillars Section -->
<section class="home-pillars-section py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-4 col-12">
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">WHY PBZ ACADEMY</span>
                <h3 class="fw-bold text-dark mb-2" style="font-size: 1.35rem; line-height: 1.25;">
                    Empowering Bankers Across Zanzibar & Beyond
                </h3>
                <p class="text-muted small mb-3" style="font-size: 0.82rem; line-height: 1.45;">
                    Accredited banking curricula designed to elevate compliance, Shariah governance, and cybersecurity proficiency.
                </p>
                <a href="{{ route('about') }}" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-semibold" style="font-size: 0.78rem;">
                    Learn About Academy
                </a>
            </div>

            <div class="col-lg-8 col-12">
                <div class="row g-2.5">
                    <div class="col-sm-6 col-12">
                        <div class="p-3 rounded-2 bg-light border h-100">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fa-solid fa-scale-balanced"></i>
                                </div>
                                <h6 class="fw-bold text-dark m-0" style="font-size: 0.85rem;">BOT Regulatory Compliance</h6>
                            </div>
                            <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                                Directly aligned with Bank of Tanzania regulatory standards and mandatory AML/CFT guidelines.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="p-3 rounded-2 bg-light border h-100">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fa-solid fa-moon"></i>
                                </div>
                                <h6 class="fw-bold text-dark m-0" style="font-size: 0.85rem;">Amana Islamic Banking</h6>
                            </div>
                            <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                                Certified Shariah contracts, Murabaha, Ijara, and Takaful operational workflows.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="p-3 rounded-2 bg-light border h-100">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <h6 class="fw-bold text-dark m-0" style="font-size: 0.85rem;">Cybersecurity Defense</h6>
                            </div>
                            <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                                Defensive hygiene, phishing countermeasures, and fraud incident response for modern banking.
                            </p>
                        </div>
                    </div>

                    <div class="col-sm-6 col-12">
                        <div class="p-3 rounded-2 bg-light border h-100">
                            <div class="d-flex align-items-center gap-2 mb-1.5">
                                <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                    <i class="fa-solid fa-certificate"></i>
                                </div>
                                <h6 class="fw-bold text-dark m-0" style="font-size: 0.85rem;">Verifiable Digital Badges</h6>
                            </div>
                            <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                                Earn tamper-proof digital certificates validating your banking competencies and career milestones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Compact Faculty / Instructors Section -->
<section class="home-instructors-section py-4 bg-light-subtle border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">ACADEMY FACULTY</span>
                <h4 class="fw-bold text-dark m-0" style="font-size: 1.25rem;">Expert Banking Instructors</h4>
            </div>
            <a href="{{ route('instructors.index') }}" class="text-decoration-none small text-primary fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                All Instructors <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="row row-cols-2 row-cols-md-4 g-2.5">
            @forelse($featuredInstructors as $instructor)
                <div class="col">
                    <div class="instructor-compact-card p-3 rounded-2 bg-white border text-center h-100 shadow-2xs">
                        <div class="position-relative d-inline-block mb-2">
                            <img src="{{ $instructor['avatar'] }}" alt="{{ $instructor['name'] }}" class="rounded-circle object-fit-cover border shadow-2xs" style="width: 52px; height: 52px;">
                        </div>
                        <h6 class="fw-bold mb-0 text-truncate text-dark" style="font-size: 0.82rem;">
                            <a href="{{ route('instructors.show', $instructor['id']) }}" class="text-dark text-decoration-none hover-primary">{{ $instructor['name'] }}</a>
                        </h6>
                        <span class="text-muted d-block text-truncate mb-1.5" style="font-size: 0.7rem;">
                            {{ $instructor['headline'] ?: 'Banking Specialist' }}
                        </span>
                        <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                            {{ $instructor['courses_count'] }} {{ Str::plural('Course', $instructor['courses_count']) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center py-2 text-muted small m-0">{{ __('frontend.no_instructors') }}</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Compact Testimonials Section -->
<section class="home-testimonials-section py-4 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">LEARNER FEEDBACK</span>
                <h4 class="fw-bold text-dark m-0" style="font-size: 1.25rem;">What PBZ Bankers Say</h4>
            </div>
            <div class="d-flex align-items-center gap-1.5 text-warning small">
                <i class="fa-solid fa-star"></i>
                <span class="fw-bold text-dark">{{ number_format($testimonials->avg('rating'), 1) }}</span>
                <span class="text-muted" style="font-size: 0.75rem;">Platform Rating</span>
            </div>
        </div>

        <div class="row g-2.5">
            @forelse($testimonials->take(3) as $testimonial)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="testimonial-compact-card p-3 rounded-2 bg-white border h-100 d-flex flex-column shadow-2xs">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-inline-flex gap-0.5 text-warning" style="font-size: 0.74rem;">
                                @for ($s = 1; $s <= 5; $s++)
                                    <i class="fa-solid fa-star {{ $s <= $testimonial['rating'] ? '' : 'text-muted opacity-25' }}"></i>
                                @endfor
                            </div>
                            <i class="fa-solid fa-quote-right text-muted opacity-25" style="font-size: 0.9rem;"></i>
                        </div>
                        <p class="text-muted small mb-2.5 flex-grow-1" style="font-size: 0.78rem; line-height: 1.45;">
                            “{{ Str::limit($testimonial['comment'], 140) }}”
                        </p>
                        <div class="d-flex align-items-center gap-2 pt-2 border-top mt-auto">
                            <img src="{{ $testimonial['student_avatar'] }}" alt="{{ $testimonial['student_name'] }}" class="rounded-circle object-fit-cover border" style="width: 26px; height: 26px;">
                            <div class="text-truncate">
                                <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size: 0.76rem;">{{ $testimonial['student_name'] }}</h6>
                                @if ($testimonial['course_title'])
                                    <span class="text-muted text-truncate d-block" style="font-size: 0.68rem;">{{ Str::limit($testimonial['course_title'], 28) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center py-2 text-muted small m-0">{{ __('frontend.no_reviews') }}</div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Compact News & Updates Section (Blog) -->
@if(isset($blogPosts) && $blogPosts->isNotEmpty())
<section class="home-news-section py-4 bg-light-subtle border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <div>
                <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">NEWS &amp; INSIGHTS</span>
                <h4 class="fw-bold text-dark m-0" style="font-size: 1.25rem;">Latest Banking Articles</h4>
            </div>
            <a href="{{ route('blog.index') }}" class="text-decoration-none small text-primary fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                All Articles <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="row g-2.5">
            @foreach($blogPosts->take(3) as $post)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card news-compact-card border h-100 shadow-2xs rounded-2 overflow-hidden bg-white">
                        <div class="position-relative" style="height: 120px; background: #e2e8f0;">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="w-100 h-100 object-fit-cover">
                            <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 start-0 m-2 rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                {{ $post['category'] }}
                            </span>
                        </div>
                        <div class="p-2.5 d-flex flex-column flex-grow-1">
                            <span class="text-muted d-block mb-1" style="font-size: 0.68rem;">
                                <i class="fa-regular fa-calendar me-1"></i>{{ $post['published_at'] ?? 'Recent' }}
                            </span>
                            <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.82rem;">
                                <a href="{{ route('blog.show', $post['slug']) }}" class="text-dark text-decoration-none hover-primary">{{ $post['title'] }}</a>
                            </h6>
                            <p class="text-muted small mb-2 flex-grow-1" style="font-size: 0.74rem; line-height: 1.35; height: 2.7em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                {{ Str::limit(strip_tags($post['excerpt']), 85) }}
                            </p>
                            <a href="{{ route('blog.show', $post['slug']) }}" class="small text-primary fw-semibold text-decoration-none mt-auto" style="font-size: 0.74rem;">
                                Read Article &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Compact Slim Newsletter / CTA Banner -->
<section class="home-cta-section py-4 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-lg-6 col-12 text-center text-lg-start">
                <h5 class="fw-bold mb-1 text-white" style="letter-spacing: -0.01em;">
                    {{ $ctaSettings['heading'] ?? 'Stay Updated with PBZ Academy Announcements' }}
                </h5>
                <p class="text-white-50 small mb-0" style="font-size: 0.82rem;">
                    {{ $ctaSettings['description'] ?? 'Receive new course releases, regulatory bulletins, and executive training schedules directly in your inbox.' }}
                </p>
            </div>
            <div class="col-lg-6 col-12">
                <form action="{{ route('newsletter.subscribe') }}" method="POST" id="newsletterSubscribeForm" class="d-flex align-items-center bg-white p-1 rounded-pill shadow-sm" style="max-width: 460px; margin: 0 auto 0 auto;">
                    @csrf
                    <input type="email" name="email" id="newsletter-email" class="form-control form-control-sm border-0 shadow-none px-3" placeholder="{{ $ctaSettings['placeholder'] ?? 'Enter your official email' }}" required style="font-size: 0.82rem;">
                    <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3.5 py-1.5 fw-semibold text-nowrap" id="newsletterSubmitBtn" style="font-size: 0.8rem;">
                        {{ $ctaSettings['button_label'] ?? 'Subscribe' }}
                    </button>
                </form>
                <div id="newsletterFeedback" class="small mt-1 text-center text-white" style="font-size: 0.75rem;"></div>
            </div>
        </div>
    </div>
</section>

<!-- Scoped CSS for Home Page Minimal Aesthetics -->
<style>
    /* Authentic PBZ Cyan Hero Section Styling */
    .home-hero-pbz {
        background: linear-gradient(135deg, #009fe3 0%, #0087c9 100%);
        color: #ffffff;
    }

    .btn-pbz-green {
        background-color: #006837 !important;
        border-color: #00522c !important;
        color: #ffffff !important;
        transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 14px rgba(0, 104, 55, 0.35);
    }
    .btn-pbz-green:hover {
        background-color: #00542c !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 104, 55, 0.45);
        color: #ffffff !important;
    }

    .stat-pill-glass {
        transition: background-color 0.2s ease, transform 0.2s ease;
    }
    .stat-pill-glass:hover {
        background: rgba(255, 255, 255, 0.24) !important;
        transform: translateY(-1px);
    }

    /* Floating Tilted Card Container (PBZ Website Style) */
    .pbz-floating-poster-container {
        max-width: 420px;
        width: 100%;
        margin: 12px 0;
    }

    /* White L-Corner Bracket at Bottom-Left */
    .pbz-floating-l-bracket {
        position: absolute;
        bottom: -10px;
        left: -12px;
        width: 44px;
        height: 44px;
        border-bottom: 4.5px solid #ffffff;
        border-left: 4.5px solid #ffffff;
        border-radius: 0 0 0 6px;
        pointer-events: none;
        z-index: 1;
    }

    /* Floating Tilted Poster Card */
    .pbz-floating-poster-card {
        transform: rotate(-2.5deg);
        transform-origin: center center;
        border: 3.5px solid #ffffff !important;
        border-radius: 14px !important;
        box-shadow: 0 24px 48px -12px rgba(0, 38, 32, 0.4), 0 12px 24px -8px rgba(0, 0, 0, 0.25) !important;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease;
        z-index: 2;
    }
    .pbz-floating-poster-card:hover {
        transform: rotate(0deg) translateY(-4px) scale(1.02);
        box-shadow: 0 30px 60px -15px rgba(0, 38, 32, 0.45) !important;
    }

    /* Floating Side Slider Buttons */
    .pbz-floating-slider-arrows {
        right: -42px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 3;
    }
    .pbz-slider-circle-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.28);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }
    .pbz-slider-circle-btn:hover {
        background: #ffffff;
        color: #009fe3;
        transform: scale(1.08);
    }

    /* Poster Dynamic Slider Animation & Dots */
    .pbz-poster-slider {
        position: relative;
        height: 235px;
        background: #002b24;
    }
    .pbz-poster-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.55s ease, transform 0.55s ease;
        transform: scale(1.03);
        z-index: 1;
    }
    .pbz-poster-slide.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
        z-index: 2;
    }
    .pbz-dot-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.45);
        border: none;
        padding: 0;
        transition: all 0.25s ease;
        cursor: pointer;
    }
    .pbz-dot-indicator.active {
        width: 20px;
        border-radius: 4px;
        background: #FFA729;
    }

    /* Course Compact Card */
    .course-compact-card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.2s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease;
    }
    .course-compact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
        border-color: #cbd5e1 !important;
    }
    .course-thumb-box img.course-thumb-img {
        transition: transform 0.35s ease;
    }
    .course-compact-card:hover .course-thumb-box img.course-thumb-img {
        transform: scale(1.04);
    }
    .course-card-title {
        font-size: 0.9rem;
        line-height: 1.35;
        height: 2.7em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course-card-title a:hover,
    .hover-primary:hover {
        color: #0d6efd !important;
    }
    .course-specs-bar {
        background: #f8fafc !important;
        border: 1px solid #eef2f6 !important;
    }

    /* Category Compact Card */
    .category-compact-card {
        border: 1px solid #e2e8f0;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .category-compact-card:hover {
        transform: translateY(-2px);
        border-color: #0d6efd !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.08) !important;
    }

    /* Bundle & Instructor Cards */
    .bundle-compact-card,
    .instructor-compact-card,
    .testimonial-compact-card,
    .news-compact-card {
        border: 1px solid #e2e8f0 !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .bundle-compact-card:hover,
    .instructor-compact-card:hover,
    .testimonial-compact-card:hover,
    .news-compact-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06) !important;
        border-color: #cbd5e1 !important;
    }

    .shadow-2xs {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    @media (max-width: 991.98px) {
        .pbz-floating-poster-container {
            margin: 15px auto 0 auto;
        }
        .pbz-floating-poster-card {
            transform: rotate(0deg) !important;
            max-width: 380px;
            margin: 0 auto;
        }
        .pbz-floating-l-bracket {
            display: none !important;
        }
        .pbz-floating-slider-arrows {
            display: none !important;
        }
    }

    @media (max-width: 767.98px) {
        .hero-main-heading {
            font-size: 1.65rem !important;
        }
        .hero-subtext {
            font-size: 0.85rem !important;
        }
        .stat-pill, .stat-pill-glass {
            padding: 4px 8px !important;
        }
        .course-thumb-box {
            height: 140px !important;
        }
    }
</style>
@endsection

@push('scripts')
    <script>
        $(function () {
            // Dynamic PBZ Floating Card Slider
            (function () {
                const slides = document.querySelectorAll('.pbz-poster-slide');
                const dots = document.querySelectorAll('.pbz-dot-indicator');
                const prevBtn = document.getElementById('pbzSliderPrev');
                const nextBtn = document.getElementById('pbzSliderNext');
                if (!slides.length) return;

                let currentIndex = 0;
                let slideTimer = null;

                function showSlide(index) {
                    slides[currentIndex].classList.remove('active');
                    if (dots[currentIndex]) dots[currentIndex].classList.remove('active');

                    currentIndex = (index + slides.length) % slides.length;

                    slides[currentIndex].classList.add('active');
                    if (dots[currentIndex]) dots[currentIndex].classList.add('active');
                }

                function startTimer() {
                    stopTimer();
                    slideTimer = setInterval(function () {
                        showSlide(currentIndex + 1);
                    }, 4000);
                }

                function stopTimer() {
                    if (slideTimer) clearInterval(slideTimer);
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        showSlide(currentIndex - 1);
                        startTimer();
                    });
                }

                if (nextBtn) {
                    nextBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        showSlide(currentIndex + 1);
                        startTimer();
                    });
                }

                dots.forEach(function (dot, idx) {
                    dot.addEventListener('click', function (e) {
                        e.preventDefault();
                        showSlide(idx);
                        startTimer();
                    });
                });

                const card = document.querySelector('.pbz-floating-poster-container');
                if (card) {
                    card.addEventListener('mouseenter', stopTimer);
                    card.addEventListener('mouseleave', startTimer);
                }

                startTimer();
            })();

            // Newsletter AJAX submission
            const form = $('#newsletterSubscribeForm');
            const submitBtn = $('#newsletterSubmitBtn');
            const defaultBtnLabel = submitBtn.text();
            const feedback = $('#newsletterFeedback');

            form.on('submit', function (event) {
                event.preventDefault();
                feedback.removeClass('text-success text-danger text-warning').text('');

                submitBtn.prop('disabled', true).text('Subscribing...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        form[0].reset();
                        feedback.addClass('text-white fw-semibold').text(response.message || 'Subscribed successfully!');
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong. Please try again later.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0] || message;
                        }
                        feedback.addClass('text-warning').text(message);
                    },
                    complete: function () {
                        submitBtn.prop('disabled', false).text(defaultBtnLabel);
                    }
                });
            });
        });
    </script>
@endpush

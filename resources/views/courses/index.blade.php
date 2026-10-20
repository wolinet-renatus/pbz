@extends('layouts.app')

{{-- Omit bulky breadcrumb hero banner to keep page minimal and compact --}}
@section('breadcrumb')
@endsection

@section('content')
    <!-- Minimal Catalog Header (Hello Section) -->
    <div class="catalog-hero-minimal bg-light py-3.5 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                            COURSE CATALOG
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Courses</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="catalog-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        Explore <span class="text-primary">Courses</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        <span id="catalogCountDisplay" class="fw-bold text-dark">{{ $courses->total() }}</span> {{ __('frontend.courses_found') ?? 'courses found' }}
                    </p>
                </div>

                <!-- Sort By Select (Top-Right) -->
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small text-nowrap d-none d-sm-inline" style="font-size: 0.82rem;">Sort by</span>
                    <select id="sortBySelect" class="form-select form-select-sm sort-select shadow-sm" style="width: auto; min-width: 160px; border-radius: 8px; font-size: 0.82rem; font-weight: 500;">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Top Filters & 3-Column Grid -->
    <section class="courses-catalog-section py-4">
        <div class="container">
            <!-- TOP FILTER & REAL-TIME SEARCH BAR -->
            <div class="top-filter-card bg-white p-3 p-md-3.5 rounded-3 border shadow-sm mb-4">
                <div class="row g-2.5 align-items-center">
                    <!-- Real-Time Search Input -->
                    <div class="col-lg-5 col-md-12">
                        <div class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.88rem; pointer-events: none;"></i>
                            <input type="text" id="courseSearchInput" class="form-control form-control-sm ps-5 pe-5 py-2 rounded-2" placeholder="Search course title, keyword, topic..." value="{{ request('search') }}" autocomplete="off" style="font-size: 0.85rem; border-color: #cbd5e1;">
                            <button type="button" id="clearSearchBtn" class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-1 text-muted text-decoration-none {{ request('search') ? '' : 'd-none' }}" style="font-size: 0.82rem; padding: 2px 8px;" title="Clear search">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown Filters: Level, Price, Reset -->
                    <div class="col-lg-7 col-md-12">
                        <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                            <!-- Level / Difficulty Select -->
                            <div class="filter-dropdown-wrapper">
                                <select id="levelSelect" class="form-select form-select-sm rounded-2 shadow-none" style="font-size: 0.82rem; min-width: 125px; border-color: #cbd5e1;">
                                    <option value="">All Levels</option>
                                    <option value="beginner" {{ request('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ request('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ request('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>

                            <!-- Dual Curriculum & Compliance Track Select -->
                            <div class="filter-dropdown-wrapper">
                                <select id="trackSelect" class="form-select form-select-sm rounded-2 shadow-none" style="font-size: 0.82rem; min-width: 170px; border-color: #006837; font-weight: 600;">
                                    <option value="">All Academy Tracks</option>
                                    <option value="conventional" {{ request('track') == 'conventional' ? 'selected' : '' }}>Conventional Banking</option>
                                    <option value="islamic_amana" {{ request('track') == 'islamic_amana' ? 'selected' : '' }}>PBZ Islamic (Amana)</option>
                                    <option value="compliance" {{ request('track') == 'compliance' ? 'selected' : '' }}>BOT Compliance (AML/KYC)</option>
                                    <option value="microlearning" {{ request('track') == 'microlearning' ? 'selected' : '' }}>Branch Microlearning (5-12m)</option>
                                </select>
                            </div>

                            <!-- Rating Select -->
                            <div class="filter-dropdown-wrapper">
                                <select id="ratingSelect" class="form-select form-select-sm rounded-2 shadow-none" style="font-size: 0.82rem; min-width: 120px; border-color: #cbd5e1;">
                                    <option value="">All Ratings</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                                </select>
                            </div>

                            <!-- Reset Filters Button -->
                            <button type="button" id="resetFiltersBtn" class="btn btn-sm btn-outline-secondary rounded-2 px-2.5 py-1.5 d-flex align-items-center gap-1.5 shadow-none" style="font-size: 0.8rem;" title="Reset all filters">
                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                <span class="d-none d-sm-inline">Reset</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Category Pills Bar (Horizontal scrollable) -->
                <div class="category-pills-bar mt-3 pt-2.5 border-top d-flex align-items-center gap-2 overflow-x-auto pb-1">
                    <button type="button" class="btn btn-sm category-pill-btn rounded-pill px-3 py-1 text-nowrap {{ !request('category') ? 'active' : '' }}" data-category="">
                        All Categories
                    </button>
                    @foreach ($categories as $cat)
                        <button type="button" class="btn btn-sm category-pill-btn rounded-pill px-3 py-1 text-nowrap {{ request('category') == $cat->category ? 'active' : '' }}" data-category="{{ $cat->category }}">
                            {{ ucfirst($cat->category) }}
                            <span class="badge bg-secondary-subtle text-secondary ms-1 rounded-pill" style="font-size: 0.7rem;">{{ $cat->count }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- COURSES GRID (3 PER ROW) -->
            <div class="courses-grid-wrapper position-relative" style="min-height: 350px;">
                <!-- Real-time Loading Spinner Overlay -->
                <div id="gridLoadingOverlay" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-none flex-column align-items-center justify-content-center z-3 rounded-3" style="min-height: 250px;">
                    <div class="spinner-border text-primary" role="status" style="width: 2.2rem; height: 2.2rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="text-muted small mt-2 fw-medium" style="font-size: 0.8rem;">Updating courses...</span>
                </div>

                <!-- Course Cards (3 per row: col-lg-4 col-md-6 col-12) -->
                <div class="row g-3 g-lg-3.5" id="coursesContainer">
                    @include('courses.partials.course-list', ['courses' => $courses])
                </div>

                <!-- Pagination Area -->
                <div id="paginationContainer" class="mt-4 pt-2">
                    @include('courses.partials.pagination', ['courses' => $courses])
                </div>
            </div>
        </div>
    </section>

    <!-- Custom CSS for Minimal Aesthetic & Compact 3-Per-Row Layout -->
    <style>
        .catalog-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .top-filter-card {
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }

        /* Category pills horizontal scroll */
        .category-pills-bar {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            white-space: nowrap;
        }
        .category-pills-bar::-webkit-scrollbar {
            display: none;
        }

        .category-pill-btn {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 500;
            transition: all 0.18s ease;
        }
        .category-pill-btn:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .category-pill-btn.active {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #ffffff !important;
        }
        .category-pill-btn.active .badge {
            background-color: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
        }

        /* Compact Card Styling */
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

        /* 2-line clamped title */
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
        .course-card-title a:hover {
            color: #0d6efd !important;
        }

        /* Specs bar */
        .course-specs-bar {
            background: #f8fafc !important;
            border: 1px solid #eef2f6 !important;
        }

        /* Hover primary helper */
        .hover-primary:hover {
            color: #0d6efd !important;
        }

        /* Pagination Centering */
        .page-nav-wrap ul {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .page-nav-wrap ul li .page-numbers {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.15s ease;
        }
        .page-nav-wrap ul li.active .page-numbers,
        .page-nav-wrap ul li .page-numbers:hover:not(.disabled) {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #ffffff;
        }
        .page-nav-wrap ul li .page-numbers.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f1f5f9;
        }

        @media (max-width: 767.98px) {
            .catalog-title {
                font-size: 1.5rem !important;
            }
            .course-thumb-box {
                height: 140px !important;
            }
        }
    </style>

    @push('scripts')
        <script>
            $(document).ready(function() {
                let searchDebounceTimeout = null;
                const coursesUrl = '{{ route('courses') }}';

                // Collect current filter parameters
                function collectFilters(page = null) {
                    const params = {};

                    const search = $('#courseSearchInput').val().trim();
                    if (search) params.search = search;

                    const activeCategoryBtn = $('.category-pill-btn.active');
                    if (activeCategoryBtn.length && activeCategoryBtn.data('category')) {
                        params.category = activeCategoryBtn.data('category');
                    }

                    const level = $('#levelSelect').val();
                    if (level) params.difficulty = level;

                    const track = $('#trackSelect').val();
                    if (track) params.track = track;

                    const rating = $('#ratingSelect').val();
                    if (rating) params.rating = rating;

                    const sort = $('#sortBySelect').val();
                    if (sort) params.sort = sort;

                    if (page) params.page = page;

                    return params;
                }

                // Execute AJAX fetch
                function fetchCourses(filters = null, updateUrl = true) {
                    if (!filters) {
                        filters = collectFilters();
                    }

                    $('#gridLoadingOverlay').removeClass('d-none').addClass('d-flex');

                    $.ajax({
                        url: coursesUrl,
                        method: 'GET',
                        data: filters,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#coursesContainer').html(response.courses_html);
                                $('#paginationContainer').html(response.pagination_html);

                                if (typeof response.total !== 'undefined') {
                                    $('#catalogCountDisplay').text(response.total);
                                }

                                if (updateUrl) {
                                    const url = new URL(coursesUrl, window.location.origin);
                                    Object.keys(filters).forEach(key => {
                                        if (filters[key]) {
                                            url.searchParams.set(key, filters[key]);
                                        }
                                    });
                                    window.history.pushState(filters, '', url.toString());
                                }

                                if (typeof WOW !== 'undefined') {
                                    new WOW().init();
                                }
                            }
                        },
                        error: function() {
                            $('#coursesContainer').html(
                                '<div class="col-12 py-4"><div class="alert alert-danger text-center mb-0">Failed to load courses. Please try again.</div></div>'
                            );
                        },
                        complete: function() {
                            $('#gridLoadingOverlay').removeClass('d-flex').addClass('d-none');
                        }
                    });
                }

                // Real-time Search with Debounce
                $('#courseSearchInput').on('input', function() {
                    const val = $(this).val();
                    if (val.length > 0) {
                        $('#clearSearchBtn').removeClass('d-none');
                    } else {
                        $('#clearSearchBtn').addClass('d-none');
                    }

                    clearTimeout(searchDebounceTimeout);
                    searchDebounceTimeout = setTimeout(function() {
                        fetchCourses();
                    }, 300);
                });

                // Clear Search Button
                $('#clearSearchBtn').on('click', function() {
                    $('#courseSearchInput').val('');
                    $(this).addClass('d-none');
                    fetchCourses();
                });

                // Category Pills Click
                $(document).on('click', '.category-pill-btn', function() {
                    $('.category-pill-btn').removeClass('active');
                    $(this).addClass('active');
                    fetchCourses();
                });

                // Dropdowns change (Level, Track, Rating, Sort)
                $('#levelSelect, #trackSelect, #ratingSelect, #sortBySelect').on('change', function() {
                    fetchCourses();
                });

                // Reset All Filters
                window.resetAllFilters = function() {
                    $('#courseSearchInput').val('');
                    $('#clearSearchBtn').addClass('d-none');
                    $('#levelSelect').val('');
                    $('#trackSelect').val('');
                    $('#ratingSelect').val('');
                    $('#sortBySelect').val('newest');
                    $('.category-pill-btn').removeClass('active');
                    $('.category-pill-btn[data-category=""]').addClass('active');
                    fetchCourses();
                };

                $('#resetFiltersBtn').on('click', function() {
                    window.resetAllFilters();
                });

                // Pagination click with smooth scroll to top of courses
                $(document).on('click', '.page-numbers:not(.disabled)', function(e) {
                    e.preventDefault();
                    const url = $(this).attr('href');
                    if (url) {
                        const urlObj = new URL(url, window.location.origin);
                        const page = urlObj.searchParams.get('page');
                        const filters = collectFilters(page);
                        fetchCourses(filters);

                        $('html, body').animate({
                            scrollTop: $('#coursesContainer').offset().top - 120
                        }, 250);
                    }
                });

                // Handle browser back/forward navigation
                window.onpopstate = function(event) {
                    if (event.state) {
                        if (event.state.search) {
                            $('#courseSearchInput').val(event.state.search);
                            $('#clearSearchBtn').removeClass('d-none');
                        } else {
                            $('#courseSearchInput').val('');
                            $('#clearSearchBtn').addClass('d-none');
                        }
                        if (event.state.difficulty) $('#levelSelect').val(event.state.difficulty);
                        if (event.state.price) $('#priceSelect').val(event.state.price);
                        if (event.state.rating) $('#ratingSelect').val(event.state.rating);
                        if (event.state.sort) $('#sortBySelect').val(event.state.sort);

                        $('.category-pill-btn').removeClass('active');
                        if (event.state.category) {
                            $(`.category-pill-btn[data-category="${event.state.category}"]`).addClass('active');
                        } else {
                            $('.category-pill-btn[data-category=""]').addClass('active');
                        }

                        fetchCourses(event.state, false);
                    }
                };
            });
        </script>
    @endpush
@endsection

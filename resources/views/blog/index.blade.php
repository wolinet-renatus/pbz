@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

{{-- Omit bulky breadcrumb hero banner --}}
@section('breadcrumb')
@endsection

@section('content')
    <!-- Minimal Header (Hello Section) -->
    <div class="page-hero-minimal bg-light py-3.5 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                            KNOWLEDGE HUB
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Knowledge Hub</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        PBZ Banking Insights &amp; <span class="text-primary">Circulars</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Official circulars, regulatory advisories, and executive research papers published by PBZ faculties.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-2xs fw-bold" style="font-size: 0.82rem;">
                        {{ $posts->total() }} {{ Str::plural('Article', $posts->total()) }} Published
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Category Filter Bar & 3-Column Grid -->
    <section class="blog-catalog-section py-4 py-lg-4.5">
        <div class="container">
            <!-- Filter & Search Bar -->
            <div class="top-filter-card bg-white p-2.5 p-md-3 rounded-3 border shadow-sm mb-4">
                <div class="row g-2.5 align-items-center">
                    <!-- Search Input -->
                    <div class="col-lg-5 col-md-12">
                        <form action="{{ route('blog.index') }}" method="GET" class="position-relative">
                            @if ($activeCategory)
                                <input type="hidden" name="category" value="{{ $activeCategory }}">
                            @endif
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.85rem;"></i>
                            <input type="text" name="q" value="{{ $searchTerm }}" class="form-control form-control-sm ps-5 pe-3 py-2 rounded-2" placeholder="Search banking insights, AML circulars..." style="font-size: 0.84rem; border-color: #cbd5e1;">
                        </form>
                    </div>

                    <!-- Category Pills (Horizontal scrollable) -->
                    <div class="col-lg-7 col-md-12">
                        <div class="category-pills-bar d-flex align-items-center gap-1.5 overflow-x-auto pb-1">
                            @php
                                $totalCount = max($categories->sum('count'), $posts->total());
                                $allQuery = array_filter(['q' => $searchTerm], fn($value) => filled($value));
                            @endphp
                            <a href="{{ route('blog.index', $allQuery) }}" class="btn btn-sm category-pill-btn rounded-pill px-3 py-1 text-nowrap {{ !$activeCategory ? 'active' : '' }}" style="font-size: 0.78rem;">
                                All Insights <span class="badge bg-secondary-subtle text-secondary ms-1 rounded-pill" style="font-size: 0.68rem;">{{ $totalCount }}</span>
                            </a>
                            @foreach ($categories as $category)
                                @php
                                    $query = array_filter(['category' => $category['slug'], 'q' => $searchTerm], fn($value) => filled($value));
                                @endphp
                                <a href="{{ route('blog.index', $query) }}" class="btn btn-sm category-pill-btn rounded-pill px-3 py-1 text-nowrap {{ $activeCategory === $category['slug'] ? 'active' : '' }}" style="font-size: 0.78rem;">
                                    {{ $category['name'] }}
                                    <span class="badge bg-secondary-subtle text-secondary ms-1 rounded-pill" style="font-size: 0.68rem;">{{ $category['count'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3-Column Posts Grid -->
            <div class="row g-3 g-lg-3.5">
                @forelse ($posts as $post)
                    @php
                        $imageUrl = $post->featured_image_url ?? asset('assets/front/img/home-1/courses/courses-01.jpg');
                        $publishedDate = optional($post->published_at)->format('d M, Y');
                    @endphp
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card blog-compact-card border h-100 shadow-sm rounded-3 overflow-hidden bg-white d-flex flex-column">
                            <!-- Thumbnail Cover (145px) -->
                            <div class="position-relative overflow-hidden" style="height: 145px; background: #e2e8f0;">
                                <a href="{{ route('blog.show', $post->slug) }}" class="d-block w-100 h-100">
                                    <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover blog-thumb-img" loading="lazy">
                                </a>
                                @if ($post->category_label)
                                    <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 start-0 m-2.5 rounded-pill px-2.5 py-1" style="font-size: 0.7rem;">
                                        {{ $post->category_label }}
                                    </span>
                                @endif
                            </div>

                            <!-- Body Content -->
                            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                <!-- Meta: Date & Read Time -->
                                <div class="d-flex align-items-center gap-3 text-muted small mb-2" style="font-size: 0.73rem;">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="fa-regular fa-calendar text-primary" style="font-size: 0.75rem;"></i>
                                        <span>{{ $publishedDate ?? 'Recent' }}</span>
                                    </span>
                                    <span>•</span>
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="fa-regular fa-clock text-primary" style="font-size: 0.75rem;"></i>
                                        <span>{{ $post->reading_time_minutes ? $post->reading_time_minutes . ' min read' : '5 min read' }}</span>
                                    </span>
                                </div>

                                <!-- Title (2-line clamped) -->
                                <h6 class="blog-card-title fw-bold mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary" title="{{ $post->title }}">
                                        {{ $post->title }}
                                    </a>
                                </h6>

                                <!-- Excerpt (2-line clamped) -->
                                <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.78rem; line-height: 1.4; height: 2.8em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    {{ Str::limit($post->excerpt ?? strip_tags($post->content), 95) }}
                                </p>

                                <!-- Footer CTA -->
                                <div class="pt-2 border-top mt-auto d-flex align-items-center justify-content-between">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="small fw-semibold text-primary text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                        <span>Read Article</span>
                                        <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <span class="text-muted" style="font-size: 0.72rem;">
                                        <i class="fa-regular fa-comment me-1"></i>{{ $post->approved_comments_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center">
                        <div class="p-4 rounded-3 border bg-light d-inline-block shadow-sm" style="max-width: 440px;">
                            <i class="fa-solid fa-newspaper fa-3x text-muted mb-2.5 opacity-50"></i>
                            <h6 class="fw-bold mb-1">No articles found</h6>
                            <p class="text-muted small mb-0">Try clearing your search query or selecting a different category.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Compact Pagination -->
            @if ($posts->hasPages())
                <div class="mt-4 pt-2 d-flex justify-content-center">
                    {{ $posts->links('vendor.pagination.stisla-default') }}
                </div>
            @endif
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .category-pills-bar {
            display: flex;
            gap: 6px;
            overflow-x: auto;
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
            font-weight: 500;
            transition: all 0.15s ease;
        }
        .category-pill-btn:hover {
            border-color: #cbd5e1;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .category-pill-btn.active {
            background-color: #006837 !important;
            border-color: #006837 !important;
            color: #ffffff !important;
        }
        .category-pill-btn.active .badge {
            background-color: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
        }
        .blog-compact-card {
            border: 1px solid #e2e8f0 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .blog-compact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
            border-color: #006837 !important;
        }
        .blog-thumb-img {
            transition: transform 0.35s ease;
        }
        .blog-compact-card:hover .blog-thumb-img {
            transform: scale(1.04);
        }
        .blog-card-title {
            font-size: 0.9rem;
            line-height: 1.35;
            height: 2.7em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .hover-primary:hover {
            color: #006837 !important;
        }
        .shadow-2xs {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.5rem !important;
            }
        }
    </style>
@endsection

@extends('layouts.app')

{{-- Omit bulky 350px breadcrumb hero banner --}}
@section('breadcrumb')
@endsection

@section('content')
    <!-- Minimal Header (Hello Section) -->
    <div class="page-hero-minimal bg-light py-3.5 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        @if ($post->category_label)
                            <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                                {{ strtoupper($post->category_label) }}
                            </span>
                        @endif
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none text-muted">Knowledge Hub</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold text-truncate" style="max-width: 220px;" aria-current="page">{{ $post->title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1.5 text-dark" style="font-size: 1.65rem; letter-spacing: -0.015em; line-height: 1.3;">
                        {{ $post->title }}
                    </h1>
                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted small" style="font-size: 0.76rem;">
                        @if ($post->published_at)
                            <span class="d-flex align-items-center gap-1">
                                <i class="fa-regular fa-calendar text-primary"></i>
                                <span>{{ $post->published_at->format('d M, Y') }}</span>
                            </span>
                        @endif
                        @if ($post->reading_time_minutes)
                            <span class="d-flex align-items-center gap-1">
                                <i class="fa-regular fa-clock text-primary"></i>
                                <span>{{ $post->reading_time_minutes }} min read</span>
                            </span>
                        @endif
                        @if ($post->author_name)
                            <span class="d-flex align-items-center gap-1">
                                <i class="fa-regular fa-user text-primary"></i>
                                <span>{{ $post->author_name }}</span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-arrow-left" style="font-size: 0.75rem;"></i>
                        <span>All Insights</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Article & Sidebar Section -->
    <section class="blog-details-main-section py-4 py-lg-4.5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column: Article Body (col-lg-8) -->
                <div class="col-lg-8 col-12">
                    <!-- Featured Image (Compact 280px max) -->
                    @if ($post->featured_image_url)
                        <div class="position-relative rounded-3 overflow-hidden border mb-3.5 bg-light" style="max-height: 280px;">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover" style="max-height: 280px;">
                        </div>
                    @endif

                    <!-- Article Body Content Card -->
                    <div class="card border rounded-3 p-3.5 p-md-4.5 bg-white shadow-sm mb-4">
                        <div class="article-content-body" style="font-size: 0.92rem; line-height: 1.7; color: #334155;">
                            {!! $post->content !!}
                        </div>

                        <!-- Tags & Share Row -->
                        <div class="pt-3.5 border-top mt-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="d-flex flex-wrap align-items-center gap-1.5">
                                <span class="text-muted fw-bold small me-1" style="font-size: 0.75rem;">TAGS:</span>
                                @forelse ($post->tags ?? [] as $tag)
                                    <a href="{{ route('blog.index', ['q' => $tag]) }}" class="badge bg-light text-dark border text-decoration-none rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                                        #{{ $tag }}
                                    </a>
                                @empty
                                    <span class="text-muted small" style="font-size: 0.75rem;">Banking, Compliance</span>
                                @endforelse
                            </div>

                            <!-- Social Share Icons -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted fw-bold small" style="font-size: 0.75rem;">SHARE:</span>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}&title={{ $shareText }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.78rem;" title="Share on LinkedIn">
                                    <i class="fa-brands fa-linkedin-in text-primary"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.78rem;" title="Share on Twitter / X">
                                    <i class="fa-brands fa-x-twitter text-dark"></i>
                                </a>
                                <a href="mailto:?subject={{ $shareText }}&body={{ $shareUrl }}" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.78rem;" title="Share via Email">
                                    <i class="fa-regular fa-envelope text-muted"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Related Insights Grid -->
                    @if ($relatedPosts->isNotEmpty())
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">Related Banking Insights</h5>
                            <div class="row g-3">
                                @foreach ($relatedPosts as $related)
                                    <div class="col-md-6 col-12">
                                        <div class="card h-100 border rounded-3 p-3 bg-white shadow-sm d-flex flex-column">
                                            <div class="d-flex align-items-center gap-2 text-muted small mb-1.5" style="font-size: 0.72rem;">
                                                <span>{{ optional($related->published_at)->format('d M, Y') ?? 'Recent' }}</span>
                                                <span>•</span>
                                                <span>{{ $related->reading_time_minutes ? $related->reading_time_minutes . ' min read' : '5 min' }}</span>
                                            </div>
                                            <h6 class="fw-bold mb-2">
                                                <a href="{{ route('blog.show', $related->slug) }}" class="text-dark text-decoration-none hover-primary">
                                                    {{ $related->title }}
                                                </a>
                                            </h6>
                                            <a href="{{ route('blog.show', $related->slug) }}" class="small fw-semibold text-primary text-decoration-none mt-auto d-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
                                                <span>Read Article</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 0.68rem;"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Comments Area -->
                    <div class="card border rounded-3 p-3.5 p-md-4 bg-white shadow-sm">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">
                            {{ $commentsTitle }}
                        </h5>

                        @if (session('success'))
                            <div class="alert alert-success py-2 px-3 rounded-2 small mb-3">
                                <i class="fa-solid fa-circle-check me-1.5"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger py-2 px-3 rounded-2 small mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Comments List -->
                        @if ($comments->isEmpty())
                            <p class="text-muted small mb-3" style="font-size: 0.82rem;">
                                No remarks posted yet. Be the first to share your professional perspectives on this circular.
                            </p>
                        @else
                            <div class="comments-list mb-4">
                                @foreach ($comments as $comment)
                                    @php
                                        $commentAvatar = 'https://www.gravatar.com/avatar/' . $comment['email_hash'] . '?s=100&d=mp';
                                    @endphp
                                    <div class="d-flex align-items-start gap-3 py-3 border-bottom">
                                        <img src="{{ $commentAvatar }}" alt="{{ $comment['name'] }}" class="rounded-circle border" style="width: 36px; height: 36px;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.82rem;">{{ $comment['name'] }}</h6>
                                                <span class="text-muted" style="font-size: 0.7rem;">{{ $comment['date'] }}</span>
                                            </div>
                                            <p class="text-muted small mb-0" style="font-size: 0.8rem; line-height: 1.45;">
                                                {!! nl2br(e($comment['body'])) !!}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Add Comment Form -->
                        <div class="pt-3 border-top">
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 0.88rem;">Leave a Professional Reply</h6>
                            <form action="{{ route('blog.comments.store', $post->slug) }}" method="POST">
                                @csrf
                                <div class="row g-2.5">
                                    <div class="col-md-6 col-12">
                                        <label class="form-label small text-muted mb-1" style="font-size: 0.76rem;">Your Full Name *</label>
                                        <input type="text" name="name" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. Salim Ali" value="{{ old('name', optional(auth()->user())->name) }}" required style="font-size: 0.82rem; border-color: #cbd5e1;">
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="form-label small text-muted mb-1" style="font-size: 0.76rem;">Official Email *</label>
                                        <input type="email" name="email" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. staff@pbzbank.co.tz" value="{{ old('email', optional(auth()->user())->email) }}" required style="font-size: 0.82rem; border-color: #cbd5e1;">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small text-muted mb-1" style="font-size: 0.76rem;">Comment Details *</label>
                                        <textarea name="comment" class="form-control form-control-sm rounded-2 py-2" rows="3" placeholder="Write your professional remarks..." required style="font-size: 0.82rem; border-color: #cbd5e1;">{{ old('comment') }}</textarea>
                                    </div>
                                    <div class="col-12 pt-1">
                                        <button type="submit" class="btn btn-primary rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.8rem; background-color: #006837; border-color: #006837;">
                                            <span>Post Reply</span>
                                            <i class="fa-solid fa-paper-plane" style="font-size: 0.7rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar (col-lg-4) -->
                <div class="col-lg-4 col-12">
                    <!-- Search Widget -->
                    <div class="card border rounded-3 p-3 bg-white shadow-sm mb-3.5">
                        <h6 class="fw-bold text-dark mb-2.5" style="font-size: 0.84rem;">Search Insights</h6>
                        <form action="{{ route('blog.index') }}" method="GET" class="position-relative">
                            <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.8rem;"></i>
                            <input type="text" name="q" class="form-control form-control-sm ps-5 pe-3 py-2 rounded-2" placeholder="Search keywords..." style="font-size: 0.82rem; border-color: #cbd5e1;">
                        </form>
                    </div>

                    <!-- Categories Widget -->
                    @if ($categories->isNotEmpty())
                        <div class="card border rounded-3 p-3 bg-white shadow-sm mb-3.5">
                            <h6 class="fw-bold text-dark mb-2.5" style="font-size: 0.84rem;">Curated Categories</h6>
                            <div class="d-flex flex-column gap-1.5">
                                @foreach ($categories as $cat)
                                    <a href="{{ route('blog.index', ['category' => $cat['slug']]) }}" class="p-2 rounded-2 bg-light text-decoration-none text-dark d-flex align-items-center justify-content-between hover-category" style="font-size: 0.78rem;">
                                        <span class="fw-medium">{{ $cat['name'] }}</span>
                                        <span class="badge bg-white text-muted border rounded-pill">{{ $cat['count'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Recent Insights Widget -->
                    <div class="card border rounded-3 p-3 bg-white shadow-sm mb-3.5">
                        <h6 class="fw-bold text-dark mb-2.5" style="font-size: 0.84rem;">Recent Publications</h6>
                        <div class="d-flex flex-column gap-2.5">
                            @foreach ($recentPosts as $recent)
                                <div class="d-flex align-items-center gap-2.5 pb-2 border-bottom">
                                    <div class="rounded-2 overflow-hidden flex-shrink-0" style="width: 48px; height: 48px; background: #e2e8f0;">
                                        <img src="{{ $recent->featured_image_url ?? asset('assets/front/img/home-1/courses/courses-01.jpg') }}" alt="{{ $recent->title }}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.78rem;">
                                            <a href="{{ route('blog.show', $recent->slug) }}" class="text-dark text-decoration-none hover-primary">
                                                {{ $recent->title }}
                                            </a>
                                        </h6>
                                        <span class="text-muted d-block small" style="font-size: 0.7rem;">
                                            {{ optional($recent->published_at)->format('d M, Y') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PBZ Contact Academy Card -->
                    <div class="p-3 rounded-3 border text-center" style="background: #002620; color: #ffffff;">
                        <h6 class="fw-bold text-white mb-1" style="font-size: 0.84rem;">PBZ Academy Publications</h6>
                        <p class="text-white-50 small mb-2.5" style="font-size: 0.74rem;">
                            Direct inquiries regarding regulatory research papers or Bank of Tanzania directives.
                        </p>
                        <a href="{{ route('contact') }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-semibold" style="background: #FFA729; color: #002620; font-size: 0.76rem;">
                            Contact Research Faculty
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .hover-primary:hover {
            color: #006837 !important;
        }
        .hover-category:hover {
            background-color: #f0fdf4 !important;
            color: #006837 !important;
        }
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.35rem !important;
            }
        }
    </style>
@endsection

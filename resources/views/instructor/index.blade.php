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
                            ACADEMY FACULTY
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Instructors</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        PBZ Certified <span class="text-primary">Instructors &amp; Fellows</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Meet the regulatory fellows, Shariah scholars, and banking specialists leading PBZ Academy programs.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-2xs fw-bold" style="font-size: 0.82rem;">
                        {{ $instructors->total() }} {{ Str::plural('Instructor', $instructors->total()) }} Available
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructors Compact Grid Section -->
    <section class="instructors-catalog-section py-4 py-lg-4.5">
        <div class="container">
            <div class="row g-3 g-lg-3.5">
                @forelse($instructors as $instructor)
                    @php
                        $stats = $instructor->stats;
                        $avatarUrl = $instructor->display_avatar ?: asset('assets/front/img/home-1/courses/client-01.png');
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        <div class="card instructor-compact-card border rounded-3 p-3 bg-white h-100 shadow-sm d-flex flex-column text-center">
                            <!-- Avatar & Status -->
                            <div class="position-relative d-inline-block mx-auto mb-2.5">
                                <img src="{{ $avatarUrl }}" alt="{{ $instructor->name }}" class="rounded-circle object-fit-cover border shadow-2xs" style="width: 64px; height: 64px; border-color: #006837 !important;">
                                <span class="position-absolute bottom-0 end-0 rounded-circle border border-white" style="width: 14px; height: 14px; background-color: #10b981;" title="Certified Active"></span>
                            </div>

                            <!-- Name & Title -->
                            <h6 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 0.88rem;">
                                <a href="{{ route('instructors.show', $instructor) }}" class="text-dark text-decoration-none hover-primary" title="{{ $instructor->name }}">
                                    {{ $instructor->name }}
                                </a>
                            </h6>
                            <p class="text-muted small mb-2.5 text-truncate" style="font-size: 0.74rem;">
                                {{ $instructor->headline ?: 'Banking Operations Specialist' }}
                            </p>

                            <!-- Mini Stats Bar -->
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-2 bg-light border mb-3 small" style="font-size: 0.72rem;">
                                <span class="d-flex align-items-center gap-1 text-muted" title="Courses Taught">
                                    <i class="fa-solid fa-graduation-cap text-primary" style="font-size: 0.75rem;"></i>
                                    <span>{{ $stats['courses'] }} {{ Str::plural('Course', $stats['courses']) }}</span>
                                </span>
                                <span class="d-flex align-items-center gap-1 text-muted" title="Enrolled Learners">
                                    <i class="fa-solid fa-user-graduate text-success" style="font-size: 0.75rem;"></i>
                                    <span>{{ number_format($stats['students']) }}</span>
                                </span>
                                <span class="d-flex align-items-center gap-1 text-dark fw-bold" title="Average Rating">
                                    <i class="fa-solid fa-star text-warning" style="font-size: 0.75rem;"></i>
                                    <span>{{ $stats['rating'] ? number_format($stats['rating'], 1) : '5.0' }}</span>
                                </span>
                            </div>

                            <!-- CTA Button -->
                            <a href="{{ route('instructors.show', $instructor) }}" class="btn btn-sm btn-outline-primary rounded-pill w-100 py-1.5 fw-semibold mt-auto" style="font-size: 0.78rem;">
                                View Profile &amp; Courses
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center">
                        <div class="p-4 rounded-3 border bg-light d-inline-block shadow-sm" style="max-width: 440px;">
                            <i class="fa-solid fa-chalkboard-user fa-3x text-muted mb-2.5 opacity-50"></i>
                            <h6 class="fw-bold mb-1">{{ __('frontend.no_instructors_yet') ?? 'No instructors found' }}</h6>
                            <p class="text-muted small mb-0">Our faculty profiles are currently being updated.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Compact Pagination -->
            @if ($instructors->hasPages())
                <div class="mt-4 pt-2 d-flex justify-content-center">
                    {{ $instructors->links('vendor.pagination.stisla-default') }}
                </div>
            @endif
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .instructor-compact-card {
            border: 1px solid #e2e8f0 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .instructor-compact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
            border-color: #006837 !important;
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

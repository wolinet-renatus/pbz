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
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                            ENTERPRISE PACKAGES
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Subscriptions</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        PBZ Academy <span class="text-primary">Subscription Plans</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Flexible institutional and branch training packages designed for banking practitioners across 34 branches.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-2xs fw-bold" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-building-columns text-primary me-1"></i> 34 Branches Connected
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="subscriptions-main-section py-4 py-lg-4.5">
        <div class="container">
            @if($plans->isEmpty())
                <!-- Clean, Compact Institutional Notice When No Retail Subscriptions Configured -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12">
                        <div class="card border rounded-3 p-4 p-md-4.5 bg-white shadow-sm text-center">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 58px; height: 58px; background: rgba(0, 104, 55, 0.1); color: #006837;">
                                <i class="fa-solid fa-building-columns fa-2x"></i>
                            </div>
                            
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-semibold mx-auto mb-2" style="font-size: 0.75rem;">
                                ENTERPRISE BRANCH PROVISIONING
                            </span>

                            <h4 class="fw-bold text-dark mb-2" style="font-size: 1.35rem; letter-spacing: -0.01em;">
                                Subscriptions Centrally Managed for PBZ Personnel
                            </h4>

                            <p class="text-muted small mb-3.5 mx-auto" style="max-width: 580px; font-size: 0.86rem; line-height: 1.55;">
                                Curricula access across PBZ Learning Academy is centrally provisioned and allocated to all 34 branches in Zanzibar, Pemba, and Mainland Tanzania by the <strong>PBZ Human Resource &amp; Training Directorate</strong>. Retail public packages are not required for registered bank staff.
                            </p>

                            <!-- Feature Badges -->
                            <div class="row row-cols-1 row-cols-md-3 g-2 mb-4 text-start">
                                <div class="col">
                                    <div class="p-2.5 rounded-2 bg-light border h-100">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fa-solid fa-scale-balanced text-primary" style="font-size: 0.85rem;"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.78rem;">BOT Mandated</span>
                                        </div>
                                        <span class="text-muted d-block small" style="font-size: 0.72rem; line-height: 1.35;">Included for compliance &amp; risk personnel.</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-2.5 rounded-2 bg-light border h-100">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fa-solid fa-moon text-success" style="font-size: 0.85rem;"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.78rem;">Amana Banking</span>
                                        </div>
                                        <span class="text-muted d-block small" style="font-size: 0.72rem; line-height: 1.35;">Comprehensive Islamic finance modules.</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="p-2.5 rounded-2 bg-light border h-100">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fa-solid fa-certificate text-warning" style="font-size: 0.85rem;"></i>
                                            <span class="fw-bold text-dark" style="font-size: 0.78rem;">Certification</span>
                                        </div>
                                        <span class="text-muted d-block small" style="font-size: 0.72rem; line-height: 1.35;">QR-code validated completion credentials.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex flex-wrap align-items-center justify-content-center gap-2.5">
                                <a href="{{ route('courses') }}" class="btn btn-sm btn-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.82rem; background-color: #006837; border-color: #006837;">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <span>Browse Available Courses</span>
                                </a>
                                <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.82rem;">
                                    <i class="fa-solid fa-headset"></i>
                                    <span>Contact Training Directorate</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Active Plans Grid (Compact, Mobile-First, 3-Per-Row) -->
                <div class="row justify-content-center g-3 g-lg-3.5">
                    @foreach($plans as $plan)
                        @php
                            $isFeatured = (bool) $plan->is_featured;
                            $isActiveUserPlan = $userActiveSubscription && $userActiveSubscription->subscription_plan_id === $plan->id;
                        @endphp
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="card h-100 border rounded-3 p-3.5 bg-white shadow-sm d-flex flex-column position-relative plan-compact-card {{ $isFeatured ? 'featured-border' : '' }}">
                                @if($isFeatured)
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge rounded-pill px-2.5 py-1 fw-bold shadow-2xs" style="background: #FFA729; color: #002620; font-size: 0.68rem;">
                                            <i class="fa-solid fa-star me-1"></i> RECOMMENDED
                                        </span>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.15rem;">{{ $plan->name }}</h5>
                                    <p class="text-muted small mb-2.5 text-truncate" style="font-size: 0.78rem;">
                                        {{ $plan->description ?? 'Comprehensive professional development package.' }}
                                    </p>

                                    <!-- Price Box -->
                                    <div class="p-2.5 rounded-2 bg-light border text-center">
                                        @if($plan->has_discount)
                                            <div class="text-muted text-decoration-line-through small" style="font-size: 0.75rem;">
                                                {{ currency_symbol() }}{{ number_format($plan->price, 2) }}
                                            </div>
                                            <div class="d-flex align-items-baseline justify-content-center gap-1">
                                                <span class="fw-bold text-dark" style="font-size: 1.65rem; color: #006837 !important;">
                                                    {{ currency_symbol() }}{{ number_format($plan->discount_price, 2) }}
                                                </span>
                                                <span class="badge bg-success rounded-pill px-2 py-0.5" style="font-size: 0.65rem;">
                                                    -{{ $plan->discount_percentage }}%
                                                </span>
                                            </div>
                                        @else
                                            <div class="fw-bold text-dark" style="font-size: 1.65rem; color: #006837 !important;">
                                                {{ currency_symbol() }}{{ number_format($plan->price, 2) }}
                                            </div>
                                        @endif
                                        <span class="text-muted d-block small" style="font-size: 0.72rem;">
                                            Per {{ str_replace('_', ' ', $plan->billing_period) }} ({{ $plan->duration_days }} days)
                                        </span>
                                    </div>
                                </div>

                                <!-- Features List -->
                                <div class="features-list mb-3 flex-grow-1">
                                    <span class="text-muted fw-bold text-uppercase d-block mb-2" style="font-size: 0.68rem; letter-spacing: 0.05em;">
                                        PACKAGE PRIVILEGES
                                    </span>
                                    <ul class="list-unstyled mb-0 small" style="font-size: 0.76rem;">
                                        <li class="mb-1.5 d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-circle-check text-success flex-shrink-0" style="font-size: 0.8rem;"></i>
                                            <span><strong>{{ $plan->courses_count }}</strong> Courses &amp; Live Classes</span>
                                        </li>
                                        @if($plan->bundles_count > 0)
                                            <li class="mb-1.5 d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-circle-check text-success flex-shrink-0" style="font-size: 0.8rem;"></i>
                                                <span><strong>{{ $plan->bundles_count }}</strong> Curricula Bundles</span>
                                            </li>
                                        @endif
                                        @if(is_array($plan->features))
                                            @foreach($plan->features as $feature)
                                                <li class="mb-1.5 d-flex align-items-center gap-2">
                                                    <i class="fa-solid fa-circle-check text-success flex-shrink-0" style="font-size: 0.8rem;"></i>
                                                    <span>{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                                <!-- Subscribe CTA -->
                                <div class="mt-auto pt-2 border-top">
                                    @if($isActiveUserPlan)
                                        <button class="btn btn-sm btn-success rounded-pill w-100 py-1.5 fw-semibold d-flex align-items-center justify-content-center gap-1.5" disabled style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <span>Currently Active</span>
                                        </button>
                                    @else
                                        <a href="{{ route('subscriptions.checkout', $plan->id) }}" class="btn btn-sm btn-primary rounded-pill w-100 py-1.5 fw-semibold d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="font-size: 0.8rem; background-color: #006837; border-color: #006837;">
                                            <span>Enroll in Plan</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 0.72rem;"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .plan-compact-card {
            border: 1px solid #e2e8f0 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .plan-compact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
            border-color: #006837 !important;
        }
        .featured-border {
            border: 2px solid #FFA729 !important;
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

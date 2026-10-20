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
                            INSTITUTIONAL PROFILE
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">About Us</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        About <span class="text-primary">PBZ Learning Academy</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Empowering staff across 34 branches in Zanzibar and Mainland Tanzania with BOT compliance &amp; Amana Islamic banking.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('courses') }}" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Explore Curricula</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Institutional Mission & Leadership Section -->
    <section class="about-overview-section py-4 py-lg-4.5 border-bottom">
        <div class="container">
            <div class="row align-items-center g-4">
                <!-- Visual / Boardroom Image Card -->
                <div class="col-lg-5 col-12">
                    <div class="position-relative bg-white border rounded-3 p-2.5 shadow-sm overflow-hidden">
                        <div class="position-relative rounded-2 overflow-hidden" style="height: 240px; background: #e2e8f0;">
                            <img src="{{ asset('assets/front/img/home-1/about/pbz-about-boardroom.png') }}" alt="PBZ Academy Executive Boardroom" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute bottom-0 start-0 w-100 p-2.5 d-flex align-items-center justify-content-between text-white" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 38, 32, 0.9) 100%);">
                                <span class="small fw-semibold" style="font-size: 0.75rem;">PBZ Academy Headquarters</span>
                                <span class="badge rounded-pill px-2 py-0.5" style="background: #FFA729; color: #002b24; font-size: 0.68rem; font-weight: 700;">Est. 1966</span>
                            </div>
                        </div>

                        <div class="p-2.5 pt-3 d-flex align-items-center gap-2.5 border-top mt-2">
                            <img src="{{ asset('assets/front/img/home-1/about/pbz-dean-amina.png') }}" alt="Dr. Amina Khamis Salim" class="rounded-circle object-fit-cover border" style="width: 44px; height: 44px; border-color: #006837 !important;">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.82rem;">{{ $heroSettings['author_name'] ?? 'Dr. Amina Khamis Salim' }}</h6>
                                <p class="text-muted mb-0" style="font-size: 0.72rem;">{{ $heroSettings['author_title'] ?? 'Head of PBZ Learning Academy & BOT Compliance Fellow' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text Content & Stats -->
                <div class="col-lg-7 col-12">
                    <div class="about-content-inner">
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-semibold mb-2" style="font-size: 0.72rem;">
                            {{ $heroSettings['subheading'] ?? 'SOVEREIGN BANKING EDUCATION' }}
                        </span>
                        <h2 class="fw-bold text-dark mb-2.5" style="font-size: 1.55rem; line-height: 1.25; letter-spacing: -0.015em;">
                            {{ $heroSettings['heading'] ?? 'Building Sovereign Banking Competence & Regulatory Excellence' }}
                        </h2>
                        <p class="text-muted small mb-3.5" style="font-size: 0.88rem; line-height: 1.55;">
                            {{ $heroSettings['description'] ?? "People's Bank of Zanzibar Ltd (PBZ) Learning Academy is the dedicated enterprise training institution empowering personnel across 34 branches in Zanzibar, Pemba, and Mainland Tanzania. We deliver continuous professional development in Bank of Tanzania (BOT) regulatory compliance, PBZ Amana Islamic banking, fraud defense, and executive leadership." }}
                        </p>

                        <!-- Compact Stats Grid -->
                        <div class="row row-cols-3 g-2 mb-3.5">
                            <div class="col">
                                <div class="p-2.5 rounded-2 bg-light border text-center">
                                    <h4 class="fw-bold text-primary m-0" style="font-size: 1.35rem;">{{ number_format($stats['courses']) }}+</h4>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Active Modules</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-2.5 rounded-2 bg-light border text-center">
                                    <h4 class="fw-bold text-success m-0" style="font-size: 1.35rem;">{{ number_format($stats['instructors']) }}+</h4>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Academy Faculty</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-2.5 rounded-2 bg-light border text-center">
                                    <h4 class="fw-bold text-dark m-0" style="font-size: 1.35rem;">34</h4>
                                    <span class="text-muted d-block" style="font-size: 0.7rem;">Branches Connected</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ $heroSettings['cta_url'] ?? route('courses') }}" class="btn btn-sm btn-primary rounded-pill px-3.5 py-1.5 fw-semibold" style="font-size: 0.82rem;">
                                {{ $heroSettings['cta_label'] ?? 'Explore Curricula' }}
                                <i class="fa-solid fa-arrow-right ms-1" style="font-size: 0.7rem;"></i>
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.82rem;">
                                Contact Academy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Academy Pillars / Key Features -->
    <section class="about-pillars-section py-4 bg-light-subtle border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">INSTITUTIONAL PILLARS</span>
                    <h3 class="fw-bold text-dark m-0" style="font-size: 1.3rem;">Core Academy Capabilities</h3>
                </div>
            </div>

            <div class="row g-2.5">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card p-3 rounded-2 bg-white border h-100 shadow-2xs">
                        <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.84rem;">BOT Regulatory Compliance</h6>
                        <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                            100% alignment with Bank of Tanzania statutory mandates, AML/CFT reporting, and KYC directives.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card p-3 rounded-2 bg-white border h-100 shadow-2xs">
                        <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            <i class="fa-solid fa-moon"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.84rem;">Shariah-Certified Amana</h6>
                        <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                            Specialized Islamic finance curricula verified by our Shariah Advisory Board for Murabaha &amp; Ijara.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card p-3 rounded-2 bg-white border h-100 shadow-2xs">
                        <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center mb-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.84rem;">Cyber Hygiene &amp; Defense</h6>
                        <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                            Realistic threat simulations, social engineering drills, and swift security incident management.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-12">
                    <div class="card p-3 rounded-2 bg-white border h-100 shadow-2xs">
                        <div class="rounded-circle bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center mb-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.84rem;">Cryptographic Certificates</h6>
                        <p class="text-muted small m-0" style="font-size: 0.75rem; line-height: 1.4;">
                            Immutable QR-code verified certificates of completion providing tamper-proof audit trails for examiners.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Academy Faculty Preview -->
    <section class="about-faculty-section py-4 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <span class="text-uppercase text-primary fw-bold" style="font-size: 0.72rem; letter-spacing: 0.08em;">ACADEMY FACULTY</span>
                    <h3 class="fw-bold text-dark m-0" style="font-size: 1.3rem;">Distinguished Instructors</h3>
                </div>
                <a href="{{ route('instructors.index') }}" class="text-decoration-none small text-primary fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.8rem;">
                    All Instructors <i class="fa-solid fa-arrow-right" style="font-size: 0.7rem;"></i>
                </a>
            </div>

            <div class="row row-cols-2 row-cols-md-4 g-2.5">
                @forelse($featuredInstructors as $instructor)
                    <div class="col">
                        <div class="p-3 rounded-2 bg-white border text-center h-100 shadow-2xs">
                            <div class="d-inline-block position-relative mb-2">
                                @if ($instructor->profile_photo)
                                    <img src="{{ asset('storage/' . $instructor->profile_photo) }}" alt="{{ $instructor->name }}" class="rounded-circle object-fit-cover border" style="width: 52px; height: 52px;">
                                @else
                                    <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center mx-auto" style="width: 52px; height: 52px; font-size: 1.1rem;">
                                        {{ strtoupper(substr($instructor->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <h6 class="fw-bold mb-0 text-truncate text-dark" style="font-size: 0.82rem;">
                                <a href="{{ route('instructors.show', $instructor->id) }}" class="text-dark text-decoration-none hover-primary">{{ $instructor->name }}</a>
                            </h6>
                            <span class="text-muted d-block text-truncate mb-1.5" style="font-size: 0.7rem;">
                                {{ $instructor->specialization ?: 'Banking Specialist' }}
                            </span>
                            <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                {{ $instructor->courses_count }} {{ Str::plural('Course', $instructor->courses_count) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><div class="alert alert-light border text-center py-2 text-muted small m-0">No instructors found.</div></div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Compact Call to Action -->
    <section class="about-cta-section py-4" style="background-color: #002620; color: #ffffff;">
        <div class="container text-center py-2">
            <h4 class="fw-bold mb-1.5 text-white" style="letter-spacing: -0.01em;">
                {{ $ctaSettings['heading'] ?? 'Accelerate Your Professional Banking Career with PBZ Academy' }}
            </h4>
            <p class="text-white-50 small mb-3 mx-auto" style="max-width: 600px; font-size: 0.82rem;">
                {{ $ctaSettings['description'] ?? 'Join over 500 PBZ banking professionals mastering anti-money laundering, Islamic banking operations, and core payment defenses today.' }}
            </p>
            <div class="d-flex align-items-center justify-content-center gap-2.5">
                <a href="{{ $ctaSettings['primary_url'] ?? route('courses') }}" class="btn btn-sm rounded-pill px-3.5 py-1.5 fw-semibold" style="background: #FFA729; color: #002620; font-size: 0.82rem;">
                    {{ $ctaSettings['primary_label'] ?? 'Browse Certified Modules' }}
                </a>
                <a href="{{ $ctaSettings['secondary_url'] ?? route('instructors.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.82rem;">
                    {{ $ctaSettings['secondary_label'] ?? 'Meet Academy Faculty' }}
                </a>
            </div>
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .shadow-2xs {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        .hover-primary:hover {
            color: #006837 !important;
        }
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.5rem !important;
            }
        }
    </style>
@endsection

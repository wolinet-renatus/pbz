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
                            ACADEMY LIAISON &amp; SUPPORT
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Contact Us</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        Get in Touch with <span class="text-primary">PBZ Academy</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Reach out to our academic liaison officers, branch coordinators, and executive compliance faculty.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-2xs fw-bold" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-clock text-warning me-1"></i> Mon - Fri: 8:30am - 4:30pm EAT
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Content Section -->
    <section class="contact-main-section py-4 py-lg-4.5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column: Official Contact Card -->
                <div class="col-lg-5 col-12">
                    <div class="contact-info-card p-3 p-md-4 rounded-3 border bg-white shadow-sm h-100 d-flex flex-column">
                        <div class="mb-3.5 pb-3 border-bottom">
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-semibold mb-2" style="font-size: 0.72rem;">
                                {{ $heroSettings['eyebrow'] ?? 'OFFICIAL LIAISON' }}
                            </span>
                            <h4 class="fw-bold text-dark mb-1.5" style="font-size: 1.25rem;">
                                {{ $heroSettings['heading'] ?? "People's Bank of Zanzibar Academy" }}
                            </h4>
                            <p class="text-muted small mb-0" style="font-size: 0.82rem; line-height: 1.45;">
                                Dedicated support for PBZ staff members, external banking professionals, and partner institutions.
                            </p>
                        </div>

                        <!-- Contact List -->
                        <div class="contact-methods-list mb-3.5 flex-grow-1">
                            <!-- Head Office Address -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-2 bg-light border mb-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(255, 167, 41, 0.15); color: #FFA729;">
                                    <i class="fa-solid fa-location-dot" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.72rem; font-weight: 600;">HEAD OFFICE</span>
                                    <span class="fw-semibold text-dark" style="font-size: 0.82rem; line-height: 1.35;">
                                        Head Office: Mpirani, P.O. Box 1116, Zanzibar, Tanzania
                                    </span>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-2 bg-light border mb-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(0, 104, 55, 0.12); color: #006837;">
                                    <i class="fa-solid fa-phone-volume" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.72rem; font-weight: 600;">PHONE &amp; TOLL-FREE</span>
                                    <a href="tel:+255242231118" class="fw-semibold text-dark text-decoration-none hover-primary" style="font-size: 0.82rem;">
                                        +255 24 223 1118 / 0800 750 075
                                    </a>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-2 bg-light border mb-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                                    <i class="fa-solid fa-envelope" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.72rem; font-weight: 600;">OFFICIAL EMAIL</span>
                                    <a href="mailto:info@pbzbank.co.tz" class="fw-semibold text-dark text-decoration-none hover-primary" style="font-size: 0.82rem;">
                                        info@pbzbank.co.tz
                                    </a>
                                </div>
                            </div>

                            <!-- Operating Hours -->
                            <div class="d-flex align-items-start gap-3 p-2.5 rounded-2 bg-light border">
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(255, 167, 41, 0.15); color: #FFA729;">
                                    <i class="fa-solid fa-clock" style="font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <span class="text-muted d-block small" style="font-size: 0.72rem; font-weight: 600;">ACADEMY HOURS</span>
                                    <span class="fw-semibold text-dark" style="font-size: 0.82rem;">
                                        Mon - Fri: 8:30am - 4:30pm EAT
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Nationwide Support Footer -->
                        <div class="p-2.5 rounded-2 border mt-auto text-center" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                            <span class="text-success small fw-semibold" style="font-size: 0.75rem;">
                                <i class="fa-solid fa-building-columns me-1"></i> Connecting 34 Branches Across Zanzibar &amp; Mainland
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Clean Form -->
                <div class="col-lg-7 col-12">
                    <div class="contact-form-card p-3 p-md-4 rounded-3 border bg-white shadow-sm h-100">
                        <div class="mb-3">
                            <h4 class="fw-bold text-dark mb-1" style="font-size: 1.25rem;">Send a Message</h4>
                            <p class="text-muted small mb-0" style="font-size: 0.82rem;">
                                Fill in the details below and our academy coordinators will respond within 24 hours.
                            </p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success py-2.5 px-3 rounded-2 small mb-3">
                                <i class="fa-solid fa-circle-check me-1.5"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger py-2.5 px-3 rounded-2 small mb-3">
                                <i class="fa-solid fa-triangle-exclamation me-1.5"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger py-2.5 px-3 rounded-2 small mb-3">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-2.5">
                                <div class="col-md-6 col-12">
                                    <label class="form-label small fw-semibold text-muted mb-1" style="font-size: 0.78rem;">Full Name *</label>
                                    <input type="text" name="name" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. Salim Ali" value="{{ old('name', optional(auth()->user())->name) }}" required style="font-size: 0.84rem; border-color: #cbd5e1;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label small fw-semibold text-muted mb-1" style="font-size: 0.78rem;">Official Email *</label>
                                    <input type="email" name="email" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. staff@pbzbank.co.tz" value="{{ old('email', optional(auth()->user())->email) }}" required style="font-size: 0.84rem; border-color: #cbd5e1;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label small fw-semibold text-muted mb-1" style="font-size: 0.78rem;">Phone Number</label>
                                    <input type="text" name="phone" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. +255 777 000 000" value="{{ old('phone') }}" style="font-size: 0.84rem; border-color: #cbd5e1;">
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="form-label small fw-semibold text-muted mb-1" style="font-size: 0.78rem;">Subject *</label>
                                    <input type="text" name="subject" class="form-control form-control-sm rounded-2 py-2" placeholder="e.g. AML Certification Inquiry" value="{{ old('subject') }}" required style="font-size: 0.84rem; border-color: #cbd5e1;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-semibold text-muted mb-1" style="font-size: 0.78rem;">Message Details *</label>
                                    <textarea name="message" class="form-control form-control-sm rounded-2 py-2" rows="4" placeholder="Describe your query or training requirement..." required style="font-size: 0.84rem; border-color: #cbd5e1;">{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12 pt-1">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.84rem; background-color: #006837; border-color: #006837;">
                                        <span>{{ $formSettings['submit_label'] ?? 'Send Message' }}</span>
                                        <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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

@extends('layouts.app')

@php
    $pageTitle = $pageTitle ?? 'Frequently Asked Questions';
    $faqItems = collect($faqItems ?? []);
@endphp

@section('content')
    <!-- Compact Minimal Hero -->
    <div class="pbz-compact-hero py-3.5 border-bottom" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <div class="d-flex align-items-center gap-2 small text-white-50 mb-1" style="font-size: 0.76rem;">
                        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">Home</a>
                        <span>/</span>
                        <span class="text-white fw-semibold">Frequently Asked Questions</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(249, 237, 39, 0.2); color: #F9ED27; font-size: 0.68rem; font-weight: 700; border: 1px solid rgba(249, 237, 39, 0.4);">
                            <i class="fa-solid fa-circle-question me-1"></i> ACADEMY KNOWLEDGE BASE
                        </span>
                        <span class="text-white-50 small" style="font-size: 0.75rem;">• Updated for 2026 Directives</span>
                    </div>

                    <h1 class="h4 fw-bold text-white mb-0 mt-1" style="letter-spacing: -0.02em;">Frequently Asked Questions</h1>
                </div>

                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1.5 rounded-3" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25);">
                    <i class="fa-solid fa-headset" style="color: #F9ED27; font-size: 0.95rem;"></i>
                    <div style="line-height: 1.2;">
                        <div class="text-white fw-bold" style="font-size: 0.74rem;">TOLL-FREE SUPPORT</div>
                        <div class="text-white-50" style="font-size: 0.68rem;">0800 750 075 (24/7)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main FAQ Content Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row g-3">
                <!-- Left Sidebar: PBZ Brand Card & Quick Help -->
                <div class="col-lg-4 col-md-5">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-3">
                        <div class="position-relative">
                            <img src="{{ asset('assets/front/img/home-1/hero/pbz-poster-banker-landscape.jpg') }}" 
                                 alt="PBZ Banking Executive" 
                                 class="w-100 d-block" 
                                 style="height: 160px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0 p-2.5" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 43, 36, 0.92) 100%);">
                                <span class="badge rounded-pill" style="background: #006837; color: #ffffff; font-size: 0.68rem;">PBZ Branch Support</span>
                                <div class="text-white fw-bold small mt-0.5">34 Branches Nationwide</div>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Need Immediate Assistance?</h6>
                            <p class="text-muted small mb-3" style="font-size: 0.78rem; line-height: 1.45;">
                                Our training support desk assists staff and branch compliance officers with onboarding, LMS logins, and BoT accreditation.
                            </p>

                            <div class="d-flex flex-column gap-2 mb-3">
                                <a href="tel:0800750075" class="btn btn-sm w-100 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm text-decoration-none" style="background: #003730; color: #ffffff; font-size: 0.78rem;">
                                    <i class="fa-solid fa-phone-volume" style="color: #F9ED27;"></i>
                                    <span>Toll Free: 0800 750 075</span>
                                </a>
                                <a href="mailto:info@pbzbank.co.tz" class="btn btn-sm w-100 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-2 border text-decoration-none" style="font-size: 0.78rem; color: #002b24; background: #f8fafc;">
                                    <i class="fa-solid fa-envelope" style="color: #0284c7;"></i>
                                    <span>info@pbzbank.co.tz</span>
                                </a>
                            </div>

                            <!-- Certificate Verifier Shortcut -->
                            <div class="p-2.5 rounded-3 border" style="background: rgba(249, 237, 39, 0.08); border-color: rgba(249, 237, 39, 0.3) !important;">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-certificate" style="color: #b45309; font-size: 0.9rem;"></i>
                                        <span class="small fw-bold text-dark" style="font-size: 0.76rem;">Verify Certificate</span>
                                    </div>
                                    <a href="{{ route('verify-certificate') }}" class="btn btn-xs btn-outline-dark rounded-pill py-0.5 px-2" style="font-size: 0.7rem;">
                                        Check Code &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Native Accordion -->
                <div class="col-lg-8 col-md-7">
                    <div class="card border-0 shadow-sm rounded-3 p-3.5 bg-white">
                        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom">
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9rem;">Regulatory &amp; Academic Questions</h6>
                                <span class="text-muted small" style="font-size: 0.76rem;">Clarifying institutional training rules, Shariah governance, and BoT filings.</span>
                            </div>
                            <span class="badge rounded-pill bg-light text-dark border px-2.5 py-1" style="font-size: 0.72rem;">
                                {{ $faqItems->count() }} Questions
                            </span>
                        </div>

                        @if ($faqItems->isNotEmpty())
                            <div class="accordion pbz-native-accordion" id="pbzFaqAccordion">
                                @foreach ($faqItems as $index => $faq)
                                    @php
                                        $headingId = 'pbzFaqHeading' . $index;
                                        $collapseId = 'pbzFaqCollapse' . $index;
                                        $number = str_pad($loop->iteration, 2, '0', STR_PAD_LEFT);
                                    @endphp
                                    <div class="accordion-item border rounded-3 mb-2.5 overflow-hidden">
                                        <h2 class="accordion-header" id="{{ $headingId }}">
                                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} py-2.5 px-3 fw-bold"
                                                    type="button" 
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $collapseId }}"
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                    aria-controls="{{ $collapseId }}"
                                                    style="font-size: 0.84rem; color: #002b24;">
                                                <span class="badge rounded-pill me-2 px-2 py-0.5" style="background: rgba(0, 104, 55, 0.1); color: #006837; font-size: 0.72rem;">
                                                    {{ $number }}
                                                </span>
                                                <span>{{ $faq['question'] ?? 'Question' }}</span>
                                            </button>
                                        </h2>
                                        <div id="{{ $collapseId }}"
                                             class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                             aria-labelledby="{{ $headingId }}" 
                                             data-bs-parent="#pbzFaqAccordion">
                                            <div class="accordion-body py-2.5 px-3 bg-light text-secondary small" style="font-size: 0.82rem; line-height: 1.55;">
                                                {!! $faq['answer'] ?? '' !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa-solid fa-circle-info text-muted fa-2x mb-2"></i>
                                <p class="text-muted small mb-0">No FAQ entries available at this moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('meta')
    <title>Frequently Asked Questions | People's Bank of Zanzibar (PBZ) LMS</title>
@endpush

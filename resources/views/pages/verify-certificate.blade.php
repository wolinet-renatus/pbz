@extends('layouts.app')

@php
    $pageTitle = 'Certificate Authenticity Verifier';
@endphp

@section('content')
    <!-- Minimal Compact Hero -->
    <div class="pbz-compact-hero py-3.5 border-bottom" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <!-- Breadcrumbs inline -->
                    <div class="d-flex align-items-center gap-2 small text-white-50 mb-1" style="font-size: 0.76rem;">
                        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">Home</a>
                        <span>/</span>
                        <span class="text-white fw-semibold">Verification</span>
                        <span>/</span>
                        <span class="text-white fw-semibold">Certificate Verifier</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(249, 237, 39, 0.2); color: #F9ED27; font-size: 0.68rem; font-weight: 700; border: 1px solid rgba(249, 237, 39, 0.4);">
                            <i class="fa-solid fa-shield-halved me-1"></i> BANK OF TANZANIA AUDIT REGISTRY
                        </span>
                        <span class="text-white-50 small" style="font-size: 0.75rem;">• Real-Time Cryptographic Validation</span>
                    </div>

                    <h1 class="h4 fw-bold text-white mb-0 mt-1" style="letter-spacing: -0.02em;">Official Certificate Authenticity Verifier</h1>
                </div>

                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1.5 rounded-3" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25);">
                    <i class="fa-solid fa-certificate" style="color: #F9ED27; font-size: 0.95rem;"></i>
                    <div style="line-height: 1.2;">
                        <div class="text-white fw-bold" style="font-size: 0.74rem;">TAMPER-PROOF VERIFICATION</div>
                        <div class="text-white-50" style="font-size: 0.68rem;">Issued Under PBZ Charter</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Verification Section -->
    <section class="py-4 bg-light">
        <div class="container" style="max-width: 860px;">
            <!-- Verifier Input Card -->
            <div class="card border-0 shadow-sm rounded-3 p-3.5 p-md-4 bg-white mb-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-3 d-none d-sm-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background: rgba(0, 104, 55, 0.1); color: #006837;">
                        <i class="fa-solid fa-qrcode fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.92rem;">Verify Official PBZ Banking Credential</h6>
                        <p class="text-muted small mb-3" style="font-size: 0.78rem; line-height: 1.45;">
                            Enter the unique alphanumeric serial code printed on the bottom margin of the certificate to confirm its validity and accreditation by the Bank of Tanzania (BoT).
                        </p>

                        <form action="{{ route('verify-certificate') }}" method="GET">
                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                <span class="input-group-text bg-light border-end-0 text-muted px-3">
                                    <i class="fa-solid fa-barcode"></i>
                                </span>
                                <input type="text" 
                                       name="certificate_number" 
                                       class="form-control border-start-0 border-end-0 px-2" 
                                       placeholder="e.g. CERT-PBZ-2026-001 or serial code" 
                                       value="{{ $code }}" 
                                       required
                                       style="font-size: 0.88rem; font-family: monospace;">
                                <button class="btn px-3.5 fw-bold d-inline-flex align-items-center gap-1.5" type="submit" style="background: #003730; color: #ffffff;">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #F9ED27; font-size: 0.8rem;"></i>
                                    <span>Verify Authenticity</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Verification Result Display -->
            @if ($result)
                @if ($result['is_valid'])
                    <!-- Authentic Certificate Result Card -->
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-3" style="border: 1px solid rgba(0, 104, 55, 0.3) !important;">
                        <!-- Status Banner -->
                        <div class="p-3 text-white d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: linear-gradient(135deg, #006837 0%, #004d27 100%);">
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 36px; height: 36px; color: #006837;">
                                    <i class="fa-solid fa-circle-check fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="m-0 fw-bold text-white" style="font-size: 0.9rem;">Authentic &amp; Verified PBZ Credential</h6>
                                    <small class="text-white-50" style="font-size: 0.72rem;">Accredited under Bank of Tanzania (BoT) Continuous Development Framework</small>
                                </div>
                            </div>
                            <span class="badge rounded-pill px-2.5 py-1" style="background: #32C5F1; color: #002822; font-size: 0.7rem; font-weight: 700;">
                                OFFICIAL VALID RECORD
                            </span>
                        </div>

                        <!-- Card Details Body -->
                        <div class="card-body p-3.5">
                            <div class="row g-2.5">
                                <div class="col-sm-6">
                                    <div class="p-2.5 rounded-2 bg-light border">
                                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.68rem;">Certificate Serial Number</small>
                                        <span class="fw-bold text-dark font-monospace" style="font-size: 0.86rem;">
                                            {{ $result['certificate_number'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="p-2.5 rounded-2 bg-light border">
                                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.68rem;">Date of Conferral</small>
                                        <span class="fw-bold text-dark" style="font-size: 0.86rem;">
                                            {{ $result['completion_date'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="p-2.5 rounded-2 bg-light border">
                                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.68rem;">Conferred To (Banker / Student)</small>
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;">
                                            {{ $result['student_name'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="p-2.5 rounded-2 bg-light border">
                                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.68rem;">Accredited Curriculum</small>
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.9rem;">
                                            {{ $result['course_title'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="p-2.5 rounded-2 bg-light border">
                                        <small class="text-muted text-uppercase fw-semibold d-block" style="font-size: 0.68rem;">Lead Faculty / Academy Authority</small>
                                        <span class="fw-bold text-dark" style="font-size: 0.86rem;">
                                            {{ $result['instructor_name'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Permanent Shareable Link -->
                            <div class="mt-3 pt-2.5 border-top">
                                <small class="text-muted d-block mb-1" style="font-size: 0.72rem;">Permanent Cryptographic Verification Link:</small>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control font-monospace" id="certUrlInput"
                                           value="{{ $result['verification_url'] }}" readonly style="font-size: 0.78rem;">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="navigator.clipboard.writeText(document.getElementById('certUrlInput').value); alert('Verification link copied to clipboard!');">
                                        <i class="fa-regular fa-copy me-1"></i> Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Unverified / Invalid Result Card -->
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden bg-white mb-3" style="border: 1px solid rgba(220, 38, 38, 0.3) !important;">
                        <div class="p-3 text-white d-flex align-items-center gap-2.5" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-white" style="width: 36px; height: 36px; color: #dc2626;">
                                <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="m-0 fw-bold text-white" style="font-size: 0.9rem;">Certificate Number Not Found</h6>
                                <small class="text-white-50" style="font-size: 0.72rem;">No matching PBZ accreditation record in the central registry</small>
                            </div>
                        </div>
                        <div class="card-body p-3.5">
                            <p class="text-secondary small mb-3" style="font-size: 0.82rem; line-height: 1.5;">
                                {{ $result['message'] ?? 'Please confirm that the code was entered accurately with correct hyphens. If you believe this is an administrative discrepancy, please contact the PBZ Learning Academy support desk.' }}
                            </p>
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.76rem;">
                                    <i class="fa-solid fa-headset me-1"></i> Contact Academy Registrar
                                </a>
                                <a href="tel:0800750075" class="btn btn-sm btn-light rounded-pill px-3 py-1 text-dark border" style="font-size: 0.76rem;">
                                    <i class="fa-solid fa-phone me-1 text-success"></i> 0800 750 075
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <!-- Informational Security Card -->
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small" style="font-size: 0.75rem;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-lock text-success"></i>
                        <span>Cryptographically secured by People's Bank of Zanzibar (PBZ) Central Records.</span>
                    </div>
                    <div>
                        <span>Head Office: Mpirani, Zanzibar</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('meta')
    <title>Certificate Authenticity Verifier | People's Bank of Zanzibar (PBZ) LMS</title>
@endpush

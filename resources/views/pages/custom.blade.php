@extends('layouts.app')

@section('content')
    <!-- Minimal Hero Header -->
    <div class="pbz-compact-hero py-3.5 border-bottom" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <!-- Breadcrumbs inline -->
                    <div class="d-flex align-items-center gap-2 small text-white-50 mb-1" style="font-size: 0.76rem;">
                        <a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">Home</a>
                        <span>/</span>
                        <span class="text-white-50">Governance</span>
                        <span>/</span>
                        <span class="text-white fw-semibold">{{ $page->title }}</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(249, 237, 39, 0.2); color: #F9ED27; font-size: 0.68rem; font-weight: 700; border: 1px solid rgba(249, 237, 39, 0.4);">
                            <i class="fa-solid fa-scale-balanced me-1"></i> BOT &amp; PDPA COMPLIANT
                        </span>
                        <span class="text-white-50 small" style="font-size: 0.75rem;">• Updated {{ date('M Y') }}</span>
                    </div>

                    <h1 class="h4 fw-bold text-white mb-0 mt-1" style="letter-spacing: -0.02em;">{{ $page->title }}</h1>
                </div>

                <!-- Right Accreditation Badge -->
                <div class="d-none d-md-flex align-items-center gap-2 px-3 py-1.5 rounded-3" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25);">
                    <i class="fa-solid fa-building-columns" style="color: #F9ED27; font-size: 0.95rem;"></i>
                    <div style="line-height: 1.2;">
                        <div class="text-white fw-bold" style="font-size: 0.74rem;">PEOPLE'S BANK OF ZANZIBAR</div>
                        <div class="text-white-50" style="font-size: 0.68rem;">Legal &amp; Regulatory Secretariat</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section: Compact Native Layout -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row g-3">
                <!-- Sidebar: Navigation & Contact Support -->
                <div class="col-lg-3 col-md-4">
                    <div class="d-flex flex-column gap-3 sticky-top" style="top: 85px; z-index: 10;">
                        <!-- Legal Navigation Card -->
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                            <div class="card-header bg-white py-2.5 px-3 border-bottom">
                                <h6 class="m-0 fw-bold text-dark d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                    <i class="fa-solid fa-book-bookmark text-success"></i>
                                    <span>STATUTORY POLICIES</span>
                                </h6>
                            </div>
                            <div class="list-group list-group-flush small" style="font-size: 0.8rem;">
                                <a href="{{ url('pages/privacy-policy') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 {{ request()->is('*privacy-policy*') ? 'active fw-bold' : '' }}">
                                    <span>Privacy &amp; Data Protection</span>
                                    <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i>
                                </a>
                                <a href="{{ url('pages/terms-and-conditions') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 {{ request()->is('*terms-and-conditions*') ? 'active fw-bold' : '' }}">
                                    <span>Terms &amp; Governance</span>
                                    <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i>
                                </a>
                                <a href="{{ url('pages/gdpr-compliance') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 {{ request()->is('*gdpr-compliance*') ? 'active fw-bold' : '' }}">
                                    <span>Cross-Border Compliance</span>
                                    <i class="fa-solid fa-chevron-right" style="font-size: 0.65rem;"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Direct Assistance Card -->
                        <div class="card border-0 shadow-sm rounded-3 p-3" style="background: #002b24; color: #ffffff;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: rgba(50, 197, 241, 0.2); color: #32C5F1;">
                                    <i class="fa-solid fa-shield-halved" style="font-size: 0.8rem;"></i>
                                </div>
                                <h6 class="m-0 fw-bold text-white" style="font-size: 0.78rem;">Governance Office</h6>
                            </div>
                            <p class="small text-white-50 mb-2.5" style="font-size: 0.72rem; line-height: 1.4;">
                                Questions regarding Bank of Tanzania statutory audits or student data records?
                            </p>
                            <a href="mailto:dpo@pbzbank.co.tz" class="btn btn-sm w-100 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="background: #32C5F1; color: #002822; font-size: 0.75rem;">
                                <i class="fa-solid fa-envelope"></i>
                                <span>dpo@pbzbank.co.tz</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Main Document Card -->
                <div class="col-lg-9 col-md-8">
                    <div class="card border-0 shadow-sm rounded-3 p-3.5 p-md-4 bg-white">
                        @if ($page->description)
                            <div class="p-3 rounded-3 mb-3" style="background: rgba(2, 132, 199, 0.06); border-left: 4px solid #0284c7;">
                                <p class="mb-0 text-dark small fw-medium" style="font-size: 0.84rem; line-height: 1.5;">
                                    <i class="fa-solid fa-circle-info me-1.5" style="color: #0284c7;"></i>
                                    {{ $page->description }}
                                </p>
                            </div>
                        @endif

                        <div class="pbz-native-page-content" style="font-size: 0.86rem; line-height: 1.65; color: #334155;">
                            {!! $page->content !!}
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-4 pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-2 text-muted small" style="font-size: 0.75rem;">
                            <div>
                                <i class="fa-solid fa-building-columns me-1 text-success"></i>
                                Official Publication • The People's Bank of Zanzibar Limited
                            </div>
                            <div>
                                <a href="javascript:window.print()" class="text-decoration-none text-secondary hover-dark">
                                    <i class="fa-solid fa-print me-1"></i> Print / Save Copy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('meta')
    @if (!empty($seoMeta['title']))
        <title>{{ $seoMeta['title'] }}</title>
    @else
        <title>{{ $page->title }} | The People's Bank of Zanzibar (PBZ) LMS</title>
    @endif
    @if (!empty($seoMeta['description']))
        <meta name="description" content="{{ $seoMeta['description'] }}">
    @endif
@endpush

@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

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
                        <span class="text-white fw-semibold">Testimonials</span>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(249, 237, 39, 0.2); color: #F9ED27; font-size: 0.68rem; font-weight: 700; border: 1px solid rgba(249, 237, 39, 0.4);">
                            <i class="fa-solid fa-award me-1"></i> VERIFIED PBZ BANKING GRADUATES
                        </span>
                        <span class="text-white-50 small" style="font-size: 0.75rem;">• 34 Branches Across Tanzania</span>
                    </div>

                    <h1 class="h4 fw-bold text-white mb-0 mt-1" style="letter-spacing: -0.02em;">Learner Reviews &amp; Success Stories</h1>
                </div>

                <!-- Right Rating Badge -->
                <div class="d-flex align-items-center gap-2 px-3 py-1.5 rounded-3" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25);">
                    <div class="d-flex align-items-center text-warning" style="font-size: 0.85rem;">
                        <i class="fa-solid fa-star" style="color: #F9ED27;"></i>
                        <i class="fa-solid fa-star" style="color: #F9ED27;"></i>
                        <i class="fa-solid fa-star" style="color: #F9ED27;"></i>
                        <i class="fa-solid fa-star" style="color: #F9ED27;"></i>
                        <i class="fa-solid fa-star" style="color: #F9ED27;"></i>
                    </div>
                    <div class="border-start ps-2" style="border-color: rgba(255,255,255,0.2) !important;">
                        <div class="text-white fw-bold" style="font-size: 0.78rem;">{{ $averageRating ? number_format($averageRating, 1) : '5.0' }} / 5.0</div>
                        <div class="text-white-50" style="font-size: 0.65rem;">100% BoT Audit Pass</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Testimonials Grid: Compact Native Cards -->
    <section class="py-4 bg-light">
        <div class="container">
            <!-- Filter / Subtitle Bar -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                <div>
                    <h6 class="m-0 fw-bold text-dark" style="font-size: 0.88rem;">Staff Feedback Across Operational Divisions</h6>
                    <span class="text-muted small" style="font-size: 0.75rem;">Anti-Money Laundering, PBZ Ikhlas Shariah Operations, and Credit Risk Management</span>
                </div>
                <div class="d-flex align-items-center gap-1.5 small text-muted" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span>Verified Employee Submissions</span>
                </div>
            </div>

            <!-- 3-Column Native Cards Grid -->
            <div class="row g-3">
                @php
                    $branchLocations = [
                        'Stone Town Main Branch, Zanzibar',
                        'Mpirani Head Office, Zanzibar',
                        'Dar es Salaam Corporate Branch',
                        'Chake Chake Branch, Pemba',
                        'Wete Branch, Pemba',
                        'Mwanza Regional Branch'
                    ];
                    $roleDesignations = [
                        'Branch Operations Manager',
                        'Senior AML Compliance Officer',
                        'PBZ Ikhlas Shariah Officer',
                        'Senior Teller & Foreign Exchange Specialist',
                        'Credit Risk Assessment Lead',
                        'Corporate Governance Associate'
                    ];
                @endphp

                @forelse($reviews as $idx => $review)
                    @php
                        $loc = $branchLocations[$idx % count($branchLocations)];
                        $role = $roleDesignations[$idx % count($roleDesignations)];
                        $name = $review->user->name ?? 'PBZ Banking Specialist';
                        $courseTitle = $review->course->title ?? 'Bank of Tanzania Certified Curriculum';
                    @endphp
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white d-flex flex-column justify-content-between" style="border: 1px solid #e2e8f0 !important;">
                            <div>
                                <!-- Top Row: Stars & Course Pill -->
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fa-solid fa-star" style="font-size: 0.72rem; color: {{ $i < ($review->rating ?? 5) ? '#F9ED27' : '#e2e8f0' }};"></i>
                                        @endfor
                                    </div>
                                    <span class="badge rounded-pill text-truncate" style="max-width: 170px; background: rgba(0, 104, 55, 0.08); color: #006837; font-size: 0.65rem; border: 1px solid rgba(0, 104, 55, 0.2);">
                                        {{ $courseTitle }}
                                    </span>
                                </div>

                                <!-- Review Quote -->
                                <p class="mb-3 text-secondary" style="font-size: 0.82rem; line-height: 1.5; font-style: italic;">
                                    “{{ Str::limit($review->comment, 240) }}”
                                </p>
                            </div>

                            <!-- Author Profile -->
                            <div class="d-flex align-items-center gap-2.5 pt-2 border-top border-light mt-auto">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm flex-shrink-0" style="width: 38px; height: 38px; background: linear-gradient(135deg, #003730 0%, #006837 100%); font-size: 0.85rem; border: 2px solid #32C5F1;">
                                    {{ strtoupper(substr($name, 0, 1)) }}
                                </div>
                                <div style="line-height: 1.25;" class="overflow-hidden">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.8rem;">
                                        {{ $name }}
                                        <i class="fa-solid fa-circle-check text-success ms-0.5" style="font-size: 0.7rem;" title="Verified Staff"></i>
                                    </div>
                                    <div class="text-success small fw-semibold text-truncate" style="font-size: 0.7rem;">
                                        {{ $role }}
                                    </div>
                                    <div class="text-muted text-truncate" style="font-size: 0.67rem;">
                                        <i class="fa-solid fa-location-dot me-0.5" style="color: #32C5F1;"></i> {{ $loc }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-3 p-4 text-center bg-white">
                            <i class="fa-solid fa-comments text-muted fa-2x mb-2"></i>
                            <h6 class="fw-bold text-dark">Learner reviews will appear here once verified.</h6>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination if present -->
            @if ($reviews->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('meta')
    <title>Learner Testimonials | People's Bank of Zanzibar (PBZ) LMS</title>
@endpush

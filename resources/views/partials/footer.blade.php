@php
    $siteName = site_name();
    $contact = $footerContact ?? frontend_setting('footer.contact', []);
    
    $phone = $contact['phone'] ?? '+255 24 223 1118 / 0800 750 075';
    $email = $contact['email'] ?? 'info@pbzbank.co.tz';
    $address = $contact['address'] ?? 'Head Office: Mpirani, P.O. Box 1116, Zanzibar, Tanzania';
    $hours = $contact['hours'] ?? 'Mon - Fri: 8:30am - 4:30pm EAT';

    $phoneLink = $phone ? preg_replace('/[^\d\+]/', '', explode('/', $phone)[0]) : null;

    $socialLinks = !empty($footerSocialLinks) ? $footerSocialLinks : collect(frontend_setting('footer.social_links', []))
        ->filter(fn($link) => filled($link['url'] ?? null))
        ->values();

    $quickLinks = $frontendMenus['quick-links'] ?? [];
    $footerLinks = $frontendMenus['footer-links'] ?? [];
@endphp

<!-- ========================================================
     PBZ CORPORATE BRANDED FOOTER (INSPIRED BY LOGO-2.PNG)
     Shape & Color Matrix:
     - Forest/Emerald Green (#006837): PBZ Ikhlas Islamic Arch & Primary Theme
     - Sky Blue / Cyan (#32C5F1): Ocean Emblem & Islamic Geometric Arches
     - Bright Gold / Yellow (#F9ED27): Radiating Sun & Rays
     - Pure White (#FFFFFF): PBZ BANK Foundation Watermark & Canvas
     - Dark Brown / Slate (#1A1510): Structural Outlines & Palm Tree Accents
     ======================================================== -->
<footer class="pbz-corporate-footer position-relative overflow-hidden text-light">
    <!-- Architectural Dome Arch Top Separator -->
    <div class="pbz-footer-arch-separator w-100 position-relative">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-100 d-block" preserveAspectRatio="none" style="height: 36px;">
            <!-- Outer Forest Green Layer -->
            <path d="M0 48H1440V24C1200 4 960 0 720 0C480 0 240 4 0 24V48Z" fill="#002b24"/>
            <!-- Tiered Cyan Arch Accent Line -->
            <path d="M0 26C240 6 480 2 720 2C960 2 1200 6 1440 26" stroke="#32C5F1" stroke-width="2.5" opacity="0.6"/>
            <!-- Inner Bright Gold Crest Line -->
            <path d="M520 8C600 4 660 3 720 3C780 3 840 4 920 8" stroke="#F9ED27" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- Giant Watermark: "PBZ BANK" (Exact reproduction of white typography at bottom of logo-2.png) -->
    <div class="pbz-footer-watermark user-select-none" aria-hidden="true">
        PBZ BANK
    </div>

    <div class="container position-relative" style="z-index: 2;">
        <!-- Top Signature Brand Crest Ribbon (Direct Mirror of logo-2.png Layout) -->
        <div class="pbz-brand-ribbon-card p-3 p-md-3.5 rounded-4 mb-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <!-- Left: Dual Emblem Showcase matching logo-2.png -->
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="pbz-emblem-canvas bg-white px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2.5 border" style="border-color: rgba(50, 197, 241, 0.3) !important;">
                        <img src="{{ asset('assets/front/img/logo/logo-2.png') }}" 
                             alt="The People's Bank of Zanzibar & PBZ Ikhlas" 
                             style="max-height: 48px; width: auto; object-fit: contain;">
                    </div>

                    <div class="pbz-crest-text">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill px-2.5 py-1" style="background: #006837; color: #ffffff; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.04em;">
                                THE PEOPLE'S BANK OF ZANZIBAR
                            </span>
                            <span class="badge rounded-pill px-2 py-1" style="background: #32C5F1; color: #002b24; font-size: 0.68rem; font-weight: 700;">
                                PBZ IKHLAS
                            </span>
                        </div>
                        <p class="mb-0 mt-1 small" style="color: #cbd5e1; font-size: 0.78rem;">
                            Sovereign Banking Learning Academy • Certified by Bank of Tanzania (BOT)
                        </p>
                    </div>
                </div>

                <!-- Right: Sovereign Credentials & Hotline -->
                <div class="d-flex align-items-center gap-2.5 ms-auto flex-wrap">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" style="background: rgba(249, 237, 39, 0.12); border: 1px solid rgba(249, 237, 39, 0.35);">
                        <i class="fa-solid fa-sun" style="color: #F9ED27; font-size: 0.8rem;"></i>
                        <span style="color: #F9ED27; font-size: 0.74rem; font-weight: 700;">EST. 1966 • ZANZIBAR</span>
                    </div>

                    @if ($phone)
                        <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="btn btn-sm rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm" style="background: #32C5F1; color: #002822; font-size: 0.76rem;">
                            <i class="fa-solid fa-phone-volume"></i>
                            <span>Toll Free: 0800 750 075</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Footer Columns Grid -->
        <div class="row g-4 justify-content-between mb-4">
            <!-- Col 1: Corporate Mission & Trust Badges -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="footer-col-content">
                    <h6 class="fw-bold text-white text-uppercase mb-2.5 d-flex align-items-center gap-2" style="font-size: 0.82rem; letter-spacing: 0.05em;">
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #F9ED27;"></span>
                        PBZ ACADEMY
                    </h6>
                    <p class="small mb-3" style="font-size: 0.8rem; line-height: 1.55; color: #cbd5e1;">
                        {{ $footerBranding['about_text'] ?? "The premier educational arm of The People's Bank of Zanzibar. Upskilling banking professionals in BOT regulatory compliance, AML/CFT risk management, and Shariah-compliant PBZ Ikhlas operations." }}
                    </p>

                    <!-- Dual Compliance Badges -->
                    <div class="d-flex flex-column gap-1.5 mb-3">
                        <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(0, 104, 55, 0.35); border: 1px solid rgba(0, 104, 55, 0.6);">
                            <i class="fa-solid fa-mosque" style="color: #32C5F1; font-size: 0.75rem;"></i>
                            <span style="color: #ffffff; font-size: 0.72rem; font-weight: 600;">PBZ Ikhlas Shariah Board Certified</span>
                        </div>
                        <div class="d-inline-flex align-items-center gap-2 px-2.5 py-1 rounded-2" style="background: rgba(249, 237, 39, 0.1); border: 1px solid rgba(249, 237, 39, 0.25);">
                            <i class="fa-solid fa-shield-halved" style="color: #F9ED27; font-size: 0.75rem;"></i>
                            <span style="color: #e2e8f0; font-size: 0.72rem; font-weight: 600;">Bank of Tanzania (BOT) Compliant</span>
                        </div>
                    </div>

                    <!-- Social Channels -->
                    @if (!empty($socialLinks) && count($socialLinks) > 0)
                        <div class="d-flex align-items-center gap-2">
                            @foreach ($socialLinks as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="pbz-footer-social-btn" aria-label="{{ $social['label'] ?? 'Social' }}">
                                    <i class="{{ $social['icon'] ?? 'fab fa-globe' }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Col 2: Fast Navigation / Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <div class="footer-col-content">
                    <h6 class="fw-bold text-white text-uppercase mb-3 d-flex align-items-center gap-2" style="font-size: 0.82rem; letter-spacing: 0.05em;">
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #32C5F1;"></span>
                        {{ __('frontend.quick_links') ?? 'Explore' }}
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.8rem;">
                        @forelse($quickLinks as $link)
                            <li class="mb-2">
                                <a href="{{ $link['url'] }}" target="{{ $link['target'] ?? '_self' }}" class="pbz-footer-link text-decoration-none">
                                    <i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>
                                    <span>{{ $link['title'] }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="mb-2"><a href="{{ route('home') }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>Home</a></li>
                            <li class="mb-2"><a href="{{ route('courses') }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>Courses</a></li>
                            <li class="mb-2"><a href="{{ route('events.index') }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>Events</a></li>
                            <li class="mb-2"><a href="{{ route('about') }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>About Us</a></li>
                            <li class="mb-2"><a href="{{ route('blog.index') }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #F9ED27; font-size: 0.65rem;"></i>Knowledge Hub</a></li>
                        @endforelse
                        <li class="mb-2">
                            <a href="{{ route('verify-certificate') }}" class="pbz-footer-link text-decoration-none">
                                <i class="fa-solid fa-certificate me-1.5" style="color: #32C5F1; font-size: 0.7rem;"></i>
                                <span class="fw-semibold text-white">Verify Certificate</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Col 3: Curricula & Islamic Finance -->
            <div class="col-lg-3 col-md-6 col-6">
                <div class="footer-col-content">
                    <h6 class="fw-bold text-white text-uppercase mb-3 d-flex align-items-center gap-2" style="font-size: 0.82rem; letter-spacing: 0.05em;">
                        <span class="d-inline-block rounded-circle" style="width: 8px; height: 8px; background: #006837;"></span>
                        {{ __('frontend.resources') ?? 'Curricula' }}
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.8rem;">
                        @forelse($footerLinks as $link)
                            <li class="mb-2">
                                <a href="{{ $link['url'] }}" target="{{ $link['target'] ?? '_self' }}" class="pbz-footer-link text-decoration-none">
                                    <i class="fa-solid fa-angle-right me-1.5" style="color: #32C5F1; font-size: 0.65rem;"></i>
                                    <span>{{ $link['title'] }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="mb-2"><a href="{{ route('courses', ['search' => 'AML']) }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #32C5F1; font-size: 0.65rem;"></i>AML / CFT & Sanctions</a></li>
                            <li class="mb-2"><a href="{{ route('courses', ['search' => 'Islamic']) }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #32C5F1; font-size: 0.65rem;"></i>PBZ Ikhlas Operations</a></li>
                            <li class="mb-2"><a href="{{ route('courses', ['track' => 'compliance']) }}" class="pbz-footer-link text-decoration-none"><i class="fa-solid fa-angle-right me-1.5" style="color: #32C5F1; font-size: 0.65rem;"></i>BOT Compliance Directives</a></li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Col 4: Arch-Styled Contact Pavilion -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="pbz-contact-arch-card p-3 p-md-3.5 rounded-4 border position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: rgba(50, 197, 241, 0.25) !important;">
                        <h6 class="fw-bold text-white text-uppercase m-0 d-flex align-items-center gap-2" style="font-size: 0.8rem; letter-spacing: 0.05em;">
                            <i class="fa-solid fa-building-columns" style="color: #F9ED27;"></i>
                            <span>PBZ HEADQUARTERS</span>
                        </h6>
                        <span class="badge rounded-pill" style="background: #006837; color: #ffffff; font-size: 0.65rem; border: 1px solid rgba(50, 197, 241, 0.4);">
                            Official
                        </span>
                    </div>

                    <ul class="list-unstyled mb-0 small" style="font-size: 0.78rem;">
                        <!-- Address -->
                        @if ($address)
                            <li class="d-flex align-items-start gap-2.5 mb-2.5">
                                <i class="fa-solid fa-location-dot mt-1 flex-shrink-0" style="color: #32C5F1; width: 14px;"></i>
                                <span style="line-height: 1.4; color: #e2e8f0;">{{ $address }}</span>
                            </li>
                        @endif

                        <!-- Email -->
                        @if ($email)
                            <li class="d-flex align-items-center gap-2.5 mb-2.5">
                                <i class="fa-solid fa-envelope flex-shrink-0" style="color: #32C5F1; width: 14px;"></i>
                                <a href="mailto:{{ $email }}" class="text-decoration-none pbz-gold-hover" style="color: #e2e8f0; font-weight: 500;">
                                    {{ $email }}
                                </a>
                            </li>
                        @endif

                        <!-- Phone -->
                        @if ($phone)
                            <li class="d-flex align-items-center gap-2.5 mb-2.5">
                                <i class="fa-solid fa-phone-volume flex-shrink-0" style="color: #F9ED27; width: 14px;"></i>
                                <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="text-decoration-none pbz-gold-hover" style="color: #ffffff; font-weight: 700;">
                                    {{ $phone }}
                                </a>
                            </li>
                        @endif

                        <!-- Hours -->
                        @if ($hours)
                            <li class="d-flex align-items-center gap-2.5 pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.1) !important;">
                                <i class="fa-solid fa-clock flex-shrink-0" style="color: #32C5F1; width: 14px;"></i>
                                <span style="color: #cbd5e1;">Hours: <strong style="color: #ffffff;">{{ $hours }}</strong></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright Row -->
        <div class="footer-bottom-bar pt-3.5 pb-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: rgba(50, 197, 241, 0.2) !important; font-size: 0.76rem; color: #94a3b8;">
            <div class="d-flex align-items-center gap-2">
                <span class="d-inline-block rounded-circle" style="width: 6px; height: 6px; background: #32C5F1;"></span>
                <span>{{ $footerBranding['copyright'] ?? '© ' . date('Y') . " The People's Bank of Zanzibar Limited. All rights reserved." }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('courses') }}" class="pbz-footer-link text-decoration-none" style="font-size: 0.74rem;">Curriculum Catalog</a>
                <span style="color: #32C5F1;">•</span>
                <a href="{{ route('contact') }}" class="pbz-footer-link text-decoration-none" style="font-size: 0.74rem;">Support</a>
                <span style="color: #32C5F1;">•</span>
                <span class="text-white-50" style="font-size: 0.74rem;">Mpirani, Zanzibar, Tanzania</span>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ===================================================
       PBZ CORPORATE FOOTER - LOGO-2 RESEMBLANCE DESIGN SYSTEM
       =================================================== */
    .pbz-corporate-footer {
        background: linear-gradient(180deg, #002b24 0%, #001f19 50%, #001713 100%);
        color: #cbd5e1;
    }

    /* Giant Subtle "PBZ BANK" Watermark (Matching White Typography in logo-2.png) */
    .pbz-footer-watermark {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: clamp(4rem, 11vw, 9.5rem);
        font-weight: 900;
        letter-spacing: 0.18em;
        color: #ffffff;
        opacity: 0.035;
        white-space: nowrap;
        pointer-events: none;
        z-index: 1;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* Top Signature Brand Ribbon Card */
    .pbz-brand-ribbon-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(50, 197, 241, 0.25);
        backdrop-filter: blur(8px);
    }

    /* Clean White Canvas for Emblems */
    .pbz-emblem-canvas {
        background-color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    /* Arch-Styled Contact Card */
    .pbz-contact-arch-card {
        background: rgba(0, 104, 55, 0.15);
        border: 1px solid rgba(50, 197, 241, 0.3) !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
    }

    /* Navigation Links */
    .pbz-footer-link {
        color: #cbd5e1;
        transition: color 0.15s ease, transform 0.15s ease;
        display: inline-block;
    }
    .pbz-footer-link:hover,
    .pbz-gold-hover:hover {
        color: #F9ED27 !important;
        transform: translateX(2px);
    }

    /* Social Action Circles */
    .pbz-footer-social-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(50, 197, 241, 0.3);
        color: #32C5F1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .pbz-footer-social-btn:hover {
        background: #F9ED27;
        border-color: #F9ED27;
        color: #002b24;
        transform: translateY(-2px);
    }
</style>

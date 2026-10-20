@php
    $primaryColor = branding_settings('primary_color', '#006837');
    $secondaryColor = branding_settings('secondary_color', '#32C5F1');
    $pbzDarkGreen = '#004d27';
    $pbzNavy = '#072818';
    $pbzGold = '#F9ED27';
@endphp
<style>
    :root {
        --theme: {{ $primaryColor }};
        --theme-2: {{ $secondaryColor }};
        --v2-primary: {{ $primaryColor }};
        --v2-secondary: {{ $secondaryColor }};
        --pbz-green: {{ $primaryColor }};
        --pbz-blue: {{ $secondaryColor }};
        --pbz-dark-green: {{ $pbzDarkGreen }};
        --pbz-navy: {{ $pbzNavy }};
        --pbz-gold: {{ $pbzGold }};
    }

    /* Logo Sizing */
    a.header-logo img, a.header-logo2 img, .header-1 .header-logo img, .header-1 .header-logo2 img {
        max-height: 54px !important;
        width: auto !important;
        max-width: 220px !important;
        object-fit: contain !important;
    }
    a.footer-logo img {
        max-height: 60px !important;
        width: auto !important;
        max-width: 240px !important;
        object-fit: contain !important;
    }

    /* PBZ Buttons & Badges */
    .theme-btn {
        background-color: var(--pbz-green) !important;
        border-color: var(--pbz-green) !important;
        color: #ffffff !important;
    }
    .theme-btn:hover, .theme-btn:focus, .theme-btn:active {
        background-color: var(--pbz-dark-green) !important;
        border-color: var(--pbz-dark-green) !important;
        color: #ffffff !important;
    }
    .theme-btn.style-2 {
        background-color: var(--pbz-blue) !important;
        border-color: var(--pbz-blue) !important;
        color: #0b2545 !important;
    }
    .theme-btn.style-2:hover {
        background-color: var(--pbz-green) !important;
        border-color: var(--pbz-green) !important;
        color: #ffffff !important;
    }

    /* Navbar Highlights */
    .main-menu ul li:hover > a,
    .main-menu ul li.active > a {
        color: var(--pbz-green) !important;
    }
    .main-menu ul li .submenu li:hover > a {
        color: var(--pbz-green) !important;
    }

    /* Footer Styling - PBZ Deep Sovereign Banking Theme */
    .mhq-footer-section.footer-bg-2 {
        background: linear-gradient(180deg, #072818 0%, #03150c 100%) !important;
    }
    .mhq-footer-section .mhq-widget-head h3 {
        color: #ffffff !important;
        border-bottom: 2px solid var(--pbz-blue);
        display: inline-block;
        padding-bottom: 6px;
    }
    .mhq-footer-section .mhq-footer-content p,
    .mhq-footer-section .list-items li a,
    .mhq-footer-section .contact-info-items p {
        color: #cbd5e1 !important;
    }
    .mhq-footer-section .list-items li a:hover {
        color: var(--pbz-blue) !important;
    }

    /* Admin Overrides */
    .bg-primary { background-color: {{ $primaryColor }} !important; }
    .text-primary, .text-primary-all *, .text-primary-all *:before, .text-primary-all *:after { color: {{ $primaryColor }} !important; }
    .btn-primary { background-color: {{ $primaryColor }} !important; border-color: {{ $primaryColor }} !important; }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active { background-color: {{ $pbzDarkGreen }} !important; border-color: {{ $pbzDarkGreen }} !important; }
    
    .nav-pills .nav-item .nav-link.active {
        background-color: {{ $primaryColor }};
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: {{ $primaryColor }} !important;
        border-color: {{ $primaryColor }} !important;
    }
    .page-item.active .page-link {
        background-color: {{ $primaryColor }};
        border-color: {{ $primaryColor }};
    }
    .main-sidebar .sidebar-menu li.active a {
        color: {{ $primaryColor }};
    }
    .main-sidebar .sidebar-menu li.active a i {
        color: {{ $primaryColor }};
    }
    .main-sidebar .sidebar-menu li ul.dropdown-menu li.active > a {
        color: {{ $primaryColor }};
    }
    .main-sidebar .sidebar-menu li a:hover {
        color: {{ $primaryColor }};
    }

    /* =========================================================================
       1. COMPLETE REMOVAL OF FLOATING CUSTOM MOUSE POINTER / CURSOR
       ========================================================================= */
    .mouseCursor, .cursor-outer, .cursor-inner, .cursor-big {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    *, html, body, div, span, p, a, button, input, select, textarea {
        cursor: auto !important;
    }
    a, button, [role="button"], input[type="submit"], input[type="button"], select, .theme-btn, .btn, .array-prev, .array-next, .swiper-button-prev, .swiper-button-next {
        cursor: pointer !important;
    }

    /* Disable distracting floating bounce animations */
    .float-bob-x, .float-bob-y {
        animation: none !important;
        transform: none !important;
    }

    /* =========================================================================
       2. REFINED SECTION PADDING & MODERN COMPACT SPACING
       ========================================================================= */
    .section-padding {
        padding: 60px 0 !important;
    }
    @media (max-width: 1199px) {
        .section-padding {
            padding: 50px 0 !important;
        }
    }
    @media (max-width: 767px) {
        .section-padding {
            padding: 40px 0 !important;
        }
    }
    .section-title {
        margin-bottom: 28px !important;
    }
    .section-title-area {
        margin-bottom: 28px !important;
    }
    .section-title h2 {
        font-size: 32px !important;
        line-height: 1.25 !important;
        margin-top: 6px !important;
    }
    @media (max-width: 767px) {
        .section-title h2 {
            font-size: 24px !important;
        }
    }

    /* =========================================================================
       3. NATIVE COMPACT CARDS FOR COURSES, CATEGORIES & NEWS
       ========================================================================= */
    /* Course Cards */
    .mhq-courses-box-items {
        margin-top: 0 !important;
        margin-bottom: 24px;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
        height: calc(100% - 24px);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
    }
    .mhq-courses-box-items:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 28px rgba(0, 104, 55, 0.12) !important;
        border-color: rgba(0, 104, 55, 0.3) !important;
    }
    .mhq-courses-box-items .mhq-courses-image {
        position: relative;
        height: 200px !important;
        overflow: hidden;
        background: #072818;
    }
    .mhq-courses-box-items .mhq-courses-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        border-radius: 13px 13px 0 0 !important;
        transition: transform 0.3s ease;
    }
    .mhq-courses-box-items:hover .mhq-courses-image img {
        transform: scale(1.03);
    }
    .mhq-courses-box-items .mhq-courses-image .post-box {
        top: 14px !important;
        left: 14px !important;
        padding: 5px 12px !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-radius: 6px !important;
        background: var(--pbz-green) !important;
        color: #ffffff !important;
    }
    .mhq-courses-box-items .mhq-courses-content {
        padding: 18px 20px !important;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .mhq-courses-box-items .mhq-courses-content .star {
        margin-bottom: 6px !important;
        font-size: 13px !important;
    }
    .mhq-courses-box-items .mhq-courses-content h3 {
        font-size: 17px !important;
        line-height: 1.35 !important;
        font-weight: 700 !important;
        margin-bottom: 8px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
    }
    .mhq-courses-box-items .mhq-courses-content h3 a {
        color: #0f172a !important;
        transition: color 0.2s ease;
    }
    .mhq-courses-box-items .mhq-courses-content h3 a:hover {
        color: var(--pbz-green) !important;
    }
    .mhq-courses-box-items .mhq-courses-content p {
        font-size: 13px !important;
        line-height: 1.5 !important;
        color: #64748b !important;
        margin-bottom: 12px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .mhq-courses-box-items .mhq-courses-content .post-date {
        padding: 10px 0 !important;
        margin-bottom: 12px !important;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .mhq-courses-box-items .mhq-courses-content .post-date li {
        font-size: 12px !important;
        color: #64748b !important;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .mhq-courses-box-items .mhq-courses-content .post-date li .icon {
        width: 24px !important;
        height: 24px !important;
        font-size: 11px !important;
        background: #f1f5f9 !important;
        color: var(--pbz-green) !important;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mhq-courses-box-items .mhq-courses-content .client-info-area {
        margin-top: auto;
        padding-top: 8px;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
    }
    .mhq-courses-box-items .mhq-courses-content .client-info-area .client-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px !important;
        font-weight: 600;
        color: #334155;
    }
    .mhq-courses-box-items .mhq-courses-content .client-info-area .client-info .img {
        width: 30px !important;
        height: 30px !important;
        border-radius: 50%;
        overflow: hidden;
    }
    .mhq-courses-box-items .mhq-courses-content .client-info-area .client-info .img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .mhq-courses-box-items .mhq-courses-content .client-info-area h2 {
        font-size: 15px !important;
        font-weight: 800 !important;
        color: var(--pbz-green) !important;
        margin: 0 !important;
    }
    .mhq-courses-box-items .mhq-courses-content .theme-btn {
        margin-top: 12px !important;
        padding: 9px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100% !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Category Boxes */
    .mhq-category-box-items {
        padding: 24px 20px !important;
        border-radius: 14px !important;
        background: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        backdrop-filter: blur(8px);
        transition: all 0.25s ease;
    }
    .mhq-category-box-items:hover {
        background: rgba(255, 255, 255, 0.16) !important;
        border-color: var(--pbz-gold) !important;
        transform: translateY(-3px);
    }
    .mhq-category-box-items .mhq-icon {
        width: 54px !important;
        height: 54px !important;
        font-size: 24px !important;
        margin-bottom: 16px !important;
        border-radius: 12px !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: var(--pbz-gold) !important;
    }
    .mhq-category-box-items .mhq-content h3 {
        font-size: 18px !important;
        margin-bottom: 8px !important;
    }
    .mhq-category-box-items .mhq-content p {
        font-size: 13px !important;
        line-height: 1.45 !important;
        color: #e2e8f0 !important;
        margin-bottom: 14px !important;
    }
    .mhq-category-box-items .theme-btn {
        padding: 7px 14px !important;
        font-size: 12px !important;
        border-radius: 6px !important;
    }

    /* News / Blog Cards */
    .mhq-news-box-items {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        box-shadow: 0 4px 14px rgba(0,0,0,0.04) !important;
        overflow: hidden;
        transition: all 0.25s ease;
    }
    .mhq-news-box-items:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 104, 55, 0.12) !important;
    }
    .mhq-news-box-items .mhq-image {
        height: 190px !important;
        overflow: hidden;
    }
    .mhq-news-box-items .mhq-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        transition: transform 0.3s ease;
    }
    .mhq-news-box-items:hover .mhq-image img {
        transform: scale(1.03);
    }
    .mhq-news-box-items .mhq-content {
        padding: 18px 20px !important;
    }
    .mhq-news-box-items .mhq-content h3 {
        font-size: 16px !important;
        line-height: 1.35 !important;
        font-weight: 700 !important;
        margin-bottom: 8px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .mhq-news-box-items .mhq-content p {
        font-size: 13px !important;
        color: #64748b !important;
        margin-bottom: 12px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .mhq-news-box-items .theme-btn {
        padding: 7px 14px !important;
        font-size: 12px !important;
        border-radius: 6px !important;
    }

    /* Event Cards (Compact Native Look) */
    .mhq-event-box-items-2 {
        border-radius: 14px !important;
        border: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0,0,0,0.04) !important;
        margin-top: 0 !important;
        margin-bottom: 24px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .mhq-event-box-items-2:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0, 104, 55, 0.1) !important;
    }
    .mhq-event-box-items-2 .mhq-image {
        height: 200px !important;
        overflow: hidden;
    }
    .mhq-event-box-items-2 .mhq-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }
    .mhq-event-box-items-2 .mhq-content {
        padding: 18px 20px !important;
    }
    .mhq-event-box-items-2 .mhq-content h3 {
        font-size: 17px !important;
        line-height: 1.35 !important;
        margin-bottom: 10px !important;
    }
    .mhq-event-box-items-2 .mhq-content .list-box {
        gap: 16px !important;
        margin-bottom: 14px !important;
    }
    .mhq-event-box-items-2 .mhq-content .list-box li {
        font-size: 12px !important;
        color: #64748b !important;
    }
    .mhq-event-box-items-2 .theme-btn {
        padding: 8px 16px !important;
        font-size: 12px !important;
        border-radius: 6px !important;
    }
</style>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteTitle = site_name();
        if (empty($siteTitle) || str_contains($siteTitle, 'Eduex') || str_contains($siteTitle, 'Laravel')) {
            $siteTitle = "People's Bank of Zanzibar (PBZ) LMS";
        }
        $siteTag = site_tagline();
        $pageTitle = trim($__env->yieldContent('title', 'Sign In'));
        $fullTitle = (!empty($pageTitle) && $pageTitle !== $siteTitle) ? $pageTitle . ' | ' . $siteTitle : $siteTitle . ' - ' . $siteTag;
        $authDesc = "Official People's Bank of Zanzibar (PBZ) Digital Learning Academy. Bank of Tanzania statutory certifications, AML/CFT compliance, and Islamic banking curricula.";
        $shareImage = asset('assets/front/img/logo/pbz-logo.png');
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $authDesc }}">

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="People's Bank of Zanzibar (PBZ) LMS">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $authDesc }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:secure_url" content="{{ $shareImage }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $authDesc }}">
    <meta name="twitter:image" content="{{ $shareImage }}">

    @php
        $favicon = branding_asset(['favicon_path', 'logos.favicon', 'favicon'], 'assets/front/img/favicon.svg');
    @endphp
    <link rel="icon" type="image/png" href="{{ $favicon }}">
    <link rel="shortcut icon" href="{{ $favicon }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/animate.css') }}">

    {!! ToastMagic::styles() !!}
    @include('partials.dynamic-styles')

    <style>
        :root {
            --pbz-forest-green: #006837;
            --pbz-dark-forest: #004d27;
            --pbz-deep-navy: #002b24;
            --pbz-cyan: #32C5F1;
            --pbz-gold: #F9ED27;
            --pbz-border: #e5e7eb;
            --pbz-text-dark: #111827;
            --pbz-text-muted: #6b7280;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--pbz-text-dark);
            background-color: #f8fafc;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .auth-split-wrapper {
            min-height: 100vh;
            display: flex;
            width: 100%;
        }

        /* -------------------------------------------
           LEFT BRANDING SHOWCASE PANEL
        ------------------------------------------- */
        .auth-brand-panel {
            flex: 0 0 46%;
            max-width: 46%;
            background: linear-gradient(150deg, #002b24 0%, #004d27 50%, #006837 100%);
            position: relative;
            overflow: hidden;
            color: #ffffff;
            padding: 3.5rem 3.5rem 3rem 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
            z-index: 1;
        }

        .auth-brand-panel::before {
            content: '';
            position: absolute;
            top: -15%;
            right: -10%;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(50, 197, 241, 0.22) 0%, rgba(50, 197, 241, 0) 70%);
            z-index: -1;
            pointer-events: none;
        }

        .auth-brand-panel::after {
            content: '';
            position: absolute;
            bottom: -15%;
            left: -15%;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(249, 237, 39, 0.12) 0%, rgba(249, 237, 39, 0) 70%);
            z-index: -1;
            pointer-events: none;
        }

        .brand-top-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #ffffff;
            margin-bottom: 2.5rem;
        }

        .brand-top-logo img {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .brand-top-logo .brand-text-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #ffffff;
            line-height: 1.1;
        }

        .brand-top-logo .brand-text-sub {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
        }

        .auth-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .auth-hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.025em;
            color: #ffffff;
            margin-bottom: 1rem;
        }

        .auth-hero-desc {
            font-size: 0.98rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.84);
            margin-bottom: 2.2rem;
            font-weight: 400;
            max-width: 480px;
        }

        .auth-features-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .auth-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .auth-feature-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #32C5F1;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .auth-feature-title {
            font-size: 0.94rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 2px;
        }

        .auth-feature-text {
            font-size: 0.82rem;
            line-height: 1.45;
            color: rgba(255, 255, 255, 0.72);
            margin: 0;
        }

        .auth-quote-card {
            background: rgba(255, 255, 255, 0.09);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 1.4rem 1.6rem;
            margin-top: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .auth-quote-text {
            font-size: 0.88rem;
            font-style: italic;
            color: rgba(255, 255, 255, 0.92);
            line-height: 1.55;
            margin-bottom: 12px;
        }

        .auth-quote-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-quote-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(50, 197, 241, 0.6);
            background: #002b24;
        }

        .auth-quote-name {
            font-size: 0.88rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }

        .auth-quote-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* -------------------------------------------
           RIGHT FORM PANEL
        ------------------------------------------- */
        .auth-form-panel {
            flex: 1 1 54%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.2rem 3.5rem;
            min-height: 100vh;
            overflow-y: auto;
        }

        .auth-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 2rem;
        }

        .back-to-site-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .back-to-site-link:hover {
            color: var(--pbz-forest-green);
            transform: translateX(-3px);
        }

        .auth-lang-btn {
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            padding: 5px 12px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .auth-lang-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .auth-form-container {
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            padding: 1rem 0 2rem 0;
        }

        .auth-page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.85rem;
            font-weight: 800;
            color: var(--pbz-text-dark);
            margin-bottom: 6px;
            letter-spacing: -0.02em;
        }

        .auth-page-subtitle {
            font-size: 0.92rem;
            color: var(--pbz-text-muted);
            margin-bottom: 1.8rem;
        }

        .form-group-custom {
            margin-bottom: 1.15rem;
        }

        .form-label-custom {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-wrapper-custom {
            position: relative;
        }

        .form-control-custom {
            width: 100%;
            height: 48px;
            padding: 10px 14px;
            font-size: 0.92rem;
            font-family: inherit;
            color: #1f2937;
            background-color: #ffffff;
            border: 1.5px solid var(--pbz-border);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .form-control-custom:focus {
            border-color: var(--pbz-forest-green);
            box-shadow: 0 0 0 3.5px rgba(0, 104, 55, 0.12);
            outline: none;
        }

        .form-control-custom::placeholder {
            color: #9ca3af;
        }

        .toggle-password-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            cursor: pointer;
            font-size: 0.95rem;
            padding: 4px;
            transition: color 0.15s ease;
        }

        .toggle-password-icon:hover {
            color: #4b5563;
        }

        .custom-check-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .custom-check-input {
            width: 17px;
            height: 17px;
            border: 1.5px solid #cbd5e1;
            border-radius: 4px;
            accent-color: var(--pbz-forest-green);
            cursor: pointer;
        }

        .custom-check-label {
            font-size: 0.84rem;
            color: #4b5563;
            cursor: pointer;
            margin: 0;
            user-select: none;
        }

        .btn-auth-primary {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, #006837 0%, #004d27 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0, 104, 55, 0.28);
            transition: all 0.25s ease;
        }

        .btn-auth-primary:hover {
            background: linear-gradient(135deg, #007d43 0%, #005c2f 100%);
            box-shadow: 0 6px 18px rgba(0, 104, 55, 0.38);
            transform: translateY(-1px);
            color: #ffffff;
        }

        .btn-auth-primary:active {
            transform: translateY(0);
        }

        /* Demo Login Box */
        .demo-auth-box {
            background: #fffdf5;
            border: 1.5px solid #fde68a;
            border-radius: 14px;
            padding: 1.1rem;
            margin-top: 1.5rem;
            position: relative;
        }

        .demo-badge {
            background: #d97706;
            color: #ffffff;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 6px;
        }

        .demo-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 2px;
        }

        .demo-subtitle {
            font-size: 0.76rem;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .demo-roles-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .demo-role-btn {
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 10px;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .demo-role-btn:hover {
            border-color: var(--pbz-forest-green);
            background: #f0fdf4;
            transform: translateY(-1px);
        }

        .demo-role-btn.active {
            border-color: var(--pbz-forest-green);
            background: #f0fdf4;
            box-shadow: 0 0 0 2px rgba(0, 104, 55, 0.15);
        }

        .demo-role-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .demo-role-desc {
            font-size: 0.68rem;
            color: #6b7280;
            line-height: 1.2;
        }

        /* Register Role Selector */
        .register-role-picker {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 1.3rem;
        }

        .role-picker-card {
            border: 1.5px solid #e5e7eb;
            background: #ffffff;
            border-radius: 12px;
            padding: 12px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .role-picker-card:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .role-picker-card.active {
            border-color: var(--pbz-forest-green);
            background: #f0fdf4;
            box-shadow: 0 0 0 2px rgba(0, 104, 55, 0.15);
        }

        .role-picker-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.2s;
        }

        .role-picker-card.active .role-picker-icon {
            background: var(--pbz-forest-green);
            color: #ffffff;
        }

        .role-picker-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.1;
        }

        .role-picker-desc {
            font-size: 0.72rem;
            color: #6b7280;
            margin-top: 2px;
        }

        .auth-switch-text {
            font-size: 0.86rem;
            color: #4b5563;
            text-align: center;
            margin-top: 1.3rem;
            margin-bottom: 0;
        }

        .auth-switch-link {
            color: var(--pbz-forest-green);
            font-weight: 700;
            text-decoration: none;
            transition: color 0.15s;
        }

        .auth-switch-link:hover {
            color: var(--pbz-dark-forest);
            text-decoration: underline;
        }

        .auth-footer {
            text-align: center;
            font-size: 0.75rem;
            color: #9ca3af;
            padding-top: 1.5rem;
        }

        @media (max-width: 991.98px) {
            .auth-split-wrapper {
                flex-direction: column;
            }
            .auth-brand-panel {
                flex: 0 0 auto;
                max-width: 100%;
                min-height: auto;
                padding: 2.5rem 1.75rem;
            }
            .auth-form-panel {
                flex: 1 1 auto;
                padding: 2rem 1.5rem;
            }
            .auth-hero-title {
                font-size: 1.8rem;
            }
            .demo-roles-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="auth-split-wrapper">
    <!-- LEFT COLUMN: BRANDING & HIGHLIGHTS -->
    <div class="auth-brand-panel">
        <div>
            <!-- PBZ Logo Lockup -->
            <a href="{{ route('home') }}" class="brand-top-logo">
                <img src="{{ asset('assets/front/img/logo/pbz-icon.png') }}" alt="PBZ Logo" onerror="this.src='{{ asset('assets/front/img/logo/pbz-logo.png') }}'">
                <div class="d-flex flex-column text-start">
                    <span class="brand-text-title">PBZ LMS</span>
                    <span class="brand-text-sub">People's Bank of Zanzibar</span>
                </div>
            </a>

            <!-- Badge -->
            <div class="auth-pill-badge">
                <i class="fa-solid fa-building-columns" style="color: #F9ED27 !important;"></i>
                <span>@yield('badge_text', 'Sovereign Banking Learning Academy')</span>
            </div>

            <!-- Hero Headline -->
            <h1 class="auth-hero-title">
                @yield('hero_title', 'Grow your banking career with expert-led courses.')
            </h1>

            <!-- Subtitle -->
            <p class="auth-hero-desc">
                @yield('hero_desc', 'Join banking professionals across Zanzibar & Tanzania. Regulatory compliance, AML/CFT, Islamic banking (PBZ Ikhlas) — all in one sovereign portal.')
            </p>

            <!-- 3 Feature Points with Solid Icons -->
            <div class="auth-features-list">
                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fa-solid fa-play"></i>
                    </div>
                    <div>
                        <div class="auth-feature-title">Learn at your own pace</div>
                        <p class="auth-feature-text">Lifetime access to every accredited course and module you enroll in.</p>
                    </div>
                </div>

                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <div class="auth-feature-title">Earn verified certificates</div>
                        <p class="auth-feature-text">Share your career milestones with tamper-proof QR-verifiable certificates.</p>
                    </div>
                </div>

                <div class="auth-feature-item">
                    <div class="auth-feature-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <div class="auth-feature-title">Learn together</div>
                        <p class="auth-feature-text">Live webinars, executive masterclasses and a collaborative banking community.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Quote Card -->
        <div class="auth-quote-card">
            <p class="auth-quote-text">
                "@yield('quote_text', 'Clear regulatory explanations, compliance assessments after every section, and an official PBZ certificate that accelerated my career trajectory.')"
            </p>
            <div class="auth-quote-author">
                <img src="@yield('quote_avatar', asset('assets/front/img/home-1/testimonial/client-01.png'))" alt="Avatar" class="auth-quote-avatar">
                <div>
                    <div class="auth-quote-name">@yield('quote_name', 'Renatus Bernardo')</div>
                    <div class="auth-quote-role">@yield('quote_role', 'Senior AML Compliance Officer · PBZ Bank')</div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: AUTHENTICATION FORM -->
    <div class="auth-form-panel">
        <!-- Topbar navigation & language selector -->
        <div class="auth-topbar">
            <a href="{{ route('home') }}" class="back-to-site-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to site</span>
            </a>

            @php
                $locales = (!empty($availableLocales) && count($availableLocales) > 0)
                    ? $availableLocales
                    : (\class_exists('\App\Http\Middleware\SetLocale') ? \App\Http\Middleware\SetLocale::getSupportedLocales() : []);
                $current = $currentLocale ?? app()->getLocale();
            @endphp

            <div class="d-flex align-items-center gap-2">
                @if (!empty($locales) && count($locales) > 1)
                    <div class="dropdown">
                        @php $currentMeta = $locales[$current] ?? reset($locales); @endphp
                        <button class="auth-lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-globe me-1 text-muted"></i>
                            <span>{{ $currentMeta['native'] ?? $currentMeta['name'] ?? 'English' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border py-1" style="min-width: 140px; font-size: 0.82rem;">
                            @foreach ($locales as $code => $meta)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between py-1.5 {{ $code === $current ? 'active fw-bold' : '' }}" href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}">
                                        <span>{{ $meta['native'] ?? $meta['name'] }}</span>
                                        @if ($code === $current)
                                            <i class="fa-solid fa-check text-success ms-2" style="font-size: 0.72rem;"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <span class="auth-lang-btn">
                        <i class="fa-solid fa-globe me-1 text-muted"></i>
                        <span>English</span>
                    </span>
                @endif
                <span class="auth-lang-btn" title="PBZ LMS Security" style="cursor: default;">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                </span>
            </div>
        </div>

        <!-- Centered Form Content -->
        <div class="auth-form-container">
            @yield('form_content')
        </div>

        <!-- Footer Copyright -->
        <div class="auth-footer">
            &copy; {{ date('Y') }} The People's Bank of Zanzibar (PBZ). All rights reserved.
        </div>
    </div>
</div>

<!-- Core Scripts -->
<script src="{{ asset('assets/front/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
{!! ToastMagic::scripts() !!}

@stack('scripts')

</body>
</html>

@php
    $mobileMenu = $frontendMenus['mobile-navigation'] ?? ($frontendMenus['main-navigation'] ?? []);
    $siteName = site_name();
    $mobileLogo = branding_asset(['dark_logo_path', 'primary_logo_path', 'logos.secondary', 'logos.primary'], 'assets/front/img/logo/black-logo.svg');

    $locales = (!empty($availableLocales) && count($availableLocales) > 0)
        ? $availableLocales
        : \App\Http\Middleware\SetLocale::getSupportedLocales();
    $current = $currentLocale ?? app()->getLocale();

    $phone = $footerContact['phone'] ?? '+255 24 223 1118 / 0800 750 075';
    $email = $footerContact['email'] ?? 'info@pbzbank.co.tz';
    $address = $footerContact['address'] ?? 'Head Office: Mpirani, P.O. Box 1116, Zanzibar, Tanzania';
    $phoneLink = $phone ? preg_replace('/[^\d\+]/', '', explode('/', $phone)[0]) : null;
@endphp

<!-- Modern Offcanvas Mobile Navigation Drawer -->
<div class="fix-area">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper d-flex flex-column h-100">
            <div class="offcanvas__content p-3 p-md-4 d-flex flex-column flex-grow-1">
                <!-- Top Bar: Logo & Close Button -->
                <div class="offcanvas__top mb-3 d-flex justify-content-between align-items-center pb-2.5 border-bottom">
                    <div class="offcanvas__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ $mobileLogo }}" alt="{{ $siteName }} logo" style="max-height: 38px; width: auto;">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button type="button" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" aria-label="Close menu">
                            <i class="fas fa-times text-dark"></i>
                        </button>
                    </div>
                </div>

                <!-- User Welcome / Auth Banner -->
                @auth
                    @php $user = auth()->user(); @endphp
                    <div class="user-mobile-card p-2.5 rounded-2 bg-light border mb-3 d-flex align-items-center gap-2.5">
                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-size: 0.85rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden flex-grow-1">
                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.82rem;">{{ $user->name }}</div>
                            <span class="badge bg-primary text-white rounded-pill px-2 py-0.5 text-uppercase" style="font-size: 0.65rem;">
                                {{ $user->role ?? 'Learner' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="user-mobile-card p-2.5 rounded-2 bg-primary-subtle border border-primary-subtle mb-3 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fw-bold text-primary" style="font-size: 0.82rem;">PBZ Academy Portal</div>
                            <div class="text-muted" style="font-size: 0.72rem;">Sign in to access your courses</div>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-semibold" style="font-size: 0.76rem;">
                            Login
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Container for MeanMenu -->
                @php
                    $hasActiveSubs = \Illuminate\Support\Facades\Schema::hasTable('subscription_plans')
                        && \App\Models\SubscriptionPlan::where('status', 'active')->exists();
                @endphp
                <nav class="mobile-menu fix mb-3">
                    <ul class="d-none" data-fallback-menu>
                        @foreach ($mobileMenu as $item)
                            @php
                                $itemUrl = $item['url'] ?? '#';
                                $itemTitle = $item['title'] ?? 'Menu Item';
                                $isSubItem = Str::contains(strtolower($itemTitle), 'subscription') || Str::contains($itemUrl, '/subscriptions');
                                if ($isSubItem && !$hasActiveSubs) {
                                    continue;
                                }
                            @endphp
                            <li><a href="{{ $itemUrl }}">{{ $itemTitle }}</a></li>
                        @endforeach
                    </ul>
                </nav>

                <!-- Language Selector in Drawer -->
                @if (!empty($locales) && count($locales) > 1)
                    <div class="mobile-lang-box mb-3 p-2.5 rounded-2 bg-light border">
                        <div class="small fw-semibold text-muted mb-1.5" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-language me-1 text-primary"></i> SELECT LANGUAGE
                        </div>
                        <select onchange="window.location.href=this.value" class="form-select form-select-sm rounded-2 shadow-none" style="font-size: 0.82rem; font-weight: 600;">
                            @foreach ($locales as $code => $meta)
                                <option value="{{ request()->fullUrlWithQuery(['lang' => $code]) }}" {{ $code === $current ? 'selected' : '' }}>
                                    {{ $meta['flag'] }} {{ $meta['native'] }} ({{ $meta['name'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Contact & Bank Office Details -->
                <div class="mobile-contact-box mt-auto pt-3 border-top">
                    <h6 class="fw-bold text-dark text-uppercase mb-2" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                        PBZ SUPPORT &amp; HEAD OFFICE
                    </h6>
                    <ul class="list-unstyled mb-3 small" style="font-size: 0.76rem;">
                        @if ($phone)
                            <li class="mb-1.5">
                                <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="text-muted text-decoration-none d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-phone text-warning" style="width: 14px;"></i>
                                    <span>{{ $phone }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($email)
                            <li class="mb-1.5">
                                <a href="mailto:{{ $email }}" class="text-muted text-decoration-none d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-envelope text-info" style="width: 14px;"></i>
                                    <span>{{ $email }}</span>
                                </a>
                            </li>
                        @endif
                        @if ($address)
                            <li class="text-muted d-flex align-items-start gap-2">
                                <i class="fa-solid fa-location-dot text-danger mt-0.5" style="width: 14px;"></i>
                                <span style="line-height: 1.35;">{{ $address }}</span>
                            </li>
                        @endif
                    </ul>

                    @if (!empty($footerSocialLinks))
                        <div class="d-flex align-items-center gap-2 mb-3">
                            @foreach ($footerSocialLinks as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.78rem;">
                                    <i class="{{ $social['icon'] ?? 'fab fa-link' }}"></i>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Bottom Sticky Auth CTA -->
                <div class="pt-2">
                    @auth
                        @php
                            $user = auth()->user();
                            $targetRoute = route('home');
                            $btnLabel = __('frontend.dashboard');
                            if ($user->isAdmin()) { $targetRoute = route('admin.dashboard'); $btnLabel = 'Admin Dashboard'; }
                            elseif ($user->isInstructor()) { $targetRoute = route('instructor.dashboard'); $btnLabel = 'Instructor Dashboard'; }
                            elseif ($user->isStudent()) { $targetRoute = route('student.dashboard'); $btnLabel = 'My Dashboard'; }
                        @endphp
                        <a href="{{ $targetRoute }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>{{ $btnLabel }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span>{{ __('frontend.login') }}</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div>

<!-- Modern PBZ LMS Header Section -->
<header id="header-sticky" class="header-1 pbz-main-header border-bottom">
    <div class="container-fluid px-lg-4">
        <div class="d-flex align-items-center justify-content-between header-inner-wrapper">
            <!-- Brand Logo -->
            <div class="logo header-logo-area d-flex align-items-center">
                @php $siteName = site_name(); @endphp
                <a href="{{ route('home') }}" class="header-logo d-inline-block">
                    <img src="{{ branding_asset(['dark_logo_path', 'logos.secondary', 'primary_logo_path', 'logos.primary'], 'assets/front/img/logo/black-logo.svg') }}"
                        alt="{{ $siteName }} logo" class="brand-logo-img">
                </a>
            </div>

            <!-- Center: Navigation Menu -->
            <div class="main-menu-navigation d-none d-lg-block">
                <nav id="mobile-menu" class="main-nav-bar">
                    <ul class="d-flex align-items-center mb-0 list-unstyled gap-1 gap-xl-2">
                        @php $mainMenu = $frontendMenus['main-navigation'] ?? []; @endphp
                        @if (!empty($mainMenu))
                            @include('partials.menu-items', [
                                'items' => $mainMenu,
                                'isRoot' => true,
                            ])
                        @else
                            <li class="active"><a href="{{ route('home') }}">{{ __('frontend.home') }}</a></li>
                            <li><a href="{{ route('courses') }}">{{ __('frontend.courses') }}</a></li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Right Actions: Search, Auth, and Mobile Toggle -->
            <div class="header-actions-area d-flex align-items-center gap-2">
                <!-- Search Button -->
                <a href="#" class="search-toggler btn btn-sm border rounded-circle d-flex align-items-center justify-content-center header-action-circle" aria-label="Search">
                    <i class="fa-regular fa-magnifying-glass" style="font-size: 0.85rem;"></i>
                </a>

                <!-- Auth Buttons with PBZ Green/Yellow Theme -->
                @if(Auth::check())
                    @php $currentUser = Auth::user(); @endphp
                    @include('partials.notification-dropdown', ['currentUser' => $currentUser])

                    @php
                        $userRole = 'guest';
                        if($currentUser->isAdmin()) $userRole = 'admin';
                        elseif($currentUser->isInstructor()) $userRole = 'instructor';
                        elseif($currentUser->isStudent()) $userRole = 'student';
                        
                        $dashboardRoute = route('home');
                        $dashboardText = __('frontend.dashboard');
                        
                        if($userRole === 'admin') { 
                            $dashboardRoute = route('admin.dashboard'); 
                            $dashboardText = __('frontend.admin_dashboard'); 
                        } elseif($userRole === 'instructor') { 
                            $dashboardRoute = route('instructor.dashboard'); 
                            $dashboardText = __('frontend.instructor_dashboard'); 
                        } elseif($userRole === 'student') { 
                            $dashboardRoute = route('student.dashboard'); 
                            $dashboardText = __('frontend.my_dashboard'); 
                        }
                    @endphp

                    <a href="{{ $dashboardRoute }}" class="btn btn-sm pbz-btn-theme rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-gauge-high" style="color: #F9ED27; font-size: 0.75rem;"></i>
                        <span>{{ $dashboardText }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm pbz-btn-theme rounded-pill px-3.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5 shadow-sm" style="font-size: 0.82rem;">
                        <i class="fa-solid fa-arrow-right-to-bracket" style="color: #F9ED27; font-size: 0.75rem;"></i>
                        <span>{{ __('frontend.login') }}</span>
                    </a>
                @endif

                <!-- Mobile Hamburger Toggle -->
                <div class="header__hamburger d-lg-none ms-1">
                    <button type="button" class="sidebar__toggle btn btn-sm border rounded-2 d-flex align-items-center justify-content-center p-2" aria-label="Open Mobile Menu" style="width: 38px; height: 38px; background: rgba(255, 255, 255, 0.7); border-color: rgba(0, 43, 36, 0.18) !important;">
                        <i class="fas fa-bars" style="color: #002b24; font-size: 1rem;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

@include('partials.search')

<style>
    .pbz-main-header {
        position: relative;
        z-index: 1020;
        background: #F9ED27; /* Bright Gold / Yellow: Radiating sun and rays of PBZ seal */
        border-bottom: 1px solid #e5d71b !important;
        transition: all 0.25s ease;
    }
    .pbz-main-header.sticky {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: #F9ED27 !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.10);
        border-bottom: 1px solid #e5d71b !important;
        z-index: 1040;
    }
    .header-inner-wrapper {
        min-height: 66px;
    }
    .brand-logo-img {
        max-height: 42px;
        width: auto;
        display: block;
    }
    .header-action-circle {
        width: 36px;
        height: 36px;
        padding: 0;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 43, 36, 0.25) !important;
        color: #002b24;
        transition: all 0.15s ease;
    }
    .header-action-circle:hover {
        background: #003730;
        border-color: #003730 !important;
        color: #ffffff;
    }
    .header-action-circle:hover i {
        color: #ffffff !important;
    }

    /* System Green-Yellow Button */
    .pbz-btn-theme {
        background-color: #003730; /* Deep PBZ green */
        border-color: #002822;
        color: #ffffff;
        transition: all 0.2s ease;
    }
    .pbz-btn-theme:hover {
        background-color: #004d43;
        border-color: #004d43;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
    .pbz-btn-theme:hover i {
        color: #F9ED27 !important;
    }

    /* Modern Navigation Links */
    .main-nav-bar ul {
        margin: 0;
        padding: 0;
    }
    .main-nav-bar ul li {
        position: relative;
        display: inline-block;
    }
    .main-nav-bar ul li a {
        display: inline-flex;
        align-items: center;
        padding: 8px 13px;
        font-size: 0.88rem;
        font-weight: 700;
        color: #002b24; /* Deep Islamic green */
        text-decoration: none;
        border-radius: 6px;
        position: relative;
        transition: all 0.18s ease;
    }
    .main-nav-bar ul li a:hover {
        color: #ffffff !important;
        background-color: #004d43;
    }
    .main-nav-bar ul li.active > a,
    .main-nav-bar ul li a.active-menu-link {
        color: #ffffff !important;
        background-color: #003730 !important;
        box-shadow: 0 2px 6px rgba(0, 43, 36, 0.25);
    }

    /* Submenus */
    .main-nav-bar ul li .submenu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 200px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 6px 0;
        display: none;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 1050;
    }
    .main-nav-bar ul li:hover > .submenu {
        display: block;
    }
    .main-nav-bar ul li .submenu li {
        display: block;
    }
    .main-nav-bar ul li .submenu li a {
        padding: 7px 16px;
        width: 100%;
        font-size: 0.82rem;
        color: #475569;
        display: block;
        box-shadow: none !important;
    }
    .main-nav-bar ul li .submenu li a:hover {
        background-color: #f0fdf4;
        color: #006837;
    }
</style>

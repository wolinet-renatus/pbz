<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<!--<< Header Area >>-->

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="mhquickdev">
    <meta name="description" content="{{ $metaDescription ?? site_name() . ' - ' . site_tagline() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ======== Page title ============ -->
    <title>{{ (!empty($pageTitle) && $pageTitle !== site_name()) ? $pageTitle . ' | ' . site_name() : site_name() . ' - ' . site_tagline() }}</title>

    @stack('meta')

    <!--<< Favcion >>-->
    @php($favicon = branding_asset(['favicon_path', 'logos.favicon', 'favicon'], 'assets/front/img/favicon.svg'))
    <link rel="icon" type="image/png" href="{{ $favicon }}">
    <link rel="shortcut icon" href="{{ $favicon }}">

    <!--<< CSS Styles >>-->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/instructor/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/student/saas-dashboard.css') }}">

    {!! ToastMagic::styles() !!}

    @stack('styles')
    @include('partials.dynamic-styles')
</head>

<body class="pbz-saas-body-app">
    <!-- Back To Top Button -->
    <button id="back-top" class="back-to-top show">
        <i class="fa-regular fa-arrow-up"></i>
    </button>

    @include('partials.impersonation-banner')

    <div class="pbz-saas-portal-wrapper">
        @yield('content')
    </div>

    @include('cookie-consent::index')

    <!--<< All JS Plugins >>-->
    <script src="{{ asset('assets/front/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/parallaxie.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
    <script src="{{ asset('assets/front/js/instructor/script.js') }}"></script>
    <script src="{{ asset('assets/front/js/sweetalert2@11.js') }}"></script>

    {!! ToastMagic::scripts() !!}

    <script>
        $(document).ready(function() {
            // Sidebar Mobile Drawer Toggle
            $(document).on('click', '#pbz-sidebar-toggle', function() {
                $('#pbz-saas-sidebar').toggleClass('open');
                $('#pbz-sidebar-overlay').toggleClass('active');
            });
            $(document).on('click', '#pbz-sidebar-overlay', function() {
                $('#pbz-saas-sidebar').removeClass('open');
                $(this).removeClass('active');
            });

            // Global search keyboard shortcut '/'
            $(document).on('keydown', function(e) {
                if (e.key === '/' && !$(e.target).is('input, textarea, select')) {
                    e.preventDefault();
                    $('#pbz-global-search').focus();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>

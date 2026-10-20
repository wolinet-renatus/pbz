@extends('partials.admin-header')

@section('title', $title ?? 'Admin Dashboard')

@section('content')

    @include('partials.admin-sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            @if(!request()->routeIs('admin.dashboard'))
                <div class="section-header">
                    <h1>@yield('title', 'Dashboard')</h1>
                    @hasSection('breadcrumb')
                        <div class="section-header-breadcrumb">
                            @yield('breadcrumb')
                        </div>
                    @endif
                </div>
            @endif

            @yield('main-content')

        </section>
        @include('partials.admin-footer')

    </div>

@endsection
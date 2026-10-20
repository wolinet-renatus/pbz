@extends('layouts.app')

@section('content')
    <section class="mhq-hero-section fix mhq-hero-1 bg-cover pt-0"
        style="background-image: url('{{ asset('assets/front/img/home-1/hero/hero-bg.jpg') }}');">
        <div class="hero-shape-1 float-bob-x">
            <img src="{{ asset('assets/front/img/home-1/hero/shape-01.png') }}" alt="img">
        </div>
        <div class="hero-shape-2 float-bob-y">
            <img src="{{ asset('assets/front/img/home-1/hero/shape-02.png') }}" alt="img">
        </div>
        <div class="hero-shape-3 float-bob-y">
            <img src="{{ asset('assets/front/img/home-1/hero/shape-03.png') }}" alt="img">
        </div>
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-5 col-md-8">
                    <div class="mhq-login-wrapper bg-white wow fadeInUp" data-wow-delay=".3s">
                        <div class="mhq-login-header text-center mb-4">
                            <?php $siteName = site_name(); ?>
                            <a href="{{ route('home') }}" class="login-logo mb-3">
                                <img src="{{ branding_asset(['dark_logo_path', 'logos.secondary', 'primary_logo_path', 'logos.primary'], 'assets/front/img/logo/black-logo.svg') }}" alt="{{ $siteName }} logo">
                            </a>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s">Verify Your Email</h2>
                            <p class="wow fadeInUp" data-wow-delay=".3s">
                                Before proceeding, please check your email for a verification link.
                            </p>
                        </div>

                        @if (session('resent'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif

                        <form action="{{ route('verification.resend') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" class="theme-btn w-100 mb-3 wow fadeInUp" data-wow-delay=".4s">
                                Resend Verification Email
                                <i class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center wow fadeInUp" data-wow-delay=".5s">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link back-btn text-muted p-0">Log out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

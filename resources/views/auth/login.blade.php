@extends('layouts.auth')

@section('title', __('auth.sign_in'))
@section('badge_text', 'Bank of Tanzania Certified Learning Academy')
@section('hero_title', 'Grow your banking career with expert-led courses.')
@section('hero_desc', 'Join banking professionals across Zanzibar & Tanzania. Video lessons, regulatory compliance, AML/CFT, Islamic banking (PBZ Ikhlas) — all in one sovereign portal.')
@section('quote_text', 'Clear regulatory explanations, compliance assessments after every section, and an official PBZ certificate that accelerated my career.')
@section('quote_name', 'Renatus Bernardo')
@section('quote_role', 'Senior AML Compliance Officer · PBZ Bank')
@section('quote_avatar', asset('assets/front/img/home-1/testimonial/client-01.png'))

@section('form_content')
    <div class="text-start">
        <h2 class="auth-page-title">Welcome Back</h2>
        <p class="auth-page-subtitle">Sign in to continue your learning journey.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success py-2 px-3 small rounded-3 mb-3">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf

        <!-- Email input -->
        <div class="form-group-custom">
            <label class="form-label-custom" for="email">Email address</label>
            <div class="input-wrapper-custom">
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    placeholder="name@pbzbank.co.tz" class="form-control-custom @error('email') is-invalid border-danger @enderror"
                    required autocomplete="email" autofocus>
            </div>
            @error('email')
                <div class="text-danger small mt-1.5 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password input -->
        <div class="form-group-custom">
            <div class="d-flex justify-content-between align-items-center mb-1.5">
                <label class="form-label-custom mb-0" for="password">Password</label>
                <a href="{{ route('password.request') }}" class="auth-switch-link small" style="font-size: 0.82rem;">Forgot password?</a>
            </div>
            <div class="input-wrapper-custom">
                <input type="password" name="password" id="password" placeholder="Enter your password"
                    class="form-control-custom @error('password') is-invalid border-danger @enderror" required
                    autocomplete="current-password">
                <i class="fa-regular fa-eye toggle-password-icon" id="togglePassword"></i>
            </div>
            @error('password')
                <div class="text-danger small mt-1.5 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Keep me signed in -->
        <div class="custom-check-wrapper my-3">
            <input class="custom-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-check-label" for="remember">Keep me signed in</label>
        </div>

        <x-recaptcha-widget class="mb-3" action="login" />

        <!-- Login Button -->
        <button type="submit" class="btn-auth-primary" id="loginSubmitBtn">
            <span>Sign In</span>
            <i class="fa-solid fa-arrow-right"></i>
        </button>

        <!-- Demo Accounts Section -->
        <div class="demo-auth-box">
            <span class="demo-badge">INSTITUTIONAL DEMO ACCESS</span>
            <div class="demo-title">
                <i class="fa-solid fa-bolt text-warning"></i>
                <span>Institutional Banking Roles</span>
            </div>
            <div class="demo-subtitle">
                Select an institutional role to sign in instantly. Password for all: <span class="fw-bold text-dark">password123</span>
            </div>
            <div class="demo-roles-grid">
                <button type="button" class="demo-role-btn" data-email="manager.forodhani@pbzbank.co.tz" data-password="password123" data-role="Branch Manager" id="btnRoleManager">
                    <div class="demo-role-name">
                        <i class="fa-solid fa-building-shield text-success"></i>
                        <span>Branch Manager</span>
                    </div>
                    <div class="demo-role-desc">Forodhani Main Branch · Oversight Matrix</div>
                </button>
                <button type="button" class="demo-role-btn" data-email="renatus.bernardo@pbzbank.co.tz" data-password="password123" data-role="Senior Teller" id="btnRoleTeller">
                    <div class="demo-role-name">
                        <i class="fa-solid fa-id-badge text-warning"></i>
                        <span>Senior Teller</span>
                    </div>
                    <div class="demo-role-desc">Forodhani Branch · Active Countdowns</div>
                </button>
                <button type="button" class="demo-role-btn" data-email="compliance@pbzbank.co.tz" data-password="password123" data-role="Compliance Faculty" id="btnRoleCompliance">
                    <div class="demo-role-name">
                        <i class="fa-solid fa-scale-balanced text-primary"></i>
                        <span>Compliance Faculty</span>
                    </div>
                    <div class="demo-role-desc">BOT Mandates &amp; Trainee Audit</div>
                </button>
                <button type="button" class="demo-role-btn" data-email="admin@pbzbank.co.tz" data-password="password123" data-role="Executive Admin" id="btnRoleAdmin">
                    <div class="demo-role-name">
                        <i class="fa-solid fa-shield-halved text-danger"></i>
                        <span>Executive Admin</span>
                    </div>
                    <div class="demo-role-desc">PBZ Governance &amp; Full Portal Access</div>
                </button>
            </div>
        </div>

        <!-- Switch to Register -->
        <p class="auth-switch-text">
            Don't have an account? <a href="{{ route('register') }}" class="auth-switch-link">Create one free</a>
        </p>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const email = document.getElementById('email');
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('loginSubmitBtn');
        const demoRoleBtns = document.querySelectorAll('.demo-role-btn');

        // Password visibility toggle
        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const isPassword = password.getAttribute('type') === 'password';
                password.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('fa-eye', !isPassword);
                this.classList.toggle('fa-eye-slash', isPassword);
            });
        }

        // Demo role autofill and instant sign-in
        demoRoleBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const roleEmail = this.getAttribute('data-email');
                const rolePassword = this.getAttribute('data-password') || 'password123';
                const roleName = this.getAttribute('data-role') || 'Institutional User';

                email.value = roleEmail;
                password.value = rolePassword;

                demoRoleBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Visual micro-feedback
                email.style.borderColor = '#006837';
                password.style.borderColor = '#006837';

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span>Signing in as ' + roleName + '...</span> <i class="fa fa-spinner fa-spin ms-2"></i>';
                }

                // Instantly submit the login form
                setTimeout(() => {
                    loginForm.submit();
                }, 150);
            });
        });

        // Form submit feedback
        if (loginForm && submitBtn) {
            loginForm.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Signing in...</span> <i class="fa fa-spinner fa-spin ms-2"></i>';
            });
        }
    });
</script>
@endpush
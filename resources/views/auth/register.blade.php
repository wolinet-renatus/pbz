@extends('layouts.auth')

@section('title', __('auth.create_your_account'))
@section('badge_text', 'Bank of Tanzania Certified Learning Academy')
@section('hero_title', 'Start learning — or start instructing — today.')
@section('hero_desc', 'Join banking professionals across Zanzibar & Tanzania. Video lessons, regulatory compliance, live webinars, certificates — all in one sovereign portal.')
@section('quote_text', 'I completed the Islamic Banking and AML certification in a month to step into my new advisory role with confidence.')
@section('quote_name', 'Fatma Juma Said')
@section('quote_role', 'Treasury & Compliance Analyst · PBZ Bank')
@section('quote_avatar', asset('assets/front/img/home-1/testimonial/client-02.png'))

@section('form_content')
    <div class="text-start">
        <h2 class="auth-page-title">Create Your Account</h2>
        <p class="auth-page-subtitle">Join our sovereign banking academy. Setup takes only a minute.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Role Switcher (Student vs Instructor) -->
    <div class="mb-3">
        <label class="form-label-custom mb-1.5">Select Account Type</label>
        <div class="register-role-picker">
            <div class="role-picker-card active" id="roleCardStudent" role="button">
                <div class="role-picker-icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="role-picker-title">Student</div>
                    <div class="role-picker-desc">Access enrolled courses</div>
                </div>
            </div>

            <a href="{{ route('instructor.register') }}" class="role-picker-card" id="roleCardInstructor">
                <div class="role-picker-icon">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <div>
                    <div class="role-picker-title">Instructor</div>
                    <div class="role-picker-desc">Teach & deliver courses</div>
                </div>
            </a>
        </div>
    </div>

    <form action="{{ route('register') }}" method="POST" id="registerForm">
        @csrf

        <!-- Full Name input with auto-split to first_name and last_name -->
        <div class="form-group-custom">
            <label class="form-label-custom" for="full_name">Full name</label>
            <div class="input-wrapper-custom">
                <input type="text" id="full_name"
                    value="{{ old('name', (old('first_name') ? old('first_name') . ' ' . old('last_name') : '')) }}"
                    placeholder="Enter your full name" class="form-control-custom @if($errors->has('first_name') || $errors->has('last_name')) is-invalid border-danger @endif"
                    required autocomplete="name" autofocus>
            </div>
            <!-- Hidden inputs to satisfy backend validation -->
            <input type="hidden" name="first_name" id="first_name" value="{{ old('first_name') }}">
            <input type="hidden" name="last_name" id="last_name" value="{{ old('last_name') }}">
            @if ($errors->has('first_name'))
                <div class="text-danger small mt-1 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('first_name') }}
                </div>
            @elseif ($errors->has('last_name'))
                <div class="text-danger small mt-1 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $errors->first('last_name') }}
                </div>
            @endif
        </div>

        <!-- Email input -->
        <div class="form-group-custom">
            <label class="form-label-custom" for="email">Email address</label>
            <div class="input-wrapper-custom">
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    placeholder="name@pbzbank.co.tz" class="form-control-custom @error('email') is-invalid border-danger @enderror"
                    required autocomplete="email">
            </div>
            @error('email')
                <div class="text-danger small mt-1 fw-semibold" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password and Confirm Side by Side -->
        <div class="row g-2 mb-2">
            <div class="col-sm-6">
                <div class="form-group-custom mb-0">
                    <label class="form-label-custom" for="password">Password</label>
                    <div class="input-wrapper-custom">
                        <input type="password" name="password" id="password" placeholder="Min. 8 characters"
                            class="form-control-custom @error('password') is-invalid border-danger @enderror" required
                            autocomplete="new-password">
                        <i class="fa-regular fa-eye toggle-password-icon" id="togglePassword"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group-custom mb-0">
                    <label class="form-label-custom" for="password_confirmation">Confirm</label>
                    <div class="input-wrapper-custom">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Repeat password" class="form-control-custom" required
                            autocomplete="new-password">
                        <i class="fa-regular fa-eye toggle-password-icon" id="toggleConfirmPassword"></i>
                    </div>
                </div>
            </div>
        </div>
        @error('password')
            <div class="text-danger small mt-1 mb-2 fw-semibold" style="font-size: 0.8rem;">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
            </div>
        @enderror

        <!-- Terms Agreement Checkbox -->
        <div class="custom-check-wrapper my-3">
            <input class="custom-check-input" type="checkbox" name="terms" id="terms" value="1" required checked>
            <label class="custom-check-label" for="terms" style="font-size: 0.8rem; line-height: 1.4;">
                By creating an account you agree to our
                <a href="{{ url('/pages/terms-and-conditions') }}" target="_blank" class="text-success text-decoration-underline fw-semibold">Terms</a>
                and
                <a href="{{ url('/pages/privacy-policy') }}" target="_blank" class="text-success text-decoration-underline fw-semibold">Privacy Policy</a>.
            </label>
        </div>

        <x-recaptcha-widget class="mb-3" action="student_register" />

        <!-- Submit Button -->
        <button type="submit" class="btn-auth-primary" id="registerSubmitBtn">
            <span>Create Account</span>
            <i class="fa-solid fa-arrow-right"></i>
        </button>

        <!-- Switch to Login -->
        <p class="auth-switch-text">
            Already have an account? <a href="{{ route('login') }}" class="auth-switch-link">Sign In</a>
        </p>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fullNameInput = document.getElementById('full_name');
        const firstNameInput = document.getElementById('first_name');
        const lastNameInput = document.getElementById('last_name');
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.getElementById('registerSubmitBtn');

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const passwordConfirmation = document.getElementById('password_confirmation');

        function syncNames() {
            const raw = (fullNameInput.value || '').trim();
            if (!raw) return;
            const parts = raw.split(/\s+/);
            firstNameInput.value = parts[0] || '';
            lastNameInput.value = parts.length > 1 ? parts.slice(1).join(' ') : parts[0];
        }

        if (fullNameInput) {
            fullNameInput.addEventListener('input', syncNames);
            fullNameInput.addEventListener('change', syncNames);
            if (fullNameInput.value) {
                syncNames();
            }
        }

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const isPass = password.getAttribute('type') === 'password';
                password.setAttribute('type', isPass ? 'text' : 'password');
                this.classList.toggle('fa-eye', !isPass);
                this.classList.toggle('fa-eye-slash', isPass);
            });
        }

        if (toggleConfirmPassword && passwordConfirmation) {
            toggleConfirmPassword.addEventListener('click', function () {
                const isPass = passwordConfirmation.getAttribute('type') === 'password';
                passwordConfirmation.setAttribute('type', isPass ? 'text' : 'password');
                this.classList.toggle('fa-eye', !isPass);
                this.classList.toggle('fa-eye-slash', isPass);
            });
        }

        if (registerForm && submitBtn) {
            registerForm.addEventListener('submit', function () {
                syncNames();
                if (!firstNameInput.value || !lastNameInput.value) {
                    syncNames();
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Creating account...</span> <i class="fa fa-spinner fa-spin"></i>';
            });
        }
    });
</script>
@endpush
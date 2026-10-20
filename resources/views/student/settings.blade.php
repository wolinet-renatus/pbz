@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Account Settings'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-user-shield"></i> SECURITY &amp; PROFILE CREDENTIALS
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">PBZ Banking Officer Profile &amp; Account Settings</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Manage your personal profile, institutional authentication credentials, and communication preferences.</p>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-circle-check text-success" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Status:</span> <strong class="text-dark">Active Banking Officer</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compact 2-Column Responsive Grid (Mobile First, Minimal Scrolling) -->
            <div class="row g-3">
                
                <!-- Left Column: Profile Information -->
                <div class="col-lg-6 col-12">
                    <div class="card border rounded-3 p-3.5 bg-white h-100 shadow-none" style="border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #e0f2fe; color: #0099cc; font-size: 12px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <h5 class="fw-bold mb-0 text-dark" style="font-size: 14px;">{{ __('student.profile_information') }}</h5>
                        </div>

                        <form id="profileForm" action="{{ route('student.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Compact Avatar Upload -->
                            <div class="d-flex align-items-center gap-3 mb-3 p-2.5 rounded-2 border" style="background: #f8fafc; border-color: #e2e8f0;">
                                <div class="position-relative" style="width: 52px; height: 52px; cursor: pointer;" onclick="document.getElementById('avatarInput').click();">
                                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('assets/front/img/home-1/courses/client-01.png') }}"
                                         alt="{{ $user->name }}" id="avatarPreview"
                                         class="w-100 h-100 rounded-circle border" style="object-fit: cover; border-color: #cbd5e1 !important;">
                                    <div class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                         style="width: 20px; height: 20px; font-size: 10px; color: #006837; border: 1px solid #cbd5e1;">
                                        <i class="fa-solid fa-camera"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="profile_photo" id="avatarInput" accept="image/*" class="d-none">
                                    <button type="button" class="btn btn-sm btn-outline-secondary px-2.5 py-0.5 rounded-2 mb-1" style="font-size: 11px;" onclick="document.getElementById('avatarInput').click();">
                                        {{ __('student.change_photo') }}
                                    </button>
                                    <div class="text-muted" style="font-size: 10.5px;">{{ __('student.recommended_size') }}</div>
                                </div>
                                @error('profile_photo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Full Name -->
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    {{ __('student.full_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control form-control-sm rounded-2 @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required placeholder="{{ __('student.enter_full_name') }}"
                                       style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                @error('name')
                                    <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control form-control-sm rounded-2 @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required placeholder="Enter your email address"
                                       style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                @error('email')
                                    <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    {{ __('student.phone_number') }}
                                </label>
                                <input type="tel" name="phone" class="form-control form-control-sm rounded-2 @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}" placeholder="{{ __('instructor.enter_phone') }}"
                                       style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                @error('phone')
                                    <div class="invalid-feedback" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Institutional Banking Section Divider -->
                            <div class="p-2 mb-2.5 rounded-2" style="background: #e6f4ea; border-left: 3px solid #006837;">
                                <div class="fw-bold text-dark" style="font-size: 11.5px; color: #006837 !important;">
                                    <i class="fa-solid fa-building-columns me-1"></i> PBZ Institutional Assignment
                                </div>
                            </div>

                            <div class="row g-2 mb-2.5">
                                <!-- Employee ID -->
                                <div class="col-sm-6 col-12">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Employee ID</label>
                                    <input type="text" name="employee_id" class="form-control form-control-sm rounded-2"
                                           value="{{ old('employee_id', $user->employee_id ?: 'PBZ-'.str_pad($user->id, 5, '0', STR_PAD_LEFT)) }}"
                                           placeholder="PBZ-00000" style="font-size: 12px; height: 35px;">
                                </div>

                                <!-- Job Title / Role -->
                                <div class="col-sm-6 col-12">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Job Title</label>
                                    <input type="text" name="job_title" class="form-control form-control-sm rounded-2"
                                           value="{{ old('job_title', $user->job_title ?: 'Frontline Banking Officer') }}"
                                           placeholder="e.g. Senior Teller" style="font-size: 12px; height: 35px;">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <!-- Branch -->
                                <div class="col-sm-6 col-12">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Bank Branch</label>
                                    <select name="branch_id" class="form-select form-select-sm rounded-2" style="font-size: 12px; height: 35px;">
                                        <option value="">Select PBZ Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }} ({{ $branch->region }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Department -->
                                <div class="col-sm-6 col-12">
                                    <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">Department</label>
                                    <select name="department_id" class="form-select form-select-sm rounded-2" style="font-size: 12px; height: 35px;">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-2 border-top d-flex align-items-center justify-content-end gap-2" style="border-color: #f1f5f9 !important;">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 px-3 py-1" style="font-size: 11.5px;" onclick="document.getElementById('profileForm').reset()">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1.5"
                                        style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
                                    <i class="fa-solid fa-floppy-disk"></i> {{ __('student.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Security & Password -->
                <div class="col-lg-6 col-12">
                    <div class="card border rounded-3 p-3.5 bg-white h-100 shadow-none" style="border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #e0f2fe; color: #0099cc; font-size: 12px;">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <h5 class="fw-bold mb-0 text-dark" style="font-size: 14px;">{{ __('student.change_password') }}</h5>
                        </div>

                        <form id="passwordForm" action="{{ route('student.settings.update') }}" method="POST">
                            @csrf

                            <!-- Current Password -->
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    {{ __('student.current_password') }}
                                </label>
                                <div class="position-relative">
                                    <input type="password" name="current_password" id="currentPassword"
                                           class="form-control form-control-sm rounded-2 pe-5 @error('current_password') is-invalid @enderror"
                                           placeholder="{{ __('student.enter_current_password') }}"
                                           style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                    <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted pe-2.5"
                                            onclick="togglePassword('currentPassword', this)" style="font-size: 12px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-2.5">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    {{ __('student.new_password') }}
                                </label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="newPassword"
                                           class="form-control form-control-sm rounded-2 pe-5 @error('password') is-invalid @enderror"
                                           placeholder="{{ __('student.enter_new_password') }}"
                                           style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                    <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted pe-2.5"
                                            onclick="togglePassword('newPassword', this)" style="font-size: 12px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div class="text-muted" style="font-size: 10.5px;">{{ __('student.min_password_length') }}</div>
                                @error('password')
                                    <div class="text-danger small mt-1" style="font-size: 11px;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="mb-3">
                                <label class="form-label text-dark fw-semibold mb-1" style="font-size: 12px;">
                                    {{ __('student.confirm_new_password') }}
                                </label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" id="confirmPassword"
                                           class="form-control form-control-sm rounded-2 pe-5"
                                           placeholder="{{ __('student.confirm_new_password') }}"
                                           style="font-size: 12.5px; border-color: #cbd5e1; height: 35px;">
                                    <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-muted pe-2.5"
                                            onclick="togglePassword('confirmPassword', this)" style="font-size: 12px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Actions -->
                            <div class="pt-2 border-top d-flex align-items-center justify-content-end gap-2" style="border-color: #f1f5f9 !important;">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 px-3 py-1" style="font-size: 11.5px;" onclick="document.getElementById('passwordForm').reset()">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1.5"
                                        style="background-color: #0099cc; border-color: #0099cc; font-size: 11.5px;">
                                    <i class="fa-solid fa-key"></i> {{ __('student.update_password_btn') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lower Row 1: Notification Preferences -->
                <div class="col-lg-6 col-12">
                    <div class="card border rounded-3 p-3.5 bg-white h-100 shadow-none" style="border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
                            <div class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #f0fdf4; color: #16a34a; font-size: 12px;">
                                <i class="fa-solid fa-sliders"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark" style="font-size: 14px;">{{ __('student.account_settings') }}</h5>
                                <div class="text-muted" style="font-size: 11px;">{{ __('student.manage_preferences') }}</div>
                            </div>
                        </div>

                        <form action="{{ route('student.settings.notifications.update') }}" method="POST" id="studentNotificationForm">
                            @csrf
                            @method('PUT')

                            <div class="d-flex flex-column gap-2.5">
                                <!-- Email Notifications -->
                                <div class="p-2.5 rounded-2 border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0;">
                                    <div>
                                        <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ __('student.email_notifications') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('student.email_notifications_desc') }}</div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="email_notifications" value="0">
                                        <input class="form-check-input notification-toggle" type="checkbox" name="email_notifications" value="1"
                                               {{ data_get($notificationSettings, 'email_notifications', true) ? 'checked' : '' }} style="cursor: pointer;">
                                    </div>
                                </div>

                                <!-- Course Reminders -->
                                <div class="p-2.5 rounded-2 border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0;">
                                    <div>
                                        <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ __('student.course_reminders') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('student.course_reminders_desc') }}</div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="course_reminders" value="0">
                                        <input class="form-check-input notification-toggle" type="checkbox" name="course_reminders" value="1"
                                               {{ data_get($notificationSettings, 'course_reminders', true) ? 'checked' : '' }} style="cursor: pointer;">
                                    </div>
                                </div>

                                <!-- Progress Reports -->
                                <div class="p-2.5 rounded-2 border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0;">
                                    <div>
                                        <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ __('student.progress_reports') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('student.progress_reports_desc') }}</div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="progress_reports" value="0">
                                        <input class="form-check-input notification-toggle" type="checkbox" name="progress_reports" value="1"
                                               {{ data_get($notificationSettings, 'progress_reports', true) ? 'checked' : '' }} style="cursor: pointer;">
                                    </div>
                                </div>

                                <!-- Marketing Emails -->
                                <div class="p-2.5 rounded-2 border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0;">
                                    <div>
                                        <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ __('student.marketing_emails') }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ __('student.marketing_emails_desc') }}</div>
                                    </div>
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="marketing_emails" value="0">
                                        <input class="form-check-input notification-toggle" type="checkbox" name="marketing_emails" value="1"
                                               {{ data_get($notificationSettings, 'marketing_emails', false) ? 'checked' : '' }} style="cursor: pointer;">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lower Row 2: Danger Zone -->
                <div class="col-lg-6 col-12">
                    <div class="card border rounded-3 p-3.5 bg-white h-100 shadow-none" style="border-color: #fecaca;">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom" style="border-color: #fef2f2 !important;">
                            <div class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #fef2f2; color: #dc2626; font-size: 12px;">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-danger" style="font-size: 14px;">{{ __('student.danger_zone') }}</h5>
                                <div class="text-muted" style="font-size: 11px;">{{ __('student.destructive_actions') }}</div>
                            </div>
                        </div>

                        @isset($latestDeletionRequest)
                            @php($deletionStatus = $latestDeletionRequest->status)
                            <div class="alert {{ $deletionStatus === 'pending' ? 'alert-warning' : ($deletionStatus === 'rejected' ? 'alert-danger' : 'alert-success') }} py-2 px-3 rounded-2 mb-3" style="font-size: 12px;" role="alert">
                                @if ($deletionStatus === 'pending')
                                    <strong>{{ __('student.awaiting_approval') }}:</strong> Submitted on {{ $latestDeletionRequest->created_at->format('M d, Y') }}.
                                @elseif($deletionStatus === 'rejected')
                                    <strong>Rejected:</strong> {{ $latestDeletionRequest->note ?? 'Please contact compliance support.' }}
                                @elseif($deletionStatus === 'approved')
                                    <strong>Approved:</strong> Request processed.
                                @endif
                            </div>
                        @endisset

                        <div class="p-3 rounded-2 border mb-3" style="background: #fff5f5; border-color: #fed7d7;">
                            <div class="fw-semibold text-danger mb-1" style="font-size: 12.5px;">{{ __('student.delete_account') }}</div>
                            <p class="text-muted mb-3" style="font-size: 11.5px; line-height: 1.45;">
                                {{ __('student.delete_account_desc') }}
                            </p>

                            @if (isset($deletionStatus) && $deletionStatus === 'pending')
                                <button type="button" class="btn btn-sm btn-secondary disabled rounded-2 px-3 py-1" style="font-size: 11.5px;" disabled>
                                    <i class="fa-solid fa-clock me-1"></i> {{ __('student.awaiting_approval') }}
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-2 px-3 py-1 fw-bold" style="font-size: 11.5px;" onclick="confirmDeleteAccount()">
                                    <i class="fa-solid fa-trash me-1"></i> {{ __('student.delete_account') }}
                                </button>
                            @endif
                        </div>

                        <form id="student-delete-account-form" action="{{ route('student.settings.account.destroy') }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>

            </div>

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#avatarInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatarPreview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const notificationForm = document.getElementById('studentNotificationForm');
        if (notificationForm) {
            notificationForm.addEventListener('change', function(event) {
                if (event.target.classList.contains('notification-toggle')) {
                    notificationForm.submit();
                }
            });
        }
    });

    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function confirmDeleteAccount() {
        const form = document.getElementById('student-delete-account-form');
        if (!form) return;

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: "{{ __('student.delete_account_title') }}",
                text: "{{ __('student.delete_account_desc') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('student.yes_delete_it') }}",
                cancelButtonText: "{{ __('frontend.cancel') }}",
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#006837'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "{{ __('student.submitting_request') }}",
                        text: "{{ __('student.please_wait_deletion') }}",
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();
                        }
                    });
                }
            });
        } else {
            if (confirm("{{ __('student.delete_account_desc') }}")) {
                form.submit();
            }
        }
    }
</script>
@endpush
@endsection

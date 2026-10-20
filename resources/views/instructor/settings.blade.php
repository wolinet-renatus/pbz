@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.settings') ?? 'Account Settings'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <!-- Page Header -->
            <div class="dashboard-header mb-3">
                <div class="section-title-area mb-0">
                    <div class="section-title mb-0">
                        <h6 style="color: var(--saas-primary, #004f44); font-size: 13px; font-weight: 700; margin-bottom: 2px;">{{ __('instructor.settings') }}</h6>
                        <h2 style="font-size: 21px; font-weight: 800; color: #0f172a; margin-bottom: 2px;">{{ __('instructor.account_settings') }}</h2>
                        <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">Manage your instructor profile, security credentials, and preferences</p>
                    </div>
                </div>
            </div>

            <!-- Compact Navigation Tabs (Zero Jumping, Ultra Minimal Scrolling) -->
            <div class="pbz-settings-nav-wrapper">
                <div class="pbz-settings-nav" role="tablist">
                    <button type="button" class="pbz-settings-tab-btn active" data-tab="tab-profile">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>{{ __('instructor.profile_info') }}</span>
                    </button>
                    <button type="button" class="pbz-settings-tab-btn" data-tab="tab-password">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>{{ __('instructor.change_password') }}</span>
                    </button>
                    <button type="button" class="pbz-settings-tab-btn" data-tab="tab-notifications">
                        <i class="fa-solid fa-bell"></i>
                        <span>{{ __('instructor.account_settings') }}</span>
                    </button>
                    <button type="button" class="pbz-settings-tab-btn tab-danger" data-tab="tab-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ __('instructor.danger_zone') }}</span>
                    </button>
                </div>
            </div>

            <!-- Tab 1: Profile Information -->
            <div class="pbz-settings-tab-panel active" id="tab-profile">
                <div class="pbz-dash-card mb-4">
                    <div class="section-title mb-3">
                        <h3 class="pbz-dash-card-title mb-1"><i class="fa-solid fa-user-circle text-primary"></i> {{ __('instructor.profile_info') }}</h3>
                        <p class="section-subtitle">{{ __('instructor.profile_info_desc') }}</p>
                    </div>

                    <form class="settings-form mt-2" id="profileForm"
                        action="{{ route('instructor.settings.profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Compact Avatar Row -->
                        <div class="pbz-avatar-compact-row">
                            <div class="avatar-preview">
                                <img src="{{ $profile['avatar'] }}" alt="{{ $profile['name'] }}" id="avatarPreview">
                                <div class="avatar-overlay">
                                    <i class="fa-solid fa-camera"></i>
                                </div>
                            </div>
                            <div class="pbz-avatar-compact-details">
                                <h5>{{ $profile['name'] }}</h5>
                                <p>{{ __('instructor.avatar_hint') }}</p>
                                <button type="button" class="pbz-change-avatar-btn" onclick="$('#avatarInput').click()">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>{{ __('instructor.change_photo') }}</span>
                                </button>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;">
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>{{ __('instructor.full_name') }} <span class="required">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $profile['name'] }}"
                                    required placeholder="{{ __('instructor.enter_full_name') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('instructor.email_address') }} <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $profile['email'] }}" required placeholder="{{ __('instructor.enter_email') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>{{ __('instructor.phone_number') }}</label>
                                <input type="tel" name="phone" class="form-control"
                                    value="{{ $profile['phone'] }}" placeholder="{{ __('instructor.enter_phone') }}">
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="form-group mb-3">
                            <label>{{ __('instructor.bio_label') }}</label>
                            <textarea name="bio" class="form-control" rows="3"
                                placeholder="{{ __('instructor.bio_placeholder') }}">{{ $profile['bio'] }}</textarea>
                            <small class="form-hint">{{ __('instructor.bio_hint') }}</small>
                        </div>

                        <!-- Social Media Links -->
                        <div class="form-section-divider">
                            <h4>{{ __('instructor.social_links') }}</h4>
                            <p class="section-subtitle">{{ __('instructor.social_links_desc') }}</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-brands fa-linkedin text-primary"></i> LinkedIn</label>
                                <input type="url" name="linkedin" class="form-control"
                                    value="{{ $profile['linkedin'] }}" placeholder="https://linkedin.com/in/username">
                            </div>
                            <div class="form-group">
                                <label><i class="fa-brands fa-twitter text-info"></i> Twitter</label>
                                <input type="url" name="twitter" class="form-control"
                                    value="{{ $profile['twitter'] }}" placeholder="https://twitter.com/username">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-brands fa-facebook text-primary"></i> Facebook</label>
                                <input type="url" name="facebook" class="form-control"
                                    value="{{ $profile['facebook'] }}" placeholder="https://facebook.com/username">
                            </div>
                            <div class="form-group">
                                <label><i class="fa-brands fa-youtube text-danger"></i> YouTube</label>
                                <input type="url" name="youtube" class="form-control"
                                    value="{{ $profile['youtube'] }}" placeholder="https://youtube.com/@username">
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <button type="button" class="cancel-btn"
                                onclick="document.getElementById('profileForm').reset()">
                                {{ __('instructor.cancel_btn') }}
                            </button>
                            <button type="submit" class="theme-btn style-2" style="padding: 10px 22px; font-size: 13px; border-radius: 10px;">
                                <i class="fa-solid fa-save"></i>
                                {{ __('instructor.save_changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tab 2: Password & Security -->
            <div class="pbz-settings-tab-panel" id="tab-password">
                <div class="pbz-dash-card mb-4">
                    <div class="section-title mb-3">
                        <h3 class="pbz-dash-card-title mb-1"><i class="fa-solid fa-shield-halved text-warning"></i> {{ __('instructor.change_password') }}</h3>
                        <p class="section-subtitle">{{ __('instructor.change_password_desc') }}</p>
                    </div>

                    <form class="settings-form mt-2" id="passwordForm"
                        action="{{ route('instructor.settings.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label>{{ __('instructor.current_password') }} <span class="required">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="current_password" class="form-control" required
                                    placeholder="{{ __('instructor.enter_current_password') }}" id="currentPassword">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('currentPassword', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>{{ __('instructor.new_password') }} <span class="required">*</span></label>
                                <div class="password-input-wrapper">
                                    <input type="password" name="new_password" class="form-control" required
                                        placeholder="{{ __('instructor.enter_new_password') }}" id="newPassword">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('newPassword', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <small class="form-hint">{{ __('instructor.min_8_chars') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('instructor.confirm_password') }} <span class="required">*</span></label>
                                <div class="password-input-wrapper">
                                    <input type="password" name="new_password_confirmation" class="form-control"
                                        required placeholder="{{ __('instructor.confirm_password') }}" id="confirmPassword">
                                    <button type="button" class="password-toggle"
                                        onclick="togglePassword('confirmPassword', this)">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="cancel-btn"
                                onclick="document.getElementById('passwordForm').reset()">
                                {{ __('instructor.cancel_btn') }}
                            </button>
                            <button type="submit" class="theme-btn style-2" style="padding: 10px 22px; font-size: 13px; border-radius: 10px;">
                                <i class="fa-solid fa-key"></i>
                                {{ __('instructor.update_password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tab 3: Notification Preferences -->
            <div class="pbz-settings-tab-panel" id="tab-notifications">
                <div class="pbz-dash-card mb-4">
                    <div class="section-title mb-3">
                        <h3 class="pbz-dash-card-title mb-1"><i class="fa-solid fa-bell text-success"></i> {{ __('instructor.account_settings') }}</h3>
                        <p class="section-subtitle">{{ __('instructor.account_settings_desc') }}</p>
                    </div>

                    <div class="account-settings-list mt-2">
                        <form action="{{ route('instructor.settings.notifications.update') }}" method="POST"
                            id="instructorNotificationForm">
                            @csrf
                            @method('PUT')

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>{{ __('instructor.email_notifications') }}</h4>
                                    <p>{{ __('instructor.email_notifications_desc') }}</p>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="hidden" name="email_notifications" value="0">
                                        <input type="checkbox" class="notification-toggle" name="email_notifications"
                                            value="1"
                                            {{ data_get($notificationSettings, 'email_notifications', true) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>{{ __('instructor.course_updates') }}</h4>
                                    <p>{{ __('instructor.course_updates_desc') }}</p>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="hidden" name="course_updates" value="0">
                                        <input type="checkbox" class="notification-toggle" name="course_updates"
                                            value="1"
                                            {{ data_get($notificationSettings, 'course_updates', true) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>{{ __('instructor.review_notifications') }}</h4>
                                    <p>{{ __('instructor.review_notifications_desc') }}</p>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="hidden" name="review_notifications" value="0">
                                        <input type="checkbox" class="notification-toggle"
                                            name="review_notifications" value="1"
                                            {{ data_get($notificationSettings, 'review_notifications', true) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="setting-item">
                                <div class="setting-info">
                                    <h4>{{ __('instructor.marketing_emails') }}</h4>
                                    <p>{{ __('instructor.marketing_emails_desc') }}</p>
                                </div>
                                <div class="setting-control">
                                    <label class="toggle-switch">
                                        <input type="hidden" name="marketing_emails" value="0">
                                        <input type="checkbox" class="notification-toggle" name="marketing_emails"
                                            value="1"
                                            {{ data_get($notificationSettings, 'marketing_emails', false) ? 'checked' : '' }}>
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Danger Zone -->
            <div class="pbz-settings-tab-panel" id="tab-danger">
                <div class="pbz-dash-card pbz-danger-zone-card mb-4">
                    <div class="section-title mb-3">
                        <h3 class="pbz-dash-card-title mb-1 text-danger"><i class="fa-solid fa-triangle-exclamation"></i> {{ __('instructor.danger_zone') }}</h3>
                        <p class="section-subtitle">{{ __('instructor.danger_zone_desc') }}</p>
                    </div>

                    <div class="danger-actions mt-3">
                        @isset($latestDeletionRequest)
                            @php($deletionStatus = $latestDeletionRequest->status)
                            <div class="alert {{ $deletionStatus === 'pending' ? 'alert-warning' : ($deletionStatus === 'rejected' ? 'alert-danger' : 'alert-success') }} mb-3"
                                role="alert">
                                @if ($deletionStatus === 'pending')
                                    <strong>{{ __('instructor.awaiting_approval_label') }}</strong> {{ __('instructor.deletion_request_submitted', ['date' => $latestDeletionRequest->created_at->format('M d, Y')]) }}
                                @elseif($deletionStatus === 'rejected')
                                    <strong>{{ __('instructor.request_rejected_label') }}</strong>
                                    {{ $latestDeletionRequest->note ?? __('instructor.contact_support_note') }}
                                @elseif($deletionStatus === 'approved')
                                    <strong>{{ __('instructor.approved_label') }}</strong> {{ __('instructor.request_processed') }}
                                @endif
                            </div>
                        @endisset
                        <div class="danger-item">
                            <div class="danger-info">
                                <h4>{{ __('instructor.delete_account') }}</h4>
                                <p>{{ __('instructor.delete_account_desc') }}</p>
                            </div>
                            @if (isset($deletionStatus) && $deletionStatus === 'pending')
                                <button type="button" class="danger-btn" disabled>
                                    <i class="fa-solid fa-clock"></i>
                                    {{ __('instructor.awaiting_approval') }}
                                </button>
                            @else
                                <button type="button" class="danger-btn" onclick="confirmDeleteAccount()">
                                    <i class="fa-solid fa-trash"></i>
                                    {{ __('instructor.delete_account') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    <form id="instructor-delete-account-form"
                        action="{{ route('instructor.settings.account.destroy') }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Tab switching logic (Zero jumping, minimal scrolling)
        function switchTab(tabId) {
            if (!tabId) return;
            var targetPanel = $('#' + tabId);
            if (!targetPanel.length) return;

            $('.pbz-settings-tab-btn').removeClass('active');
            $('.pbz-settings-tab-btn[data-tab="' + tabId + '"]').addClass('active');

            $('.pbz-settings-tab-panel').removeClass('active');
            targetPanel.addClass('active');

            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, '#' + tabId.replace('tab-', ''));
            }
        }

        $('.pbz-settings-tab-btn').on('click', function(e) {
            e.preventDefault();
            var tabId = $(this).data('tab');
            switchTab(tabId);
        });

        // Resolve initial tab from hash or errors
        var hash = window.location.hash ? window.location.hash.substring(1) : '';
        @if (isset($errors) && ($errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation')))
            switchTab('tab-password');
        @elseif (isset($errors) && $errors->any())
            switchTab('tab-profile');
        @else
            if (hash && $('#tab-' + hash).length) {
                switchTab('tab-' + hash);
            }
        @endif

        // Avatar Preview
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

        $('.avatar-preview').on('click', function() {
            $('#avatarInput').click();
        });

        // AJAX update for notification switches (No page reload, zero jump!)
        $(document).on('change', '.notification-toggle', function() {
            const form = $('#instructorNotificationForm');
            const formData = new FormData(form[0]);

            fetch(form.attr('action'), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) {
                return res.json();
            })
            .then(function(data) {
                if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2200,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: data.message || 'Notification preferences updated.'
                    });
                }
            })
            .catch(function(err) {
                console.error('Notification update error', err);
            });
        });
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
        const form = document.getElementById('instructor-delete-account-form');
        if (!form) return;

        Swal.fire({
            title: '{{ __('instructor.delete_account_confirm_title') }}',
            text: '{{ __('instructor.delete_account_confirm_text') }}',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('instructor.yes_delete_it') }}',
            cancelButtonText: '{{ __('instructor.cancel_btn') }}',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#1d4ed8'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Submitting request…',
                    text: 'Please wait while we submit your account deletion request for admin approval.',
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
    }
</script>
@endpush
@endsection

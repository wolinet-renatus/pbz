<footer class="pbz-saas-footer">
    <div class="pbz-saas-footer-content">
        <div class="pbz-saas-footer-brand">
            <span class="pbz-footer-dot"></span>
            <span class="fw-semibold text-dark">{{ site_name() ?? 'PBZ LMS' }}</span>
            <span class="text-muted">Faculty & Instructor Studio</span>
            <span class="text-muted d-none d-md-inline">•</span>
            <span class="text-muted d-none d-md-inline">&copy; {{ date('Y') }} People's Bank of Zanzibar. All rights reserved.</span>
        </div>
        <div class="pbz-saas-footer-links">
            <a href="{{ route('instructor.dashboard') }}">{{ __('instructor.dashboard') ?? 'Dashboard' }}</a>
            <a href="{{ route('instructor.courses') }}">{{ __('instructor.my_courses') ?? 'Courses' }}</a>
            <a href="{{ route('instructor.analytics') }}">{{ __('instructor.analytics') ?? 'Reports' }}</a>
            <a href="{{ route('instructor.settings') }}">{{ __('instructor.settings') ?? 'Settings' }}</a>
            <a href="{{ route('home') }}" target="_blank" rel="noopener">Portal Home <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 10px;"></i></a>
        </div>
    </div>
</footer>

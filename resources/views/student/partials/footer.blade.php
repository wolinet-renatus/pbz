<!-- PBZ SaaS Portal Modern Student Footer -->
<div class="pbz-saas-footer">
    <div class="pbz-saas-footer-content">
        <div class="pbz-saas-footer-brand">
            <span class="pbz-footer-dot"></span>
            <span>&copy; {{ date('Y') }} The People's Bank of Zanzibar (PBZ). All rights reserved.</span>
            <span class="text-muted d-none d-md-inline">&bull;</span>
            <span class="text-muted d-none d-md-inline">Sovereign Banking Learning Academy</span>
        </div>
        <div class="pbz-saas-footer-links">
            <a href="{{ route('home') }}" target="_blank">Main Site</a>
            <a href="{{ route('courses') }}">Course Catalog</a>
            <a href="{{ route('student.my-courses') }}">My Learning</a>
            <a href="{{ route('student.certificates') }}">Certificates</a>
            <a href="{{ route('student.settings') }}">Settings</a>
            <a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a>
            <a href="{{ url('/pages/terms-and-conditions') }}">Terms</a>
        </div>
    </div>
</div>

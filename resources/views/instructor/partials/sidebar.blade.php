@php $user = $user ?? auth()->user(); @endphp
<aside class="pbz-saas-sidebar" id="pbz-saas-sidebar">
    <!-- Brand Header -->
    <div class="pbz-sidebar-brand">
        <a href="{{ route('instructor.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="pbz-brand-logo-icon">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div class="pbz-brand-title">
                PBZ <span>LMS</span>
                <div style="font-size: 10px; color: #64748b; font-weight: 500; letter-spacing: 0;">Faculty Studio</div>
            </div>
        </a>
    </div>

    <!-- Scrollable Nav Section -->
    <div class="pbz-sidebar-nav-container">
        <!-- Top / Main Section -->
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('instructor.dashboard') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-table-columns"></i>
                    <span>{{ __('instructor.dashboard') ?? 'Dashboard' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: INSTRUCTOR -->
        <div class="pbz-sidebar-group-title">INSTRUCTOR</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('instructor.courses') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.courses*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>{{ __('instructor.my_courses') ?? 'My Courses' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.bundles.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.bundles.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Bundles</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.live-classes.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.live-classes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-video"></i>
                    <span>Live Classes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.quizzes.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.quizzes*') ? 'active' : '' }}">
                    <i class="fa-regular fa-circle-question"></i>
                    <span>{{ __('instructor.quiz_attempts') ?? 'Test Series' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.assignments.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.assignments*') ? 'active' : '' }}">
                    <i class="fa-regular fa-clipboard"></i>
                    <span>{{ __('instructor.assignments') ?? 'Assignments' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.students') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.students*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>{{ __('instructor.students') ?? 'Students' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.analytics') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.analytics') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>{{ __('instructor.analytics') ?? 'Reports' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: INBOX -->
        <div class="pbz-sidebar-group-title">INBOX</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('instructor.messages.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.messages.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span>Messages</span>
                    <span class="badge bg-danger rounded-pill ms-auto instructor-chat-badge" style="display: none; font-size: 10px;"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.notifications.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.notifications.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-bell"></i>
                    <span>Notifications</span>
                </a>
            </li>
        </ul>

        <!-- Group: ENGAGEMENT -->
        <div class="pbz-sidebar-group-title">ENGAGEMENT</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('instructor.discussions.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.discussions.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-comments"></i>
                    <span>Course Forums</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.reviews') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.reviews') ? 'active' : '' }}">
                    <i class="fa-regular fa-star"></i>
                    <span>{{ __('instructor.reviews') ?? 'Reviews' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('instructor.events.index') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.events*') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>{{ __('instructor.events') ?? 'Events' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: ACCOUNT -->
        <div class="pbz-sidebar-group-title">ACCOUNT</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('instructor.settings') }}" class="pbz-sidebar-link {{ request()->routeIs('instructor.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>{{ __('instructor.settings') ?? 'Profile' }}</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Pinned Bottom User Card & Logout -->
    <div class="pbz-sidebar-footer">
        <div class="pbz-user-avatar-wrap">
            @if ($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
            @else
                <img src="{{ asset('assets/front/img/home-1/courses/client-01.png') }}" alt="{{ $user->name }}">
            @endif
        </div>
        <div class="pbz-user-info">
            <div class="pbz-user-name">{{ $user->name }}</div>
            <div class="pbz-user-role">Senior Faculty / Instructor</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="pbz-logout-btn" title="{{ __('instructor.logout') ?? 'Logout' }}">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>
</aside>
<div class="pbz-sidebar-overlay" id="pbz-sidebar-overlay"></div>

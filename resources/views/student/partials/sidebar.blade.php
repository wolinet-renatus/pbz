@php($user = $user ?? Auth::user())
<aside class="pbz-saas-sidebar" id="pbz-saas-sidebar">
    <!-- Brand Header -->
    <div class="pbz-sidebar-brand">
        <a href="{{ route('student.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none">
            <div class="pbz-brand-logo-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="pbz-brand-title">
                PBZ <span>LMS</span>
                <div style="font-size: 10px; color: #64748b; font-weight: 500; letter-spacing: 0;">Bank Academy</div>
            </div>
        </a>
    </div>

    <!-- Scrollable Nav Section -->
    <div class="pbz-sidebar-nav-container">
        @if($user->isAdmin())
            <div class="px-3 pt-2 pb-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm w-100 text-white fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #07172b, #0f2b48); border: 1px solid #38bdf8; font-size: 11px; border-radius: 6px; padding: 6px 10px;">
                    <i class="fa-solid fa-shield-halved text-info"></i> Admin Console
                </a>
            </div>
        @endif

        <!-- Top / Main Section -->
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.dashboard') }}" class="pbz-sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-table-columns"></i>
                    <span>{{ __('student.dashboard') ?? 'Dashboard' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: INBOX -->
        <div class="pbz-sidebar-group-title">INBOX</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.messages.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.messages.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span>Messages</span>
                    <span class="badge bg-danger rounded-pill ms-auto student-chat-badge" style="display: none; font-size: 10px;"></span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.notifications.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.notifications.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-bell"></i>
                    <span>{{ __('student.notifications') ?? 'Notifications' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: COMPLIANCE & BOT AUDIT -->
        <div class="pbz-sidebar-group-title">COMPLIANCE &amp; AUDIT</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.compliance.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.compliance.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-scale-balanced"></i>
                    <span>Compliance Engine</span>
                    <span class="badge rounded-pill ms-auto" style="background: #006837; color: #F9ED27; font-size: 9px; font-weight: 700;">BOT</span>
                </a>
            </li>
            @if($user->isBranchManager() || $user->isAdmin())
                <li>
                    <a href="{{ route('student.compliance.branch-matrix') }}" class="pbz-sidebar-link {{ request()->routeIs('student.compliance.branch-matrix') ? 'active' : '' }}">
                        <i class="fa-solid fa-building-shield"></i>
                        <span>Branch Matrix</span>
                        <span class="badge rounded-pill ms-auto" style="background: #dc2626; color: #fff; font-size: 9px;">MGR</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- Group: LEARNING -->
        <div class="pbz-sidebar-group-title">LEARNING</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.my-courses') }}" class="pbz-sidebar-link {{ request()->routeIs('student.my-courses') || request()->routeIs('student.courses.access') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i>
                    <span>{{ __('student.my_courses') ?? 'My Learning' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.live-classes.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.live-classes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-video"></i>
                    <span>Live Classes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.quiz-attempts') }}" class="pbz-sidebar-link {{ request()->routeIs('student.quiz-attempts') ? 'active' : '' }}">
                    <i class="fa-regular fa-circle-question"></i>
                    <span>{{ __('student.my_quiz_attempts') ?? 'Practice Tests' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.assignments') }}" class="pbz-sidebar-link {{ request()->routeIs('student.assignments') ? 'active' : '' }}">
                    <i class="fa-regular fa-clipboard"></i>
                    <span>{{ __('student.my_assignments') ?? 'Assignments' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.certificates') }}" class="pbz-sidebar-link {{ request()->routeIs('student.certificates') ? 'active' : '' }}">
                    <i class="fa-solid fa-certificate"></i>
                    <span>{{ __('student.certificates') ?? 'Certificates' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: COMMUNITY -->
        <div class="pbz-sidebar-group-title">COMMUNITY</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.community.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.community.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>{{ __('student.community') ?? 'Community' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.ai-chat.index') }}" class="pbz-sidebar-link {{ request()->routeIs('student.ai-chat.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-robot"></i>
                    <span>{{ __('student.ai_assistant') ?? 'AI Assistant' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.events.bookings') }}" class="pbz-sidebar-link {{ request()->routeIs('student.events.bookings') ? 'active' : '' }}">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>{{ __('student.my_event_bookings') ?? 'Events' }}</span>
                </a>
            </li>
        </ul>

        <!-- Group: ACCOUNT -->
        <div class="pbz-sidebar-group-title">ACCOUNT</div>
        <ul class="pbz-sidebar-nav">
            <li>
                <a href="{{ route('student.settings') }}" class="pbz-sidebar-link {{ request()->routeIs('student.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>{{ __('student.settings') ?? 'Settings' }}</span>
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
            <div class="pbz-user-role" style="font-size: 11px; color: #64748b;">
                {{ $user->job_title ?: 'PBZ Banking Officer' }}
            </div>
            <div style="font-size: 10px; color: #006837; font-weight: 600;">
                <i class="fa-solid fa-location-dot me-0.5"></i> {{ $user->branch->name ?? 'Zanzibar Branch' }}
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="pbz-logout-btn" title="{{ __('student.logout') ?? 'Logout' }}">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
        </form>
    </div>
</aside>
<div class="pbz-sidebar-overlay" id="pbz-sidebar-overlay"></div>
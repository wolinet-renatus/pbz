<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <!-- Brand Header -->
        <div class="sidebar-brand px-3 py-3" style="height: auto; min-height: 60px; line-height: normal; display: flex; align-items: center; justify-content: center;">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-center text-decoration-none">
                <img src="{{ branding_asset(['primary_logo_path', 'logos.primary'], 'assets/front/img/logo/white-logo.svg') }}"
                    alt="PBZ Logo" style="max-height: 36px; max-width: 100%; width: auto;" class="flex-shrink-0">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ branding_asset(['favicon_path', 'logos.favicon'], 'assets/front/img/favicon.svg') }}"
                    alt="PBZ" style="max-height: 22px;">
            </a>
        </div>

        @php
            $pendingReviewsCount = \App\Models\Review::where('is_approved', false)->count();
        @endphp

        <ul class="sidebar-menu">
            <!-- ======================================================== -->
            <!-- 1. OVERVIEW                                              -->
            <!-- ======================================================== -->
            <li class="menu-header">OVERVIEW</li>

            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.reports.index') }}">
                    <i class="fas fa-chart-pie"></i><span>Reports &amp; Analytics</span>
                </a>
            </li>

            <!-- ======================================================== -->
            <!-- 2. ACADEMY & LEARNING                                    -->
            <!-- ======================================================== -->
            <li class="menu-header">ACADEMY &amp; LEARNING</li>

            <!-- Courses & Curriculum Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.courses.*') || request()->routeIs('admin.bundles.*') || request()->routeIs('admin.course-categories.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-graduation-cap"></i><span>Courses &amp; Curriculum</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Courses</li>
                    <li class="{{ request()->routeIs('admin.courses.index') && !request()->has('status') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.index') }}">All Courses</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.courses.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.create') }}">Create Course</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.courses.index') && request('status') == 'pending' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.index', ['status' => 'pending']) }}">Pending Courses</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.courses.index') && request('status') == 'published' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.index', ['status' => 'published']) }}">Published Courses</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.courses.index') && request('status') == 'draft' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.index', ['status' => 'draft']) }}">Draft Courses</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.courses.index') && request('status') == 'archived' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.courses.index', ['status' => 'archived']) }}">Archived Courses</a>
                    </li>
                    <li class="dropdown-sublabel">Catalog Structure</li>
                    <li class="{{ request()->routeIs('admin.bundles.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.bundles.index') }}">Course Bundles</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.course-categories.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.course-categories.index') }}">Course Categories</a>
                    </li>
                </ul>
            </li>

            <!-- Assessments & Events Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.quiz-attempts.*') || request()->routeIs('admin.assignment-submissions.*') || request()->routeIs('admin.certificates.*') || request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-chart-line"></i><span>Assessments &amp; Events</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Activity &amp; Credentials</li>
                    <li class="{{ request()->routeIs('admin.quiz-attempts.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.quiz-attempts.index') }}">Quiz Attempts</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.assignment-submissions.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.assignment-submissions.index') }}">Assignment Submissions</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.certificates.templates.*') || (request()->routeIs('admin.certificates.index') && request('tab') !== 'issued') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.certificates.index', ['tab' => 'templates']) }}">Certificate Templates</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.certificates.index') && request('tab') === 'issued' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.certificates.index', ['tab' => 'issued']) }}">Issued Certificates</a>
                    </li>
                    <li class="dropdown-sublabel">Live Learning</li>
                    <li class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.events.index') }}">Events &amp; Classes</a>
                    </li>
                </ul>
            </li>

            <!-- ======================================================== -->
            <!-- 3. PEOPLE & ENGAGEMENT                                   -->
            <!-- ======================================================== -->
            <li class="menu-header">PEOPLE &amp; ENGAGEMENT</li>

            <!-- Enrollments Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-clipboard-list"></i><span>Enrollments</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('admin.enrollments.index') && !request()->routeIs('admin.enrollments.pending') && !request()->routeIs('admin.enrollments.completed') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.enrollments.index') }}">All Enrollments</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.enrollments.pending') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.enrollments.pending') }}">Pending Enrollments</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.enrollments.completed') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.enrollments.completed') }}">Completed Enrollments</a>
                    </li>
                </ul>
            </li>

            <!-- People & Accounts Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.students.*') || request()->routeIs('admin.instructors.*') || request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i><span>People &amp; Accounts</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Bank Staff &amp; Officers</li>
                    <li class="{{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.students.index') }}">All Staff &amp; Officers</a>
                    </li>
                    @can('student:create')
                    <li class="{{ request()->routeIs('admin.students.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.students.create') }}">Add New Staff</a>
                    </li>
                    @endcan
                    <li class="dropdown-sublabel">Instructors</li>
                    <li class="{{ request()->routeIs('admin.instructors.index') && !request()->has('status') && !request()->routeIs('admin.instructors.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.instructors.index') }}">All Instructors</a>
                    </li>
                    @can('instructor:create')
                    <li class="{{ request()->routeIs('admin.instructors.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.instructors.create') }}">Add Instructor</a>
                    </li>
                    @endcan
                    <li class="{{ request()->routeIs('admin.instructors.pending') || (request()->routeIs('admin.instructors.index') && request('status') == 'pending') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.instructors.pending') }}">Pending Instructors</a>
                    </li>
                    <li class="dropdown-sublabel">Account Lifecycle</li>
                    <li class="{{ request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.account-deletions.index') }}">Account Deletions</a>
                    </li>
                </ul>
            </li>

            <!-- Engagement & Content Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.reviews.*') || request()->routeIs('admin.blog-posts.*') || request()->routeIs('admin.blog-comments.*') || request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.notifications.*') || request()->routeIs('admin.settings.newsletter.index') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-bullhorn"></i>
                    <span>Engagement &amp; Content</span>
                    @if ($pendingReviewsCount > 0)
                        <span class="badge badge-warning sidebar-dropdown-badge">{{ $pendingReviewsCount }}</span>
                    @endif
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Reviews &amp; Ratings</li>
                    <li class="{{ request()->routeIs('admin.reviews.index') && !request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.reviews.index') }}">All Reviews</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.reviews.pending') ? 'active' : '' }}">
                        <a class="nav-link d-flex align-items-center justify-content-between" href="{{ route('admin.reviews.pending') }}">
                            <span>Pending Reviews</span>
                            @if ($pendingReviewsCount > 0)
                                <span class="badge badge-warning">{{ $pendingReviewsCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="dropdown-sublabel">Blogs &amp; News</li>
                    <li class="{{ request()->routeIs('admin.blog-posts.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.blog-posts.index') }}">All Posts</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.blog-posts.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.blog-posts.create') }}">Create Post</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.blog-categories.index') }}">Blog Categories</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.blog-comments.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.blog-comments.index') }}">Blog Comments</a>
                    </li>
                    <li class="dropdown-sublabel">Communications</li>
                    <li class="{{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.notifications.index') }}">Push Notifications</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.settings.newsletter.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.settings.newsletter.index') }}">Newsletter Subscribers</a>
                    </li>
                </ul>
            </li>

            <!-- ======================================================== -->
            <!-- 4. SYSTEM & PLATFORM                                     -->
            <!-- ======================================================== -->
            <li class="menu-header">SYSTEM &amp; PLATFORM</li>

            <!-- Frontend Manager Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.frontend.menus.*') || request()->routeIs('admin.frontend.settings.*') || request()->routeIs('admin.frontend.faq.*') || request()->routeIs('admin.frontend.seo.*') || request()->routeIs('admin.frontend.marquee.*') || request()->routeIs('admin.frontend.home.*') || request()->routeIs('admin.frontend.about.*') || request()->routeIs('admin.frontend.contact.*') || request()->routeIs('admin.custom-pages.*') || request()->routeIs('admin.frontend.theme.*') || request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-paint-brush"></i><span>Frontend Manager</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Navigation &amp; Home</li>
                    <li class="{{ request()->routeIs('admin.frontend.menus.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.menus.index') }}">Menus</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.home.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.home.edit') }}">Homepage Content</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.theme.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.theme.edit') }}">Homepage Theme</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.marquee.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.marquee.edit') }}">Marquee Items</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.banners.index') }}">App Banners</a>
                    </li>
                    <li class="dropdown-sublabel">Pages &amp; SEO</li>
                    <li class="{{ request()->routeIs('admin.frontend.about.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.about.edit') }}">About Page</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.contact.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.contact.edit') }}">Contact Page</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.faq.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.faq.edit') }}">FAQ Content</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.custom-pages.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.custom-pages.index') }}">Custom Pages</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.seo.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.seo.edit') }}">SEO Metadata</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.frontend.settings.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.frontend.settings.edit') }}">Footer &amp; Contact</a>
                    </li>
                </ul>
            </li>

            <!-- System & Settings Dropdown -->
            <li class="dropdown {{ request()->routeIs('admin.languages.*') || request()->routeIs('admin.settings.index') || request()->routeIs('admin.settings.system.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-cog"></i><span>System &amp; Settings</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-sublabel">Configuration</li>
                    <li class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.settings.index') }}">Settings &amp; Config</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.languages.index') }}">Language Manager</a>
                    </li>
                    <li class="dropdown-sublabel">System Maintenance</li>
                    <li class="{{ request()->routeIs('admin.settings.system.status') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.settings.system.status') }}">System Status</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.settings.system.cache') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.settings.system.cache') }}">Cache Management</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.settings.system.logs') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('admin.settings.system.logs') }}">Error Logs</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Compact Profile Card -->
        @php($adminUser = auth()->user())
        @if ($adminUser)
            <div class="mt-3 mb-2 px-3 hide-sidebar-mini">
                <div class="p-2 rounded-2 d-flex align-items-center gap-2" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08);">
                    @if ($adminUser->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($adminUser->profile_photo))
                        <img alt="image" src="{{ asset('storage/' . $adminUser->profile_photo) }}"
                            class="rounded-circle" width="30" height="30" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 30px; height: 30px; background: #0099cc; font-size: 11px;">
                            {{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0 flex-grow-1" style="line-height: 1.2;">
                        <div class="text-truncate text-white fw-bold" style="font-size: 11.5px;">{{ $adminUser->name }}</div>
                        <div class="text-truncate" style="font-size: 10px; color: #94a3b8;">{{ $adminUser->role ?? 'Admin' }}</div>
                    </div>
                    <a href="{{ route('admin.profile.edit') }}" class="text-muted p-1" title="Edit Profile" style="color: #94a3b8 !important;">
                        <i class="fas fa-gear" style="font-size: 11px;"></i>
                    </a>
                </div>
            </div>
        @endif

        <div class="mt-1 mb-3 px-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-sm btn-block text-white fw-bold py-1.5 rounded-2 d-flex align-items-center justify-content-center gap-1.5" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #f87171 !important; font-size: 11.5px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>
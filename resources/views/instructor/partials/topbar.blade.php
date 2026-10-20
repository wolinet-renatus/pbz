@php($user = $user ?? Auth::user())
<header class="pbz-saas-topbar">
    <div class="pbz-topbar-left">
        <button type="button" class="pbz-sidebar-toggle-btn" id="pbz-sidebar-toggle" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="pbz-topbar-page-meta">
            <div class="pbz-topbar-date">{{ now()->format('l, d M Y') }}</div>
            <h1 class="pbz-topbar-title">{{ $pageTitle ?? __('instructor.dashboard') ?? 'Dashboard' }}</h1>
        </div>
    </div>

    <div class="pbz-topbar-right">
        <!-- Search Bar with Shortcut -->
        <div class="pbz-topbar-search d-none d-md-flex">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="pbz-global-search" placeholder="Search..." autocomplete="off">
            <span class="search-kbd">/</span>
        </div>

        <!-- Language Pill -->
        <div class="pbz-topbar-lang d-none d-sm-flex">
            <i class="fa-solid fa-globe" style="color: var(--saas-primary);"></i>
            <span>English</span>
            <i class="fa-solid fa-chevron-down" style="font-size: 10px; color: #94a3b8;"></i>
        </div>

        <!-- Theme Toggle Button -->
        <button type="button" class="pbz-topbar-btn" id="pbz-theme-toggle" title="Toggle theme">
            <i class="fa-solid fa-circle-half-stroke"></i>
        </button>

        <!-- Notifications Bell -->
        <a href="{{ route('instructor.notifications.index') }}" class="pbz-topbar-btn" title="Notifications">
            <i class="fa-regular fa-bell"></i>
            <span class="topbar-badge">8</span>
        </a>

        <!-- Instructor Avatar Thumbnail -->
        <a href="{{ route('instructor.settings') }}" class="pbz-topbar-user" title="{{ $user->name }}">
            @if ($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
            @else
                <img src="{{ asset('assets/front/img/home-1/courses/client-01.png') }}" alt="{{ $user->name }}">
            @endif
        </a>
    </div>
</header>

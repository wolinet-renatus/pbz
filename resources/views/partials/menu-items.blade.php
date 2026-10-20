@php
    $items = $items ?? [];
    $isRoot = $isRoot ?? false;
@endphp

@foreach ($items as $index => $item)
    @php
        $children = $item['children'] ?? [];
        $hasChildren = !empty($children);
        $url = $item['url'] ?? '#';
        $target = $item['target'] ?? '_self';
        $title = $item['title'] ?? 'Menu Item';

        // Filter out any legacy commercial subscription links
        if (Str::contains(strtolower($title), 'subscription') || Str::contains($url, '/subscriptions')) {
            continue;
        }

        // High-precision active route matching
        $isCurrent = false;
        $cleanUrl = rtrim($url, '/');
        $currentUrl = rtrim(request()->url(), '/');

        if ($cleanUrl === $currentUrl || request()->fullUrlIs($url)) {
            $isCurrent = true;
        } elseif ($cleanUrl === rtrim(route('home'), '/') && (request()->is('/') || request()->routeIs('home'))) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/courses') && request()->is('courses*')) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/events') && request()->is('events*')) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/about') && request()->is('about*')) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/instructors') && request()->is('instructors*')) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/blog') && request()->is('blog*')) {
            $isCurrent = true;
        } elseif (Str::contains($cleanUrl, '/contact') && request()->is('contact*')) {
            $isCurrent = true;
        }

        $iconClass = $isRoot ? 'fa-solid fa-chevron-down' : 'fas fa-angle-right';
    @endphp

    <li class="{{ $hasChildren ? 'has-dropdown' : '' }} {{ $isCurrent ? 'active' : '' }}" data-nav-index="{{ $loopIndex ?? 0 }}-{{ $index }}">
        <a href="{{ $url }}" target="{{ $target }}" class="{{ $isCurrent ? 'active-menu-link' : '' }}">
            <span>{{ $title }}</span>
            @if($hasChildren)
                <i class="{{ $iconClass }}" style="font-size: 0.65rem; margin-left: 4px;"></i>
            @endif
        </a>
        @if($hasChildren)
            <ul class="submenu shadow-lg">
                @include('partials.menu-items', ['items' => $children, 'isRoot' => false, 'loopIndex' => ($loopIndex ?? 0) . '-' . $index])
            </ul>
        @endif
    </li>
@endforeach

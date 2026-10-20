@php
    $contact = frontend_setting('footer.contact', []);
    $phone = $contact['phone'] ?? '+255 24 223 1118 / 0800 750 075';
    $email = $contact['email'] ?? 'info@pbzbank.co.tz';
    $address = $contact['address'] ?? 'Head Office: Mpirani, P.O. Box 1116, Zanzibar, Tanzania';

    $phoneLink = $phone ? preg_replace('/[^\d\+]/', '', explode('/', $phone)[0]) : null;

    $socialLinks = collect(frontend_setting('footer.social_links', []))
        ->filter(fn($link) => filled($link['url'] ?? null))
        ->values();

    $locales = (!empty($availableLocales) && count($availableLocales) > 0)
        ? $availableLocales
        : \App\Http\Middleware\SetLocale::getSupportedLocales();
    $current = $currentLocale ?? app()->getLocale();
@endphp

<!-- Modern PBZ Topbar Section -->
<div class="pbz-topbar py-1.5 border-bottom" style="background-color: #32C5F1 !important; color: #002b24 !important;">
    <div class="container-fluid px-lg-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <!-- Left: Contact Details -->
            <div class="d-flex align-items-center flex-wrap gap-3 gap-md-4 text-nowrap topbar-contact-info">
                @if ($phone)
                    <a href="{{ $phoneLink ? 'tel:' . $phoneLink : '#' }}" class="topbar-link d-inline-flex align-items-center gap-1.5 text-decoration-none">
                        <i class="fa-solid fa-phone-volume" style="font-size: 0.74rem; color: #003730;"></i>
                        <span>{{ $phone }}</span>
                    </a>
                @endif

                @if ($email)
                    <a href="mailto:{{ $email }}" class="topbar-link d-inline-flex align-items-center gap-1.5 text-decoration-none">
                        <i class="fa-solid fa-envelope" style="font-size: 0.74rem; color: #003730;"></i>
                        <span>{{ $email }}</span>
                    </a>
                @endif

                @if ($address)
                    <span class="topbar-text d-none d-xl-inline-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-location-dot" style="font-size: 0.74rem; color: #c53030;"></i>
                        <span>{{ $address }}</span>
                    </span>
                @endif
            </div>

            <!-- Right: Social & Language Selector -->
            <div class="d-flex align-items-center gap-2.5 ms-auto">
                @if ($socialLinks->isNotEmpty())
                    <div class="topbar-socials d-none d-md-flex align-items-center gap-2">
                        @foreach ($socialLinks as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="topbar-social-btn" aria-label="{{ $link['label'] ?? 'Social' }}">
                                <i class="{{ $link['icon'] ?? 'fab fa-globe' }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Modern Styled Language Selector Dropdown -->
                @if (!empty($locales) && count($locales) > 1)
                    <div class="dropdown topbar-language-dropdown position-relative">
                        @php $currentMeta = $locales[$current] ?? reset($locales); @endphp
                        <button class="btn btn-sm topbar-lang-btn dropdown-toggle d-flex align-items-center gap-1.5 py-1 px-2.5 rounded-pill border" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.74rem; font-weight: 600;">
                            <span>{!! $currentMeta['flag'] ?? '<i class="fa-solid fa-globe"></i>' !!}</span>
                            <span class="d-none d-sm-inline">{{ $currentMeta['native'] ?? $currentMeta['name'] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border py-1" style="min-width: 155px; font-size: 0.78rem; z-index: 1050;">
                            @foreach ($locales as $code => $meta)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between py-1.5 {{ $code === $current ? 'active fw-bold' : '' }}" href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}">
                                        <span class="d-flex align-items-center gap-2">
                                            <span>{{ $meta['flag'] }}</span>
                                            <span>{{ $meta['native'] }}</span>
                                        </span>
                                        @if ($code === $current)
                                            <i class="fa-solid fa-check text-primary ms-2" style="font-size: 0.7rem;"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .pbz-topbar {
        background-color: #32C5F1 !important; /* Sky Blue / Cyan: Ocean & Islamic branch geometric arches */
        color: #002b24 !important;
        font-size: 0.76rem;
        position: relative;
        z-index: 1025;
        border-bottom: 1px solid rgba(0, 43, 36, 0.15) !important;
    }
    .topbar-link {
        color: #002b24;
        font-weight: 600;
        transition: color 0.15s ease;
    }
    .topbar-link:hover {
        color: #004d43 !important;
    }
    .topbar-text {
        color: #003730;
        font-weight: 500;
    }
    .topbar-social-btn {
        color: #002b24;
        font-size: 0.75rem;
        transition: all 0.15s ease;
    }
    .topbar-social-btn:hover {
        color: #004d43;
        transform: translateY(-1px);
    }
    .topbar-lang-btn {
        background: rgba(255, 255, 255, 0.45);
        color: #002b24;
        border-color: rgba(0, 43, 36, 0.2) !important;
    }
    .topbar-lang-btn:hover, .topbar-lang-btn:focus {
        background: rgba(255, 255, 255, 0.75);
        color: #002b24;
    }
</style>

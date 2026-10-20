@extends('layouts.app')

{{-- Omit bulky 350px breadcrumb hero banner --}}
@section('breadcrumb')
@endsection

@section('content')
    <!-- Minimal Header (Hello Section) -->
    <div class="page-hero-minimal bg-light py-3.5 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.72rem; letter-spacing: 0.06em;">
                            SYMPOSIA &amp; SUMMITS
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Events</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                        PBZ Academy <span class="text-primary">Events &amp; Banking Summits</span>
                    </h1>
                    <p class="text-muted small mb-0">
                        Executive masterclasses, BOT compliance forums, and Islamic banking symposia for financial practitioners.
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-1.5 shadow-2xs fw-bold" style="font-size: 0.82rem;">
                        {{ $events->total() }} {{ Str::plural('Event', $events->total()) }} Scheduled
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Events Catalog Section (Compact 3-Per-Row Grid) -->
    <section class="events-catalog-section py-4 py-lg-4.5">
        <div class="container">
            @if ($events->count() === 0)
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-12 text-center py-5">
                        <div class="p-4 rounded-3 border bg-light d-inline-block shadow-sm w-100" style="max-width: 440px;">
                            <i class="fa-solid fa-calendar-xmark fa-3x text-muted mb-2.5 opacity-50"></i>
                            <h6 class="fw-bold mb-1">{{ __('frontend.no_events_yet') ?? 'No scheduled summits at this time' }}</h6>
                            <p class="text-muted small mb-0">{{ __('frontend.no_events_desc') ?? 'Check back soon for upcoming regulatory forums and masterclasses.' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-3 g-lg-3.5">
                    @foreach ($events as $event)
                        @php
                            $fallbackImages = [
                                asset('assets/front/img/inner/event/01.jpg'),
                                asset('assets/front/img/inner/event/02.jpg'),
                                asset('assets/front/img/inner/event/03.jpg'),
                                asset('assets/front/img/inner/event/04.jpg'),
                            ];
                            $image = $event->featured_image
                                ? (Str::startsWith($event->featured_image, 'events/') ? asset('assets/front/img/inner/' . $event->featured_image) : asset('storage/' . $event->featured_image))
                                : $fallbackImages[$loop->index % count($fallbackImages)];
                            
                            $formattedDate = optional($event->start_date)->format('d M, Y') ?? 'Date TBA';
                            $isFree = empty($event->price) || (float)$event->price <= 0;
                        @endphp
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="card event-compact-card border rounded-3 h-100 shadow-sm overflow-hidden bg-white d-flex flex-column">
                                <!-- Thumbnail Cover (145px) -->
                                <div class="position-relative overflow-hidden" style="height: 145px; background: #e2e8f0;">
                                    <a href="{{ route('events.show', $event->slug) }}" class="d-block w-100 h-100">
                                        <img src="{{ $image }}" alt="{{ $event->title }}" class="w-100 h-100 object-fit-cover event-thumb-img" loading="lazy" onerror="this.src='{{ asset('assets/front/img/home-1/courses/courses-01.jpg') }}'">
                                    </a>
                                    
                                    <!-- Date Pill Overlay -->
                                    <span class="badge bg-dark bg-opacity-75 text-white position-absolute top-0 start-0 m-2.5 rounded-pill px-2.5 py-1" style="font-size: 0.7rem;">
                                        <i class="fa-regular fa-calendar me-1 text-warning"></i> {{ $formattedDate }}
                                    </span>

                                    <!-- Price / Staff Badge -->
                                    <span class="badge position-absolute top-0 end-0 m-2.5 rounded-pill px-2.5 py-1 fw-bold" style="background: {{ $isFree ? '#006837' : '#FFA729' }}; color: {{ $isFree ? '#ffffff' : '#002620' }}; font-size: 0.68rem;">
                                        {{ $isFree ? 'Free for PBZ Staff' : currency_symbol() . number_format($event->price, 0) }}
                                    </span>
                                </div>

                                <!-- Body Details -->
                                <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                    <!-- Location Pill -->
                                    <div class="d-flex align-items-center gap-1.5 text-muted small mb-2 text-truncate" style="font-size: 0.74rem;">
                                        <i class="fa-solid fa-location-dot text-danger flex-shrink-0" style="font-size: 0.78rem;"></i>
                                        <span class="text-truncate">{{ $event->location ?? 'Head Office / Online' }}</span>
                                    </div>

                                    <!-- Title (Clamped 2 lines) -->
                                    <h6 class="event-card-title fw-bold mb-2">
                                        <a href="{{ route('events.show', $event->slug) }}" class="text-dark text-decoration-none hover-primary" title="{{ $event->title }}">
                                            {{ $event->title }}
                                        </a>
                                    </h6>

                                    <!-- Summary / Description (Clamped 2 lines) -->
                                    <p class="text-muted small mb-3 flex-grow-1" style="font-size: 0.78rem; line-height: 1.4; height: 2.8em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        {{ Str::limit($event->summary ?? strip_tags($event->description), 95) }}
                                    </p>

                                    <!-- Speakers & Meta Bar -->
                                    <div class="pt-2 border-top mt-auto d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-1 text-muted small" style="font-size: 0.72rem;">
                                            <i class="fa-solid fa-chalkboard-user text-primary"></i>
                                            <span>
                                                @if($event->speakers->count() > 0)
                                                    {{ $event->speakers->count() }} {{ Str::plural('Speaker', $event->speakers->count()) }}
                                                @else
                                                    PBZ Faculty
                                                @endif
                                            </span>
                                        </div>

                                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
                                            <span>Details</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 0.68rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Compact Pagination -->
                @if ($events->hasPages())
                    <div class="mt-4 pt-2 d-flex justify-content-center">
                        {{ $events->links('vendor.pagination.stisla-default') }}
                    </div>
                @endif
            @endif
        </div>
    </section>

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        .event-compact-card {
            border: 1px solid #e2e8f0 !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .event-compact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
            border-color: #006837 !important;
        }
        .event-thumb-img {
            transition: transform 0.3s ease;
        }
        .event-compact-card:hover .event-thumb-img {
            transform: scale(1.04);
        }
        .event-card-title {
            font-size: 0.88rem;
            line-height: 1.35;
            height: 2.7em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .hover-primary:hover {
            color: #006837 !important;
        }
        .shadow-2xs {
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        }
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.5rem !important;
            }
        }
    </style>
@endsection

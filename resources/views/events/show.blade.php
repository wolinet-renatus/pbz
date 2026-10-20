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
                            SUMMIT AGENDA
                        </span>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0" style="font-size: 0.76rem;">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('events.index') }}" class="text-decoration-none text-muted">Events</a></li>
                                <li class="breadcrumb-item active text-dark fw-semibold text-truncate" style="max-width: 240px;" aria-current="page">{{ $event->title }}</li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="page-title fw-bold mb-1 text-dark" style="font-size: 1.65rem; letter-spacing: -0.015em;">
                        {{ $event->title }}
                    </h1>
                    <p class="text-muted small mb-0">
                        <i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $event->location ?? 'Head Office / Online' }}
                        <span class="mx-2">•</span>
                        <i class="fa-regular fa-calendar text-primary me-1"></i> {{ optional($event->start_date)->format('d M, Y') ?? 'Date TBA' }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('events.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-arrow-left" style="font-size: 0.75rem;"></i>
                        <span>All Events</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Section -->
    <section class="event-details-main-section py-4 py-lg-4.5">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column: Details, Highlights & Schedule (col-lg-8) -->
                <div class="col-lg-8 col-12">
                    <!-- Featured Event Visual -->
                    @php
                        $fallbackImages = [
                            asset('assets/front/img/inner/event/01.jpg'),
                            asset('assets/front/img/inner/event/02.jpg'),
                            asset('assets/front/img/inner/event/03.jpg'),
                            asset('assets/front/img/inner/event/04.jpg'),
                        ];
                        $featured = $event->featured_image
                            ? (Str::startsWith($event->featured_image, 'events/') ? asset('assets/front/img/inner/' . $event->featured_image) : asset('storage/' . $event->featured_image))
                            : $fallbackImages[0];
                    @endphp
                    <div class="position-relative rounded-3 overflow-hidden border mb-3.5 bg-light" style="max-height: 300px;">
                        <img src="{{ $featured }}" alt="{{ $event->title }}" class="w-100 h-100 object-fit-cover" style="max-height: 300px;" onerror="this.src='{{ asset('assets/front/img/home-1/courses/courses-01.jpg') }}'">
                    </div>

                    <!-- Event Overview -->
                    <div class="card border rounded-3 p-3.5 p-md-4 bg-white shadow-sm mb-3.5">
                        <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Summit Overview</h5>
                        @if ($event->summary)
                            <p class="text-dark fw-medium small mb-3" style="font-size: 0.86rem; line-height: 1.5;">
                                {{ $event->summary }}
                            </p>
                        @endif
                        <div class="text-muted small" style="font-size: 0.84rem; line-height: 1.6;">
                            {!! nl2br(e($event->description)) !!}
                        </div>
                    </div>

                    <!-- Highlights / Key Takeaways -->
                    @if ($event->highlights->isNotEmpty())
                        <div class="card border rounded-3 p-3.5 p-md-4 bg-white shadow-sm mb-3.5">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">
                                <i class="fa-solid fa-list-check text-primary me-2"></i> What Banking Delegates Will Experience
                            </h5>
                            <div class="row g-2">
                                @foreach ($event->highlights as $highlight)
                                    <div class="col-md-6 col-12">
                                        <div class="p-2.5 rounded-2 bg-light border d-flex align-items-start gap-2 h-100">
                                            <i class="fa-solid fa-circle-check text-success mt-1 flex-shrink-0" style="font-size: 0.85rem;"></i>
                                            <div class="small" style="font-size: 0.78rem; line-height: 1.4;">
                                                @if($highlight->title)
                                                    <strong class="text-dark d-block">{{ $highlight->title }}</strong>
                                                @endif
                                                <span class="text-muted">{{ $highlight->description }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Speakers / Faculty -->
                    @if ($event->speakers->isNotEmpty())
                        <div class="card border rounded-3 p-3.5 p-md-4 bg-white shadow-sm mb-3.5">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.15rem;">
                                <i class="fa-solid fa-chalkboard-user text-primary me-2"></i> Featured Speakers &amp; Fellows
                            </h5>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2.5">
                                @foreach ($event->speakers as $speaker)
                                    @php
                                        $speakerImage = $speaker->image_path
                                            ? asset('storage/' . $speaker->image_path)
                                            : asset('assets/front/img/home-1/courses/client-01.png');
                                    @endphp
                                    <div class="col">
                                        <div class="p-2.5 rounded-2 border bg-light text-center h-100">
                                            <img src="{{ $speakerImage }}" alt="{{ $speaker->name }}" class="rounded-circle object-fit-cover border mb-2" style="width: 48px; height: 48px;">
                                            <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 0.82rem;">{{ $speaker->name }}</h6>
                                            <span class="text-muted d-block small text-truncate" style="font-size: 0.7rem;">{{ $speaker->title }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Sticky Summary & Registration Card (col-lg-4) -->
                <div class="col-lg-4 col-12">
                    <div class="card border rounded-3 p-3.5 bg-white shadow-sm sticky-top" style="top: 85px;">
                        <!-- Price Badge -->
                        @php
                            $isFree = empty($event->price) || (float)$event->price <= 0;
                        @endphp
                        <div class="p-3 rounded-2 text-center mb-3" style="background: {{ $isFree ? '#f0fdf4' : '#fffbeb' }}; border: 1px solid {{ $isFree ? '#bbf7d0' : '#fde68a' }};">
                            <span class="text-muted d-block small fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.05em;">REGISTRATION STATUS</span>
                            <div class="fw-bold" style="font-size: 1.55rem; color: {{ $isFree ? '#006837' : '#b45309' }};">
                                {{ $isFree ? 'Free for PBZ Staff' : currency_symbol() . number_format($event->price, 2) }}
                            </div>
                            <span class="text-muted small" style="font-size: 0.72rem;">Certificate of Attendance Included</span>
                        </div>

                        <!-- Countdown Timer (if future) -->
                        @if ($countdownTarget)
                            <div class="mb-3 p-2.5 rounded-2 bg-light border text-center" data-countdown="{{ $countdownTarget }}">
                                <span class="text-muted d-block small mb-1.5 fw-semibold" style="font-size: 0.7rem;">EVENT COMMENCES IN</span>
                                <div class="d-flex align-items-center justify-content-center gap-1.5 text-center">
                                    <div class="p-1 rounded bg-white border flex-fill">
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;" data-countdown-part="days">00</span>
                                        <span class="text-muted" style="font-size: 0.6rem;">Days</span>
                                    </div>
                                    <span class="text-muted fw-bold">:</span>
                                    <div class="p-1 rounded bg-white border flex-fill">
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;" data-countdown-part="hours">00</span>
                                        <span class="text-muted" style="font-size: 0.6rem;">Hours</span>
                                    </div>
                                    <span class="text-muted fw-bold">:</span>
                                    <div class="p-1 rounded bg-white border flex-fill">
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;" data-countdown-part="minutes">00</span>
                                        <span class="text-muted" style="font-size: 0.6rem;">Mins</span>
                                    </div>
                                    <span class="text-muted fw-bold">:</span>
                                    <div class="p-1 rounded bg-white border flex-fill">
                                        <span class="fw-bold text-dark d-block" style="font-size: 0.95rem;" data-countdown-part="seconds">00</span>
                                        <span class="text-muted" style="font-size: 0.6rem;">Secs</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Event Key Specs -->
                        <ul class="list-unstyled mb-3 small" style="font-size: 0.76rem;">
                            <li class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted"><i class="fa-regular fa-calendar me-1.5 text-primary"></i> Start Date</span>
                                <span class="fw-semibold text-dark">{{ optional($event->start_date)->format('d M, Y') ?? 'TBA' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted"><i class="fa-regular fa-calendar-check me-1.5 text-success"></i> End Date</span>
                                <span class="fw-semibold text-dark">{{ optional($event->end_date)->format('d M, Y') ?? 'Same Day' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted"><i class="fa-regular fa-clock me-1.5 text-warning"></i> Time</span>
                                <span class="fw-semibold text-dark">{{ $event->start_time ? optional($event->start_time)->format('h:i A') : '09:00 AM EAT' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted"><i class="fa-solid fa-users me-1.5 text-info"></i> Confirmed</span>
                                <span class="fw-semibold text-dark">{{ $event->confirmed_bookings_count ?? 0 }} Delegates</span>
                            </li>
                            <li class="d-flex justify-content-between py-1.5 border-bottom">
                                <span class="text-muted"><i class="fa-solid fa-chair me-1.5 text-danger"></i> Seats</span>
                                <span class="fw-semibold text-dark">{{ $event->total_seats ? $event->remainingSeats() . ' remaining' : 'Unlimited' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-1.5">
                                <span class="text-muted"><i class="fa-solid fa-location-dot me-1.5 text-danger"></i> Venue</span>
                                <span class="fw-semibold text-dark text-truncate" style="max-width: 160px;">{{ $event->location ?? 'Head Office' }}</span>
                            </li>
                        </ul>

                        <!-- Booking Action -->
                        <div>
                            @if ($event->is_published)
                                @auth
                                    <a href="{{ route('events.book', $event->slug) }}" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="font-size: 0.84rem; background-color: #006837; border-color: #006837;">
                                        <span>Reserve Delegate Seat</span>
                                        <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold d-flex align-items-center justify-content-center gap-1.5 shadow-sm" style="font-size: 0.84rem; background-color: #006837; border-color: #006837;">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                        <span>Sign In to Register</span>
                                    </a>
                                @endauth
                            @else
                                <div class="alert alert-warning py-2 text-center small m-0 rounded-2">
                                    Event in Draft Mode
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const countdownEl = document.querySelector('[data-countdown]');
                if (!countdownEl) return;

                const targetIso = countdownEl.getAttribute('data-countdown');
                if (!targetIso) {
                    countdownEl.style.display = 'none';
                    return;
                }

                const parts = {
                    days: countdownEl.querySelector('[data-countdown-part="days"]'),
                    hours: countdownEl.querySelector('[data-countdown-part="hours"]'),
                    minutes: countdownEl.querySelector('[data-countdown-part="minutes"]'),
                    seconds: countdownEl.querySelector('[data-countdown-part="seconds"]'),
                };

                const pad = (num) => num.toString().padStart(2, '0');

                function updateCountdown() {
                    const target = new Date(targetIso).getTime();
                    if (Number.isNaN(target)) {
                        countdownEl.style.display = 'none';
                        return false;
                    }

                    const now = Date.now();
                    let distance = Math.max(0, target - now);

                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    distance -= days * (1000 * 60 * 60 * 24);
                    const hours = Math.floor(distance / (1000 * 60 * 60));
                    distance -= hours * (1000 * 60 * 60);
                    const minutes = Math.floor(distance / (1000 * 60));
                    distance -= minutes * (1000 * 60);
                    const seconds = Math.floor(distance / 1000);

                    if (parts.days) parts.days.textContent = pad(days);
                    if (parts.hours) parts.hours.textContent = pad(hours);
                    if (parts.minutes) parts.minutes.textContent = pad(minutes);
                    if (parts.seconds) parts.seconds.textContent = pad(seconds);

                    return target - now > 0;
                }

                if (!updateCountdown()) return;
                setInterval(updateCountdown, 1000);
            });
        </script>
    @endpush

    <style>
        .page-hero-minimal {
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.35rem !important;
            }
        }
    </style>
@endsection

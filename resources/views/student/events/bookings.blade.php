@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Event Bookings'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-calendar-check"></i> BANKING SYMPOSIA &amp; EXECUTIVE SEMINARS
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">My Event Bookings</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Manage your reservations, auditorium passes, and accredited banking workshop credentials.</p>
                    </div>

                    <!-- Mini KPI Badges -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-ticket text-success" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Total Bookings:</span> <strong class="text-dark">{{ $bookings->total() }}</strong>
                            </div>
                        </div>
                        <a href="{{ route('events.index') }}" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5"
                           style="background-color: #006837; border-color: #006837; font-size: 12px;">
                            <i class="fa-solid fa-compass"></i> {{ __('student.explore_events_btn') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Compact Instant Search & Filter Bar -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2.5">
                    <div class="position-relative flex-grow-1" style="max-width: 360px; min-width: 220px;">
                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12px;"></i>
                        <input type="text" id="eventRealtimeSearch" class="form-control form-control-sm ps-5 rounded-2"
                               placeholder="Filter by event name or reference code..." style="font-size: 12px; border-color: #cbd5e1; height: 34px;">
                    </div>

                    <div class="d-flex align-items-center gap-1.5 flex-wrap" id="eventFilterPills">
                        <button type="button" class="btn btn-sm event-filter-pill active" data-filter="all"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #006837; color: #fff; border: 1px solid #006837;">
                            All Bookings
                        </button>
                        <button type="button" class="btn btn-sm event-filter-pill" data-filter="confirmed"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            Confirmed
                        </button>
                        <button type="button" class="btn btn-sm event-filter-pill" data-filter="pending"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            Pending
                        </button>
                    </div>
                </div>
            </div>

            <!-- Native Compact Cards Grid (Mobile First, Less Vertical Scrolling) -->
            <div class="row g-2.5" id="eventBookingsContainer">
                @forelse ($bookings as $booking)
                    <div class="col-lg-6 col-12 event-booking-item"
                         data-title="{{ strtolower($booking['event_title']) }}"
                         data-reference="{{ strtolower($booking['reference']) }}"
                         data-status="{{ strtolower($booking['status']) }}">
                        
                        <div class="card border rounded-3 p-3 bg-white h-100 shadow-none pbz-booking-card" style="border-color: #e2e8f0; transition: border-color 0.15s ease, box-shadow 0.15s ease;">
                            
                            <!-- Header Row: Title & Badges -->
                            <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-1.5 mb-1">
                                        <span class="badge px-2 py-0.5 rounded-pill" style="background: #e0f2fe; color: #0099cc; font-size: 10px; font-weight: 700;">
                                            <i class="fa-solid fa-chair me-1"></i> {{ $booking['seats'] }} {{ Str::plural('Seat', $booking['seats']) }}
                                        </span>
                                        <span class="badge px-2 py-0.5 rounded-pill" 
                                              style="{{ $booking['status'] === 'confirmed' ? 'background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;' : 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;' }} font-size: 10px; font-weight: 700;">
                                            {{ $booking['status_label'] }}
                                        </span>
                                    </div>

                                    <h5 class="fw-bold mb-0 text-truncate-2" style="font-size: 13.5px; line-height: 1.35; color: #0f172a;">
                                        {{ $booking['event_title'] }}
                                    </h5>
                                </div>
                            </div>

                            <!-- Meta Details (Date, Time, Reference) -->
                            <div class="p-2.5 rounded-2 mb-2.5 border" style="background: #f8fafc; border-color: #e2e8f0; font-size: 11.5px;">
                                <div class="row g-2">
                                    <div class="col-sm-6 col-12">
                                        <div class="text-muted" style="font-size: 10.5px;">Date &amp; Time</div>
                                        <div class="fw-semibold text-dark">
                                            @if ($booking['has_event'])
                                                <i class="fa-regular fa-calendar me-1" style="color: #0099cc;"></i> {{ $booking['start_date_formatted'] ?? 'TBD' }} 
                                                <span class="text-muted">({{ $booking['start_time_formatted'] ?? 'TBD' }})</span>
                                            @else
                                                <span class="text-muted">Event Schedule Finalized Soon</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="text-muted" style="font-size: 10.5px;">Booking Reference</div>
                                        <div>
                                            <code class="px-1.5 py-0.5 rounded" style="background: #e2e8f0; color: #0f172a; font-size: 11px; font-weight: 700;">{{ $booking['reference'] }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Row: Booked At & Ticket Button -->
                            <div class="pt-2 border-top d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #f1f5f9 !important;">
                                <span class="text-muted" style="font-size: 11px;">
                                    <i class="fa-regular fa-clock me-1"></i> Booked on {{ $booking['booked_at_formatted'] ?? 'N/A' }}
                                </span>

                                <a href="{{ $booking['ticket_url'] }}" target="_blank"
                                   class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
                                   style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
                                    <i class="fa-solid fa-ticket" style="font-size: 10px;"></i> {{ __('student.view_ticket_btn') }}
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                            <div class="mx-auto mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                <i class="fa-solid fa-calendar-xmark"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ __('student.no_events_title') }}</h5>
                            <p class="text-muted mb-3" style="font-size: 12.5px;">{{ __('student.no_events_desc') }}</p>
                            <div>
                                <a href="{{ route('events.index') }}" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2"
                                   style="background-color: #006837; border-color: #006837; font-size: 12px;">
                                    {{ __('student.explore_events_btn') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Empty Search State -->
            <div id="noSearchBookings" class="card p-4 text-center rounded-3 bg-white border shadow-none d-none mt-3" style="border-color: #e2e8f0;">
                <div class="text-muted mb-1 fs-5"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="fw-bold text-dark" style="font-size: 13.5px;">No matching event bookings found</div>
                <div class="text-muted" style="font-size: 12px;">Try adjusting your keyword or status filter.</div>
            </div>

            <!-- Pagination -->
            @if ($bookings->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $bookings->links() }}
                </div>
            @endif

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

<style>
    .pbz-booking-card:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('eventRealtimeSearch');
    const filterPills = document.querySelectorAll('.event-filter-pill');
    const bookingItems = document.querySelectorAll('.event-booking-item');
    const noSearchState = document.getElementById('noSearchBookings');

    let currentFilter = 'all';
    let currentSearch = '';

    function filterBookings() {
        let visibleCount = 0;

        bookingItems.forEach(item => {
            const title = item.dataset.title || '';
            const reference = item.dataset.reference || '';
            const status = item.dataset.status || '';

            const matchesSearch = title.includes(currentSearch) || reference.includes(currentSearch);
            const matchesFilter = (currentFilter === 'all') || (status === currentFilter);

            if (matchesSearch && matchesFilter) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (noSearchState) {
            if (visibleCount === 0 && bookingItems.length > 0) {
                noSearchState.classList.remove('d-none');
            } else {
                noSearchState.classList.add('d-none');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            currentSearch = e.target.value.toLowerCase().trim();
            filterBookings();
        });
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function() {
            filterPills.forEach(p => {
                p.classList.remove('active');
                p.style.background = '#f8fafc';
                p.style.color = '#64748b';
                p.style.borderColor = '#cbd5e1';
            });

            this.classList.add('active');
            this.style.background = '#006837';
            this.style.color = '#ffffff';
            this.style.borderColor = '#006837';

            currentFilter = this.dataset.filter;
            filterBookings();
        });
    });
});
</script>
@endpush
@endsection

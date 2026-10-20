@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Notifications'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            @php
                $unreadCount = $user->unreadNotifications()->count();
                $totalCount = $notifications->total();
            @endphp

            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-bell"></i> INSTITUTIONAL DIRECTIVES &amp; ALERTS
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">Notifications &amp; Activity Stream</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Review important compliance notices, assessment grades, and administrative academy broadcasts.</p>
                    </div>

                    <!-- Mini KPI Badges & Mark All Read -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-bell text-primary" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Total:</span> <strong class="text-dark">{{ $totalCount }}</strong>
                            </div>
                        </div>
                        <div class="p-2 px-3 rounded-2 border d-flex align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0;">
                            <i class="fa-solid fa-envelope-open-text text-warning" style="font-size: 14px;"></i>
                            <div style="font-size: 11.5px;">
                                <span class="text-muted">Unread:</span> <strong class="text-dark">{{ $unreadCount }}</strong>
                            </div>
                        </div>

                        @if($unreadCount > 0)
                            <a href="{{ route('student.notifications.readAll') }}" 
                               class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5"
                               style="background-color: #006837; border-color: #006837; font-size: 12px;">
                                <i class="fa-solid fa-check-double"></i> Mark All Read
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Compact Instant Filter Bar -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2.5">
                    <div class="d-flex align-items-center gap-1.5 flex-wrap" id="notifFilterPills">
                        <button type="button" class="btn btn-sm notif-filter-pill active" data-filter="all"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #006837; color: #fff; border: 1px solid #006837;">
                            All ({{ $totalCount }})
                        </button>
                        <button type="button" class="btn btn-sm notif-filter-pill" data-filter="unread"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            Unread ({{ $unreadCount }})
                        </button>
                        <button type="button" class="btn btn-sm notif-filter-pill" data-filter="read"
                                style="font-size: 11.5px; border-radius: 20px; padding: 3px 12px; font-weight: 600; background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;">
                            Read ({{ max(0, $totalCount - $unreadCount) }})
                        </button>
                    </div>

                    <div class="position-relative flex-grow-1" style="max-width: 320px; min-width: 200px;">
                        <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12px;"></i>
                        <input type="text" id="notifRealtimeSearch" class="form-control form-control-sm ps-5 rounded-2"
                               placeholder="Filter notification messages..." style="font-size: 12px; border-color: #cbd5e1; height: 34px;">
                    </div>
                </div>
            </div>

            <!-- Notifications List (Native Compact Cards) -->
            <div id="notifListContainer">
                @forelse($notifications as $notification)
                    @php
                        $isUnread = !$notification->read_at;
                        $notifType = $notification->data['type'] ?? '';
                        $title = $notification->data['title'] ?? 'System Notification';
                        $message = $notification->data['message'] ?? '';
                    @endphp

                    <div class="card border rounded-3 p-3 mb-2 bg-white shadow-none notif-item {{ $isUnread ? 'is-unread' : 'is-read' }}"
                         data-status="{{ $isUnread ? 'unread' : 'read' }}"
                         data-text="{{ strtolower($title . ' ' . $message) }}"
                         style="border-color: {{ $isUnread ? '#0099cc' : '#e2e8f0' }}; {{ $isUnread ? 'border-left: 4px solid #0099cc !important;' : '' }} transition: border-color 0.15s ease, box-shadow 0.15s ease;">
                        
                        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                            <!-- Icon & Content Group -->
                            <div class="d-flex align-items-start gap-2.5 flex-grow-1 min-w-0">
                                <!-- Type Icon Circle -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 34px; height: 34px; font-size: 13px; {{ $isUnread ? 'background: #e0f2fe; color: #0099cc;' : 'background: #f1f5f9; color: #64748b;' }}">
                                    @if(str_contains(strtolower($notifType), 'course') || str_contains(strtolower($title), 'course'))
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    @elseif(str_contains(strtolower($notifType), 'quiz') || str_contains(strtolower($title), 'quiz'))
                                        <i class="fa-solid fa-circle-question"></i>
                                    @elseif(str_contains(strtolower($notifType), 'assignment') || str_contains(strtolower($title), 'assignment'))
                                        <i class="fa-solid fa-file-contract"></i>
                                    @else
                                        <i class="fa-solid fa-bell"></i>
                                    @endif
                                </div>

                                <div class="min-w-0 flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 13.5px; line-height: 1.3;">
                                            {{ $title }}
                                        </h5>
                                        @if($isUnread)
                                            <span class="badge px-2 py-0.5 rounded-pill" style="background: #e0f2fe; color: #0099cc; font-size: 10px; font-weight: 700;">
                                                New
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-muted mb-1.5" style="font-size: 12.5px; line-height: 1.45;">
                                        {{ $message }}
                                    </p>

                                    <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 11px;">
                                        <span>
                                            <i class="fa-regular fa-clock me-1 text-primary"></i> {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center gap-2 flex-shrink-0 align-self-center pt-1 pt-sm-0">
                                @if($isUnread)
                                    <form action="{{ route('student.notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 text-muted" style="font-size: 11.5px; font-weight: 600;">
                                            <i class="fa-solid fa-check me-0.5"></i> {{ __('student.mark_as_read') }}
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('student.notifications.read', $notification->id) }}"
                                   class="btn btn-sm text-white fw-bold px-3 py-1 rounded-2 d-inline-flex align-items-center gap-1"
                                   style="background-color: #006837; border-color: #006837; font-size: 11.5px;">
                                    View Details <i class="fa-solid fa-arrow-right" style="font-size: 9px;"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                        <div class="mx-auto mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa-solid fa-bell-slash"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">No Notifications</h5>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">You have no unread directives or system notices right now.</p>
                    </div>
                @endforelse

                <!-- Empty Search State -->
                <div id="noSearchNotifs" class="card p-4 text-center rounded-3 bg-white border shadow-none d-none mt-2" style="border-color: #e2e8f0;">
                    <div class="text-muted mb-1 fs-5"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <div class="fw-bold text-dark" style="font-size: 13.5px;">No matching notifications</div>
                    <div class="text-muted" style="font-size: 12px;">Try adjusting your keyword or status filter.</div>
                </div>

                <!-- Pagination -->
                @if ($notifications->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

<style>
    .notif-item:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('notifRealtimeSearch');
    const filterPills = document.querySelectorAll('.notif-filter-pill');
    const notifItems = document.querySelectorAll('.notif-item');
    const noSearchState = document.getElementById('noSearchNotifs');

    let currentFilter = 'all';
    let currentSearch = '';

    function filterNotifications() {
        let visibleCount = 0;

        notifItems.forEach(item => {
            const text = item.dataset.text || '';
            const status = item.dataset.status || '';

            const matchesSearch = text.includes(currentSearch);
            const matchesFilter = (currentFilter === 'all') || (status === currentFilter);

            if (matchesSearch && matchesFilter) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        if (noSearchState) {
            if (visibleCount === 0 && notifItems.length > 0) {
                noSearchState.classList.remove('d-none');
            } else {
                noSearchState.classList.add('d-none');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            currentSearch = e.target.value.toLowerCase().trim();
            filterNotifications();
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
            filterNotifications();
        });
    });
});
</script>
@endpush
@endsection
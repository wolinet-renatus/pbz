@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    @include('student.partials.sidebar')

    <div class="pbz-saas-main">
        @include('student.partials.topbar', ['pageTitle' => 'Statutory Compliance Hub'])

        <div class="pbz-saas-content-area p-3 p-md-4" style="max-width: 1200px; margin: 0 auto;">

            <!-- 1. Sleek Compliance Header Card -->
            <div class="card border-0 rounded-4 text-white mb-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #07172b 0%, #0d2847 60%, #0f3661 100%);">
                <div class="card-body p-4 p-md-4 position-relative">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8 col-12">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 10.5px; letter-spacing: 0.04em;">
                                    <i class="fa-solid fa-scale-balanced me-1"></i> Bank of Tanzania (BOT) Statutory Tracker
                                </span>
                                @if($isBranchManager)
                                    <span class="badge rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); font-size: 10.5px;">
                                        Supervisory Access
                                    </span>
                                @endif
                            </div>

                            <h3 class="fw-bold mb-1 text-white" style="font-size: 1.6rem; letter-spacing: -0.02em;">
                                {{ $user->name }}
                            </h3>
                            <p class="text-white-50 mb-0" style="font-size: 13px;">
                                <i class="fa-solid fa-location-dot me-1 text-info"></i> {{ $user->branch->name ?? 'Zanzibar Branch' }} &bull;
                                <span class="text-white">{{ $user->job_title ?: 'PBZ Banking Officer' }}</span>
                            </p>
                        </div>

                        <!-- Compliance Score Pill -->
                        <div class="col-lg-4 col-12 text-lg-end text-start">
                            <div class="d-inline-flex align-items-center gap-3 p-2.5 px-3.5 rounded-3" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.12);">
                                <div>
                                    <div class="text-uppercase fw-semibold" style="font-size: 10.5px; color: #94a3b8; letter-spacing: 0.05em;">Compliance Score</div>
                                    <div class="fw-bold text-white" style="font-size: 1.75rem; line-height: 1.1;">
                                        {{ $complianceData['compliance_rate'] }}%
                                    </div>
                                </div>
                                <div class="vr bg-white opacity-25" style="height: 36px;"></div>
                                <div>
                                    @if($complianceData['compliance_rate'] >= 80)
                                        <span class="badge bg-success rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">
                                            <i class="fa-solid fa-check me-1"></i> AUDIT READY
                                        </span>
                                    @elseif($complianceData['compliance_rate'] >= 50)
                                        <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">
                                            <i class="fa-solid fa-clock me-1"></i> IN PROGRESS
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-2.5 py-1 fw-bold" style="font-size: 11px;">
                                            <i class="fa-solid fa-exclamation me-1"></i> ACTION REQUIRED
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($isBranchManager)
                                <div class="mt-2.5">
                                    <a href="{{ route('student.compliance.branch-matrix') }}" class="btn btn-sm text-decoration-none fw-bold px-3 py-1.5 rounded-pill shadow-sm" style="background: #00c0f3; color: #07172b; font-size: 12px; border: none;">
                                        <i class="fa-solid fa-building-shield me-1"></i> Branch Oversight Matrix &rarr;
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Clean 3-Metric Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Satisfied Mandates</span>
                                <div class="fs-4 fw-bold text-dark mt-0.5">
                                    {{ $complianceData['completed'] }} <span class="text-muted fw-normal" style="font-size: 14px;">/ {{ $complianceData['total_assigned'] }}</span>
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #dcfce7; color: #16a34a; font-size: 14px;">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Active / In Progress</span>
                                <div class="fs-4 fw-bold text-dark mt-0.5">
                                    {{ $complianceData['in_progress'] }} <span class="text-muted fw-normal" style="font-size: 14px;">modules</span>
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #e0f2fe; color: #0284c7; font-size: 14px;">
                                <i class="fa-solid fa-spinner"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none" style="{{ $complianceData['overdue_count'] > 0 ? 'border-color: #fca5a5 !important;' : '' }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Overdue Alerts</span>
                                <div class="fs-4 fw-bold {{ $complianceData['overdue_count'] > 0 ? 'text-danger' : 'text-dark' }} mt-0.5">
                                    {{ $complianceData['overdue_count'] }} <span class="text-muted fw-normal" style="font-size: 14px;">statutory</span>
                                </div>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: {{ $complianceData['overdue_count'] > 0 ? '#fee2e2' : '#f1f5f9' }}; color: {{ $complianceData['overdue_count'] > 0 ? '#dc2626' : '#64748b' }}; font-size: 14px;">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Primary Card: Mandatory Compliance Modules -->
            <div class="card border rounded-4 bg-white shadow-none mb-4 overflow-hidden">
                <div class="p-3.5 px-4 border-bottom bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 15px;">
                            Your Regulatory Compliance Mandates
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">Complete each module before statutory deadline to prevent supervisory escalation.</p>
                    </div>

                    <!-- Clean Status Filter -->
                    <div class="btn-group btn-group-sm" role="group" id="mandateFilters">
                        <button type="button" class="btn btn-outline-secondary active fw-semibold" data-filter="all" style="font-size: 11.5px;">All ({{ $complianceData['total_assigned'] }})</button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold" data-filter="pending" style="font-size: 11.5px;">Pending ({{ $complianceData['in_progress'] }})</button>
                        <button type="button" class="btn btn-outline-secondary fw-semibold" data-filter="completed" style="font-size: 11.5px;">Completed ({{ $complianceData['completed'] }})</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;">
                            <tr>
                                <th class="ps-4 py-3">Mandate Course</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Statutory Deadline</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($complianceData['enrollments'] as $enrollment)
                                @php
                                    $course = $enrollment->course;
                                    $isOverdue = $enrollment->isOverdue();
                                    $isCompleted = $enrollment->isCompleted();
                                    $daysRemaining = $enrollment->daysRemaining();
                                    $filterClass = $isCompleted ? 'filter-completed' : 'filter-pending';
                                @endphp
                                <tr class="mandate-row {{ $filterClass }}">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: #07172b; color: #38bdf8; font-size: 14px;">
                                                <i class="fa-solid fa-shield-halved"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 13.5px;">
                                                    {{ $course->title }}
                                                </div>
                                                <div class="text-muted" style="font-size: 11.5px;">
                                                    Validity: {{ $course->validity_months ?: 12 }} Months &bull; Est: {{ $course->estimated_minutes ?: 20 }} mins
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($course->compliance_category === 'aml_cft')
                                            <span class="badge rounded-pill" style="background: rgba(239, 68, 68, 0.12); color: #dc2626; font-size: 11px; font-weight: 600;">
                                                AML / CFT Directive
                                            </span>
                                        @elseif($course->compliance_category === 'kyc')
                                            <span class="badge rounded-pill" style="background: rgba(245, 158, 11, 0.12); color: #b45309; font-size: 11px; font-weight: 600;">
                                                KYC &amp; Due Diligence
                                            </span>
                                        @elseif($course->compliance_category === 'cyber_hygiene')
                                            <span class="badge rounded-pill" style="background: rgba(14, 165, 233, 0.12); color: #0284c7; font-size: 11px; font-weight: 600;">
                                                Cyber Hygiene
                                            </span>
                                        @else
                                            <span class="badge rounded-pill" style="background: rgba(16, 185, 129, 0.12); color: #047857; font-size: 11px; font-weight: 600;">
                                                BOT Directives
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isCompleted)
                                            <span class="badge rounded-pill px-2.5 py-1" style="background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 10.5px;">
                                                <i class="fa-solid fa-check me-1"></i> COMPLIANT
                                            </span>
                                        @elseif($isOverdue)
                                            <span class="badge rounded-pill px-2.5 py-1" style="background: #fee2e2; color: #dc2626; font-weight: 700; font-size: 10.5px;">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> OVERDUE
                                            </span>
                                        @elseif($enrollment->is_escalated)
                                            <span class="badge rounded-pill px-2.5 py-1" style="background: #fef3c7; color: #d97706; font-weight: 700; font-size: 10.5px;">
                                                <i class="fa-solid fa-bullhorn me-1"></i> ESCALATED
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-2.5 py-1" style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 10.5px;">
                                                IN PROGRESS
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isCompleted)
                                            <span class="text-muted" style="font-size: 12px;">Verified on {{ $enrollment->completed_at?->format('M d, Y') ?? 'Cycle' }}</span>
                                        @elseif($isOverdue)
                                            <span class="fw-bold text-danger d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                                <i class="fa-solid fa-circle-exclamation"></i> Deadline Passed
                                            </span>
                                        @elseif($daysRemaining !== null)
                                            <span class="fw-bold {{ $daysRemaining <= 7 ? 'text-danger' : ($daysRemaining <= 14 ? 'text-warning' : 'text-dark') }}" style="font-size: 12.5px;">
                                                {{ $daysRemaining }} days remaining
                                            </span>
                                            <div class="text-muted" style="font-size: 11px;">Due: {{ $enrollment->due_date?->format('M d, Y') }}</div>
                                        @else
                                            <span class="text-muted" style="font-size: 12px;">Active Cycle</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('student.courses.access', $course->id) }}" class="btn btn-sm px-3.5 py-1 rounded-2 fw-semibold" style="{{ $isCompleted ? 'background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;' : 'background: #00c0f3; color: #07172b; border: none; font-weight: 700;' }} font-size: 11.5px;">
                                            {{ $isCompleted ? 'Review Module' : 'Launch Session' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-muted">
                                        No statutory compliance courses are currently assigned.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. Fast Microlearning Modules (Compact 3-Item Row) -->
            @if($microlearningCourses->count() > 0)
                <div class="card border rounded-4 bg-white shadow-none p-3.5 px-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13.5px;">
                                <i class="fa-solid fa-bolt text-warning me-1.5"></i> 5–10 Min Branch Micro-Scenarios
                            </h6>
                            <span class="text-muted" style="font-size: 11.5px;">Quick dilemmas between teller customer queues.</span>
                        </div>
                        <a href="{{ route('courses') }}" class="text-decoration-none text-muted fw-semibold" style="font-size: 11.5px;">
                            Browse All &rarr;
                        </a>
                    </div>

                    <div class="row g-2.5">
                        @foreach($microlearningCourses as $micro)
                            <div class="col-md-4 col-12">
                                <div class="p-2.5 rounded-3 border bg-light d-flex align-items-center justify-content-between gap-2">
                                    <div class="min-w-0">
                                        <div class="fw-semibold text-dark text-truncate" style="font-size: 12.5px;">{{ $micro->title }}</div>
                                        <span class="badge bg-secondary-subtle text-secondary" style="font-size: 10px;">{{ $micro->estimated_minutes ?: 8 }} mins</span>
                                    </div>
                                    <a href="{{ route('student.courses.access', $micro->id) }}" class="btn btn-sm btn-outline-primary py-0.5 px-2 rounded-2 flex-shrink-0" style="font-size: 11px;">
                                        Start
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterButtons = document.querySelectorAll('#mandateFilters button');
        const rows = document.querySelectorAll('.mandate-row');

        filterButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                rows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else if (filter === 'completed') {
                        row.style.display = row.classList.contains('filter-completed') ? '' : 'none';
                    } else if (filter === 'pending') {
                        row.style.display = row.classList.contains('filter-pending') ? '' : 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection

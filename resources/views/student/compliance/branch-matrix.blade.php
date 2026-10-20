@extends('layouts.student')

@section('content')
@php
    $routePrefix = request()->routeIs('admin.*') ? 'admin' : 'student';
    $assignRoute = route($routePrefix . '.compliance.assign-mandate');
@endphp

<div class="pbz-saas-shell">
    @include('student.partials.sidebar')

    <div class="pbz-saas-main">
        @include('student.partials.topbar', ['pageTitle' => 'Branch Regulatory Oversight Matrix'])

        <div class="pbz-saas-content-area p-3 p-md-4" style="max-width: 1400px; margin: 0 auto;">

            <!-- 1. Role Detection & Access Control Banner -->
            <div class="card border-0 rounded-4 text-white mb-4 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #07172b 0%, #0d2847 60%, #0c3358 100%); border-left: 5px solid #00c0f3 !important;">
                <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1.5">
                            @if($isAdmin)
                                <span class="badge rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="background: rgba(0, 192, 243, 0.18); color: #38bdf8; border: 1px solid rgba(0, 192, 243, 0.35); font-size: 11px;">
                                    <i class="fa-solid fa-user-shield me-1"></i> Executive Admin Oversight
                                </span>
                                <span class="badge rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="background: rgba(34, 197, 94, 0.18); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.35); font-size: 11px;">
                                    Full CUD Permissions Active
                                </span>
                            @elseif($isBranchManager)
                                <span class="badge rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="background: rgba(249, 237, 39, 0.18); color: #fde047; border: 1px solid rgba(249, 237, 39, 0.35); font-size: 11px;">
                                    <i class="fa-solid fa-building-user me-1"></i> Branch Manager Supervisory Access
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-2.5 py-1 text-uppercase fw-bold" style="font-size: 11px;">
                                    Auditor Read-Only Access
                                </span>
                            @endif
                        </div>

                        <h3 class="fw-bold mb-1 text-white" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            Branch Regulatory Compliance Ledger
                        </h3>
                        <p class="text-white-50 mb-0" style="font-size: 13px;">
                            Bank of Tanzania (BOT) statutory audit matrix &bull; AML/CFT, KYC, and Fiduciary Mandates for PBZ Branch Officers.
                        </p>
                    </div>

                    <!-- Authoritative Actions for Administrator / Branch Manager -->
                    @if($isAdmin || $isBranchManager)
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm fw-bold px-3 py-2 rounded-2 shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#assignMandateModal" style="background: #00c0f3; color: #07172b; border: none; font-size: 12.5px;">
                                <i class="fa-solid fa-plus-circle"></i> Direct Assign Mandate
                            </button>

                            @if($isAdmin)
                                <button type="button" class="btn btn-sm fw-bold px-3 py-2 rounded-2 shadow-sm d-flex align-items-center gap-2 text-white" data-bs-toggle="modal" data-bs-target="#bulkAssignModal" style="background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.25); font-size: 12.5px;">
                                    <i class="fa-solid fa-users-gear"></i> Bulk Branch Cycle
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. Controls & Branch Filter Bar -->
            <div class="card border rounded-3 p-3 bg-white shadow-none mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <form action="{{ url()->current() }}" method="GET" class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 450px;">
                        <span class="text-muted small fw-semibold text-nowrap"><i class="fa-solid fa-filter me-1 text-primary"></i> Scope Branch:</span>
                        <select name="branch_id" class="form-select form-select-sm shadow-none" onchange="this.form.submit()" style="border-radius: 8px; font-weight: 500;">
                            @if($isAdmin)
                                <option value="">All PBZ Branches (Consolidated Network)</option>
                            @endif
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ $selectedBranchId == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }} ({{ $b->region }})
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <span>Showing: <strong>{{ $matrixData['total_staff'] }}</strong> staff records</span>
                        <span class="text-secondary">&bull;</span>
                        <span class="badge {{ $matrixData['branch_compliance_score'] >= 85 ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-2.5 py-1">
                            {{ $matrixData['branch_compliance_score'] }}% Branch Health
                        </span>
                    </div>
                </div>
            </div>

            <!-- 3. Key Performance Indicators -->
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Regulatory Score</span>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #e0f2fe; color: #0284c7;">
                                <i class="fa-solid fa-scale-balanced" style="font-size: 13px;"></i>
                            </div>
                        </div>
                        <div class="fs-3 fw-bold text-dark mb-0.5">
                            {{ $matrixData['branch_compliance_score'] }}%
                        </div>
                        <span class="text-muted" style="font-size: 11.5px;">Statutory Threshold: &ge; 85%</span>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Active Roster</span>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #f1f5f9; color: #475569;">
                                <i class="fa-solid fa-users" style="font-size: 13px;"></i>
                            </div>
                        </div>
                        <div class="fs-3 fw-bold text-dark mb-0.5">
                            {{ $matrixData['total_staff'] }}
                        </div>
                        <span class="text-muted" style="font-size: 11.5px;">Staff under audit tracking</span>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none" style="{{ $matrixData['total_overdue'] > 0 ? 'border-color: #fca5a5 !important;' : '' }}">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Overdue Mandates</span>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: {{ $matrixData['total_overdue'] > 0 ? '#fee2e2' : '#f1f5f9' }}; color: {{ $matrixData['total_overdue'] > 0 ? '#dc2626' : '#64748b' }};">
                                <i class="fa-solid fa-triangle-exclamation" style="font-size: 13px;"></i>
                            </div>
                        </div>
                        <div class="fs-3 fw-bold {{ $matrixData['total_overdue'] > 0 ? 'text-danger' : 'text-dark' }} mb-0.5">
                            {{ $matrixData['total_overdue'] }}
                        </div>
                        <span class="text-muted" style="font-size: 11.5px;">Window expired mandates</span>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card border rounded-3 p-3 bg-white h-100 shadow-none">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Active Escalations</span>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #fef3c7; color: #d97706;">
                                <i class="fa-solid fa-bullhorn" style="font-size: 13px;"></i>
                            </div>
                        </div>
                        <div class="fs-3 fw-bold text-dark mb-0.5">
                            {{ $matrixData['escalated_staff_count'] }}
                        </div>
                        <span class="text-muted" style="font-size: 11.5px;">Formal alerts dispatched</span>
                    </div>
                </div>
            </div>

            <!-- 4. Staff Compliance Adherence Ledger Table -->
            <div class="card border rounded-4 bg-white shadow-none overflow-hidden mb-4">
                <div class="p-3.5 px-4 border-bottom bg-light d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark" style="font-size: 15px;">
                            Staff Compliance Ledger
                        </h5>
                        <p class="text-muted mb-0" style="font-size: 12px;">Audited breakdown per employee with supervisory CUD operations.</p>
                    </div>

                    <span class="badge bg-white text-muted border rounded-pill px-3 py-1" style="font-size: 11.5px;">
                        {{ count($matrixData['matrix_rows']) }} Enrolled Officers
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em;">
                            <tr>
                                <th class="ps-4 py-3">Staff Officer</th>
                                <th>Branch &amp; Dept</th>
                                <th>Mandate Progress</th>
                                <th>Audit Status</th>
                                <th>Enrolled Mandate Modules</th>
                                <th class="text-end pe-4">Supervisory Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($matrixData['matrix_rows'] as $row)
                                @php
                                    $staff = $row['user'];
                                    $status = $row['status'];
                                    $rate = $status['compliance_rate'];
                                    $overdue = $status['overdue_count'];
                                    $enrollments = $status['enrollments'];
                                @endphp
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 36px; height: 36px; background: #07172b; color: #38bdf8; font-size: 12px;">
                                                {{ strtoupper(substr($staff->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 13.5px;">{{ $staff->name }}</div>
                                                <div class="text-muted" style="font-size: 11.5px;">
                                                    {{ $staff->employee_id ?: 'PBZ-'.str_pad($staff->id, 5, '0', STR_PAD_LEFT) }} &bull; {{ $staff->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark" style="font-size: 12.5px;">{{ $staff->branch->name ?? 'Zanzibar Branch' }}</div>
                                        <div class="text-muted" style="font-size: 11.5px;">{{ $staff->job_title ?: 'Banking Officer' }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2" style="width: 140px;">
                                            <div class="progress flex-grow-1 rounded-pill" style="height: 6px; background: #e2e8f0;">
                                                <div class="progress-bar rounded-pill" style="width: {{ $rate }}%; background-color: {{ $rate >= 80 ? '#16a34a' : ($rate >= 50 ? '#f59e0b' : '#dc2626') }};"></div>
                                            </div>
                                            <span class="fw-bold text-dark" style="font-size: 12px;">{{ $rate }}%</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 11px;">
                                            {{ $status['completed'] }}/{{ $status['total_assigned'] }} Completed
                                        </div>
                                    </td>
                                    <td>
                                        @if($overdue > 0)
                                            <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #fee2e2; color: #dc2626; font-size: 11px;">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $overdue }} OVERDUE
                                            </span>
                                        @elseif($row['has_escalated'])
                                            <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #fef3c7; color: #d97706; font-size: 11px;">
                                                <i class="fa-solid fa-bullhorn me-1"></i> ESCALATED
                                            </span>
                                        @elseif($status['expiring_soon_count'] > 0)
                                            <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #fef3c7; color: #b45309; font-size: 11px;">
                                                {{ $status['expiring_soon_count'] }} Expiring Soon
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-2.5 py-1 fw-bold" style="background: #dcfce7; color: #16a34a; font-size: 11px;">
                                                <i class="fa-solid fa-check me-1"></i> COMPLIANT
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Enrolled Mandate Badges with Quick Management -->
                                        <div class="d-flex flex-column gap-1.5" style="max-width: 280px;">
                                            @foreach($enrollments as $enr)
                                                <div class="p-1.5 px-2 rounded-2 border d-flex align-items-center justify-content-between gap-2" style="background: #f8fafc; font-size: 11.5px;">
                                                    <div class="text-truncate" title="{{ $enr->course->title }}">
                                                        <span class="fw-semibold text-dark">{{ \Illuminate\Support\Str::limit($enr->course->title, 22) }}</span>
                                                        <span class="d-block text-muted" style="font-size: 10px;">
                                                            @if($enr->isCompleted())
                                                                <span class="text-success"><i class="fa-solid fa-check"></i> Certified</span>
                                                            @elseif($enr->isOverdue())
                                                                <span class="text-danger fw-bold"><i class="fa-solid fa-clock"></i> Overdue</span>
                                                            @else
                                                                <span>Due: {{ $enr->due_date?->format('M d') ?? 'Active' }}</span>
                                                            @endif
                                                        </span>
                                                    </div>

                                                    @if($isAdmin || $isBranchManager)
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-light border py-0 px-1.5 rounded-1 text-muted" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 11px;">
                                                                <i class="fa-solid fa-ellipsis"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size: 12px;">
                                                                <li>
                                                                    <a class="dropdown-item extend-deadline-btn" href="#" data-enr-id="{{ $enr->id }}" data-course-title="{{ $enr->course->title }}" data-staff-name="{{ $staff->name }}" data-current-due="{{ $enr->due_date?->format('Y-m-d') }}">
                                                                        <i class="fa-solid fa-calendar-plus text-primary me-2"></i> Extend Statutory Deadline
                                                                    </a>
                                                                </li>
                                                                @if(!$enr->isCompleted())
                                                                    <li>
                                                                        <a class="dropdown-item verify-compliance-btn" href="#" data-enr-id="{{ $enr->id }}" data-course-title="{{ $enr->course->title }}" data-staff-name="{{ $staff->name }}">
                                                                            <i class="fa-solid fa-check-double text-success me-2"></i> Mark Certified / Waive
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if($isAdmin)
                                                                    <li><hr class="dropdown-divider"></li>
                                                                    <li>
                                                                        <a class="dropdown-item text-danger revoke-mandate-btn" href="#" data-enr-id="{{ $enr->id }}" data-course-title="{{ $enr->course->title }}" data-staff-name="{{ $staff->name }}">
                                                                            <i class="fa-solid fa-trash me-2"></i> Revoke / Unassign Mandate
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-inline-flex align-items-center gap-1.5">
                                            @if($overdue > 0 || $row['has_escalated'])
                                                @php
                                                    $firstOverdueEnr = $enrollments->firstWhere(fn($e) => $e->isOverdue()) ?? $enrollments->first();
                                                @endphp
                                                @if($row['has_escalated'])
                                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-2.5 py-1 resolve-escalation-btn" data-enr-id="{{ $firstOverdueEnr?->id }}" title="Clear escalation alert" style="font-size: 11.5px;">
                                                        <i class="fa-solid fa-check me-1"></i> Resolve Alert
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-2.5 py-1 fw-semibold escalate-btn" data-enr-id="{{ $firstOverdueEnr?->id }}" style="font-size: 11.5px;">
                                                        <i class="fa-solid fa-bullhorn me-1"></i> Escalate Alert
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-success small fw-semibold">
                                                    <i class="fa-solid fa-circle-check me-1"></i> Good Standing
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-muted">
                                        No staff members found under the selected branch filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ==================================================================== -->
<!-- MODAL 1: [CREATE] DIRECT ASSIGN COMPLIANCE MANDATE                   -->
<!-- ==================================================================== -->
<div class="modal fade" id="assignMandateModal" tabindex="-1" aria-labelledby="assignMandateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom p-3.5 px-4" style="background: #07172b; color: #ffffff;">
                <h5 class="modal-title fw-bold" id="assignMandateModalLabel" style="font-size: 15px;">
                    <i class="fa-solid fa-plus-circle text-info me-2"></i> Assign Statutory Compliance Mandate
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $assignRoute }}" method="POST" id="assignMandateForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Target Staff Officer</label>
                        <select name="user_id" class="form-select form-select-sm" required style="border-radius: 8px;">
                            <option value="">-- Choose Staff Officer --</option>
                            @foreach($availableStaff as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->job_title ?: 'Officer' }} - {{ $s->email }})</option>
                            @endforeach
                            @if($isAdmin)
                                <option value="all_branch" style="font-weight: 700; color: #0284c7;">&bull; ALL Staff Members in Current Scope</option>
                            @endif
                        </select>
                        <input type="hidden" name="branch_id" value="{{ $selectedBranchId }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Statutory Compliance Course</label>
                        <select name="course_id" class="form-select form-select-sm" required style="border-radius: 8px;">
                            <option value="">-- Select Statutory Module --</option>
                            @foreach($availableCourses as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->title }} [{{ strtoupper($c->compliance_category ?: 'BOT DIRECTIVE') }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark small">Window Duration</label>
                            <select name="days_allowed" class="form-select form-select-sm" style="border-radius: 8px;">
                                <option value="14">14 Days (Urgent)</option>
                                <option value="30" selected>30 Days (Standard Statutory)</option>
                                <option value="60">60 Days (Extended)</option>
                                <option value="90">90 Days (Quarterly Audit)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-dark small">Or Custom Deadline</label>
                            <input type="date" name="custom_due_date" class="form-control form-control-sm" style="border-radius: 8px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 px-4 bg-light">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm fw-bold px-4 rounded-2" style="background: #00c0f3; color: #07172b; border: none;">
                        Assign Mandate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================================================================== -->
<!-- MODAL 2: [CREATE BULK] BULK BRANCH CYCLE ASSIGNMENT                  -->
<!-- ==================================================================== -->
@if($isAdmin)
<div class="modal fade" id="bulkAssignModal" tabindex="-1" aria-labelledby="bulkAssignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom p-3.5 px-4" style="background: #07172b; color: #ffffff;">
                <h5 class="modal-title fw-bold" id="bulkAssignModalLabel" style="font-size: 15px;">
                    <i class="fa-solid fa-users-gear text-info me-2"></i> Trigger Branch Cohort Compliance Cycle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $assignRoute }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="all_branch">
                <input type="hidden" name="branch_id" value="{{ $selectedBranchId }}">
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        This action enrolls all active staff officers within the selected branch scope into the chosen statutory directive with a unified statutory deadline.
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Select Statutory Mandate</label>
                        <select name="course_id" class="form-select form-select-sm" required style="border-radius: 8px;">
                            @foreach($availableCourses as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Mandate Completion Window</label>
                        <select name="days_allowed" class="form-select form-select-sm" style="border-radius: 8px;">
                            <option value="14">14 Days Window</option>
                            <option value="30" selected>30 Days Standard Statutory Window</option>
                            <option value="45">45 Days Cohort Window</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 px-4 bg-light">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm fw-bold px-4 rounded-2" style="background: #00c0f3; color: #07172b; border: none;">
                        Trigger Bulk Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ==================================================================== -->
<!-- MODAL 3: [UPDATE] EXTEND STATUTORY DEADLINE                          -->
<!-- ==================================================================== -->
<div class="modal fade" id="extendDeadlineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom p-3.5 px-4" style="background: #07172b; color: #ffffff;">
                <h5 class="modal-title fw-bold" style="font-size: 15px;">
                    <i class="fa-solid fa-calendar-plus text-info me-2"></i> Extend Statutory Deadline
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="extendDeadlineForm" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="mb-2" style="font-size: 13px;">
                        Staff Officer: <strong id="extendStaffName" class="text-dark"></strong><br>
                        Course Mandate: <span id="extendCourseTitle" class="text-muted"></span>
                    </p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark small">Add Days to Deadline</label>
                        <div class="d-flex gap-2 mb-2">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 quick-days-btn" data-days="7">+7 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 quick-days-btn" data-days="14">+14 Days</button>
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 quick-days-btn" data-days="30">+30 Days</button>
                        </div>
                        <input type="hidden" name="days" id="extendDaysInput" value="14">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-semibold text-dark small">Or Pick Exact Date</label>
                        <input type="date" name="new_due_date" id="extendCustomDate" class="form-control form-control-sm" style="border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer border-top p-3 px-4 bg-light">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm fw-bold px-4 rounded-2" style="background: #00c0f3; color: #07172b; border: none;">
                        Save Extension
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================================================================== -->
<!-- MODAL 4: [DELETE] CONFIRM REVOKE / UNASSIGN MANDATE                  -->
<!-- ==================================================================== -->
<div class="modal fade" id="revokeMandateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom p-3.5 px-4 bg-danger text-white">
                <h5 class="modal-title fw-bold" style="font-size: 15px;">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> Confirm Mandate Revocation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="revokeMandateForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4">
                    <p class="mb-2 text-dark" style="font-size: 13.5px;">
                        Are you sure you want to unassign <strong id="revokeCourseTitle"></strong> from <strong id="revokeStaffName"></strong>?
                    </p>
                    <p class="text-muted small mb-0">
                        This action removes the enrollment record and any active escalation alerts associated with it. This is typically done if a mandate was assigned mistakenly or staff transferred roles.
                    </p>
                </div>
                <div class="modal-footer border-top p-3 px-4 bg-light">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3 rounded-2" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger fw-bold px-4 rounded-2">
                        Confirm Revoke
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const routePrefix = '{{ $routePrefix }}';

        // 1. Extend Deadline Handler
        document.querySelectorAll('.extend-deadline-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enrId = this.getAttribute('data-enr-id');
                const courseTitle = this.getAttribute('data-course-title');
                const staffName = this.getAttribute('data-staff-name');
                const currentDue = this.getAttribute('data-current-due');

                document.getElementById('extendStaffName').textContent = staffName;
                document.getElementById('extendCourseTitle').textContent = courseTitle;
                document.getElementById('extendCustomDate').value = currentDue || '';

                const form = document.getElementById('extendDeadlineForm');
                form.action = '/' + (routePrefix === 'admin' ? 'admin' : 'student') + '/compliance/extend-deadline/' + enrId;

                const modal = new bootstrap.Modal(document.getElementById('extendDeadlineModal'));
                modal.show();
            });
        });

        // Quick Days selection buttons in Extend Modal
        document.querySelectorAll('.quick-days-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.quick-days-btn').forEach(b => b.classList.remove('active', 'btn-primary'));
                this.classList.add('active', 'btn-primary');
                document.getElementById('extendDaysInput').value = this.getAttribute('data-days');
                document.getElementById('extendCustomDate').value = '';
            });
        });

        // 2. Mark Certified / Waive Compliance Handler
        document.querySelectorAll('.verify-compliance-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enrId = this.getAttribute('data-enr-id');
                const staffName = this.getAttribute('data-staff-name');
                const courseTitle = this.getAttribute('data-course-title');

                if (!confirm('Certify and mark as fully COMPLIANT for ' + staffName + ' on ' + courseTitle + '?')) {
                    return;
                }

                const postUrl = '/' + (routePrefix === 'admin' ? 'admin' : 'student') + '/compliance/verify/' + enrId;
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = postUrl;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            });
        });

        // 3. Revoke Mandate Handler
        document.querySelectorAll('.revoke-mandate-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enrId = this.getAttribute('data-enr-id');
                const courseTitle = this.getAttribute('data-course-title');
                const staffName = this.getAttribute('data-staff-name');

                document.getElementById('revokeStaffName').textContent = staffName;
                document.getElementById('revokeCourseTitle').textContent = courseTitle;

                const form = document.getElementById('revokeMandateForm');
                form.action = '/' + (routePrefix === 'admin' ? 'admin' : 'student') + '/compliance/revoke/' + enrId;

                const modal = new bootstrap.Modal(document.getElementById('revokeMandateModal'));
                modal.show();
            });
        });

        // 4. Resolve Escalation Handler
        document.querySelectorAll('.resolve-escalation-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enrId = this.getAttribute('data-enr-id');
                if (!enrId) return;

                const postUrl = '/' + (routePrefix === 'admin' ? 'admin' : 'student') + '/compliance/resolve-escalation/' + enrId;
                
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = postUrl;
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            });
        });

        // 5. Escalate Alert Handler
        document.querySelectorAll('.escalate-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const enrId = this.getAttribute('data-enr-id');
                if (!enrId) return;

                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Escalating...';

                const postUrl = '/' + (routePrefix === 'admin' ? 'admin' : 'student') + '/compliance/escalate/' + enrId;

                fetch(postUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        reason: 'Supervisory Notice: Regulatory BOT compliance deadline exceeded. Immediate resolution required.'
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        button.className = 'btn btn-sm btn-secondary rounded-pill px-2.5 py-1';
                        button.innerHTML = '<i class="fa-solid fa-check me-1"></i> Alert Dispatched';
                    } else {
                        button.disabled = false;
                        button.innerHTML = '<i class="fa-solid fa-bullhorn me-1"></i> Retry Escalate';
                    }
                })
                .catch(() => {
                    button.disabled = false;
                    button.innerHTML = '<i class="fa-solid fa-bullhorn me-1"></i> Retry Escalate';
                });
            });
        });
    });
</script>
@endpush
@endsection

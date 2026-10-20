@extends('layouts.admin')

@section('title', 'Certificate Templates')

@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Certificate Templates</div>
    </div>
@endsection

@section('main-content')
    <div class="certificate-manager-v2">
        <!-- Top Navigation Tabs -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <ul class="nav nav-pills pbz-tab-nav" id="certTabNav">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'templates' ? 'active' : '' }}" href="{{ route('admin.certificates.index', ['tab' => 'templates']) }}">
                        <i class="fas fa-certificate me-1.5"></i> Certificate Templates
                        <span class="badge ms-1.5 {{ $activeTab === 'templates' ? 'bg-white text-dark' : 'bg-light text-secondary' }}">{{ $statistics['total_templates'] ?? count($templates) }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'issued' ? 'active' : '' }}" href="{{ route('admin.certificates.index', ['tab' => 'issued']) }}">
                        <i class="fas fa-file-signature me-1.5"></i> Issued Certificates
                        <span class="badge ms-1.5 {{ $activeTab === 'issued' ? 'bg-white text-dark' : 'bg-light text-secondary' }}">{{ $statistics['total'] }}</span>
                    </a>
                </li>
            </ul>

            @if($activeTab === 'templates')
                <div>
                    <a href="{{ route('admin.certificates.templates.create') }}" class="btn btn-primary pbz-btn-emerald py-2 px-3.5 shadow-sm fw-bold">
                        <i class="fas fa-plus me-1.5"></i> New Template
                    </a>
                </div>
            @endif
        </div>

        @if($activeTab === 'templates')
            <!-- How Certificate Templates Work Banner (Collapsible) -->
            <div class="card pbz-info-card mb-4">
                <div class="card-header pbz-info-header" data-toggle="collapse" data-target="#howTemplatesWorkCollapse" aria-expanded="true" style="cursor: pointer;">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="pbz-bulb-icon">
                            <i class="far fa-lightbulb"></i>
                        </div>
                        <h4 class="mb-0 text-dark fw-bold" style="font-size: 14.5px;">How certificate templates work</h4>
                    </div>
                    <i class="fas fa-chevron-down text-muted transition-icon"></i>
                </div>
                <div id="howTemplatesWorkCollapse" class="collapse show">
                    <div class="card-body pt-0 pb-3" style="font-size: 13px; color: #475569; line-height: 1.6;">
                        <p class="mb-2">
                            Certificate templates define the design, layout, legal compliance clauses, and institutional branding rendered when learners complete courses in the PBZ Banking Academy.
                        </p>
                        <div class="row g-3 mt-1">
                            <div class="col-md-4">
                                <div class="p-2.5 rounded-2 border bg-light h-100">
                                    <div class="fw-bold text-dark mb-1"><i class="fas fa-palette text-primary me-1"></i> Visual Drag &amp; Drop Designer</div>
                                    <span class="small text-muted">Position text, logos, signatures, official seals, and custom borders anywhere on an accredited A4 canvas.</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2.5 rounded-2 border bg-light h-100">
                                    <div class="fw-bold text-dark mb-1"><i class="fas fa-code text-success me-1"></i> Automatic Data Binding</div>
                                    <span class="small text-muted">Use smart placeholders like <code>{student_name}</code>, <code>{course_title}</code>, and <code>{verification_code}</code> to dynamically populate certificate data.</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-2.5 rounded-2 border bg-light h-100">
                                    <div class="fw-bold text-dark mb-1"><i class="fas fa-bolt text-warning me-1"></i> Instant Platform-Wide Sync</div>
                                    <span class="small text-muted">Any modifications saved to the active template immediately reflect across all new downloads and online verification views.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates List Card -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h4 class="mb-0 text-dark fw-bold" style="font-size: 16px;">Certificate templates</h4>
                        <p class="text-muted mb-0 small">Manage accredited templates and launch the visual drag-and-drop designer.</p>
                    </div>
                    <div class="badge rounded-pill px-3 py-1.5" style="background: #e0f2fe; color: #0284c7; font-weight: 700;">
                        {{ count($templates) }} Available
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 pbz-templates-table">
                            <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px;">
                                <tr>
                                    <th class="ps-4">NAME</th>
                                    <th>ORIENTATION</th>
                                    <th>BACKGROUND</th>
                                    <th>ISSUED</th>
                                    <th>STATUS</th>
                                    <th class="text-end pe-4">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $tmpl)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ route('admin.certificates.templates.edit', $tmpl->id) }}" class="fw-bold text-dark text-decoration-none hover-primary" style="font-size: 13.5px;">
                                                    {{ $tmpl->name }}
                                                </a>
                                                @if($tmpl->is_default)
                                                    <span class="badge rounded-pill fw-bold" style="background: #e0e7ff; color: #4338ca; font-size: 10px; padding: 3px 9px;">Default</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small" style="font-size: 11px;">
                                                Validity: {{ $tmpl->valid_for_months ? $tmpl->valid_for_months . ' months' : 'Lifetime' }} &bull; Updated {{ $tmpl->updated_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11.5px; font-weight: 600;">
                                                <i class="fas {{ $tmpl->orientation === 'portrait' ? 'fa-file' : 'fa-file-image' }} me-1 text-secondary"></i>
                                                {{ ucfirst($tmpl->orientation) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($tmpl->background_image)
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset($tmpl->background_image) }}" alt="BG" class="rounded border" style="width: 38px; height: 26px; object-fit: cover;">
                                                    <span class="small text-muted">Custom Image</span>
                                                </div>
                                            @else
                                                <span class="text-muted" style="font-size: 12px;">None (Standard)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark" style="font-size: 13px;">{{ number_format($tmpl->issued_count) }}</span>
                                        </td>
                                        <td>
                                            @if($tmpl->is_active)
                                                <span class="badge" style="background: #dcfce7; color: #16a34a; font-weight: 700; font-size: 11px; padding: 4px 10px;">Active</span>
                                            @else
                                                <span class="badge" style="background: #fee2e2; color: #dc2626; font-weight: 700; font-size: 11px; padding: 4px 10px;">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-flex align-items-center gap-1.5">
                                                <!-- Preview Button -->
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-icon-square" title="Preview Template" onclick="openPreviewModal({{ $tmpl->id }}, '{{ addslashes($tmpl->name) }}')">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <!-- Edit Visual Designer Button -->
                                                <a href="{{ route('admin.certificates.templates.edit', $tmpl->id) }}" class="btn btn-sm btn-outline-primary btn-icon-square" title="Visual Drag & Drop Designer">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <!-- Set as Default (if not already default) -->
                                                @if(!$tmpl->is_default)
                                                    <form action="{{ route('admin.certificates.templates.set-default', $tmpl->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning btn-icon-square" title="Set as System Default">
                                                            <i class="far fa-star"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Duplicate Template Button -->
                                                <form action="{{ route('admin.certificates.templates.duplicate', $tmpl->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-info btn-icon-square" title="Duplicate Template">
                                                        <i class="far fa-clone"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete Button -->
                                                @if(count($templates) > 1)
                                                    <form action="{{ route('admin.certificates.templates.destroy', $tmpl->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete template &quot;{{ $tmpl->name }}&quot;?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-icon-square" title="Delete Template">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-certificate fs-2 text-secondary mb-2 d-block"></i>
                                            No certificate templates found. Click "New Template" to create one.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @else
            <!-- Issued Certificates Tab Content -->
            <div class="row g-3 mb-4">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-sm border-0 rounded-3 mb-0">
                        <div class="card-icon bg-primary" style="background-color: #006837 !important;">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #64748b;">Total Issued</h4>
                            </div>
                            <div class="card-body" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                                {{ number_format($statistics['total']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-sm border-0 rounded-3 mb-0">
                        <div class="card-icon bg-success" style="background-color: #0099cc !important;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #64748b;">Last 7 Days</h4>
                            </div>
                            <div class="card-body" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                                {{ number_format($statistics['last_seven_days']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1 shadow-sm border-0 rounded-3 mb-0">
                        <div class="card-icon bg-info" style="background-color: #8b5cf6 !important;">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-uppercase" style="font-size: 11px; font-weight: 700; color: #64748b;">This Month</h4>
                            </div>
                            <div class="card-body" style="font-size: 22px; font-weight: 700; color: #0f172a;">
                                {{ number_format($statistics['this_month']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Issued Certificates Table Card -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h4 class="mb-0 text-dark fw-bold" style="font-size: 16px;">Issued Certificates Ledger</h4>
                        <p class="text-muted mb-0 small">Audit completed student certificates and download high-resolution PDF archives.</p>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.certificates.index') }}" class="mb-4">
                        <input type="hidden" name="tab" value="issued">
                        <div class="form-row align-items-center">
                            <div class="col-md-4 mb-2">
                                <div class="input-group">
                                    <input type="text" id="search" name="search" class="form-control form-control-sm"
                                        placeholder="Search by student or course..." value="{{ $search }}" style="height: 38px;">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit" style="background: #006837; border-color: #006837;"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="date" id="date_from" name="date_from" class="form-control form-control-sm"
                                    value="{{ $dateFrom }}" placeholder="Date From" style="height: 38px;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="date" id="date_to" name="date_to" class="form-control form-control-sm"
                                    value="{{ $dateTo }}" placeholder="Date To" style="height: 38px;">
                            </div>
                            <div class="col-md-2 mb-2 d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold" style="background: #006837; border-color: #006837; height: 38px;">
                                    Filter
                                </button>
                                @if ($search || $dateFrom || $dateTo)
                                    <a href="{{ route('admin.certificates.index', ['tab' => 'issued']) }}" class="btn btn-sm btn-secondary" style="height: 38px;" title="Reset Filters">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    @if ($certificates->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="table-light text-muted" style="font-size: 11px; text-transform: uppercase;">
                                    <tr>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Instructor</th>
                                        <th>Completed At</th>
                                        <th>Certificate #</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($certificates as $certificate)
                                        <tr>
                                            <td>
                                                <strong class="text-dark">{{ $certificate->user?->name ?? '—' }}</strong>
                                                <div class="text-muted small" style="font-size: 11px;">{{ $certificate->user?->email ?? '—' }}</div>
                                            </td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $certificate->course?->title ?? '—' }}</span>
                                            </td>
                                            <td>{{ $certificate->course?->instructor?->name ?? 'PBZ Faculty' }}</td>
                                            <td>{{ $certificate->completion_date ?? '—' }}</td>
                                            <td><code>{{ $certificate->certificate_number ?? '—' }}</code></td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.certificates.download', $certificate) }}"
                                                    class="btn btn-sm btn-outline-success fw-bold py-1 px-2.5 rounded-2" style="font-size: 11.5px;">
                                                    <i class="fas fa-download me-1"></i> Download PDF
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <p class="text-muted mb-0 small">
                                    Showing {{ $certificates->firstItem() ?? 0 }} to {{ $certificates->lastItem() ?? 0 }} of
                                    {{ $certificates->total() }} certificates
                                </p>
                            </div>
                            <div>
                                {{ $certificates->links('vendor.pagination.stisla-default') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-file-signature fs-2 text-secondary mb-2 d-block"></i>
                            No certificates found matching your criteria.
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Live Preview Modal -->
    <div class="modal fade" id="certPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 920px;">
            <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="modal-header py-2.5 px-3 bg-dark text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-certificate text-warning"></i>
                        <h5 class="modal-title fs-6 fw-bold mb-0 text-white" id="certPreviewModalTitle">Certificate Preview</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark" style="min-height: 520px; overflow-x: auto; display: flex; justify-content: center; align-items: center;">
                    <iframe id="certPreviewIframe" src="about:blank" style="width: 100%; height: 620px; border: 0;" title="Preview"></iframe>
                </div>
                <div class="modal-footer py-2 px-3 bg-light d-flex justify-content-between">
                    <div class="small text-muted">
                        <i class="fas fa-info-circle me-1 text-primary"></i> Preview displays realistic PBZ sample credentials and verification tags.
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary py-1 px-3" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .pbz-tab-nav {
            background: #ffffff;
            padding: 4px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            gap: 4px;
        }
        .pbz-tab-nav .nav-link {
            color: #64748b !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            padding: 7px 16px !important;
            border-radius: 6px !important;
            transition: all 0.15s ease !important;
        }
        .pbz-tab-nav .nav-link.active {
            background-color: #006837 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 104, 55, 0.25) !important;
        }
        .pbz-btn-emerald {
            background-color: #006837 !important;
            border-color: #006837 !important;
            color: #ffffff !important;
            font-size: 13px !important;
            border-radius: 6px !important;
            letter-spacing: 0.3px !important;
            transition: all 0.15s ease !important;
        }
        .pbz-btn-emerald:hover {
            background-color: #00522c !important;
            border-color: #00522c !important;
            transform: translateY(-1px);
        }
        .pbz-info-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }
        .pbz-info-header {
            background: #ffffff !important;
            padding: 12px 18px !important;
            border-bottom: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        .pbz-bulb-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #fef3c7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
        }
        .btn-icon-square {
            width: 32px;
            height: 32px;
            padding: 0 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px !important;
            font-size: 12px !important;
        }
        .pbz-templates-table th {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }
        .hover-primary:hover {
            color: #006837 !important;
            text-decoration: underline !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function openPreviewModal(templateId, templateName) {
            $('#certPreviewModalTitle').text('Preview: ' + templateName);
            const previewUrl = "{{ url('admin/certificates/templates') }}/" + templateId + "/preview";
            $('#certPreviewIframe').attr('src', previewUrl);
            $('#certPreviewModal').modal('show');
        }

        $(document).ready(function () {
            $('#howTemplatesWorkCollapse').on('show.bs.collapse', function () {
                $('.transition-icon').removeClass('fa-chevron-right').addClass('fa-chevron-down');
            });
            $('#howTemplatesWorkCollapse').on('hide.bs.collapse', function () {
                $('.transition-icon').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            });
        });
    </script>
@endpush

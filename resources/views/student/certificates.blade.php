@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => __('student.certificates') ?? 'Certificates'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">

            <!-- Compact Page Header -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h3 class="fw-bold mb-1" style="font-size: 1.25rem; color: #0f172a;">
                        <i class="fa-solid fa-award text-success me-1.5"></i> {{ __('student.my_certificates') ?? 'My Certificates' }}
                    </h3>
                    <p class="text-muted mb-0" style="font-size: 13px;">
                        {{ __('student.download_certificates_desc') ?? 'Preview, download, and verify your official Bank of Tanzania accredited credentials.' }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('student.my-courses') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3 py-1.5" style="font-size: 12px; font-weight: 600;">
                        <i class="fa-solid fa-book-open me-1"></i> My Courses
                    </a>
                    <a href="{{ route('verify-certificate') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-2 px-3 py-1.5" style="font-size: 12px; font-weight: 600;">
                        <i class="fa-solid fa-shield-halved me-1"></i> Verify Portal
                    </a>
                </div>
            </div>

            <!-- Certificates Grid -->
            <div class="row g-3">
                @forelse($completedEnrollments as $index => $enrollment)
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card h-100 border rounded-3 p-3 shadow-none bg-white" style="border-color: #e2e8f0 !important;">
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <!-- Solid Icon Badge -->
                                <div style="width: 44px; height: 44px; border-radius: 10px; background: #006837; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 19px; flex-shrink: 0;">
                                    <i class="fa-solid fa-certificate"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <h5 class="fw-bold mb-1 text-truncate" title="{{ $enrollment['course_title'] }}" style="font-size: 14.5px; color: #0f172a;">
                                        {{ $enrollment['course_title'] }}
                                    </h5>
                                    <div class="d-flex align-items-center flex-wrap gap-3 text-muted" style="font-size: 12px;">
                                        <span>
                                            <i class="fa-regular fa-user me-1 text-success"></i>
                                            {{ $enrollment['instructor_name'] }}
                                        </span>
                                        <span>
                                            <i class="fa-regular fa-calendar-check me-1 text-success"></i>
                                            {{ optional($enrollment['completed_at'])->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificate Identifier Box -->
                            <div class="p-2.5 rounded-2 mb-3 d-flex align-items-center justify-content-between" style="background: #f8fafc; border: 1px solid #e2e8f0; font-size: 12px;">
                                <div>
                                    <span class="text-muted text-uppercase fw-semibold" style="font-size: 10.5px; letter-spacing: 0.3px;">Certificate ID:</span>
                                    <span class="fw-bold font-monospace text-dark ms-1">{{ $enrollment['certificate_number'] }}</span>
                                </div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill font-size-11 fw-bold">
                                    <i class="fa-solid fa-check-circle me-0.5"></i> Verified
                                </span>
                            </div>

                            <!-- Action Buttons: Preview, Download, Verify -->
                            <div class="d-flex align-items-center gap-2 mt-auto">
                                <!-- Preview Button -->
                                <button type="button" 
                                    class="btn btn-sm btn-outline-success fw-bold rounded-2 px-3 py-1.5 flex-grow-1 btn-preview-cert"
                                    data-course-id="{{ $enrollment['course_id'] }}"
                                    data-course-title="{{ $enrollment['course_title'] }}"
                                    data-cert-number="{{ $enrollment['certificate_number'] }}"
                                    data-preview-url="{{ route('student.courses.certificate.preview', $enrollment['course_id']) }}"
                                    data-download-url="{{ route('student.courses.certificate.download', $enrollment['course_id']) }}"
                                    data-verify-url="{{ route('verify-certificate', ['code' => $enrollment['certificate_number']]) }}"
                                    style="font-size: 12.5px;">
                                    <i class="fa-solid fa-eye me-1.5"></i> Preview
                                </button>

                                <!-- Direct Download Button -->
                                <a href="{{ $enrollment['course_id'] ? route('student.courses.certificate.download', $enrollment['course_id']) : '#' }}"
                                    class="btn btn-sm btn-success fw-bold rounded-2 px-3 py-1.5"
                                    style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                                    <i class="fa-solid fa-download me-1.5"></i> Download PDF
                                </a>

                                <!-- Verify Button -->
                                <a href="{{ route('verify-certificate', ['code' => $enrollment['certificate_number']]) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-secondary rounded-2 px-2.5 py-1.5 fw-semibold"
                                    style="font-size: 12.5px;"
                                    title="Verify Authenticity">
                                    <i class="fa-solid fa-shield-halved text-success"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Clean Compact Empty State -->
                    <div class="col-12">
                        <div class="card border rounded-3 text-center p-5 bg-white shadow-none" style="border-color: #e2e8f0 !important;">
                            <div class="mx-auto mb-3" style="width: 58px; height: 58px; border-radius: 14px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 26px;">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">
                                {{ __('student.no_certificates_title') ?? 'No Certificates Earned Yet' }}
                            </h5>
                            <p class="text-muted mx-auto mb-4" style="max-width: 480px; font-size: 13.5px; line-height: 1.5;">
                                {{ __('student.no_certificates_desc') ?? 'Complete all curriculum lessons, compliance quizzes, and assessments in your enrolled courses to generate your official PBZ bank certificates.' }}
                            </p>
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('student.my-courses') }}" class="btn btn-sm btn-success rounded-2 px-3 py-1.5 fw-bold" style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                                    <i class="fa-solid fa-play me-1"></i> {{ __('student.view_my_courses') ?? 'Continue My Learning' }}
                                </a>
                                <a href="{{ route('courses') }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3 py-1.5 fw-semibold" style="font-size: 12.5px;">
                                    <i class="fa-solid fa-compass me-1"></i> Browse Course Catalog
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- PBZ SaaS Portal Modern Footer -->
            <div class="pbz-saas-footer">
                <div class="pbz-saas-footer-content">
                    <div class="pbz-saas-footer-brand">
                        <span class="pbz-footer-dot"></span>
                        <span>&copy; {{ date('Y') }} The People's Bank of Zanzibar (PBZ). All rights reserved.</span>
                        <span class="text-muted d-none d-md-inline">•</span>
                        <span class="text-muted d-none d-md-inline">Sovereign Banking Learning Academy</span>
                    </div>
                    <div class="pbz-saas-footer-links">
                        <a href="{{ route('home') }}" target="_blank">Main Site</a>
                        <a href="{{ route('courses') }}">Course Catalog</a>
                        <a href="{{ route('student.my-courses') }}">My Learning</a>
                        <a href="{{ route('student.certificates') }}">Certificates</a>
                        <a href="{{ route('student.settings') }}">Settings</a>
                        <a href="{{ url('/pages/privacy-policy') }}">Privacy Policy</a>
                        <a href="{{ url('/pages/terms-and-conditions') }}">Terms</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Certificate Preview Modal -->
<div class="modal fade" id="certificatePreviewModal" tabindex="-1" aria-labelledby="certificatePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header py-3 px-4 bg-light border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #006837; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="certificatePreviewModalLabel" style="font-size: 15px; color: #0f172a;">
                            Certificate of Completion
                        </h5>
                        <div class="text-muted small" style="font-size: 11.5px;">
                            ID: <span class="font-monospace fw-bold text-dark" id="modalCertId"></span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="modalDownloadBtn" class="btn btn-sm btn-success fw-bold px-3 py-1.5 rounded-2" style="background-color: #006837; border-color: #006837; font-size: 12.5px;">
                        <i class="fa-solid fa-download me-1"></i> Download PDF
                    </a>
                    <button type="button" id="modalPrintBtn" class="btn btn-sm btn-outline-secondary fw-semibold px-2.5 py-1.5 rounded-2" style="font-size: 12.5px;" title="Print Certificate">
                        <i class="fa-solid fa-print"></i>
                    </button>
                    <a href="#" id="modalVerifyBtn" target="_blank" class="btn btn-sm btn-outline-success fw-semibold px-2.5 py-1.5 rounded-2" style="font-size: 12.5px;" title="Verify Online">
                        <i class="fa-solid fa-shield-halved"></i>
                    </a>
                    <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>

            <!-- Modal Body (Certificate Iframe Container) -->
            <div class="modal-body p-3 bg-secondary-subtle position-relative" style="min-height: 580px;">
                <!-- Loading Spinner -->
                <div id="certIframeLoader" class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 5;">
                    <div class="spinner-border text-success" role="status" style="width: 2.5rem; height: 2.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-2 text-muted fw-semibold small">Generating Certificate Preview...</div>
                </div>

                <!-- Framed Preview Iframe -->
                <div class="mx-auto shadow-sm rounded-2 overflow-hidden bg-white" style="max-width: 950px; border: 1px solid #cbd5e1;">
                    <iframe id="certPreviewIframe" src="" style="width: 100%; height: 580px; border: none; display: block;" loading="lazy"></iframe>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer py-2 px-4 bg-light border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 12px;">
                <div>
                    <i class="fa-solid fa-shield-halved text-success me-1"></i>
                    Bank of Tanzania Accredited • Official People's Bank of Zanzibar Credential
                </div>
                <button type="button" class="btn btn-sm btn-secondary rounded-2 px-3" data-bs-dismiss="modal" style="font-size: 12px;">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const previewModalEl = document.getElementById('certificatePreviewModal');
        if (!previewModalEl) return;

        const previewModal = new bootstrap.Modal(previewModalEl);
        const iframe = document.getElementById('certPreviewIframe');
        const loader = document.getElementById('certIframeLoader');
        const modalCertId = document.getElementById('modalCertId');
        const modalDownloadBtn = document.getElementById('modalDownloadBtn');
        const modalVerifyBtn = document.getElementById('modalVerifyBtn');
        const modalPrintBtn = document.getElementById('modalPrintBtn');

        // Handle Preview Click
        document.querySelectorAll('.btn-preview-cert').forEach(btn => {
            btn.addEventListener('click', function () {
                const previewUrl = this.getAttribute('data-preview-url');
                const downloadUrl = this.getAttribute('data-download-url');
                const verifyUrl = this.getAttribute('data-verify-url');
                const certNumber = this.getAttribute('data-cert-number');

                modalCertId.textContent = certNumber;
                modalDownloadBtn.href = downloadUrl;
                modalVerifyBtn.href = verifyUrl;

                loader.style.display = 'block';
                iframe.style.opacity = '0';
                iframe.src = previewUrl;

                previewModal.show();
            });
        });

        // Hide loader when iframe finishes loading
        if (iframe) {
            iframe.addEventListener('load', function () {
                loader.style.display = 'none';
                iframe.style.opacity = '1';
                iframe.style.transition = 'opacity 0.25s ease';
            });
        }

        // Print iframe content
        if (modalPrintBtn && iframe) {
            modalPrintBtn.addEventListener('click', function () {
                try {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                } catch (e) {
                    window.open(iframe.src, '_blank');
                }
            });
        }

        // Clear iframe src on modal hide to release resources
        previewModalEl.addEventListener('hidden.bs.modal', function () {
            iframe.src = '';
            loader.style.display = 'block';
        });
    });
</script>
@endpush

<div class="assignment-content-wrapper">
    <!-- Learning Navigation Action Bar (at top of assignment) -->
    <div class="learning-nav-toolbar p-3 bg-white border rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 shadow-none" style="border-color: #e2e8f0 !important;">
        <button type="button" id="prev-btn" class="btn btn-sm btn-outline-secondary px-3 py-1.5 fw-semibold rounded-2 d-inline-flex align-items-center gap-1.5" style="font-size: 12.5px;">
            <i class="fa-solid fa-chevron-left" style="font-size: 10px;"></i> Previous
        </button>

        <div class="learning-item-counter fw-bold text-muted text-center" id="learning-item-counter" style="font-size: 12.5px;">
            <span id="current-item-indicator" class="text-dark">{{ $assignment->title }}</span>
        </div>

        <button type="button" id="next-btn" class="btn btn-sm btn-primary px-3 py-1.5 fw-bold rounded-2 d-inline-flex align-items-center gap-1.5" style="background-color: #0099cc; border-color: #0099cc; font-size: 12.5px;">
            Next <i class="fa-solid fa-chevron-right" style="font-size: 10px;"></i>
        </button>
    </div>

    <!-- PBZ Incident Dossier Header Stage -->
    <div class="card border-0 rounded-3 overflow-hidden mb-3 text-white" style="background: #081226;">
        <div class="p-4 p-md-5">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" style="background: #1e293b; border: 1px solid #d4af37; color: #d4af37; font-size: 11.5px; font-weight: 700;">
                    <i class="fa-solid fa-folder-closed"></i> PBZ INCIDENT DOSSIER #STR-2026-FHD-089
                </div>
                <span class="badge px-2.5 py-1 rounded-pill" style="background: #0f172a; color: #94a3b8; border: 1px solid #334155; font-size: 11px;">
                    <i class="fa-solid fa-building-columns me-1" style="color: #0099cc;"></i> Forodhani Branch Ops
                </span>
            </div>

            <h2 class="fw-bold text-white mb-2" style="font-size: 1.55rem;">
                {{ $assignment->title }}
            </h2>

            @if ($assignment->description)
                <div class="text-white-50 mb-3" style="font-size: 14px; line-height: 1.65; max-width: 850px;">
                    {!! $assignment->description !!}
                </div>
            @endif

            <!-- Quick Case Summary Stats -->
            <div class="row g-2 mt-2" style="max-width: 700px;">
                <div class="col-sm-4 col-12">
                    <div class="p-2.5 rounded border" style="background: #0f172a; border-color: #1e293b; font-size: 12px;">
                        <span class="text-white-50">Branch Location:</span>
                        <div class="fw-bold text-white">Forodhani Coastal Branch</div>
                    </div>
                </div>
                <div class="col-sm-4 col-12">
                    <div class="p-2.5 rounded border" style="background: #0f172a; border-color: #1e293b; font-size: 12px;">
                        <span class="text-white-50">Deposit Value:</span>
                        <div class="fw-bold text-warning font-monospace">TZS 95,000,000</div>
                    </div>
                </div>
                <div class="col-sm-4 col-12">
                    <div class="p-2.5 rounded border" style="background: #0f172a; border-color: #1e293b; font-size: 12px;">
                        <span class="text-white-50">Deliverable:</span>
                        <div class="fw-bold" style="color: #4ade80;">Internal STR Escalation Memo</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Practical Instructions Card -->
    @if ($assignment->instructions)
        <div class="card border rounded-3 bg-white p-4 mb-3 shadow-none" style="border-color: #e2e8f0;">
            <div class="d-flex align-items-center gap-2 mb-2">
                <div style="width: 32px; height: 32px; border-radius: 6px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 15px;">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <h5 class="fw-bold text-dark mb-0" style="font-size: 14px;">Audit Checklist &amp; Report Instructions</h5>
            </div>
            <div class="text-dark" style="font-size: 13.5px; line-height: 1.7;">
                {!! $assignment->instructions !!}
            </div>
        </div>
    @endif

    <!-- Downloadable Dossier Attachments -->
    @if ($assignment->files && $assignment->files->count() > 0)
        <div class="card border rounded-3 bg-white p-3.5 mb-3 shadow-none" style="border-color: #e2e8f0;">
            <div class="fw-bold text-dark mb-2.5" style="font-size: 13px;">
                <i class="fa-solid fa-paperclip text-muted me-1.5"></i> Reference Files &amp; Case Attachments
            </div>
            <div class="d-flex flex-column gap-2">
                @foreach ($assignment->files as $file)
                    <div class="p-2.5 rounded border d-flex align-items-center justify-content-between" style="background: #f8fafc; border-color: #e2e8f0;">
                        <div class="d-flex align-items-center gap-2.5">
                            <i class="fa-solid fa-file-pdf text-danger" style="font-size: 18px;"></i>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 13px;">{{ $file->original_filename }}</div>
                                <span class="text-muted" style="font-size: 11px;">{{ $file->file_size ?? 'Document File' }}</span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $file->file_path) }}" download="{{ $file->original_filename }}" class="btn btn-sm btn-outline-secondary rounded-2 px-3 py-1" style="font-size: 12px;">
                            <i class="fa-solid fa-download me-1"></i> Download
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Previous Submission Status Card (if exists) -->
    @if ($submission)
        <div class="card border rounded-3 p-4 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge fw-bold px-2.5 py-1 rounded-pill" style="background: {{ !empty($submissionData['is_graded']) ? '#f0fdf4' : '#fffbeb' }}; color: {{ !empty($submissionData['is_graded']) ? '#16a34a' : '#d97706' }}; border: 1px solid {{ !empty($submissionData['is_graded']) ? '#bbf7d0' : '#fde68a' }}; font-size: 11.5px;">
                        <i class="fa-solid fa-clock-rotate-left me-1"></i> {{ $submissionData['status_label'] ?? 'Submitted For Review' }}
                    </span>
                    <span class="text-muted" style="font-size: 12px;">
                        Submitted on: {{ $submissionData['submitted_at'] ?? '—' }}
                    </span>
                </div>

                @if (!empty($submissionData['is_graded']))
                    <div class="fw-bold" style="font-size: 14px; color: #006837;">
                        Grade Awarded: <span class="badge bg-success text-white px-2.5 py-1">{{ $submission->grade ?? 'N/A' }}%</span>
                    </div>
                @endif
            </div>

            @if ($submission->instructor_notes)
                <div class="p-3 rounded-2 border mb-3" style="background: #f8fafc; border-color: #e2e8f0;">
                    <div class="fw-bold text-dark mb-1" style="font-size: 12.5px;">
                        <i class="fa-solid fa-comment-dots text-primary me-1"></i> Faculty Assessor Feedback:
                    </div>
                    <div class="text-muted" style="font-size: 12.5px;">{{ $submission->instructor_notes }}</div>
                </div>
            @endif

            @if ($submission->submission_text)
                <div class="p-3 rounded-2 border" style="background: #f8fafc; border-color: #e2e8f0;">
                    <div class="fw-bold text-dark mb-1" style="font-size: 12.5px;">Your Submitted Memo:</div>
                    <div class="text-dark" style="font-size: 13px; line-height: 1.6;">
                        {!! $submission->submission_text !!}
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Submission Form Workbench -->
    @if (!$submission || !empty($submissionData['can_resubmit']))
        <div class="card border rounded-3 bg-white mb-3 shadow-none" style="border-color: #e2e8f0;">
            <div class="card-header bg-white border-bottom p-3.5" style="border-color: #e2e8f0;">
                <h5 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                    <i class="fa-solid fa-pen-to-square me-1.5" style="color: #0099cc;"></i> STR Memo Submission Workbench
                </h5>
            </div>

            <div class="card-body p-4">
                <form id="assignment-form" enctype="multipart/form-data"
                      data-assignment-id="{{ $assignment->id }}"
                      data-course-id="{{ $assignment->topic->course_id }}" class="assignment-form">

                    <div class="mb-3.5">
                        <label for="submission_text" class="form-label fw-bold text-dark" style="font-size: 13px;">
                            Draft STR Memo (Text Submission)
                        </label>
                        <textarea class="form-control rounded-2 p-3" id="submission_text" name="submission_text" rows="8" placeholder="Draft your internal Suspicious Transaction Report memo here detailing: 1) Observed Red Flags, 2) Frontline Tellers Immediate Actions, 3) Source of Wealth verification results, 4) Recommended FIU escalation..." style="font-size: 13px; border-color: #cbd5e1;"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="files" class="form-label fw-bold text-dark" style="font-size: 13px;">
                            Upload Completed Memo or Supporting Evidence (.pdf, .docx, .zip)
                        </label>
                        <input type="file" class="form-control rounded-2 p-2.5" id="files" name="files[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.txt,.jpg,.jpeg,.png" style="font-size: 13px; border-color: #cbd5e1;">
                        <small class="text-muted d-block mt-1" style="font-size: 11.5px;">
                            Maximum file size: 25 MB. Multiple supporting spreadsheets or PDF documents allowed.
                        </small>
                        <div id="file-preview" class="mt-2"></div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: #e2e8f0;">
                        <span class="text-muted" style="font-size: 12px;">
                            <i class="fa-solid fa-shield-halved me-1 text-success"></i> Handled under PBZ Confidential Statutory Compliance Protocol
                        </span>

                        <button type="submit" class="btn btn-success fw-bold px-4 py-2.5 rounded-2 d-inline-flex align-items-center gap-2" style="background-color: #006837; border-color: #006837; font-size: 13.5px;">
                            <i class="fa-solid fa-paper-plane"></i> {{ $submission ? 'Resubmit Case Study Memo' : 'Submit Case Study Memo' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

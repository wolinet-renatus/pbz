@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.review_submission') ?? 'Review Submission'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <!-- Top Navigation & Action Bar -->
            <div class="pbz-submission-topbar">
                <div>
                    <a href="{{ route('instructor.assignments.show', $assignment->id) }}" class="pbz-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Back to {{ \Illuminate\Support\Str::limit($assignment->title, 40) }}</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-size-13">
                        <i class="fa-solid fa-graduation-cap text-primary me-1"></i>
                        {{ optional($assignment->topic->course)->title ?? 'Course' }}
                    </span>
                </div>
            </div>

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: #ecfdf5; color: #065f46;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                        <span class="fw-semibold">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: #fef2f2; color: #991b1b;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                        <span class="fw-semibold">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Student & Submission Overview Header Card (Native Mobile First) -->
            <div class="pbz-submission-overview-card">
                <div class="pbz-submission-overview-inner">
                    <!-- Student Info -->
                    <div class="pbz-student-info">
                        <div class="pbz-student-avatar">
                            <img src="{{ $submission->user->profile_photo ? asset('storage/' . $submission->user->profile_photo) : asset('assets/front/img/home-1/courses/client-01.png') }}"
                                alt="{{ $submission->user->name }}">
                        </div>
                        <div class="pbz-student-details">
                            <h4 class="pbz-student-name">{{ $submission->user->name }}</h4>
                            <p class="pbz-student-subtext">
                                <span><i class="fa-regular fa-envelope me-1"></i>{{ $submission->user->email ?? 'Student' }}</span>
                                @if(optional($assignment->topic)->title)
                                    <span>•</span>
                                    <span><i class="fa-solid fa-folder-tree me-1"></i>{{ $assignment->topic->title }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Meta KPI Chips -->
                    <div class="pbz-submission-kpi-row">
                        <div class="pbz-submission-kpi-box">
                            <span class="pbz-submission-kpi-label">
                                <i class="fa-regular fa-calendar-check text-muted"></i> Submitted
                            </span>
                            <span class="pbz-submission-kpi-val">
                                {{ optional($submission->submitted_at)->format('M d, Y') ?? '—' }}
                                <small class="text-muted d-block font-size-11" style="font-weight: 500;">
                                    {{ optional($submission->submitted_at)->format('h:i A') ?? '' }}
                                </small>
                            </span>
                        </div>

                        <div class="pbz-submission-kpi-box">
                            <span class="pbz-submission-kpi-label">
                                <i class="fa-solid fa-circle-dot text-muted"></i> Status
                            </span>
                            <div>
                                <span class="pbz-status-pill {{ $statusClasses[$submission->status] ?? 'pending' }}">
                                    @if($submission->status === 'graded')
                                        <i class="fa-solid fa-check"></i>
                                    @elseif($submission->status === 'returned')
                                        <i class="fa-solid fa-rotate-left"></i>
                                    @else
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    @endif
                                    {{ $statusOptions[$submission->status] ?? ucfirst($submission->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="pbz-submission-kpi-box">
                            <span class="pbz-submission-kpi-label">
                                <i class="fa-solid fa-award text-muted"></i> Grade
                            </span>
                            <span class="pbz-submission-kpi-val pbz-grade-badge">
                                {{ $submission->grade !== null ? $submission->grade . '%' : 'Not graded' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content & Review Layout Grid -->
            <div class="pbz-submission-grid">
                <!-- Left Main Column: Submission Text & Attachments -->
                <div class="pbz-submission-main-col">
                    <!-- Submission Written Content Card -->
                    <div class="pbz-dash-card">
                        <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                            <h3 class="pbz-dash-card-title">
                                <i class="fa-solid fa-align-left text-primary"></i>
                                Student Written Response
                            </h3>
                            @if ($submission->submission_text)
                                <span class="badge bg-light text-muted border font-size-11">
                                    {{ str_word_count(strip_tags($submission->submission_text)) }} words
                                </span>
                            @endif
                        </div>

                        @if ($submission->submission_text)
                            <div class="pbz-submission-text-box">
                                {!! nl2br(e($submission->submission_text)) !!}
                            </div>
                        @else
                            <div class="pbz-submission-empty-box">
                                <i class="fa-regular fa-file-lines"></i>
                                <p class="mb-0 fw-medium">No written response provided for this assignment.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Uploaded Files & Attachments Card -->
                    <div class="pbz-dash-card">
                        <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                            <h3 class="pbz-dash-card-title">
                                <i class="fa-solid fa-paperclip text-primary"></i>
                                Submitted Attachments
                            </h3>
                            <span class="badge bg-light text-muted border font-size-11">
                                {{ $submission->files->count() }} {{ \Illuminate\Support\Str::plural('file', $submission->files->count()) }}
                            </span>
                        </div>

                        @if ($submission->files->isNotEmpty())
                            <ul class="pbz-files-list">
                                @foreach ($submission->files as $file)
                                    @php
                                        $ext = strtolower(pathinfo($file->original_filename, PATHINFO_EXTENSION));
                                        $iconClass = match($ext) {
                                            'pdf' => 'fa-solid fa-file-pdf text-danger',
                                            'doc', 'docx' => 'fa-solid fa-file-word text-primary',
                                            'zip', 'rar', '7z', 'tar', 'gz' => 'fa-solid fa-file-zipper text-warning',
                                            'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp' => 'fa-solid fa-file-image text-success',
                                            'xls', 'xlsx', 'csv' => 'fa-solid fa-file-excel text-success',
                                            default => 'fa-solid fa-file-lines text-info',
                                        };
                                    @endphp
                                    <li class="pbz-file-item">
                                        <div class="pbz-file-info">
                                            <div class="pbz-file-icon-box">
                                                <i class="{{ $iconClass }}"></i>
                                            </div>
                                            <div class="pbz-file-texts">
                                                <a href="{{ $file->file_url }}" target="_blank" rel="noopener" class="pbz-file-name" title="{{ $file->original_filename }}">
                                                    {{ $file->original_filename }}
                                                </a>
                                                <span class="pbz-file-sub">
                                                    {{ strtoupper($ext) ?: 'FILE' }} • {{ number_format(($file->file_size ?? 0) / 1024, 1) }} KB
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ $file->file_url }}" target="_blank" rel="noopener" download class="pbz-file-dl-btn">
                                            <i class="fa-solid fa-download"></i>
                                            <span>Download</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="pbz-submission-empty-box">
                                <i class="fa-solid fa-folder-open"></i>
                                <p class="mb-0 fw-medium">No files were uploaded with this submission.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Grading & Feedback Card (Sticky on Desktop) -->
                <div class="pbz-submission-side-col">
                    <div class="pbz-dash-card">
                        <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                            <h3 class="pbz-dash-card-title">
                                <i class="fa-solid fa-marker text-primary"></i>
                                Grade & Feedback
                            </h3>
                            <span class="badge bg-light text-muted border font-size-11">Review Form</span>
                        </div>

                        <form method="POST"
                            action="{{ route('instructor.assignments.submissions.update', $submission->id) }}"
                            class="pbz-grading-form">
                            @csrf
                            @method('PUT')

                            <div class="pbz-form-group">
                                <label for="status">
                                    <i class="fa-solid fa-list-check text-muted font-size-12"></i>
                                    Grading Status
                                </label>
                                <select id="status" name="status" class="pbz-select">
                                    @foreach ($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('status', $submission->status) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="form-error text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pbz-form-group">
                                <label for="grade">
                                    <i class="fa-solid fa-percent text-muted font-size-12"></i>
                                    Grade (0 - 100%)
                                </label>
                                <div class="pbz-input-addon-wrap">
                                    <input type="number" id="grade" name="grade" min="0" max="100"
                                        step="1" class="pbz-input" value="{{ old('grade', $submission->grade) }}"
                                        placeholder="e.g. 85">
                                    <span class="pbz-input-addon">%</span>
                                </div>
                                <span class="text-muted font-size-11 mt-1">Leave empty or set to 0-100%</span>
                                @error('grade')
                                    <span class="form-error text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pbz-form-group">
                                <label for="instructor_notes">
                                    <i class="fa-solid fa-comment-dots text-muted font-size-12"></i>
                                    Instructor Feedback
                                </label>
                                <textarea id="instructor_notes" name="instructor_notes" rows="5" class="pbz-textarea"
                                    placeholder="Provide constructive feedback, praise, or guidance for the student...">{{ old('instructor_notes', $submission->instructor_notes) }}</textarea>
                                @error('instructor_notes')
                                    <span class="form-error text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="pbz-submit-grade-btn">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Save Grade & Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>
@endsection

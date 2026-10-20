@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => 'Edit Live Class'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <!-- Top Navigation & Context Bar -->
            <div class="pbz-submission-topbar">
                <div>
                    <a href="{{ route('instructor.live-classes.index') }}" class="pbz-back-link">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Back to Live Classes</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    @if($liveClass->status === 'live')
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill font-size-13">
                            <i class="fa-solid fa-broadcast-tower text-danger me-1"></i> Live Session Active
                        </span>
                    @elseif($liveClass->status === 'scheduled')
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill font-size-13">
                            <i class="fa-regular fa-calendar-check text-warning me-1"></i> Scheduled
                        </span>
                    @elseif($liveClass->status === 'ended')
                        <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill font-size-13">
                            <i class="fa-solid fa-flag-checkered me-1"></i> Session Ended
                        </span>
                    @else
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill font-size-13">
                            {{ ucfirst($liveClass->status ?? 'Draft') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Page Title Area -->
            <div class="section-title-area mb-3">
                <div class="section-title mb-0">
                    <h6 style="color: var(--saas-primary, #004f44); font-size: 13px; font-weight: 700; margin-bottom: 3px;">Live Classes Module</h6>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">Edit Live Class Session</h2>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">Update meeting details, scheduled timing, and curriculum linkage</p>
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 12px; background: #fef2f2; color: #991b1b;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                        <span class="fw-bold">Please correct the errors below:</span>
                    </div>
                    <ul class="mb-0 ps-4 font-size-13">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Live Class Edit Form -->
            <form action="{{ route('instructor.live-classes.update', $liveClass->id) }}" method="POST" id="liveClassForm">
                @csrf
                @method('PUT')

                <div class="pbz-liveclass-grid">
                    <!-- Left Column: Primary Class Info -->
                    <div class="pbz-liveclass-main-col">
                        <!-- Card 1: Course & Curriculum Link -->
                        <div class="pbz-dash-card">
                            <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                                <h3 class="pbz-dash-card-title">
                                    <i class="fa-solid fa-book-open-reader text-primary"></i>
                                    Course & Curriculum Linkage
                                </h3>
                                <span class="badge bg-light text-muted border font-size-11">Required</span>
                            </div>

                            <!-- Course Select -->
                            <div class="pbz-form-group">
                                <label for="course_id" class="pbz-form-label">
                                    <span>Select Course</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="pbz-input-icon-wrap">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    <select id="course_id" name="course_id" class="pbz-select @error('course_id') is-invalid @enderror" required>
                                        <option value="">-- Choose Course --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('course_id', $liveClass->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="pbz-form-hint">Course students enrolled in will be notified and given access to this session.</span>
                                @error('course_id')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Lesson Select -->
                            <div class="pbz-form-group">
                                <label for="lesson_id" class="pbz-form-label">
                                    <span>Link to Live Lesson in Curriculum</span>
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <div class="pbz-input-icon-wrap">
                                    <i class="fa-solid fa-circle-play"></i>
                                    <select id="lesson_id" name="lesson_id" class="pbz-select @error('lesson_id') is-invalid @enderror">
                                        <option value="">-- Choose Live Lesson (or leave unlinked) --</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}" {{ old('lesson_id', $liveClass->lesson_id) == $lesson->id ? 'selected' : '' }}>
                                                {{ $lesson->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="pbz-form-hint">Links this live stream directly inside the student's lesson player view.</span>
                                @error('lesson_id')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Card 2: Session Details & Description -->
                        <div class="pbz-dash-card">
                            <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                                <h3 class="pbz-dash-card-title">
                                    <i class="fa-solid fa-file-lines text-primary"></i>
                                    Session Details & Agenda
                                </h3>
                            </div>

                            <!-- Title -->
                            <div class="pbz-form-group">
                                <label for="title" class="pbz-form-label">
                                    <span>Live Class Title</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="pbz-input-icon-wrap">
                                    <i class="fa-solid fa-heading"></i>
                                    <input type="text" id="title" name="title" class="pbz-input @error('title') is-invalid @enderror"
                                        value="{{ old('title', $liveClass->title) }}" placeholder="e.g. Q&A and Interactive Review Session" required>
                                </div>
                                @error('title')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="pbz-form-group">
                                <label for="description" class="pbz-form-label">
                                    <span>Description / Agenda</span>
                                    <span class="text-muted fw-normal">(Optional)</span>
                                </label>
                                <textarea id="description" name="description" rows="4" class="pbz-textarea @error('description') is-invalid @enderror"
                                    placeholder="Provide key topics, prerequisites, or preparation notes for students...">{{ old('description', $liveClass->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Card 3: Meeting Connection URL -->
                        <div class="pbz-dash-card">
                            <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                                <h3 class="pbz-dash-card-title">
                                    <i class="fa-solid fa-video text-primary"></i>
                                    Video Conference Connection
                                </h3>
                            </div>

                            <div class="pbz-form-group">
                                <label for="join_url" class="pbz-form-label">
                                    <span>Live Meeting Join URL (Zoom / Google Meet / Teams)</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="pbz-input-icon-wrap">
                                    <i class="fa-solid fa-link"></i>
                                    <input type="url" id="join_url" name="join_url" class="pbz-input @error('join_url') is-invalid @enderror"
                                        value="{{ old('join_url', $liveClass->join_url) }}" placeholder="https://zoom.us/j/... or https://meet.google.com/..." required>
                                </div>
                                <span class="pbz-form-hint">The secure video link students click when clicking "Join Live Class".</span>
                                @error('join_url')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            @if($liveClass->join_url)
                                <div class="mt-2">
                                    <a href="{{ $liveClass->join_url }}" target="_blank" rel="noopener noreferrer" class="d-inline-flex align-items-center gap-1 font-size-12 text-primary fw-semibold">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        Test meeting link in new tab
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column: Schedule & Action Sidebar (Sticky Desktop) -->
                    <div class="pbz-liveclass-side-col">
                        <!-- Card 4: Timing & Schedule -->
                        <div class="pbz-dash-card">
                            <div class="pbz-dash-card-header pb-2 mb-3 border-bottom">
                                <h3 class="pbz-dash-card-title">
                                    <i class="fa-solid fa-clock text-primary"></i>
                                    Schedule & Timing
                                </h3>
                            </div>

                            <!-- Scheduled Start Time -->
                            <div class="pbz-form-group">
                                <label for="scheduled_at" class="pbz-form-label">
                                    <span>Scheduled Start Time</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="pbz-input-icon-wrap">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="pbz-input @error('scheduled_at') is-invalid @enderror"
                                        value="{{ old('scheduled_at', $liveClass->scheduled_at ? $liveClass->scheduled_at->format('Y-m-d\TH:i') : '') }}" required>
                                </div>
                                @error('scheduled_at')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Duration (Minutes) -->
                            <div class="pbz-form-group">
                                <label for="duration_minutes" class="pbz-form-label">
                                    <span>Duration (Minutes)</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="pbz-input-addon-wrap">
                                    <input type="number" id="duration_minutes" name="duration_minutes" min="1" max="1440"
                                        class="pbz-input @error('duration_minutes') is-invalid @enderror"
                                        value="{{ old('duration_minutes', $liveClass->duration_minutes ?: 60) }}" required placeholder="60">
                                    <span class="pbz-input-addon">min</span>
                                </div>
                                <span class="pbz-form-hint">E.g. 45, 60, or 90 minutes.</span>
                                @error('duration_minutes')
                                    <span class="text-danger font-size-12 mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Session Meta Summary -->
                            <div class="d-flex flex-column gap-2 mt-3 pt-3 border-top">
                                <div class="pbz-session-meta-chip">
                                    <span class="chip-label">Current Status</span>
                                    <span class="chip-val text-capitalize">{{ $liveClass->status ?? 'Scheduled' }}</span>
                                </div>
                                <div class="pbz-session-meta-chip">
                                    <span class="chip-label">Instructor</span>
                                    <span class="chip-val">{{ optional($liveClass->course->instructor)->name ?? Auth::user()->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card 5: Actions Card -->
                        <div class="pbz-dash-card pbz-form-actions-card">
                            <button type="submit" class="pbz-btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Save Changes</span>
                            </button>

                            <a href="{{ route('instructor.live-classes.index') }}" class="pbz-btn-secondary">
                                <i class="fa-solid fa-xmark"></i>
                                <span>Cancel & Return</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseSelect = document.getElementById('course_id');
    const lessonSelect = document.getElementById('lesson_id');

    function loadLessons(courseId, selectedLessonId = null) {
        if (!courseId) {
            lessonSelect.innerHTML = '<option value="">-- Choose Live Lesson (or leave unlinked) --</option>';
            return;
        }

        lessonSelect.innerHTML = '<option value="">Loading lessons...</option>';

        fetch(`/instructor/live-classes/lessons?course_id=${encodeURIComponent(courseId)}`)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.json();
            })
            .then(data => {
                let html = '<option value="">-- Choose Live Lesson (or leave unlinked) --</option>';
                if (data.lessons && data.lessons.length > 0) {
                    data.lessons.forEach(lesson => {
                        const selected = (selectedLessonId && selectedLessonId == lesson.id) ? 'selected' : '';
                        html += `<option value="${lesson.id}" ${selected}>${lesson.title}</option>`;
                    });
                } else {
                    html += '<option value="" disabled>No Live Lessons found in curriculum</option>';
                }
                lessonSelect.innerHTML = html;
            })
            .catch(err => {
                console.error('Error fetching lessons:', err);
                lessonSelect.innerHTML = '<option value="">-- Choose Live Lesson (or leave unlinked) --</option>';
            });
    }

    if (courseSelect) {
        courseSelect.addEventListener('change', function() {
            loadLessons(this.value);
        });
    }
});
</script>
@endsection

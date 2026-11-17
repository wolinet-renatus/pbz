@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $isEdit = isset($course) && $course;
    $pricingModel = old('pricing_model', $course->pricing_model ?? 'free');
    $scheduleEnabled = old('schedule_enabled', $course->schedule_enabled ?? false);
    $publicCourse = old('public_course', $course->public_course ?? true);
@endphp

<div class="row">
    <!-- Left Column: Main Course Information -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Course Details</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Course Title <span class="text-danger">*</span></label>
                    <input type="text" id="title" name="title" class="form-control"
                        value="{{ old('title', $course->title ?? '') }}" required
                        placeholder="e.g., AML / CFT & KYC Regulatory Certification">
                </div>

                <div class="form-group">
                    <label for="description">Course Description</label>
                    <textarea id="description" name="description" class="form-control" rows="5"
                        placeholder="Describe what staff and learners will gain from this course...">{{ old('description', $course->description ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="objectives">Learning Objectives</label>
                            <textarea id="objectives" name="objectives" class="form-control" rows="4"
                                placeholder="One objective per line">{{ old('objectives', $course->objectives ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="requirements">Prerequisites / Requirements</label>
                            <textarea id="requirements" name="requirements" class="form-control" rows="4"
                                placeholder="One requirement per line">{{ old('requirements', $course->requirements ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <label for="tags">Tags (comma-separated)</label>
                    <input type="text" id="tags" name="tags" class="form-control"
                        value="{{ old('tags', $course->tags ?? '') }}"
                        placeholder="e.g., AML, BOT, Banking, Islamic Finance">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>PBZ Curriculum &amp; Regulatory Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="curriculum_type">Curriculum Track <span class="text-danger">*</span></label>
                            @php $currType = old('curriculum_type', $course->curriculum_type ?? 'conventional'); @endphp
                            <select id="curriculum_type" name="curriculum_type" class="form-control" required>
                                <option value="conventional" {{ $currType === 'conventional' ? 'selected' : '' }}>Conventional Banking</option>
                                <option value="islamic_amana" {{ $currType === 'islamic_amana' ? 'selected' : '' }}>PBZ Amana (Islamic Banking)</option>
                                <option value="general_banking" {{ $currType === 'general_banking' ? 'selected' : '' }}>General Banking &amp; Operations</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="compliance_category">Compliance Category</label>
                            @php $compCat = old('compliance_category', $course->compliance_category ?? ''); @endphp
                            <select id="compliance_category" name="compliance_category" class="form-control">
                                <option value="">None (Elective / General)</option>
                                <option value="bot_mandate" {{ $compCat === 'bot_mandate' ? 'selected' : '' }}>BOT Statutory Mandate</option>
                                <option value="aml_cft" {{ $compCat === 'aml_cft' ? 'selected' : '' }}>AML / CFT</option>
                                <option value="kyc" {{ $compCat === 'kyc' ? 'selected' : '' }}>KYC &amp; Customer Due Diligence</option>
                                <option value="cyber_hygiene" {{ $compCat === 'cyber_hygiene' ? 'selected' : '' }}>Cyber Hygiene &amp; Security</option>
                                <option value="operational_risk" {{ $compCat === 'operational_risk' ? 'selected' : '' }}>Operational Risk</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estimated_minutes">Estimated Duration (minutes)</label>
                            <input type="number" id="estimated_minutes" name="estimated_minutes" class="form-control"
                                min="1" value="{{ old('estimated_minutes', $course->estimated_minutes ?? 30) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="validity_months">Certification Validity (months)</label>
                            <input type="number" id="validity_months" name="validity_months" class="form-control"
                                min="1" max="120" value="{{ old('validity_months', $course->validity_months ?? 12) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_mandatory" name="is_mandatory" value="1"
                                {{ old('is_mandatory', $course->is_mandatory ?? false) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_mandatory">Mandatory Course</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shariah_board_certified" name="shariah_board_certified" value="1"
                                {{ old('shariah_board_certified', $course->shariah_board_certified ?? false) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="shariah_board_certified">Shariah Board Certified</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_microlearning" name="is_microlearning" value="1"
                                {{ old('is_microlearning', $course->is_microlearning ?? false) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_microlearning">Microlearning Module</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Publishing, Assignment, Pricing & Media -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4>Publishing &amp; Classification</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="instructor_id">Instructor / Owner <span class="text-danger">*</span></label>
                    @php $selectedInstructor = old('instructor_id', $course->instructor_id ?? auth()->id()); @endphp
                    <select id="instructor_id" name="instructor_id" class="form-control" required>
                        @foreach ($instructors as $inst)
                            <option value="{{ $inst->id }}" {{ (int) $selectedInstructor === (int) $inst->id ? 'selected' : '' }}>
                                {{ $inst->name }} ({{ ucfirst($inst->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Course Status <span class="text-danger">*</span></label>
                    @php $currStatus = old('status', $course->status ?? 'published'); @endphp
                    <select id="status" name="status" class="form-control" required>
                        <option value="draft" {{ $currStatus === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ $currStatus === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="published" {{ $currStatus === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ $currStatus === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="visibility">Visibility <span class="text-danger">*</span></label>
                    @php $currVis = old('visibility', $course->visibility ?? 'public'); @endphp
                    <select id="visibility" name="visibility" class="form-control" required>
                        <option value="public" {{ $currVis === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $currVis === 'private' ? 'selected' : '' }}>Private (Internal Only)</option>
                        <option value="draft" {{ $currVis === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="course_category_id">Category</label>
                    @php $selectedCategory = old('course_category_id', $course->course_category_id ?? ''); @endphp
                    <select id="course_category_id" name="course_category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (int) $selectedCategory === (int) $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="course_language_id">Language</label>
                    @php $selectedLang = old('course_language_id', $course->course_language_id ?? ''); @endphp
                    <select id="course_language_id" name="course_language_id" class="form-control">
                        <option value="">Select Language</option>
                        @foreach ($languages as $lang)
                            <option value="{{ $lang->id }}" {{ (int) $selectedLang === (int) $lang->id ? 'selected' : '' }}>
                                {{ $lang->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="difficulty">Difficulty Level <span class="text-danger">*</span></label>
                    @php $currDiff = old('difficulty', $course->difficulty ?? 'beginner'); @endphp
                    <select id="difficulty" name="difficulty" class="form-control" required>
                        <option value="beginner" {{ $currDiff === 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ $currDiff === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ $currDiff === 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="public_course" name="public_course" value="1"
                        {{ $publicCourse ? 'checked' : '' }}>
                    <label class="custom-control-label" for="public_course">Unlimited Seats</label>
                </div>

                <div class="form-group {{ $publicCourse ? 'd-none' : '' }}" id="maxStudentsGroup">
                    <label for="max_students">Maximum Seats</label>
                    <input type="number" id="max_students" name="max_students" class="form-control" min="1"
                        value="{{ old('max_students', $course->max_students ?? '') }}">
                </div>

                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="is_live_course" name="is_live_course" value="1"
                        {{ old('is_live_course', $course->is_live_course ?? false) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_live_course">Includes Live Sessions</label>
                </div>

                <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="schedule_enabled" name="schedule_enabled" value="1"
                        {{ $scheduleEnabled ? 'checked' : '' }}>
                    <label class="custom-control-label" for="schedule_enabled">Schedule Release Date</label>
                </div>

                <div class="form-group mb-0 {{ $scheduleEnabled ? '' : 'd-none' }}" id="scheduleDateGroup">
                    <label for="schedule_date">Release Date &amp; Time</label>
                    <input type="datetime-local" id="schedule_date" name="schedule_date" class="form-control"
                        value="{{ old('schedule_date', isset($course->schedule_date) ? $course->schedule_date->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Pricing</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="pricing_model">Pricing Model <span class="text-danger">*</span></label>
                    <select id="pricing_model" name="pricing_model" class="form-control" required>
                        <option value="free" {{ $pricingModel === 'free' ? 'selected' : '' }}>Free (Corporate / Internal)</option>
                        <option value="paid" {{ $pricingModel === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div id="paidFieldsGroup" class="{{ $pricingModel === 'paid' ? '' : 'd-none' }}">
                    <div class="form-group">
                        <label for="regular_price">Regular Price</label>
                        <input type="number" step="0.01" min="0" id="regular_price" name="regular_price" class="form-control"
                            value="{{ old('regular_price', $course->regular_price ?? '') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="sale_price">Sale Price (optional)</label>
                        <input type="number" step="0.01" min="0" id="sale_price" name="sale_price" class="form-control"
                            value="{{ old('sale_price', $course->sale_price ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Course Media</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="featured_image">Featured Thumbnail</label>
                    @if ($isEdit && $course->featured_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $course->featured_image) }}" alt="{{ $course->title }}"
                                class="img-fluid rounded border" style="max-height: 140px; width: 100%; object-fit: cover;">
                            <div class="custom-control custom-checkbox mt-1">
                                <input type="checkbox" class="custom-control-input" id="remove_featured_image" name="remove_featured_image" value="1">
                                <label class="custom-control-label text-danger" for="remove_featured_image">Remove current thumbnail</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" id="featured_image" name="featured_image" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">JPEG, PNG, GIF, or WEBP up to 5 MB.</small>
                </div>

                <div class="form-group mb-0">
                    <label for="intro_video">Intro Video (optional)</label>
                    @if ($isEdit && $course->intro_video)
                        <div class="mb-2">
                            <span class="badge badge-info d-inline-block mb-1">Current video uploaded</span>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remove_intro_video" name="remove_intro_video" value="1">
                                <label class="custom-control-label text-danger" for="remove_intro_video">Remove current intro video</label>
                            </div>
                        </div>
                    @endif
                    <input type="file" id="intro_video" name="intro_video" class="form-control-file" accept="video/mp4,video/webm,video/quicktime">
                    <small class="form-text text-muted">MP4, MOV, or WEBM up to 500 MB.</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function() {
        const pricingEl = document.getElementById('pricing_model');
        const paidGroup = document.getElementById('paidFieldsGroup');
        if (pricingEl && paidGroup) {
            pricingEl.addEventListener('change', function() {
                paidGroup.classList.toggle('d-none', this.value !== 'paid');
            });
        }

        const publicEl = document.getElementById('public_course');
        const maxStudentsGroup = document.getElementById('maxStudentsGroup');
        if (publicEl && maxStudentsGroup) {
            publicEl.addEventListener('change', function() {
                maxStudentsGroup.classList.toggle('d-none', this.checked);
            });
        }

        const schedEl = document.getElementById('schedule_enabled');
        const schedGroup = document.getElementById('scheduleDateGroup');
        if (schedEl && schedGroup) {
            schedEl.addEventListener('change', function() {
                schedGroup.classList.toggle('d-none', !this.checked);
            });
        }
    })();
</script>
@endpush

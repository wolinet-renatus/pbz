@forelse($courses as $index => $course)
    @php
        $lessonCount = $course->topics->sum(function ($topic) {
            return $topic->lessons->count();
        });
        
        $totalDuration = $course->topics->sum(function ($topic) {
            return $topic->lessons->sum(function ($lesson) {
                return (int) ($lesson->duration ?? 0);
            });
        });

        $formattedDuration = null;
        if ($totalDuration > 0) {
            $hours = floor($totalDuration / 60);
            $mins = $totalDuration % 60;
            $formattedDuration = ($hours > 0 ? $hours . 'h ' : '') . ($mins > 0 ? $mins . 'm' : ($hours === 0 ? '0m' : ''));
        } else {
            $formattedDuration = 'Self-paced';
        }

        $isFree = ($course->pricing_model === 'free' || (!$course->sale_price && !$course->regular_price));
        $hasDiscount = (!$isFree && $course->regular_price > 0 && $course->sale_price > 0 && $course->regular_price > $course->sale_price);
        $discountPercent = $hasDiscount ? round((($course->regular_price - $course->sale_price) / $course->regular_price) * 100) : 0;

        $displayPrice = $isFree 
            ? __('frontend.free') 
            : currency_format($course->sale_price ?? $course->regular_price ?? 0);
        $originalPrice = ($hasDiscount) ? currency_format($course->regular_price) : null;

        $ratingVal = number_format($course->average_rating ?? 5.0, 1);
        $studentsCount = $course->students_count ?? 0;
        $difficulty = ucfirst($course->difficulty ?: 'All Levels');

        $thumbUrl = $course->featured_image 
            ? asset('storage/' . $course->featured_image) 
            : asset('assets/front/img/home-1/courses/courses-01.jpg');

        $instructorPhoto = ($course->instructor && $course->instructor->profile_photo)
            ? asset('storage/' . $course->instructor->profile_photo)
            : null;
        $instructorName = $course->instructor->name ?? __('frontend.instructor');
    @endphp

    <div class="col-lg-4 col-md-6 col-12">
        <div class="card course-compact-card border h-100 shadow-sm rounded-3 overflow-hidden bg-white d-flex flex-column">
            <!-- Thumbnail Section (145px compact height) -->
            <div class="course-thumb-box position-relative overflow-hidden" style="height: 145px; background: #f1f5f9;">
                <a href="{{ route('courses.show', $course->id) }}" class="d-block w-100 h-100 text-decoration-none">
                    <img src="{{ $thumbUrl }}" alt="{{ $course->title }}" class="course-thumb-img w-100 h-100 object-fit-cover" loading="lazy">
                </a>
                
                <!-- Dual Curriculum & Compliance Badge (Top-Left) -->
                <div class="position-absolute top-0 start-0 m-2.5 z-2" style="max-width: 75%;">
                    @if ($course->curriculum_type === 'islamic_amana')
                        <span class="badge shadow-sm border rounded-pill px-2.5 py-1 text-truncate d-inline-block mw-100" style="font-size: 0.70rem; font-weight: 700; background: #006837; color: #F9ED27; border-color: #004d28 !important;">
                            <i class="fa-solid fa-moon me-1 text-warning"></i> PBZ Islamic (Amana)
                        </span>
                    @elseif(!empty($course->compliance_category))
                        <span class="badge shadow-sm border rounded-pill px-2.5 py-1 text-truncate d-inline-block mw-100" style="font-size: 0.70rem; font-weight: 700; background: #081226; color: #F9ED27; border-color: #1e293b !important;">
                            <i class="fa-solid fa-scale-balanced me-1 text-warning"></i> BOT Mandate
                        </span>
                    @else
                        <span class="badge bg-white text-dark shadow-sm border rounded-pill px-2.5 py-1 text-truncate d-inline-block mw-100" style="font-size: 0.70rem; font-weight: 600;">
                            <i class="fa-solid fa-building-columns me-1 text-primary"></i> Conventional
                        </span>
                    @endif
                </div>

                <!-- Microlearning / Corporate Status Badge (Top-Right) -->
                <div class="position-absolute top-0 end-0 m-2.5 z-2">
                    @if ($course->is_microlearning)
                        <span class="badge shadow-sm rounded-pill px-2 py-1 fw-bold text-white" style="font-size: 0.68rem; background: #0284c7;">
                            <i class="fa-solid fa-bolt me-1"></i> {{ $course->estimated_minutes ?: 8 }}m Scenario
                        </span>
                    @elseif ($course->is_mandatory)
                        <span class="badge shadow-sm rounded-pill px-2 py-1 fw-bold text-white" style="font-size: 0.68rem; background: #dc2626;">
                            MANDATORY
                        </span>
                    @else
                        <span class="badge shadow-sm rounded-pill px-2 py-1 fw-bold" style="font-size: 0.68rem; background: #e0f2fe; color: #0369a1;">
                            PBZ STAFF
                        </span>
                    @endif
                </div>

                <!-- Video Popup preview button if available -->
                @if ($course->intro_video)
                    <a href="{{ asset('storage/' . $course->intro_video) }}" class="video-play-pill video-popup position-absolute bottom-0 start-0 m-2 rounded-pill bg-dark bg-opacity-75 text-white px-2 py-0.5 d-inline-flex align-items-center gap-1 shadow-sm text-decoration-none" style="font-size: 11px;">
                        <i class="fa-solid fa-play" style="font-size: 9px;"></i>
                        <span>Preview</span>
                    </a>
                @endif
            </div>

            <!-- Card Content Body -->
            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                <!-- Stars & Trainees Count Row -->
                <div class="d-flex align-items-center justify-content-between mb-1.5">
                    <div class="d-flex align-items-center gap-1.5">
                        <span class="text-warning rating-stars d-inline-flex gap-0.5" style="font-size: 0.76rem;">
                            @for ($s = 1; $s <= 5; $s++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </span>
                        <span class="fw-bold text-dark" style="font-size: 0.8rem;">{{ $ratingVal }}</span>
                    </div>
                    <span class="text-muted" style="font-size: 0.75rem;">
                        {{ $studentsCount }} {{ Str::plural('trainee', $studentsCount) }}
                    </span>
                </div>

                <!-- Course Title (Clamped to 2 lines) -->
                <h6 class="course-card-title fw-bold mb-2">
                    <a href="{{ route('courses.show', $course->id) }}" class="text-dark text-decoration-none hover-primary" title="{{ $course->title }}">
                        {{ $course->title }}
                    </a>
                </h6>

                <!-- Instructor Row -->
                <div class="d-flex align-items-center gap-2 mb-2.5">
                    @if ($instructorPhoto)
                        <img src="{{ $instructorPhoto }}" alt="{{ $instructorName }}" class="rounded-circle object-fit-cover flex-shrink-0 border" style="width: 22px; height: 22px;">
                    @else
                        <div class="rounded-circle bg-primary-subtle text-primary fw-bold d-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; font-size: 10px;">
                            {{ strtoupper(substr($instructorName, 0, 1)) }}
                        </div>
                    @endif
                    <span class="text-muted text-truncate" style="font-size: 0.78rem; font-weight: 500;">
                        {{ $instructorName }}
                    </span>
                </div>

                <!-- Specs Row: Lessons, Duration, Difficulty -->
                <div class="course-specs-bar d-flex align-items-center justify-content-between text-muted small py-1.5 px-2 mb-2.5 rounded-2 bg-light border" style="font-size: 0.73rem;">
                    <span class="d-flex align-items-center gap-1 text-truncate">
                        <i class="fa-regular fa-circle-play text-primary" style="font-size: 0.75rem;"></i>
                        <span>{{ $lessonCount }} lessons</span>
                    </span>
                    <span class="d-flex align-items-center gap-1 text-truncate">
                        <i class="fa-regular fa-clock text-primary" style="font-size: 0.75rem;"></i>
                        <span>{{ $formattedDuration }}</span>
                    </span>
                    <span class="d-flex align-items-center gap-1 text-truncate">
                        <i class="fa-solid fa-signal text-primary" style="font-size: 0.7rem;"></i>
                        <span>{{ $difficulty }}</span>
                    </span>
                </div>

                <!-- PBZ Corporate Staff Access Bar -->
                <div class="d-flex align-items-center gap-1.5 small fw-semibold mb-3 mt-auto" style="font-size: 0.72rem; color: #006837;">
                    <i class="fa-solid fa-circle-check text-success" style="font-size: 0.75rem;"></i>
                    <span>PBZ Staff Academy • Sovereign Access</span>
                </div>

                <!-- Footer: Staff Access Status & Quick Action Button -->
                <div class="d-flex align-items-center justify-content-between pt-2.5 border-top mt-auto">
                    <div class="d-flex align-items-center gap-1">
                        <span class="badge rounded-pill px-2 py-1 fw-bold" style="background: #e6f4ea; color: #137333; font-size: 0.72rem;">
                            <i class="fa-solid fa-lock-open me-1"></i> FREE STAFF ACCESS
                        </span>
                    </div>

                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary px-3 py-1 rounded-2 fw-semibold" style="font-size: 0.78rem; background-color: #006837; border-color: #006837; transition: all 0.2s ease;">
                        View &amp; Enroll
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 py-5 text-center">
        <div class="empty-state-box p-4 rounded-3 border bg-light d-inline-block shadow-sm" style="max-width: 460px;">
            <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                <i class="fa-solid fa-graduation-cap fa-lg"></i>
            </div>
            <h5 class="fw-bold mb-1">{{ __('frontend.no_courses_found') ?? 'No courses found' }}</h5>
            <p class="text-muted small mb-3">No courses match your active search or filter criteria. Try adjusting your keywords or clearing filters.</p>
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1.5" onclick="resetAllFilters()">
                <i class="fa-solid fa-rotate-left me-1"></i> Reset All Filters
            </button>
        </div>
    </div>
@endforelse

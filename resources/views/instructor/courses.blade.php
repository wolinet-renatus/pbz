@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.my_courses') ?? 'My Courses'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <!-- Page Header -->
            <div class="section-title-area wow fadeInUp d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div class="section-title mb-0">
                    <h6 style="color: var(--saas-primary, #004f44); font-size: 13px; font-weight: 700; margin-bottom: 4px;">{{ __('instructor.my_courses') }}</h6>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ __('instructor.manage_courses_title') }}</h2>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">{{ __('instructor.manage_courses_subtitle') }}</p>
                </div>
                <div class="dashboard-header-actions mb-0">
                    <a href="{{ route('instructor.courses.create') }}" class="theme-btn" style="padding: 10px 18px; font-size: 13px; border-radius: 10px;">
                        {{ __('instructor.create_new_course') }}
                        <i class="fa-solid fa-plus ms-1"></i>
                    </a>
                </div>
            </div>

                    <!-- Courses Section with Gradient Background -->
                    <div class="dashboard-courses-section">
                        <div class="row">
                            @forelse($courses as $index => $course)
                                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                    <div class="mhq-courses-box-items">
                                        <div class="mhq-courses-image">
                                            <img src="{{ $course['image_url'] }}" alt="{{ $course['title'] }}"
                                                onerror="this.src='{{ asset('assets/front/img/home-1/courses/courses-01.jpg') }}'">
                                            <span class="post-box">{{ $course['category'] }}</span>
                                            @if ($course['is_live_course'])
                                                <span class="post-box" style="left: auto; right: 8px; top: 8px; background-color: #dc3545; border-color: #dc3545;">
                                                    <i class="fas fa-broadcast-tower me-1"></i> {{ __('frontend.live') }}
                                                </span>
                                            @endif
                                            @if ($course['status'] === 'draft')
                                                <span class="course-status-badge draft">{{ __('instructor.draft') }}</span>
                                            @elseif($course['status'] === 'pending')
                                                <span class="course-status-badge pending">{{ __('instructor.pending_approval') }}</span>
                                            @elseif($course['status'] === 'published')
                                                <span class="course-status-badge published">{{ __('instructor.published') }}</span>
                                            @endif
                                        </div>
                                        <div class="mhq-courses-content">
                                            <div class="star">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php $rating = $course['rating_for_stars']; @endphp
                                                    @if ($rating >= $i)
                                                        <i class="fa-solid fa-star"></i>
                                                    @elseif($rating >= $i - 0.5)
                                                        <i class="fa-solid fa-star-half-stroke"></i>
                                                    @else
                                                        <i class="fa-regular fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="star-average">
                                                    {{ $course['rating'] !== null ? number_format($course['rating'], 1) : '—' }}
                                                </span>
                                            </div>
                                            <h3><a
                                                    href="{{ route('courses.show', $course['id']) }}">{{ $course['title'] }}</a>
                                            </h3>
                                            <ul class="post-date">
                                                <li>
                                                    <a href="#" class="icon video-popup">
                                                        <i class="fa-regular fa-circle-play"></i>
                                                    </a>
                                                    {{ $course['lessons'] }}{{ __('instructor.lessons_count_postfix') }}
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <i class="fa-regular fa-user"></i>
                                                    </div>
                                                    {{ __('instructor.students') }} {{ number_format($course['students']) }}
                                                </li>
                                            </ul>
                                            <div class="client-info-area">
                                                <div class="client-info">
                                                    <div class="img">
                                                        <img src="{{ asset('assets/front/img/home-1/courses/client-01.png') }}"
                                                            alt="img">
                                                    </div>
                                                    {{ explode(' ', $user->name)[0] }}
                                                </div>
                                                <div class="badge rounded-pill px-2.5 py-1 fw-bold text-success border border-success-subtle bg-success-subtle" style="font-size: 11px;">
                                                    <i class="fa-solid fa-building-columns me-1"></i> Staff Academy
                                                </div>
                                            </div>
                                            <div class="course-actions">
                                                <a href="{{ route('instructor.courses.edit', $course['id']) }}"
                                                    class="theme-btn">
                                                    {{ __('instructor.edit_course') }}
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                                <a href="{{ route('courses.show', $course['id']) }}"
                                                    class="theme-btn style-2">
                                                    {{ __('instructor.view_course') }}
                                                    <i class="fa-solid fa-arrow-up-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="dashboard-empty-state">
                                        <i class="fa-solid fa-book-open"></i>
                                        <h3>{{ __('instructor.no_courses_title') }}</h3>
                                        <p>{{ __('instructor.no_courses_desc') }}</p>

                                    </div>
                                </div>
                            @endforelse
                    </div>
                    <!-- Dashboard Courses Section End -->
                </div>

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>
@endsection

@extends('layouts.instructor')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('instructor.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('instructor.partials.topbar', ['pageTitle' => __('instructor.quizzes_label') ?? 'Quizzes'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area">
            <div class="section-title-area wow fadeInUp mb-4">
                <div class="section-title mb-0">
                    <h6 style="color: var(--saas-primary, #004f44); font-size: 13px; font-weight: 700; margin-bottom: 4px;">{{ __('instructor.quizzes_label') }}</h6>
                    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 4px;">{{ __('instructor.your_course_quizzes') }}</h2>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">{{ __('instructor.quizzes_subtitle') }}</p>
                </div>
            </div>

            <div class="dashboard-stats-minimal mb-4">
                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-1">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">{{ $summary['total_quizzes'] }}</div>
                                <div class="stat-label-minimal">{{ __('instructor.quizzes_label') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-2">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">{{ $summary['total_attempts'] }}</div>
                                <div class="stat-label-minimal">{{ __('instructor.total_attempts') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-3">
                                <i class="fa-solid fa-square-check"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">{{ $summary['passed_attempts'] }}</div>
                                <div class="stat-label-minimal">{{ __('instructor.passed_attempts') }}</div>
                            </div>
                        </div>

                        <div class="stat-card-minimal">
                            <div class="stat-icon-minimal stat-icon-4">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                            <div class="stat-content-minimal">
                                <div class="stat-value-minimal">
                                    {{ $summary['average_score'] !== null ? $summary['average_score'] . '%' : '—' }}</div>
                                <div class="stat-label-minimal">{{ __('instructor.average_score') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="assignments-filter-card wow fadeInUp" data-wow-delay=".1s">
                        <form method="GET" action="{{ route('instructor.quizzes.index') }}"
                            class="assignments-filter-form">
                            <div class="filter-group">
                                <label for="quiz-course-filter">{{ __('instructor.course') }}</label>
                                <div class="filter-select">
                                    <select id="quiz-course-filter" name="course_id" class="nice-select">
                                        <option value="">{{ __('instructor.all_courses') }}</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}"
                                                {{ $selectedCourseId === $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="filter-group">
                                <label for="quiz-search">{{ __('instructor.search') }}</label>
                                <div class="filter-search">
                                    <input type="search" id="quiz-search" name="search" class="search-input"
                                        value="{{ $searchTerm }}" placeholder="{{ __('instructor.search_quiz_title') }}">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <div class="filter-actions">
                                <button type="submit" class="filter-submit-btn">
                                    <i class="fa-solid fa-search"></i>
                                    <span>{{ __('instructor.apply') }}</span>
                                </button>
                                @if ($selectedCourseId || $searchTerm)
                                    <a href="{{ route('instructor.quizzes.index') }}" class="filter-reset-btn">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>{{ __('instructor.reset') }}</span>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="assignments-grid">
                        @forelse($quizzes as $quiz)
                            <div class="assignment-card wow fadeInUp" data-wow-delay=".05s">
                                <div class="assignment-card-header">
                                    <div class="assignment-icon">
                                        <i class="fa-solid fa-circle-question"></i>
                                    </div>
                                    <div>
                                        <h3>{{ $quiz->title }}</h3>
                                        <p>
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            {{ $quiz->course_title }}
                                        </p>
                                    </div>
                                </div>

                                <div class="assignment-card-body">
                                    <p class="assignment-description">{{ $quiz->short_description }}</p>

                                    <div class="assignment-stats">
                                        <div class="assignment-stat">
                                            <span class="stat-label">{{ __('instructor.attempts') }}</span>
                                            <span class="stat-value">{{ $quiz->attempts_count }}</span>
                                        </div>
                                        <div class="assignment-stat">
                                            <span class="stat-label">{{ __('instructor.passed') }}</span>
                                            <span class="stat-value">{{ $quiz->passed_attempts_count }}</span>
                                        </div>
                                        <div class="assignment-stat">
                                            <span class="stat-label">{{ __('instructor.passing_score') }}</span>
                                            <span class="stat-value">{{ $quiz->passing_score }}%</span>
                                        </div>
                                        <div class="assignment-stat">
                                            <span class="stat-label">{{ __('instructor.pass_rate') }}</span>
                                            <span
                                                class="stat-value">{{ $quiz->pass_rate !== null ? $quiz->pass_rate . '%' : '—' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="assignment-card-footer">
                                    <a href="{{ route('instructor.quizzes.show', $quiz) }}" class="assignment-action-btn">
                                        <i class="fa-solid fa-eye"></i>
                                        {{ __('instructor.view_attempts') }}
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="dashboard-empty-state">
                                <i class="fa-solid fa-circle-question"></i>
                                <h3>{{ __('instructor.no_quizzes_found') }}</h3>
                                <p>{{ __('instructor.create_quizzes_desc') }}</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($quizzes->hasPages())
                        <div class="table-pagination">
                            <div class="pagination-info">
                                {{ __('instructor.showing_quizzes', ['from' => $quizzes->firstItem(), 'to' => $quizzes->lastItem(), 'total' => $quizzes->total()]) }}
                            </div>
                            <div class="pagination-links">
                                @if ($quizzes->onFirstPage())
                                    <span class="pagination-btn disabled">
                                        <i class="fa-solid fa-chevron-left"></i>
                                        {{ __('instructor.previous') }}
                                    </span>
                                @else
                                    <a href="{{ $quizzes->previousPageUrl() }}" class="pagination-btn">
                                        <i class="fa-solid fa-chevron-left"></i>
                                        {{ __('instructor.previous') }}
                                    </a>
                                @endif

                                <div class="pagination-numbers">
                                    @foreach ($quizzes->getUrlRange(max(1, $quizzes->currentPage() - 2), min($quizzes->lastPage(), $quizzes->currentPage() + 2)) as $page => $url)
                                        @if ($page === $quizzes->currentPage())
                                            <span class="pagination-number active">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}"
                                                class="pagination-number">{{ $page }}</a>
                                        @endif
                                    @endforeach
                                </div>

                                @if ($quizzes->hasMorePages())
                                    <a href="{{ $quizzes->nextPageUrl() }}" class="pagination-btn">
                                        {{ __('instructor.next') }}
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="pagination-btn disabled">
                                        {{ __('instructor.next') }}
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

            <!-- Portal Footer -->
            @include('instructor.partials.footer')
        </div>
    </div>
</div>
@endsection

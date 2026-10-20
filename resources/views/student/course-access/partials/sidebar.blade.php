<!-- Course Content Card -->
<div class="card border rounded-3 shadow-none bg-white mb-3" style="border-color: #e2e8f0 !important;">
    <div class="card-header bg-white py-3 px-3.5 border-bottom d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
        <h5 class="fw-bold mb-0" style="font-size: 15px; color: #0f172a;">
            {{ __('student.course_content') ?? 'Course Content' }}
        </h5>
        <span class="badge bg-light text-muted border px-2 py-0.5 rounded-pill" style="font-size: 11px;">
            {{ count($topicsData) }} {{ count($topicsData) === 1 ? 'Section' : 'Sections' }}
        </span>
    </div>

    <!-- Search Input Filter -->
    <div class="p-2.5 border-bottom bg-light-subtle" style="border-color: #e2e8f0 !important;">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0" style="border-color: #cbd5e1; color: #64748b;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" id="curriculum-search-input" class="form-control border-start-0 ps-1" placeholder="Search lessons..." style="border-color: #cbd5e1; font-size: 12.5px;">
        </div>
    </div>

    <!-- Sections Accordion -->
    <div class="course-curriculum p-2" id="course-curriculum-accordion">
        @foreach ($topicsData as $topicData)
            @php
                $isTopicActive = false;
                foreach ($topicData['items'] as $it) {
                    if ($it['is_active'] && $it['type'] === 'lesson') {
                        $isTopicActive = true;
                        break;
                    }
                }
            @endphp
            <div class="chapter-section mb-2 rounded-2 border overflow-hidden {{ $isTopicActive ? '' : 'collapsed' }}" style="border-color: #e2e8f0 !important;">
                <div class="chapter-header p-2.5 bg-light d-flex align-items-center justify-content-between" 
                     data-chapter="{{ $topicData['index'] + 1 }}" 
                     style="cursor: pointer; user-select: none;">
                    <div class="d-flex align-items-center gap-2 min-w-0">
                        <i class="fa-solid {{ $isTopicActive ? 'fa-chevron-down' : 'fa-chevron-right' }} chapter-toggle-icon text-muted" style="font-size: 11px;"></i>
                        <span class="fw-bold text-dark text-truncate" style="font-size: 13px;">
                            Section {{ $topicData['index'] + 1 }}
                        </span>
                    </div>
                    <span class="chapter-progress badge bg-white text-muted border rounded-pill px-2 py-0.5 font-monospace fw-bold" style="font-size: 10.5px; border-color: #cbd5e1 !important;">
                        {{ $topicData['progress']['completed_items'] }}/{{ $topicData['progress']['total_items'] }}
                    </span>
                </div>

                <div class="chapter-content {{ $isTopicActive ? '' : 'd-none' }}" style="background: #ffffff;">
                    @php $hasLessons = false; @endphp
                    @foreach ($topicData['items'] as $item)
                        @if ($item['type'] === 'lesson')
                            @php $hasLessons = true; @endphp
                            <div class="curriculum-item lesson-item p-2.5 d-flex align-items-center justify-content-between gap-2 border-bottom {{ $item['is_active'] ? 'active' : '' }} {{ !$item['is_accessible'] ? 'locked' : '' }}"
                                data-item-id="{{ $item['id'] }}" 
                                data-item-type="lesson"
                                data-course-id="{{ $course->id }}"
                                data-accessible="{{ $item['is_accessible'] ? '1' : '0' }}"
                                style="cursor: {{ $item['is_accessible'] ? 'pointer' : 'not-allowed' }}; text-decoration: none; transition: background-color 0.15s ease; border-color: #f1f5f9 !important;">
                                
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <!-- Status Icon -->
                                    <div class="curriculum-item-status flex-shrink-0" style="width: 18px; text-align: center;">
                                        @if ($item['is_completed'])
                                            <i class="fa-solid fa-circle-check text-success status-completed" style="font-size: 14px;"></i>
                                        @elseif($item['is_active'])
                                            <i class="fa-solid fa-circle-dot status-active" style="color: #0099cc; font-size: 14px;"></i>
                                        @elseif(!$item['is_accessible'])
                                            <i class="fa-solid fa-lock text-muted status-locked" style="font-size: 12px; opacity: 0.6;"></i>
                                        @else
                                            <i class="fa-regular fa-circle text-muted" style="font-size: 13px;"></i>
                                        @endif
                                    </div>

                                    <!-- Title -->
                                    <div class="d-flex align-items-center gap-1.5 min-w-0">
                                        @if (($item['content_type'] ?? 'video') === 'interactive_chart')
                                            <span class="badge px-1.5 py-0.5 rounded flex-shrink-0" style="font-size: 9px; background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;">CHART</span>
                                        @elseif(($item['content_type'] ?? 'video') === 'calculator')
                                            <span class="badge px-1.5 py-0.5 rounded flex-shrink-0" style="font-size: 9px; background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;">CALC</span>
                                        @elseif(($item['content_type'] ?? 'video') === 'decision_tree')
                                            <span class="badge px-1.5 py-0.5 rounded flex-shrink-0" style="font-size: 9px; background: #fef3c7; color: #d97706; border: 1px solid #fde68a;">DECISION</span>
                                        @elseif(($item['content_type'] ?? 'video') === 'embed_iframe')
                                            <span class="badge px-1.5 py-0.5 rounded flex-shrink-0" style="font-size: 9px; background: #e0e7ff; color: #4f46e5; border: 1px solid #c7d2fe;">H5P</span>
                                        @elseif($item['is_live'] ?? false)
                                            <span class="badge px-1.5 py-0.5 rounded flex-shrink-0" style="font-size: 9px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;">LIVE</span>
                                        @endif
                                        <span class="curriculum-item-title text-truncate fw-medium" style="font-size: 12.5px; color: {{ $item['is_active'] ? '#0099cc' : ($item['is_accessible'] ? '#1e293b' : '#94a3b8') }}; font-weight: {{ $item['is_active'] ? '700' : '500' }} !important;">
                                            {{ $item['title'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Duration -->
                                @if ($item['duration_formatted'])
                                    <span class="curriculum-item-duration text-muted flex-shrink-0" style="font-size: 11px;">
                                        {{ $item['duration_formatted'] }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasLessons)
                        <div class="p-2.5 text-center text-muted" style="font-size: 11.5px;">
                            No lessons in this section.
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- More Card (Quizzes & Assignments) -->
@php
    $allQuizzes = collect();
    $allAssignments = collect();
    foreach ($topicsData as $td) {
        foreach ($td['items'] as $it) {
            if ($it['type'] === 'quiz') {
                $allQuizzes->push($it);
            } elseif ($it['type'] === 'assignment') {
                $allAssignments->push($it);
            }
        }
    }
@endphp

@if ($allQuizzes->isNotEmpty() || $allAssignments->isNotEmpty())
<div class="card border rounded-3 shadow-none bg-white mb-3" style="border-color: #e2e8f0 !important;">
    <div class="card-header bg-white py-3 px-3.5 border-bottom d-flex align-items-center justify-content-between" style="border-color: #e2e8f0 !important;">
        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2" style="font-size: 15px; color: #0f172a;">
            <i class="fa-solid fa-shapes text-primary" style="font-size: 14px; color: #0099cc !important;"></i>
            {{ __('student.more') ?? 'More' }}
        </h5>
    </div>

    <div class="card-body p-3">
        <!-- QUIZZES -->
        @if ($allQuizzes->isNotEmpty())
            <div class="mb-3">
                <div class="text-uppercase fw-bold text-muted mb-2" style="font-size: 10.5px; letter-spacing: 0.5px;">
                    QUIZZES
                </div>
                <div class="d-flex flex-column gap-2">
                    @foreach ($allQuizzes as $quizItem)
                        <div class="curriculum-item quiz-item p-2.5 rounded-2 border d-flex align-items-center justify-content-between gap-2 {{ $quizItem['is_active'] ? 'active' : '' }} {{ !$quizItem['is_accessible'] ? 'locked' : '' }}"
                            data-item-id="{{ $quizItem['id'] }}" 
                            data-item-type="quiz"
                            data-course-id="{{ $course->id }}"
                            data-accessible="{{ $quizItem['is_accessible'] ? '1' : '0' }}"
                            style="cursor: {{ $quizItem['is_accessible'] ? 'pointer' : 'not-allowed' }}; border-color: {{ $quizItem['is_active'] ? '#0099cc' : '#e2e8f0' }} !important; background: {{ $quizItem['is_active'] ? '#f0f9ff' : '#ffffff' }};">
                            
                            <div class="d-flex align-items-center gap-2.5 min-w-0">
                                <div class="flex-shrink-0" style="width: 24px; height: 24px; border-radius: 6px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    @if ($quizItem['is_completed'])
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-regular fa-circle-question"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="fw-bold text-truncate" style="font-size: 12.5px; color: #0f172a;">
                                        {{ $quizItem['title'] }}
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        @if ($quizItem['is_completed'])
                                            <span class="text-success fw-semibold"><i class="fa-solid fa-check me-0.5"></i> Passed</span>
                                        @elseif(!$quizItem['is_accessible'])
                                            <span class="text-muted"><i class="fa-solid fa-lock me-0.5"></i> Locked</span>
                                        @else
                                            <span>Assessment Ready</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted flex-shrink-0" style="font-size: 11px;"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- ASSIGNMENTS -->
        @if ($allAssignments->isNotEmpty())
            <div>
                <div class="text-uppercase fw-bold text-muted mb-2" style="font-size: 10.5px; letter-spacing: 0.5px;">
                    ASSIGNMENTS
                </div>
                <div class="d-flex flex-column gap-2">
                    @foreach ($allAssignments as $assignmentItem)
                        <div class="curriculum-item assignment-item p-2.5 rounded-2 border d-flex align-items-center justify-content-between gap-2 {{ $assignmentItem['is_active'] ? 'active' : '' }} {{ !$assignmentItem['is_accessible'] ? 'locked' : '' }}"
                            data-item-id="{{ $assignmentItem['id'] }}" 
                            data-item-type="assignment"
                            data-course-id="{{ $course->id }}"
                            data-accessible="{{ $assignmentItem['is_accessible'] ? '1' : '0' }}"
                            style="cursor: {{ $assignmentItem['is_accessible'] ? 'pointer' : 'not-allowed' }}; border-color: {{ $assignmentItem['is_active'] ? '#0099cc' : '#e2e8f0' }} !important; background: {{ $assignmentItem['is_active'] ? '#f0f9ff' : '#ffffff' }};">
                            
                            <div class="d-flex align-items-center gap-2.5 min-w-0">
                                <div class="flex-shrink-0" style="width: 24px; height: 24px; border-radius: 6px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                                    @if ($assignmentItem['is_completed'])
                                        <i class="fa-solid fa-check text-success"></i>
                                    @else
                                        <i class="fa-regular fa-clipboard"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="fw-bold text-truncate" style="font-size: 12.5px; color: #0f172a;">
                                        {{ $assignmentItem['title'] }}
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        @if ($assignmentItem['is_completed'])
                                            <span class="text-success fw-semibold"><i class="fa-solid fa-check me-0.5"></i> Submitted</span>
                                        @elseif(!$assignmentItem['is_accessible'])
                                            <span class="text-muted"><i class="fa-solid fa-lock me-0.5"></i> Locked</span>
                                        @else
                                            <span>Practical Case Study</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted flex-shrink-0" style="font-size: 11px;"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endif

<style>
    .curriculum-item:hover:not(.locked) {
        background-color: #f8fafc !important;
    }
    .curriculum-item.active {
        background-color: #f0f9ff !important;
        border-left: 3px solid #0099cc !important;
    }
    .chapter-section.collapsed .chapter-content {
        display: none !important;
    }
</style>

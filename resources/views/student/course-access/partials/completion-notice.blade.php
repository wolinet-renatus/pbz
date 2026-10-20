<!-- Course Completion Notice -->
<div class="card border rounded-3 p-4 mb-3 text-white shadow-none" style="background-color: #006837; border-color: #00502a !important;">
    <div class="row align-items-center g-3">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 26px; color: #d4af37; flex-shrink: 0;">
                    <i class="fa-solid fa-award"></i>
                </div>
                <div>
                    <h4 class="text-white fw-bold mb-1" style="font-size: 1.15rem;">
                        {{ __('student.congratulations_course_completed') ?? 'Congratulations! Course Completed' }}
                    </h4>
                    <p class="text-white-50 mb-0" style="font-size: 13px;">
                        {{ __('student.course_completed_desc') ?? 'You have fulfilled all Bank of Tanzania regulatory standards and lessons for this course.' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-start text-md-end">
            <a href="{{ route('student.certificates') }}" class="btn btn-sm fw-bold px-3 py-2 rounded-2"
                style="background-color: #d4af37; border-color: #d4af37; color: #072818; font-size: 13px;">
                <i class="fa-solid fa-certificate me-1.5"></i> {{ __('student.view_certificate') ?? 'View Certificate' }}
            </a>
        </div>
    </div>
</div>

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * My Courses Controller
 *
 * This controller handles the my courses functionality.
 *
 * @package App\Http\Controllers\Student
 */
class MyCoursesController extends Controller
{
    public function index(): View
    {
        $user = $this->currentUser();

        $enrollments = Enrollment::with(['course.instructor', 'course.topics.lessons', 'payment'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['approved', 'completed'])
            ->orderByDesc('enrolled_at')
            ->paginate(12);

        $transformed = $enrollments->getCollection()->values()->map(function (Enrollment $enrollment, int $index) use ($user) {
            $course = $enrollment->course;
            $lessonCount = $course?->topics->sum(fn ($topic) => $topic->lessons->count()) ?? 0;
            
            $progressPercentage = 0;
            if ($enrollment->status === Enrollment::STATUS_COMPLETED) {
                $progressPercentage = 100;
            } elseif ($lessonCount > 0) {
                $completedLessons = \App\Models\LessonProgress::where('user_id', $user->id)
                    ->where('enrollment_id', $enrollment->id)
                    ->where('is_completed', true)
                    ->count();
                $progressPercentage = min(100, round(($completedLessons / $lessonCount) * 100));
            }

            return [
                'id' => $enrollment->id,
                'course_id' => $course?->id,
                'course_title' => $course?->title,
                'course_category' => $course?->category ? ucfirst($course->category) : 'Banking & Finance',
                'is_live_course' => $course?->is_live_course ?? false,
                'featured_image' => $course?->featured_image,
                'intro_video' => $course?->intro_video,
                'status' => $enrollment->status,
                'price_label' => $this->priceLabel($course),
                'lesson_count' => $lessonCount,
                'progress_percentage' => $progressPercentage,
                'max_students' => $course?->max_students,
                'instructor_name' => $course?->instructor->name ?? 'PBZ Faculty',
                'instructor_avatar' => $course?->instructor->profile_photo,
                'enrolled_at' => $enrollment->enrolled_at,
                'animation_delay' => ($index % 6) * 0.2,
                'is_pending' => $enrollment->status === Enrollment::STATUS_PENDING,
                'is_approved' => $enrollment->status === Enrollment::STATUS_APPROVED,
                'is_completed' => $enrollment->status === Enrollment::STATUS_COMPLETED,
            ];
        });

        $enrollments->setCollection($transformed);

        return view('student.my-courses', [
            'enrollments' => $enrollments,
            'user' => $user,
        ]);
    }

    private function priceLabel($course): string
    {
        if (! $course) {
            return 'Free';
        }

        if ($course->pricing_model === 'free') {
            return 'Free';
        }

        if ($course->sale_price) {
            return '$' . number_format($course->sale_price, 2);
        }

        return '$' . number_format($course->regular_price ?? 0, 2);
    }

    private function currentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();

        return $user;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use App\Models\Payment;
use App\Models\QuizAttempt;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Reports Controller
 *
 * This controller handles the management of reports.
 *
 * @package App\Http\Controllers\Admin
 */
class ReportsController extends Controller
{
    /**
     * Display the reports index
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfPreviousMonth = $startOfMonth->copy()->subMonth();
        $endOfPreviousMonth = $startOfPreviousMonth->copy()->endOfMonth();

        $completedPaymentsQuery = Payment::query()->where('status', Payment::STATUS_COMPLETED);

        $financials = [
            'total_revenue' => (float) (clone $completedPaymentsQuery)->sum('amount'),
            'total_instructor' => (float) (clone $completedPaymentsQuery)->sum('instructor_earning'),
            'total_platform' => (float) (clone $completedPaymentsQuery)->sum('platform_commission'),
            'monthly_revenue' => (float) (clone $completedPaymentsQuery)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount'),
            'monthly_instructor' => (float) (clone $completedPaymentsQuery)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('instructor_earning'),
            'monthly_platform' => (float) (clone $completedPaymentsQuery)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('platform_commission'),
            'previous_month_revenue' => (float) (clone $completedPaymentsQuery)->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])->sum('amount'),
        ];

        $financials['revenue_growth'] = $financials['previous_month_revenue'] > 0
            ? (($financials['monthly_revenue'] - $financials['previous_month_revenue']) / $financials['previous_month_revenue']) * 100
            : null;

        $enrollmentAgg = Enrollment::query()
            ->selectRaw('COUNT(*) as total_enrollments')
            ->selectRaw("SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed_enrollments", [Enrollment::STATUS_COMPLETED])
            ->selectRaw("SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as active_enrollments", [Enrollment::STATUS_APPROVED])
            ->selectRaw("SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending_enrollments", [Enrollment::STATUS_PENDING])
            ->selectRaw('SUM(CASE WHEN COALESCE(enrolled_at, created_at) BETWEEN ? AND ? THEN 1 ELSE 0 END) as new_enrollments_month', [$startOfMonth, $endOfMonth])
            ->first();

        $totalEnrollments = (int) ($enrollmentAgg->total_enrollments ?? 0);
        $completedEnrollments = (int) ($enrollmentAgg->completed_enrollments ?? 0);

        $enrollmentStats = [
            'total_enrollments' => $totalEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'active_enrollments' => (int) ($enrollmentAgg->active_enrollments ?? 0),
            'pending_enrollments' => (int) ($enrollmentAgg->pending_enrollments ?? 0),
            'new_enrollments_month' => (int) ($enrollmentAgg->new_enrollments_month ?? 0),
            'completion_rate' => $totalEnrollments > 0
                ? ($completedEnrollments / $totalEnrollments) * 100
                : 0.0,
        ];

        $studentStats = [
            'total_students' => User::where('role', 'student')->count(),
            'new_students_month' => User::where('role', 'student')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'approved_instructors' => User::where('role', 'instructor')->where('is_approved', true)->count(),
        ];

        $courseAgg = Course::query()
            ->selectRaw('COUNT(*) as total_courses')
            ->selectRaw("SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published_courses")
            ->selectRaw('SUM(CASE WHEN is_mandatory = 1 THEN 1 ELSE 0 END) as mandatory_courses')
            ->first();

        $quizAgg = QuizAttempt::query()
            ->selectRaw('COUNT(*) as total_attempts')
            ->selectRaw('SUM(CASE WHEN passed = 1 THEN 1 ELSE 0 END) as passed_attempts')
            ->selectRaw('AVG(score) as avg_score')
            ->first();

        $reviewAgg = Review::query()
            ->where('is_approved', true)
            ->selectRaw('COUNT(*) as total_reviews')
            ->selectRaw('AVG(rating) as avg_rating')
            ->first();

        $totalQuizAttempts = (int) ($quizAgg->total_attempts ?? 0);
        $passedQuizAttempts = (int) ($quizAgg->passed_attempts ?? 0);

        $academyStats = [
            'total_courses' => (int) ($courseAgg->total_courses ?? 0),
            'published_courses' => (int) ($courseAgg->published_courses ?? 0),
            'mandatory_courses' => (int) ($courseAgg->mandatory_courses ?? 0),
            'total_quiz_attempts' => $totalQuizAttempts,
            'passed_quiz_attempts' => $passedQuizAttempts,
            'quiz_pass_rate' => $totalQuizAttempts > 0 ? ($passedQuizAttempts / $totalQuizAttempts) * 100 : 0.0,
            'avg_quiz_score' => round((float) ($quizAgg->avg_score ?? 0), 1),
            'lessons_completed' => LessonProgress::where('is_completed', true)->count(),
            'total_reviews' => (int) ($reviewAgg->total_reviews ?? 0),
            'avg_rating' => round((float) ($reviewAgg->avg_rating ?? 0), 1),
            'active_branches' => Branch::where('is_active', true)->count(),
        ];

        $hasRevenue = $financials['total_revenue'] > 0;
        $topCourses = $this->topCoursesReport(6);
        $topInstructors = $this->topInstructorsReport(5);
        $branchPerformance = $this->branchPerformanceReport();
        $monthlyTrend = $this->monthlyTrendReport(6);

        $monthlyTrendChart = [
            'labels' => $monthlyTrend->pluck('label')->values()->all(),
            'revenue' => $monthlyTrend->pluck('revenue')->values()->all(),
            'enrollments' => $monthlyTrend->pluck('enrollments')->values()->all(),
            'completions' => $monthlyTrend->pluck('completions')->values()->all(),
        ];

        $topCourseChart = [
            'labels' => $topCourses->pluck('course_title')->values()->all(),
            'revenue' => $topCourses->pluck('total_revenue')->values()->all(),
            'sales' => $topCourses->pluck('total_sales')->values()->all(),
            'enrollments' => $topCourses->pluck('total_enrollments')->values()->all(),
            'completions' => $topCourses->pluck('total_completions')->values()->all(),
        ];

        $topInstructorChart = [
            'labels' => $topInstructors->pluck('instructor_name')->values()->all(),
            'earnings' => $topInstructors->pluck('total_earning')->values()->all(),
            'enrollments' => $topInstructors->pluck('total_enrollments')->values()->all(),
        ];

        return view('admin.reports.index', [
            'hasRevenue' => $hasRevenue,
            'financials' => $financials,
            'academyStats' => $academyStats,
            'enrollmentStats' => $enrollmentStats,
            'studentStats' => $studentStats,
            'topCourses' => $topCourses,
            'topInstructors' => $topInstructors,
            'branchPerformance' => $branchPerformance,
            'monthlyTrend' => $monthlyTrend,
            'monthlyTrendChart' => $monthlyTrendChart,
            'topCourseChart' => $topCourseChart,
            'topInstructorChart' => $topInstructorChart,
        ]);
    }

    /**
     * Get the top courses report using joined course, enrollment, payment, review, and instructor tables.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function topCoursesReport(int $limit = 6): Collection
    {
        $paymentsSub = DB::table('payments')
            ->select([
                'enrollment_id',
                DB::raw('SUM(amount) as paid_amount'),
                DB::raw('COUNT(id) as paid_count'),
            ])
            ->where('status', Payment::STATUS_COMPLETED)
            ->groupBy('enrollment_id');

        $enrollmentSub = DB::table('enrollments')
            ->leftJoinSub($paymentsSub, 'payment_agg', 'payment_agg.enrollment_id', '=', 'enrollments.id')
            ->select([
                'enrollments.course_id',
                DB::raw('COUNT(enrollments.id) as total_enrollments'),
                DB::raw("SUM(CASE WHEN enrollments.status = '" . Enrollment::STATUS_COMPLETED . "' THEN 1 ELSE 0 END) as total_completions"),
                DB::raw('COALESCE(SUM(payment_agg.paid_amount), 0) as total_revenue'),
                DB::raw('COALESCE(SUM(payment_agg.paid_count), 0) as total_sales'),
            ])
            ->groupBy('enrollments.course_id');

        $reviewSub = DB::table('reviews')
            ->select([
                'course_id',
                DB::raw('AVG(rating) as avg_rating'),
                DB::raw('COUNT(id) as reviews_count'),
            ])
            ->where('is_approved', true)
            ->groupBy('course_id');

        $rows = DB::table('courses')
            ->leftJoin('users as instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->leftJoinSub($enrollmentSub, 'enroll_agg', 'enroll_agg.course_id', '=', 'courses.id')
            ->leftJoinSub($reviewSub, 'review_agg', 'review_agg.course_id', '=', 'courses.id')
            ->whereNull('courses.deleted_date')
            ->select([
                'courses.id as course_id',
                'courses.title as course_title',
                'instructors.name as instructor_name',
                DB::raw('COALESCE(enroll_agg.total_enrollments, 0) as total_enrollments'),
                DB::raw('COALESCE(enroll_agg.total_completions, 0) as total_completions'),
                DB::raw('COALESCE(enroll_agg.total_revenue, 0) as total_revenue'),
                DB::raw('COALESCE(enroll_agg.total_sales, 0) as total_sales'),
                DB::raw('COALESCE(review_agg.avg_rating, 0) as avg_rating'),
                DB::raw('COALESCE(review_agg.reviews_count, 0) as reviews_count'),
            ])
            ->orderByDesc('total_revenue')
            ->orderByDesc('total_enrollments')
            ->orderByDesc('total_completions')
            ->limit($limit)
            ->get();

        return $rows->map(function ($row) {
            $enrollments = (int) $row->total_enrollments;
            $completions = (int) $row->total_completions;

            return [
                'course_id' => (int) $row->course_id,
                'course_title' => $row->course_title,
                'instructor_name' => $row->instructor_name ?? 'PBZ Faculty',
                'total_enrollments' => $enrollments,
                'total_completions' => $completions,
                'completion_rate' => $enrollments > 0 ? round(($completions / $enrollments) * 100, 1) : 0.0,
                'total_revenue' => (float) $row->total_revenue,
                'total_sales' => (int) $row->total_sales,
                'avg_rating' => round((float) $row->avg_rating, 1),
                'reviews_count' => (int) $row->reviews_count,
            ];
        });
    }

    /**
     * Get the top instructors report using joined user, course, enrollment, and payment tables.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function topInstructorsReport(int $limit = 5): Collection
    {
        $paymentsSub = DB::table('payments')
            ->select([
                'enrollment_id',
                DB::raw('SUM(instructor_earning) as paid_earning'),
                DB::raw('COUNT(id) as paid_count'),
            ])
            ->where('status', Payment::STATUS_COMPLETED)
            ->groupBy('enrollment_id');

        $courseStatsSub = DB::table('enrollments')
            ->leftJoinSub($paymentsSub, 'payment_agg', 'payment_agg.enrollment_id', '=', 'enrollments.id')
            ->select([
                'enrollments.course_id',
                DB::raw('COUNT(enrollments.id) as total_enrollments'),
                DB::raw("SUM(CASE WHEN enrollments.status = '" . Enrollment::STATUS_COMPLETED . "' THEN 1 ELSE 0 END) as total_completions"),
                DB::raw('COALESCE(SUM(payment_agg.paid_earning), 0) as total_earning'),
                DB::raw('COALESCE(SUM(payment_agg.paid_count), 0) as total_sales'),
            ])
            ->groupBy('enrollments.course_id');

        $rows = DB::table('users')
            ->join('courses', function ($join) {
                $join->on('courses.instructor_id', '=', 'users.id')
                    ->whereNull('courses.deleted_date');
            })
            ->leftJoinSub($courseStatsSub, 'course_stats', 'course_stats.course_id', '=', 'courses.id')
            ->where('users.role', 'instructor')
            ->select([
                'users.id as instructor_id',
                'users.name as instructor_name',
                DB::raw('COUNT(DISTINCT courses.id) as courses_count'),
                DB::raw('COALESCE(SUM(course_stats.total_enrollments), 0) as total_enrollments'),
                DB::raw('COALESCE(SUM(course_stats.total_completions), 0) as total_completions'),
                DB::raw('COALESCE(SUM(course_stats.total_earning), 0) as total_earning'),
                DB::raw('COALESCE(SUM(course_stats.total_sales), 0) as total_sales'),
            ])
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_earning')
            ->orderByDesc('total_enrollments')
            ->orderByDesc('total_completions')
            ->limit($limit)
            ->get();

        return $rows->map(function ($row) {
            return [
                'instructor_id' => (int) $row->instructor_id,
                'instructor_name' => $row->instructor_name,
                'courses_count' => (int) $row->courses_count,
                'total_enrollments' => (int) $row->total_enrollments,
                'total_completions' => (int) $row->total_completions,
                'total_earning' => (float) $row->total_earning,
                'total_sales' => (int) $row->total_sales,
            ];
        });
    }

    /**
     * Get branch-level staff & enrollment compliance metrics via SQL joins.
     *
     * @return \Illuminate\Support\Collection
     */
    private function branchPerformanceReport(): Collection
    {
        $rows = DB::table('branches')
            ->leftJoin('users', function ($join) {
                $join->on('users.branch_id', '=', 'branches.id')
                    ->where('users.role', '=', 'student');
            })
            ->leftJoin('enrollments', 'enrollments.user_id', '=', 'users.id')
            ->where('branches.is_active', true)
            ->select([
                'branches.id',
                'branches.name',
                'branches.code',
                'branches.region',
                DB::raw('COUNT(DISTINCT users.id) as staff_count'),
                DB::raw('COUNT(DISTINCT enrollments.id) as total_enrollments'),
                DB::raw("COUNT(DISTINCT CASE WHEN enrollments.status = '" . Enrollment::STATUS_COMPLETED . "' THEN enrollments.id END) as completed_enrollments"),
                DB::raw("COUNT(DISTINCT CASE WHEN enrollments.status = '" . Enrollment::STATUS_APPROVED . "' THEN enrollments.id END) as active_enrollments"),
            ])
            ->groupBy('branches.id', 'branches.name', 'branches.code', 'branches.region')
            ->orderByDesc('total_enrollments')
            ->orderByDesc('staff_count')
            ->orderBy('branches.name')
            ->get();

        return $rows->map(function ($row) {
            $total = (int) $row->total_enrollments;
            $completed = (int) $row->completed_enrollments;

            return [
                'id' => (int) $row->id,
                'name' => $row->name,
                'code' => $row->code,
                'region' => $row->region,
                'staff_count' => (int) $row->staff_count,
                'total_enrollments' => $total,
                'completed_enrollments' => $completed,
                'active_enrollments' => (int) $row->active_enrollments,
                'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 1) : 0.0,
            ];
        });
    }

    /**
     * Get the monthly trend report
     *
     * @param int $months
     * @return \Illuminate\Support\Collection
     */
    private function monthlyTrendReport(int $months = 6): Collection
    {
        $data = collect();
        $months = max($months, 1);

        for ($i = $months - 1; $i >= 0; $i--) {
            $period = Carbon::now()->subMonths($i);
            $start = $period->copy()->startOfMonth();
            $end = $period->copy()->endOfMonth();

            $data->push([
                'label' => $period->format('M Y'),
                'revenue' => (float) Payment::where('status', Payment::STATUS_COMPLETED)
                    ->whereBetween('created_at', [$start, $end])
                    ->sum('amount'),
                'enrollments' => Enrollment::whereRaw('COALESCE(enrolled_at, created_at) BETWEEN ? AND ?', [$start, $end])->count(),
                'completions' => Enrollment::completed()
                    ->whereRaw('COALESCE(completed_at, updated_at) BETWEEN ? AND ?', [$start, $end])
                    ->count(),
            ]);
        }

        return $data;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use App\Models\EventBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $thisMonthStart = Carbon::now()->startOfMonth();
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Optional Top Filter parameters
        $filterCourseId = $request->query('course_id');
        $filterCategoryId = $request->query('category_id');
        $filterStatus = $request->query('status');

        // Base Queries scoped by filters if present
        $paymentsQuery = Payment::where('status', Payment::STATUS_COMPLETED);
        $enrollmentsQuery = Enrollment::query();
        $coursesQuery = Course::query();

        if ($filterCourseId) {
            $paymentsQuery->whereHas('enrollment', fn($q) => $q->where('course_id', $filterCourseId));
            $enrollmentsQuery->where('course_id', $filterCourseId);
            $coursesQuery->where('id', $filterCourseId);
        } elseif ($filterCategoryId) {
            $paymentsQuery->whereHas('enrollment.course', fn($q) => $q->where('category_id', $filterCategoryId));
            $enrollmentsQuery->whereHas('course', fn($q) => $q->where('category_id', $filterCategoryId));
            $coursesQuery->where('category_id', $filterCategoryId);
        }

        if ($filterStatus) {
            if ($filterStatus === 'active') {
                $coursesQuery->where('status', 'published');
            } elseif (in_array($filterStatus, ['pending', 'draft', 'published', 'archived'])) {
                $coursesQuery->where('status', $filterStatus);
            }
        }

        // 1. Overview Stats
        $totalRevenue = (float) (clone $paymentsQuery)->sum('amount');
        $lastMonthRevenue = (float) (clone $paymentsQuery)
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('amount');
        $revenueChangePct = $lastMonthRevenue > 0
            ? round((($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : null;

        $totalStudents = User::where('role', 'student')->count();
        $newStudentsThisMonth = User::where('role', 'student')
            ->where('created_at', '>=', $thisMonthStart)
            ->count();
        $lastMonthNewStudents = User::where('role', 'student')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->count();
        $studentsChangePct = $lastMonthNewStudents > 0
            ? round((($newStudentsThisMonth - $lastMonthNewStudents) / $lastMonthNewStudents) * 100, 1)
            : null;

        $totalEnrollments = (clone $enrollmentsQuery)->count();
        $thisMonthEnrollments = (clone $enrollmentsQuery)->where('created_at', '>=', $thisMonthStart)->count();

        $completedEnrollments = (clone $enrollmentsQuery)->where('status', Enrollment::STATUS_COMPLETED)->count();
        $pendingEnrollments = (clone $enrollmentsQuery)->where('status', Enrollment::STATUS_PENDING)->count();

        $averageRating = Review::where('is_approved', true)->avg('rating') ?: 0;
        $totalApprovedReviews = Review::where('is_approved', true)->count();

        // 2. Pending Offline Payments
        $pendingOfflinePayments = Payment::where('payment_method', Payment::PAYMENT_METHOD_OFFLINE)
            ->where('status', Payment::STATUS_PENDING)
            ->count();

        // 3. Multi-period Chart Data
        $charts = [
            'thirty_days' => $this->getChartData('thirty_days'),
            'this_year' => $this->getChartData('this_year'),
            'last_12_months' => $this->getChartData('last_12_months'),
        ];

        // 4. Secondary Stats
        $totalCourses = (clone $coursesQuery)->count();
        $activeCourses = (clone $coursesQuery)->where('status', 'published')->count();
        $completionRate = $totalEnrollments > 0
            ? round(($completedEnrollments / $totalEnrollments) * 100, 1)
            : 0;

        // 5. Top Performing Courses
        $topCourseData = Enrollment::join('payments', 'enrollments.id', '=', 'payments.enrollment_id')
            ->where('payments.status', Payment::STATUS_COMPLETED)
            ->select('enrollments.course_id', DB::raw('SUM(payments.amount) as total_revenue'))
            ->groupBy('enrollments.course_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $topCourses = Course::whereIn('id', $topCourseData->pluck('course_id'))
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->select('id', 'title', 'featured_image')
            ->get()
            ->map(function ($course) use ($topCourseData) {
                $revenue = (float) ($topCourseData->firstWhere('course_id', $course->id)->total_revenue ?? 0);

                $completedCount = Enrollment::where('course_id', $course->id)
                    ->where('status', Enrollment::STATUS_COMPLETED)
                    ->count();
                $courseCompletionRate = $course->enrollments_count > 0
                    ? round(($completedCount / $course->enrollments_count) * 100, 1)
                    : 0;

                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'thumbnail' => $course->thumbnail,
                    'enrollments' => $course->enrollments_count,
                    'revenue' => $revenue,
                    'rating' => round($course->reviews_avg_rating ?? 0, 1),
                    'completion_rate' => $courseCompletionRate,
                ];
            })
            ->sortByDesc('revenue')
            ->values();

        // If topCourses from payments is empty, pull published courses with most enrollments
        if ($topCourses->isEmpty()) {
            $topCourses = Course::where('status', 'published')
                ->withCount(['enrollments', 'reviews'])
                ->withAvg('reviews', 'rating')
                ->orderByDesc('enrollments_count')
                ->limit(5)
                ->get()
                ->map(function ($course) {
                    $completedCount = Enrollment::where('course_id', $course->id)
                        ->where('status', Enrollment::STATUS_COMPLETED)
                        ->count();
                    $courseCompletionRate = $course->enrollments_count > 0
                        ? round(($completedCount / $course->enrollments_count) * 100, 1)
                        : 0;

                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'thumbnail' => $course->thumbnail,
                        'enrollments' => $course->enrollments_count,
                        'revenue' => 0,
                        'rating' => round($course->reviews_avg_rating ?? 5.0, 1),
                        'completion_rate' => $courseCompletionRate,
                    ];
                });
        }

        // 6. Student Engagement
        $active7Days = Enrollment::where('created_at', '>=', Carbon::now()->subDays(7))
            ->distinct('user_id')->count('user_id');
        if ($active7Days === 0) {
            $active7Days = User::where('role', 'student')->where('updated_at', '>=', Carbon::now()->subDays(7))->count();
        }
        if ($active7Days === 0 && $totalStudents > 0) {
            $active7Days = min($totalStudents, Enrollment::distinct('user_id')->count('user_id'));
        }

        $activeEngaged = Enrollment::whereIn('status', [Enrollment::STATUS_APPROVED, Enrollment::STATUS_COMPLETED])
            ->distinct('user_id')->count('user_id');
        $completingEngaged = $completedEnrollments;
        $atRiskEngaged = $pendingEnrollments;

        $studentEngagement = [
            'active_students' => $active7Days ?: $activeEngaged,
            'active_percentage' => $totalStudents > 0 ? round((($active7Days ?: $activeEngaged) / $totalStudents) * 100, 1) : 0,
            'completing_students' => $completingEngaged,
            'completing_percentage' => $totalStudents > 0 ? round(($completingEngaged / $totalStudents) * 100, 1) : 0,
            'at_risk_students' => $atRiskEngaged,
            'at_risk_percentage' => $totalStudents > 0 ? round(($atRiskEngaged / $totalStudents) * 100, 1) : 0,
        ];

        // 7. Recent Activity
        $recentEnrollments = Enrollment::with(['user:id,name', 'course:id,title'])
            ->latest()->limit(5)->get()->map(fn($e) => [
                'type' => 'enrollment',
                'icon' => 'fa-user-plus',
                'message' => ($e->user->name ?? 'Student') . ' enrolled in "' . ($e->course->title ?? 'Course') . '"',
                'time' => $e->created_at->diffForHumans(),
                'timestamp' => $e->created_at,
            ]);

        $recentReviews = Review::with(['user:id,name', 'course:id,title'])
            ->where('is_approved', true)
            ->latest()->limit(5)->get()->map(fn($r) => [
                'type' => 'review',
                'icon' => 'fa-star',
                'message' => ($r->user->name ?? 'Student') . ' rated "' . ($r->course->title ?? 'Course') . '" ' . round($r->rating, 1) . ' stars',
                'time' => $r->created_at->diffForHumans(),
                'timestamp' => $r->created_at,
            ]);

        $recentActivity = $recentEnrollments->merge($recentReviews)->sortByDesc('timestamp')->take(8)->values();

        // 8. Recent Event Bookings
        $recentEventBookings = EventBooking::with(['user:id,name', 'event:id,title'])
            ->latest('booked_at')
            ->limit(5)
            ->get()
            ->map(fn($b) => [
                'id' => $b->id,
                'user_name' => $b->full_name ?: ($b->user->name ?? 'Student'),
                'event_title' => $b->event->title ?? 'Event',
                'seats' => $b->seats,
                'status' => $b->status,
                'time' => $b->booked_at ? $b->booked_at->diffForHumans() : $b->created_at->diffForHumans(),
            ]);

        // 9. Recent Staff Enrollments & Compliance
        $recentEnrollmentsList = Enrollment::with(['user.branch', 'course'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'course_title' => $e->course->title ?? 'PBZ Banking Course',
                'student_name' => $e->user->name ?? 'Bank Staff',
                'branch' => $e->user->branch->name ?? 'Zanzibar HQ',
                'status' => $e->status,
                'date' => ($e->enrolled_at ?? $e->created_at)?->format('M d, Y') ?? 'Recent',
            ]);

        $recentTransactions = $recentEnrollmentsList;

        $analytics = [
            'overview' => [
                'total_revenue' => $totalRevenue,
                'revenue_change_pct' => $revenueChangePct,
                'total_students' => $totalStudents,
                'new_students_this_month' => $newStudentsThisMonth,
                'students_change_pct' => $studentsChangePct,
                'total_enrollments' => $totalEnrollments,
                'this_month_enrollments' => $thisMonthEnrollments,
                'completed_enrollments' => $completedEnrollments,
                'pending_enrollments' => $pendingEnrollments,
                'total_certificates' => $completedEnrollments,
                'average_rating' => $averageRating,
                'total_reviews' => $totalApprovedReviews,
                'completion_rate' => $completionRate,
                'active_courses' => $activeCourses,
                'total_courses' => $totalCourses,
                'refund_rate' => 0,
                'pending_offline_payments' => $pendingOfflinePayments,
                'active_7d_count' => $studentEngagement['active_students'],
                'inactive_7d_count' => max(0, $totalStudents - $studentEngagement['active_students']),
            ],
            'charts' => $charts,
            'top_courses' => $topCourses,
            'student_engagement' => $studentEngagement,
            'recent_activity' => $recentActivity,
            'recent_event_bookings' => $recentEventBookings,
            'recent_transactions' => $recentTransactions,
            'filters' => [
                'course_id' => $filterCourseId,
                'category_id' => $filterCategoryId,
                'status' => $filterStatus,
            ],
        ];

        return view('admin.dashboard', compact('analytics'));
    }

    private function getChartData($period)
    {
        $labels = [];
        $revenue = [];
        $enrollments = [];

        if ($period === 'thirty_days') {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $labels[] = $date->format('d M');
                $revenue[] = (float) Payment::where('status', Payment::STATUS_COMPLETED)
                    ->whereDate('created_at', $date)
                    ->sum('amount');
                $enrollments[] = Enrollment::whereDate('created_at', $date)->count();
            }
        } elseif ($period === 'this_year') {
            $startOfYear = Carbon::now()->startOfYear();
            $currentMonth = Carbon::now()->month;
            for ($i = 1; $i <= $currentMonth; $i++) {
                $date = $startOfYear->copy()->month($i);
                $labels[] = $date->format('M');
                $revenue[] = (float) Payment::where('status', Payment::STATUS_COMPLETED)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount');
                $enrollments[] = Enrollment::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }
        } else { // last_12_months
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $labels[] = $date->format('M');
                $revenue[] = (float) Payment::where('status', Payment::STATUS_COMPLETED)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->sum('amount');
                $enrollments[] = Enrollment::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
            }
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'enrollments' => $enrollments,
        ];
    }
}

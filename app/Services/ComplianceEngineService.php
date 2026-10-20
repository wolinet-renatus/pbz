<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\BranchEscalation;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComplianceEngineService
{
    /**
     * Direct one-click enrollment for PBZ corporate staff.
     */
    public function directEnroll(User $user, Course $course): Enrollment
    {
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing) {
            if ($existing->status === Enrollment::STATUS_PENDING) {
                $existing->update([
                    'status' => Enrollment::STATUS_APPROVED,
                    'enrolled_at' => $existing->enrolled_at ?? now(),
                ]);
            }
            return $existing;
        }

        // Calculate compliance due date if mandatory or compliance
        $dueDate = null;
        if ($course->is_mandatory || !empty($course->compliance_category)) {
            $dueDate = now()->addDays(30); // 30-day corporate compliance window
        }

        return Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => Enrollment::STATUS_APPROVED,
            'enrolled_at' => now(),
            'due_date' => $dueDate,
            'expires_at' => $dueDate ? now()->addMonths($course->validity_months ?: 12) : null,
        ]);
    }

    /**
     * Dynamic cohort auto-enrollment for PBZ staff based on branch, department, and role.
     */
    public function autoEnrollStaff(User $user): int
    {
        $mandatoryCourses = Course::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_mandatory', true)
                    ->orWhereNotNull('compliance_category');
            })
            ->get();

        $enrolledCount = 0;

        foreach ($mandatoryCourses as $course) {
            $existing = Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();

            if (!$existing) {
                $this->directEnroll($user, $course);
                $enrolledCount++;
            }
        }

        return $enrolledCount;
    }

    /**
     * Get real-time compliance scorecard and countdowns for a staff member.
     */
    public function getStaffComplianceStatus(User $user): array
    {
        $mandatoryEnrollments = Enrollment::with('course')
            ->where('user_id', $user->id)
            ->whereHas('course', function ($query) {
                $query->where('is_mandatory', true)
                    ->orWhereNotNull('compliance_category');
            })
            ->get();

        $total = $mandatoryEnrollments->count();
        $completed = $mandatoryEnrollments->where('status', Enrollment::STATUS_COMPLETED)->count();
        $overdue = 0;
        $expiringSoon = 0;

        $tracks = [
            'bot_mandate' => ['label' => 'BOT Statutory Directives', 'completed' => 0, 'total' => 0],
            'aml_cft'     => ['label' => 'AML & CFT Prevention', 'completed' => 0, 'total' => 0],
            'kyc'         => ['label' => 'KYC & Due Diligence', 'completed' => 0, 'total' => 0],
            'cyber_hygiene'=> ['label' => 'Cyber Security & Hygiene', 'completed' => 0, 'total' => 0],
        ];

        foreach ($mandatoryEnrollments as $enr) {
            $cat = $enr->course->compliance_category ?: 'bot_mandate';
            if (isset($tracks[$cat])) {
                $tracks[$cat]['total']++;
                if ($enr->isCompleted()) {
                    $tracks[$cat]['completed']++;
                }
            }

            if ($enr->isOverdue()) {
                $overdue++;
            } elseif ($enr->isExpiringSoon(14)) {
                $expiringSoon++;
            }
        }

        $complianceRate = $total > 0 ? round(($completed / $total) * 100) : 100;

        return [
            'total_assigned' => $total,
            'completed' => $completed,
            'in_progress' => $total - $completed,
            'overdue_count' => $overdue,
            'expiring_soon_count' => $expiringSoon,
            'compliance_rate' => $complianceRate,
            'enrollments' => $mandatoryEnrollments,
            'category_tracks' => $tracks,
        ];
    }

    /**
     * Get branch-wide compliance oversight matrix for Branch Managers and Compliance Executives.
     */
    public function getBranchComplianceMatrix(?int $branchId = null): array
    {
        $query = User::with(['branch', 'department', 'enrollments.course'])
            ->where('role', 'student');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $staffList = $query->get();

        $totalAssignedMandates = 0;
        $totalCompletedMandates = 0;
        $totalOverdueMandates = 0;
        $escalatedCount = 0;

        $matrixRows = [];

        foreach ($staffList as $staff) {
            $staffStatus = $this->getStaffComplianceStatus($staff);

            $totalAssignedMandates += $staffStatus['total_assigned'];
            $totalCompletedMandates += $staffStatus['completed'];
            $totalOverdueMandates += $staffStatus['overdue_count'];

            $hasEscalated = $staff->enrollments->where('is_escalated', true)->count() > 0;
            if ($hasEscalated) {
                $escalatedCount++;
            }

            $matrixRows[] = [
                'user' => $staff,
                'status' => $staffStatus,
                'has_escalated' => $hasEscalated,
            ];
        }

        $branchScore = $totalAssignedMandates > 0 
            ? round(($totalCompletedMandates / $totalAssignedMandates) * 100) 
            : 100;

        return [
            'branch' => $branchId ? Branch::find($branchId) : null,
            'total_staff' => $staffList->count(),
            'branch_compliance_score' => $branchScore,
            'total_overdue' => $totalOverdueMandates,
            'escalated_staff_count' => $escalatedCount,
            'matrix_rows' => $matrixRows,
        ];
    }

    /**
     * Escalate an overdue compliance enrollment to the Branch Manager.
     */
    public function escalateEnrollment(Enrollment $enrollment, ?User $escalatedBy = null, ?string $reason = null): BranchEscalation
    {
        $enrollment->update([
            'is_escalated' => true,
            'escalated_at' => now(),
        ]);

        $branchId = $enrollment->user?->branch_id;

        return BranchEscalation::create([
            'enrollment_id' => $enrollment->id,
            'user_id' => $enrollment->user_id,
            'course_id' => $enrollment->course_id,
            'branch_id' => $branchId,
            'escalated_by' => $escalatedBy?->id,
            'status' => 'pending',
            'urgency' => 'critical',
            'reason' => $reason ?? 'Automated Compliance Engine Escalation: BOT statutory deadline exceeded.',
        ]);
    }
}

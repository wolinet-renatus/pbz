<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchEscalation;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\ComplianceEngineService;
use Carbon\Carbon;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplianceController extends Controller
{
    public function __construct(
        protected ComplianceEngineService $complianceService
    ) {}

    /**
     * Display the Simplified, Uncluttered Automated Compliance Hub for Staff.
     */
    public function index()
    {
        $user = Auth::user();
        $user->load(['branch', 'department']);

        // Auto-enroll staff in any newly assigned mandatory courses
        $this->complianceService->autoEnrollStaff($user);

        $complianceData = $this->complianceService->getStaffComplianceStatus($user);

        // Fetch concise interactive microlearning scenario courses (lightweight)
        $microlearningCourses = Course::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_microlearning', true)
                    ->orWhere('estimated_minutes', '<=', 15);
            })
            ->take(3)
            ->get(['id', 'title', 'estimated_minutes', 'curriculum_type']);

        return view('student.compliance.index', [
            'user' => $user,
            'complianceData' => $complianceData,
            'microlearningCourses' => $microlearningCourses,
            'isBranchManager' => $user->isBranchManager() || $user->isAdmin(),
            'isAdmin' => $user->isAdmin(),
        ]);
    }

    /**
     * Branch Manager & Executive Compliance Oversight Matrix & Heatmap with CUD capabilities.
     */
    public function branchMatrix(Request $request)
    {
        $user = Auth::user();
        if (!$user->isBranchManager() && !$user->isAdmin()) {
            ToastMagic::error('Unauthorized. Only Branch Managers and Compliance Executives can access this oversight matrix.');
            return redirect()->route('student.compliance.index');
        }

        $branchId = $user->isAdmin() ? $request->get('branch_id', $user->branch_id) : $user->branch_id;
        $branches = Branch::where('is_active', true)->get();

        $matrixData = $this->complianceService->getBranchComplianceMatrix($branchId);

        // Fetch all published courses available for direct mandate assignment
        $availableCourses = Course::where('status', 'published')
            ->orderBy('title')
            ->get(['id', 'title', 'compliance_category', 'is_mandatory', 'validity_months']);

        // Fetch staff members in this branch scope for assignment
        $staffQuery = User::where('role', 'student');
        if ($branchId) {
            $staffQuery->where('branch_id', $branchId);
        }
        $availableStaff = $staffQuery->orderBy('name')->get(['id', 'name', 'email', 'branch_id', 'job_title', 'employee_id']);

        return view('student.compliance.branch-matrix', [
            'user' => $user,
            'matrixData' => $matrixData,
            'branches' => $branches,
            'selectedBranchId' => $branchId,
            'availableCourses' => $availableCourses,
            'availableStaff' => $availableStaff,
            'isAdmin' => $user->isAdmin(),
            'isBranchManager' => $user->isBranchManager(),
        ]);
    }

    /**
     * [CREATE] Direct Assign Compliance Mandate to a specific staff member or entire branch.
     */
    public function assignMandate(Request $request)
    {
        $user = Auth::user();
        if (!$user->isBranchManager() && !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized operation.'], 403);
        }

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'user_id' => 'required',
            'custom_due_date' => 'nullable|date',
            'days_allowed' => 'nullable|integer|min:1|max:365',
        ]);

        $course = Course::findOrFail($request->course_id);

        if ($request->filled('custom_due_date')) {
            $dueDate = Carbon::parse($request->custom_due_date)->endOfDay();
        } elseif ($request->filled('days_allowed')) {
            $dueDate = now()->addDays((int) $request->days_allowed)->endOfDay();
        } else {
            $dueDate = now()->addDays(30)->endOfDay();
        }

        $assignedCount = 0;

        if ($request->user_id === 'all_branch') {
            $branchId = $user->isAdmin() ? $request->input('branch_id', $user->branch_id) : $user->branch_id;
            $staffQuery = User::where('role', 'student');
            if ($branchId) {
                $staffQuery->where('branch_id', $branchId);
            }
            $targetUsers = $staffQuery->get();
        } else {
            $targetUsers = User::whereIn('id', (array) $request->user_id)->get();
        }

        foreach ($targetUsers as $targetUser) {
            $enrollment = Enrollment::where('user_id', $targetUser->id)
                ->where('course_id', $course->id)
                ->first();

            if ($enrollment) {
                $enrollment->update([
                    'status' => Enrollment::STATUS_APPROVED,
                    'due_date' => $dueDate,
                    'is_escalated' => false,
                ]);
            } else {
                Enrollment::create([
                    'user_id' => $targetUser->id,
                    'course_id' => $course->id,
                    'status' => Enrollment::STATUS_APPROVED,
                    'enrolled_at' => now(),
                    'due_date' => $dueDate,
                    'expires_at' => now()->addMonths($course->validity_months ?: 12),
                    'is_escalated' => false,
                ]);
            }
            $assignedCount++;
        }

        ToastMagic::success("Mandate '{$course->title}' successfully assigned to {$assignedCount} staff member(s). Deadline: " . $dueDate->format('M d, Y'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Mandate assigned to {$assignedCount} staff member(s).",
            ]);
        }

        return redirect()->back();
    }

    /**
     * [UPDATE] Extend statutory compliance deadline for a staff enrollment.
     */
    public function extendDeadline(Request $request, $enrollmentId)
    {
        $user = Auth::user();
        if (!$user->isBranchManager() && !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized operation.'], 403);
        }

        $enrollment = Enrollment::with(['user', 'course'])->findOrFail($enrollmentId);

        if ($request->filled('new_due_date')) {
            $newDueDate = Carbon::parse($request->input('new_due_date'))->endOfDay();
        } else {
            $days = (int) $request->input('days', 14);
            $base = ($enrollment->due_date && $enrollment->due_date->isFuture()) ? $enrollment->due_date : now();
            $newDueDate = $base->copy()->addDays($days)->endOfDay();
        }

        $enrollment->update([
            'due_date' => $newDueDate,
            'is_escalated' => false,
        ]);

        // If there were pending escalations, mark them as resolved by extension
        BranchEscalation::where('enrollment_id', $enrollment->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'resolved',
                'resolved_at' => now(),
                'reason' => 'Statutory deadline extended by administrator.',
            ]);

        ToastMagic::success("Statutory deadline extended for {$enrollment->user->name} to " . $newDueDate->format('M d, Y'));

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Deadline extended successfully.',
                'new_due_date' => $newDueDate->format('M d, Y'),
            ]);
        }

        return redirect()->back();
    }

    /**
     * [UPDATE] Certified manual compliance override (e.g., external seminar / auditor waiver).
     */
    public function verifyCompliance(Request $request, $enrollmentId)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isBranchManager()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized operation.'], 403);
        }

        $enrollment = Enrollment::with(['user', 'course'])->findOrFail($enrollmentId);

        $enrollment->update([
            'status' => Enrollment::STATUS_COMPLETED,
            'completed_at' => now(),
            'is_escalated' => false,
        ]);

        BranchEscalation::where('enrollment_id', $enrollment->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);

        ToastMagic::success("Compliance certified & marked COMPLIANT for {$enrollment->user->name} on '{$enrollment->course->title}'.");

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Compliance certified & completed.',
            ]);
        }

        return redirect()->back();
    }

    /**
     * [DELETE] Revoke or unassign a compliance mandate from a staff member.
     */
    public function revokeMandate(Request $request, $enrollmentId)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Only PBZ Compliance Executives & Administrators can revoke statutory mandates.'], 403);
        }

        $enrollment = Enrollment::with(['user', 'course'])->findOrFail($enrollmentId);
        $staffName = $enrollment->user->name;
        $courseTitle = $enrollment->course->title;

        // Clean up any related branch escalations
        BranchEscalation::where('enrollment_id', $enrollment->id)->delete();
        $enrollment->delete();

        ToastMagic::info("Mandate '{$courseTitle}' unassigned from {$staffName}.");

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mandate successfully revoked.',
            ]);
        }

        return redirect()->back();
    }

    /**
     * [DELETE/RESOLVE] Dismiss or resolve an active escalation alert.
     */
    public function resolveEscalation(Request $request, $enrollmentId)
    {
        $user = Auth::user();
        if (!$user->isBranchManager() && !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized operation.'], 403);
        }

        $enrollment = Enrollment::with(['user', 'course'])->findOrFail($enrollmentId);
        $enrollment->update([
            'is_escalated' => false,
        ]);

        BranchEscalation::where('enrollment_id', $enrollment->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);

        ToastMagic::success("Escalation alert cleared for {$enrollment->user->name}.");

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Escalation cleared.',
            ]);
        }

        return redirect()->back();
    }

    /**
     * Escalate an overdue compliance enrollment to the staff member & branch records.
     */
    public function escalate(Request $request, $enrollmentId)
    {
        $user = Auth::user();
        if (!$user->isBranchManager() && !$user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized operation.'], 403);
        }

        $enrollment = Enrollment::with('user', 'course')->findOrFail($enrollmentId);

        $escalation = $this->complianceService->escalateEnrollment(
            $enrollment,
            $user,
            $request->input('reason', 'Branch Manager Escalation: Regulatory BOT compliance deadline exceeded.')
        );

        ToastMagic::warning("Compliance escalation issued for {$enrollment->user->name} on '{$enrollment->course->title}'.");

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Escalation successfully logged and dispatched.',
                'escalation' => $escalation,
            ]);
        }

        return redirect()->back();
    }
}

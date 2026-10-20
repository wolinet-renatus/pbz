<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PbzCorporateAcademySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Branches
        $branches = [
            ['name' => 'Forodhani Main Branch', 'code' => 'PBZ-B01', 'region' => 'Unguja', 'address' => 'Mizingani Rd, Stone Town, Zanzibar'],
            ['name' => 'Mwanakwerekwe Branch', 'code' => 'PBZ-B02', 'region' => 'Unguja', 'address' => 'Mwanakwerekwe Commercial Center, Unguja'],
            ['name' => 'Malindi Port Branch', 'code' => 'PBZ-B03', 'region' => 'Unguja', 'address' => 'Port Authority Bldg, Malindi, Zanzibar'],
            ['name' => 'Chake Chake Branch', 'code' => 'PBZ-B04', 'region' => 'Pemba', 'address' => 'Main Commercial St, Chake Chake, Pemba'],
            ['name' => 'Wete Branch', 'code' => 'PBZ-B05', 'region' => 'Pemba', 'address' => 'Government Rd, Wete, Pemba'],
            ['name' => 'Kariakoo Branch', 'code' => 'PBZ-B06', 'region' => 'Mainland', 'address' => 'Uhuru / Msimbazi St, Dar es Salaam'],
            ['name' => 'Victoria Branch', 'code' => 'PBZ-B07', 'region' => 'Mainland', 'address' => 'Bagamoyo Rd, Victoria, Dar es Salaam'],
        ];

        $branchModels = [];
        foreach ($branches as $b) {
            $branchModels[$b['code']] = Branch::updateOrCreate(
                ['code' => $b['code']],
                $b
            );
        }

        // 2. Seed Departments
        $departments = [
            ['name' => 'Retail & Frontline Banking', 'code' => 'RET', 'description' => 'Tellers, customer service, and branch operations'],
            ['name' => 'PBZ Islamic Banking (Amana)', 'code' => 'ISL', 'description' => 'Shariah-compliant financing, Murabaha, and Amana deposit operations'],
            ['name' => 'AML, CFT & Regulatory Compliance', 'code' => 'CMP', 'description' => 'Bank of Tanzania (BOT) statutory monitoring and sanctions screening'],
            ['name' => 'Credit Risk & Lending', 'code' => 'RSK', 'description' => 'Underwriting, asset quality, and collateral valuation'],
            ['name' => 'ICT & Cyber Threat Defense', 'code' => 'ICT', 'description' => 'Core banking system security and infosec hygiene'],
            ['name' => 'Treasury & International Trade', 'code' => 'TRS', 'description' => 'FX liquidity, correspondent banking, and trade finance'],
        ];

        $deptModels = [];
        foreach ($departments as $d) {
            $deptModels[$d['code']] = Department::updateOrCreate(
                ['code' => $d['code']],
                $d
            );
        }

        $forodhaniBranch = $branchModels['PBZ-B01'];
        $pembaBranch = $branchModels['PBZ-B04'];

        // 3. Seed / Update Official Institutional Banking Accounts

        // A. Branch Operations Manager: manager.forodhani@pbzbank.co.tz (and student@pbzbank.co.tz)
        $managerUser = User::updateOrCreate(
            ['email' => 'manager.forodhani@pbzbank.co.tz'],
            [
                'name' => 'Fadhila Abdalla Haji',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'employee_id' => 'PBZ-01048',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['RET']->id,
                'job_title' => 'Branch Operations Manager',
                'is_branch_manager' => true,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]
        );
        $forodhaniBranch->update(['manager_id' => $managerUser->id]);

        $studentAlias = User::where('email', 'student@pbzbank.co.tz')->first();
        if ($studentAlias) {
            $studentAlias->update([
                'name' => 'Fadhila Abdalla Haji',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'employee_id' => 'PBZ-01048',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['RET']->id,
                'job_title' => 'Branch Operations Manager',
                'is_branch_manager' => true,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]);
        }

        // B. Senior Frontline Teller: renatus.bernardo@pbzbank.co.tz (and bernadorenatus39@gmail.com)
        $tellerUser = User::updateOrCreate(
            ['email' => 'renatus.bernardo@pbzbank.co.tz'],
            [
                'name' => 'Renatus Bernardo',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'employee_id' => 'PBZ-01824',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['RET']->id,
                'job_title' => 'Senior Teller & Frontline KYC Officer',
                'is_branch_manager' => false,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]
        );

        $renatusAlias = User::where('email', 'bernadorenatus39@gmail.com')->first();
        if ($renatusAlias) {
            $renatusAlias->update([
                'name' => 'Renatus Bernardo',
                'password' => Hash::make('password123'),
                'employee_id' => 'PBZ-01824',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['RET']->id,
                'job_title' => 'Senior Teller & Frontline KYC Officer',
                'is_branch_manager' => false,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]);
        }

        // C. Compliance Faculty & Instructor: compliance@pbzbank.co.tz (and instructor@pbzbank.co.tz)
        $complianceFaculty = User::updateOrCreate(
            ['email' => 'compliance@pbzbank.co.tz'],
            [
                'name' => 'Dr. Amina Khamis Salim',
                'password' => Hash::make('password123'),
                'role' => 'instructor',
                'employee_id' => 'PBZ-00312',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['CMP']->id,
                'job_title' => 'Head of AML & Regulatory Compliance',
                'is_branch_manager' => false,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]
        );
        $instructorAlias = User::where('email', 'instructor@pbzbank.co.tz')->first();
        if ($instructorAlias) {
            $instructorAlias->update([
                'name' => 'Dr. Amina Khamis Salim',
                'password' => Hash::make('password123'),
                'employee_id' => 'PBZ-00312',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['CMP']->id,
                'job_title' => 'Head of AML & Regulatory Compliance',
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]);
        }

        // D. Executive Admin: admin@pbzbank.co.tz (and admin@pbz.cm)
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@pbzbank.co.tz'],
            [
                'name' => 'PBZ Executive Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'employee_id' => 'PBZ-00001',
                'job_title' => 'Chief Compliance Officer & System Admin',
                'is_branch_manager' => false,
                'is_approved' => 1,
                'email_verified_at' => now(),
            ]
        );
        $adminAlias = User::where('email', 'admin@pbz.cm')->first();
        if ($adminAlias) {
            $adminAlias->update([
                'name' => 'PBZ Executive Administrator',
                'password' => Hash::make('password123'),
                'employee_id' => 'PBZ-00001',
                'job_title' => 'Chief Compliance Officer & System Admin',
            ]);
        }

        // 4. Seed Additional Branch Staff for realistic supervisory matrix
        $additionalStaff = [
            [
                'name' => 'Khamis Juma Bakari',
                'email' => 'khamis.bakari@pbzbank.co.tz',
                'employee_id' => 'PBZ-02105',
                'job_title' => 'Teller Officer',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['RET']->id,
            ],
            [
                'name' => 'Fatma Said Ali',
                'email' => 'fatma.ali@pbzbank.co.tz',
                'employee_id' => 'PBZ-02319',
                'job_title' => 'Amana Islamic Finance Advisor',
                'branch_id' => $forodhaniBranch->id,
                'department_id' => $deptModels['ISL']->id,
            ],
            [
                'name' => 'Ali Mohamed Issa',
                'email' => 'ali.issa@pbzbank.co.tz',
                'employee_id' => 'PBZ-03042',
                'job_title' => 'Credit Appraisal Specialist',
                'branch_id' => $pembaBranch->id,
                'department_id' => $deptModels['RSK']->id,
            ],
        ];

        $staffModels = [$managerUser, $tellerUser];
        if ($renatusAlias) $staffModels[] = $renatusAlias;
        if ($studentAlias) $staffModels[] = $studentAlias;

        foreach ($additionalStaff as $s) {
            $user = User::updateOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'student',
                    'employee_id' => $s['employee_id'],
                    'job_title' => $s['job_title'],
                    'branch_id' => $s['branch_id'],
                    'department_id' => $s['department_id'],
                    'is_approved' => 1,
                ]
            );
            $staffModels[] = $user;
        }

        // 5. Update Existing Courses with Dual Curriculum & Compliance classifications
        $course1 = Course::find(1);
        if ($course1) {
            $course1->update([
                'curriculum_type' => 'conventional',
                'compliance_category' => 'aml_cft',
                'is_mandatory' => true,
                'validity_months' => 12,
                'estimated_minutes' => 15,
                'is_microlearning' => false,
            ]);
        }

        $course2 = Course::find(2);
        if ($course2) {
            $course2->update([
                'curriculum_type' => 'islamic_amana',
                'shariah_board_certified' => true,
                'compliance_category' => 'bot_mandate',
                'is_mandatory' => true,
                'validity_months' => 12,
                'estimated_minutes' => 20,
                'is_microlearning' => false,
            ]);
        }

        $course3 = Course::find(3);
        if ($course3) {
            $course3->update([
                'curriculum_type' => 'conventional',
                'compliance_category' => 'cyber_hygiene',
                'is_mandatory' => true,
                'validity_months' => 12,
                'estimated_minutes' => 10,
                'is_microlearning' => false,
            ]);
        }

        // 6. Create Microlearning Scenario Course (5–12 min between queues)
        $microCourse = Course::updateOrCreate(
            ['title' => 'Island Branch Cash Smurfing & Sanctions Screening Challenge'],
            [
                'instructor_id' => 2, // Dr. Amina
                'description' => 'Interactive 8-minute scenario challenge testing rapid identification of structured cash smurfing across Unguja and Pemba branches.',
                'pricing_model' => 'free',
                'curriculum_type' => 'conventional',
                'compliance_category' => 'aml_cft',
                'is_mandatory' => true,
                'is_microlearning' => true,
                'estimated_minutes' => 8,
                'validity_months' => 6,
                'status' => 'published',
                'visibility' => 'public',
                'public_course' => true,
                'category' => 'Compliance',
            ]
        );

        // 7. Auto-Enroll Staff with Realistic Countdown Deadlines
        $allCourses = [$course1, $course2, $course3, $microCourse];

        foreach ($staffModels as $staff) {
            foreach ($allCourses as $idx => $course) {
                if (!$course) continue;

                // Alternate statuses for rich demo
                if (in_array($staff->email, ['renatus.bernardo@pbzbank.co.tz', 'bernadorenatus39@gmail.com'])) {
                    // Renatus has course 1 completed, course 2 in-progress with 14 days, course 3 with 5 days, microCourse overdue
                    $completed = ($idx === 0);
                    $dueDate = match($idx) {
                        0 => now()->subDays(10),
                        1 => now()->addDays(14),
                        2 => now()->addDays(5),
                        default => now()->subDays(2), // overdue
                    };

                    $enrollment = Enrollment::updateOrCreate(
                        ['user_id' => $staff->id, 'course_id' => $course->id],
                        [
                            'status' => $completed ? Enrollment::STATUS_COMPLETED : Enrollment::STATUS_APPROVED,
                            'enrolled_at' => now()->subDays(20),
                            'due_date' => $dueDate,
                            'completed_at' => $completed ? now()->subDays(10) : null,
                            'is_escalated' => ($idx === 3),
                            'escalated_at' => ($idx === 3) ? now()->subDay() : null,
                        ]
                    );

                    // Create branch escalation record for the overdue course (course 3)
                    if ($idx === 3 && $staff->email === 'renatus.bernardo@pbzbank.co.tz') {
                        \App\Models\BranchEscalation::updateOrCreate(
                            ['enrollment_id' => $enrollment->id],
                            [
                                'user_id' => $staff->id,
                                'course_id' => $course->id,
                                'branch_id' => $staff->branch_id ?? $forodhaniBranch->id,
                                'status' => 'pending',
                                'urgency' => 'critical',
                                'reason' => 'Mandatory BOT island branch cash smurfing compliance overdue by 2 days.',
                            ]
                        );
                    }
                } else {
                    $completed = ($idx % 2 === 0);
                    Enrollment::updateOrCreate(
                        ['user_id' => $staff->id, 'course_id' => $course->id],
                        [
                            'status' => $completed ? Enrollment::STATUS_COMPLETED : Enrollment::STATUS_APPROVED,
                            'enrolled_at' => now()->subDays(15),
                            'due_date' => now()->addDays(10 + ($idx * 5)),
                            'completed_at' => $completed ? now()->subDays(5) : null,
                        ]
                    );
                }
            }
        }
    }
}

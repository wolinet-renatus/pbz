<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Branches table
        if (!Schema::hasTable('branches')) {
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->string('region')->default('Unguja'); // Unguja, Pemba, Mainland
                $table->string('address')->nullable();
                $table->unsignedBigInteger('manager_id')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Departments table
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 3. User table enhancements for PBZ Staff
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->string('employee_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('branch_id');
            }
            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title')->nullable()->after('department_id');
            }
            if (!Schema::hasColumn('users', 'is_branch_manager')) {
                $table->boolean('is_branch_manager')->default(false)->after('job_title');
            }
        });

        // 4. Course table enhancements for Dual Curriculum & Compliance
        Schema::table('courses', function (Blueprint $table) {
            if (!Schema::hasColumn('courses', 'curriculum_type')) {
                $table->string('curriculum_type')->default('conventional')->after('pricing_model'); // conventional, islamic_amana, general_banking
            }
            if (!Schema::hasColumn('courses', 'shariah_board_certified')) {
                $table->boolean('shariah_board_certified')->default(false)->after('curriculum_type');
            }
            if (!Schema::hasColumn('courses', 'compliance_category')) {
                $table->string('compliance_category')->nullable()->after('shariah_board_certified'); // bot_mandate, aml_cft, kyc, cyber_hygiene, operational_risk
            }
            if (!Schema::hasColumn('courses', 'is_mandatory')) {
                $table->boolean('is_mandatory')->default(false)->after('compliance_category');
            }
            if (!Schema::hasColumn('courses', 'validity_months')) {
                $table->integer('validity_months')->default(12)->after('is_mandatory');
            }
            if (!Schema::hasColumn('courses', 'estimated_minutes')) {
                $table->integer('estimated_minutes')->default(10)->after('validity_months');
            }
            if (!Schema::hasColumn('courses', 'is_microlearning')) {
                $table->boolean('is_microlearning')->default(false)->after('estimated_minutes');
            }
            if (!Schema::hasColumn('courses', 'target_roles')) {
                $table->text('target_roles')->nullable()->after('is_microlearning');
            }
        });

        // 5. Enrollments table enhancements for automated compliance tracking
        Schema::table('enrollments', function (Blueprint $table) {
            if (!Schema::hasColumn('enrollments', 'due_date')) {
                $table->timestamp('due_date')->nullable()->after('enrolled_at');
            }
            if (!Schema::hasColumn('enrollments', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('due_date');
            }
            if (!Schema::hasColumn('enrollments', 'expires_at')) {
                $table->timestamp('expires_at')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('enrollments', 'is_escalated')) {
                $table->boolean('is_escalated')->default(false)->after('expires_at');
            }
            if (!Schema::hasColumn('enrollments', 'escalated_at')) {
                $table->timestamp('escalated_at')->nullable()->after('is_escalated');
            }
        });

        // 6. Branch Compliance Escalations table
        if (!Schema::hasTable('branch_escalations')) {
            Schema::create('branch_escalations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('enrollment_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('course_id');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->unsignedBigInteger('escalated_by')->nullable();
                $table->string('status')->default('pending'); // pending, acknowledged, resolved
                $table->string('urgency')->default('high'); // normal, high, critical
                $table->text('reason')->nullable();
                $table->timestamp('resolved_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_escalations');

        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'completed_at', 'expires_at', 'is_escalated', 'escalated_at']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'curriculum_type',
                'shariah_board_certified',
                'compliance_category',
                'is_mandatory',
                'validity_months',
                'estimated_minutes',
                'is_microlearning',
                'target_roles',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'branch_id', 'department_id', 'job_title', 'is_branch_manager']);
        });

        Schema::dropIfExists('departments');
        Schema::dropIfExists('branches');
    }
};

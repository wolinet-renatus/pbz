<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // Official PBZ Banking Accounts
            [
                'email' => 'admin@pbzbank.co.tz',
                'name' => 'PBZ Executive Administrator',
                'email_verified_at' => now(),
                'role' => 'admin',
                'password' => 'password123',
                'is_approved' => true,
                'spatie_role' => 'admin',
                'meta' => [
                    'employee_id' => 'PBZ-00001',
                    'job_title' => 'Chief Compliance Officer & System Admin',
                ],
            ],
            [
                'email' => 'compliance@pbzbank.co.tz',
                'name' => 'Dr. Amina Khamis Salim',
                'email_verified_at' => now(),
                'role' => 'instructor',
                'password' => 'password123',
                'is_approved' => true,
                'spatie_role' => 'instructor',
                'meta' => [
                    'employee_id' => 'PBZ-00312',
                    'job_title' => 'Head of AML & Regulatory Compliance',
                    'bio' => 'Senior Bank of Tanzania (BOT) Compliance Faculty and Bank Examiner.',
                ],
            ],
            [
                'email' => 'manager.forodhani@pbzbank.co.tz',
                'name' => 'Fadhila Abdalla Haji',
                'email_verified_at' => now(),
                'role' => 'student',
                'password' => 'password123',
                'is_approved' => true,
                'spatie_role' => 'student',
                'meta' => [
                    'employee_id' => 'PBZ-01048',
                    'job_title' => 'Branch Operations Manager',
                    'is_branch_manager' => true,
                ],
            ],
            [
                'email' => 'renatus.bernardo@pbzbank.co.tz',
                'name' => 'Renatus Bernardo',
                'email_verified_at' => now(),
                'role' => 'student',
                'password' => 'password123',
                'is_approved' => true,
                'spatie_role' => 'student',
                'meta' => [
                    'employee_id' => 'PBZ-01824',
                    'job_title' => 'Senior Teller & Frontline KYC Officer',
                ],
            ],
            // Legacy / Fallback EduEx accounts
            [
                'email' => 'admin@eduex.com',
                'name' => 'Admin User',
                'email_verified_at' => now(),
                'role' => 'admin',
                'password' => 'password',
                'is_approved' => true,
                'spatie_role' => 'admin',
                'meta' => [],
            ],
            [
                'email' => 'instructor@eduex.com',
                'name' => 'Demo Instructor',
                'email_verified_at' => now(),
                'role' => 'instructor',
                'password' => 'password',
                'is_approved' => true,
                'spatie_role' => 'instructor',
                'meta' => [
                    'bio' => 'Passionate instructor ready to share knowledge.',
                ],
            ],
            [
                'email' => 'student@eduex.com',
                'name' => 'Demo Student',
                'email_verified_at' => now(),
                'role' => 'student',
                'password' => 'password',
                'is_approved' => true,
                'spatie_role' => 'student',
                'meta' => [],
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::updateOrCreate(
                Arr::only($account, ['email']),
                [
                    'name' => $account['name'],
                    'password' => Hash::make($account['password']),
                    'role' => $account['role'],
                    'is_approved' => $account['is_approved'],
                    'email_verified_at' => $account['email_verified_at'],
                    ...$account['meta'],
                ]
            );

            $spatieRole = Role::where('name', $account['spatie_role'])->first();
            if ($spatieRole) {
                $user->syncRoles([$spatieRole->name]);
            }

            $this->command->info(sprintf(
                '%s user ensured: %s / %s',
                ucfirst($account['role']),
                $account['email'],
                $account['password']
            ));
        }
    }
}


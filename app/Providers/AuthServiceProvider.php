<?php

namespace App\Providers;

use App\Models\Event;
use App\Policies\EventPolicy;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * Auth Service Provider
 *
 * This service provider registers the authentication policies and RBAC Gates.
 *
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // 1. Granular Gates for Instructor CUD operations (Indirection layer)
        Gate::define('instructor:create', function (User $user) {
            return $user->hasPermissionTo('instructor:create') || $user->hasRole('admin');
        });

        Gate::define('instructor:update', function (User $user, ?User $instructor = null) {
            return $user->hasPermissionTo('instructor:update') || $user->hasRole('admin');
        });

        Gate::define('instructor:delete', function (User $user, ?User $instructor = null) {
            if ($instructor && (int)$user->id === (int)$instructor->id) {
                return false;
            }
            return $user->hasPermissionTo('instructor:delete') || $user->hasRole('admin');
        });

        // 2. Granular Gates for Student (Bank Trainee) CUD operations
        Gate::define('student:create', function (User $user) {
            return $user->hasPermissionTo('student:create') || $user->hasRole('admin');
        });

        Gate::define('student:update', function (User $user, ?User $student = null) {
            return $user->hasPermissionTo('student:update') || $user->hasRole('admin');
        });

        Gate::define('student:delete', function (User $user, ?User $student = null) {
            if ($student && (int)$user->id === (int)$student->id) {
                return false;
            }
            return $user->hasPermissionTo('student:delete') || $user->hasRole('admin');
        });

        // 3. Prepend security policy interceptor to Gate beforeCallbacks.
        // This guarantees self-deletion attempts are explicitly blocked before package-level permission checks.
        $interceptor = function (User $user, string $ability, array $args = []) {
            $target = $args[0] ?? null;
            if (in_array($ability, ['instructor:delete', 'student:delete']) && $target instanceof User && (int)$user->id === (int)$target->id) {
                return false; // Absolute veto on self-deletion
            }
            try {
                if ($user->role === 'admin' || $user->hasRole('admin') || ($ability !== 'manage-all' && $user->hasPermissionTo('manage-all'))) {
                    return true;
                }
            } catch (\Throwable $e) {
                if ($user->role === 'admin') {
                    return true;
                }
            }
        };

        try {
            $gate = app(\Illuminate\Contracts\Auth\Access\Gate::class);
            $reflection = new \ReflectionProperty($gate, 'beforeCallbacks');
            $reflection->setAccessible(true);
            $callbacks = $reflection->getValue($gate);
            array_unshift($callbacks, $interceptor);
            $reflection->setValue($gate, $callbacks);
        } catch (\Throwable $e) {
            Gate::before($interceptor);
        }
    }
}

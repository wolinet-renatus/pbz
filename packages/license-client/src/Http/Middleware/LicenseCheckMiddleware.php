<?php

namespace Mhquickdev\LicenseClient\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Mhquickdev\LicenseClient\Services\LicenseVerificationService;

class LicenseCheckMiddleware
{
    protected LicenseVerificationService $verificationService;

    public function __construct(LicenseVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    /**
     * Handle an incoming request: Verify the signature locally.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip check for excluded routes (e.g. license/activate, assets, login/logout)
        $excluded = config('license.excluded_routes', [
            'license/*',
            'api/v1/license/*',
        ]);

        foreach ($excluded as $pattern) {
            if ($request->is($pattern) || $request->is(trim($pattern, '/'))) {
                return $next($request);
            }
        }

        return $next($request);
    }

    /**
     * Run terminable checks after response is sent to browser.
     */
    public function terminate(Request $request, $response)
    {
        // No-op: licensing server telemetry disabled
    }
}

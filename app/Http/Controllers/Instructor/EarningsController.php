<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Earnings Controller
 *
 * Deprecated for PBZ Bank Corporate Academy.
 * All courses are internal and free of charge for bank personnel; monetization and withdrawals are disabled.
 *
 * @package App\Http\Controllers\Instructor
 */
class EarningsController extends Controller
{
    /**
     * Redirect legacy earnings route to instructor dashboard.
     */
    public function index(Request $request)
    {
        return redirect()->route('instructor.dashboard');
    }

    /**
     * Redirect legacy subscription sales route to instructor dashboard.
     */
    public function subscriptionSales(Request $request)
    {
        return redirect()->route('instructor.dashboard');
    }

    /**
     * Redirect legacy withdrawals route to instructor dashboard.
     */
    public function withdrawals(Request $request)
    {
        return redirect()->route('instructor.dashboard');
    }

    /**
     * Redirect legacy store withdrawal route to instructor dashboard.
     */
    public function storeWithdrawal(Request $request)
    {
        return redirect()->route('instructor.dashboard');
    }
}

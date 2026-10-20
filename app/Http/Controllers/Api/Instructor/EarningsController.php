<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * API Earnings Controller
 *
 * Deprecated for PBZ Bank Corporate Academy.
 *
 * @package App\Http\Controllers\Api\Instructor
 */
class EarningsController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Monetization and instructor earnings are disabled for PBZ internal corporate academy.',
        ], 200);
    }

    public function subscriptionSales(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Subscription sales are disabled for PBZ internal corporate academy.',
        ], 200);
    }

    public function withdrawals(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Withdrawals are disabled for PBZ internal corporate academy.',
        ], 200);
    }

    public function storeWithdrawal(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Withdrawals are disabled for PBZ internal corporate academy.',
        ], 400);
    }
}

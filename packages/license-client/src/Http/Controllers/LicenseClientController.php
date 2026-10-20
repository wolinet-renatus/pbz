<?php

namespace Mhquickdev\LicenseClient\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Mhquickdev\LicenseClient\Services\LicenseVerificationService;

class LicenseClientController extends Controller
{
    protected LicenseVerificationService $verificationService;

    public function __construct(LicenseVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    /**
     * Show the activation form page.
     */
    public function showActivationForm()
    {
        return redirect()->route('admin.dashboard')->with('success', 'System activated.');
    }

    /**
     * Handle the activation form submission.
     */
    public function activate(Request $request)
    {
        $request->validate([
            'purchase_code' => ['required', 'string', 'min:10', 'max:50'],
        ]);

        $purchaseCode = $request->input('purchase_code');
        $domain = $request->getHost();

        $result = $this->verificationService->activateProduct($purchaseCode, $domain);

        if (!$result['success']) {
            return back()->withInput()->withErrors([
                'purchase_code' => $result['message'],
            ]);
        }

        return redirect('/')->with('success', 'License activated successfully!');
    }
}

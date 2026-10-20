<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CertificateTemplateController extends Controller
{
    /**
     * Display a listing of certificate templates.
     */
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route('admin.certificates.index', ['tab' => 'templates']);
    }

    /**
     * Show the form/designer for creating a new certificate template.
     */
    public function create(): View
    {
        $template = new CertificateTemplate([
            'name' => 'PBZ Completion Certificate ' . date('Y'),
            'orientation' => 'landscape',
            'valid_for_months' => null,
            'canvas_width' => 842,
            'canvas_height' => 595,
            'is_default' => false,
            'is_active' => true,
            'elements' => CertificateTemplate::defaultPBZElements(),
        ]);

        return view('admin.certificates.templates.builder', [
            'template' => $template,
            'isEdit' => false,
            'initialElements' => CertificateTemplate::defaultPBZElements(),
        ]);
    }

    /**
     * Store a newly created certificate template in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'orientation' => 'required|in:landscape,portrait',
            'valid_for_months' => 'nullable|integer|min:1',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'elements_json' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'custom_css' => 'nullable|string',
            'custom_html' => 'nullable|string',
        ]);

        $elements = [];
        if (!empty($validated['elements_json'])) {
            $decoded = json_decode($validated['elements_json'], true);
            if (is_array($decoded)) {
                $elements = $decoded;
            }
        }

        if (empty($elements)) {
            $elements = CertificateTemplate::defaultPBZElements();
        }

        $backgroundPath = null;
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $fileName = 'bg_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/certificates'), $fileName);
            $backgroundPath = 'uploads/certificates/' . $fileName;
        }

        $isDefault = $request->boolean('is_default');
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : true;

        // If this is the only template, make it default automatically
        if (CertificateTemplate::count() === 0) {
            $isDefault = true;
        }

        $template = CertificateTemplate::create([
            'name' => $validated['name'],
            'orientation' => $validated['orientation'],
            'valid_for_months' => $validated['valid_for_months'] ?? null,
            'canvas_width' => $validated['orientation'] === 'landscape' ? 842 : 595,
            'canvas_height' => $validated['orientation'] === 'landscape' ? 595 : 842,
            'elements' => $elements,
            'background_image' => $backgroundPath,
            'custom_css' => $validated['custom_css'] ?? null,
            'custom_html' => $validated['custom_html'] ?? null,
            'is_default' => $isDefault,
            'is_active' => $isActive,
            'created_by' => auth()->id(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Certificate template created successfully.',
                'redirect' => route('admin.certificates.templates.edit', $template->id),
            ]);
        }

        return redirect()
            ->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template "' . $template->name . '" created successfully.');
    }

    /**
     * Show the form/designer for editing the specified certificate template.
     */
    public function edit(CertificateTemplate $template): View
    {
        $initialElements = $template->elements;
        if (empty($initialElements) || !is_array($initialElements)) {
            $initialElements = CertificateTemplate::defaultPBZElements();
        }

        return view('admin.certificates.templates.builder', [
            'template' => $template,
            'isEdit' => true,
            'initialElements' => $initialElements,
        ]);
    }

    /**
     * Update the specified certificate template in storage.
     */
    public function update(Request $request, CertificateTemplate $template): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'orientation' => 'required|in:landscape,portrait',
            'valid_for_months' => 'nullable|integer|min:1',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'elements_json' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'remove_background' => 'nullable|boolean',
            'custom_css' => 'nullable|string',
            'custom_html' => 'nullable|string',
        ]);

        $elements = $template->elements;
        if ($request->has('elements_json')) {
            $decoded = json_decode($request->input('elements_json'), true);
            if (is_array($decoded)) {
                $elements = $decoded;
            }
        }

        $backgroundPath = $template->background_image;
        if ($request->boolean('remove_background')) {
            if ($backgroundPath && File::exists(public_path($backgroundPath))) {
                File::delete(public_path($backgroundPath));
            }
            $backgroundPath = null;
        }

        if ($request->hasFile('background_image')) {
            if ($backgroundPath && File::exists(public_path($backgroundPath))) {
                File::delete(public_path($backgroundPath));
            }
            $file = $request->file('background_image');
            $fileName = 'bg_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/certificates'), $fileName);
            $backgroundPath = 'uploads/certificates/' . $fileName;
        }

        $isDefault = $request->boolean('is_default');
        $isActive = $request->has('is_active') ? $request->boolean('is_active') : true;

        $template->update([
            'name' => $validated['name'],
            'orientation' => $validated['orientation'],
            'valid_for_months' => $validated['valid_for_months'] ?? null,
            'canvas_width' => $validated['orientation'] === 'landscape' ? 842 : 595,
            'canvas_height' => $validated['orientation'] === 'landscape' ? 595 : 842,
            'elements' => $elements,
            'background_image' => $backgroundPath,
            'custom_css' => $validated['custom_css'] ?? null,
            'custom_html' => $validated['custom_html'] ?? null,
            'is_default' => $isDefault,
            'is_active' => $isActive,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Certificate template updated successfully.',
                'template' => $template,
            ]);
        }

        return redirect()
            ->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template "' . $template->name . '" updated successfully.');
    }

    /**
     * Remove the specified certificate template from storage.
     */
    public function destroy(CertificateTemplate $template): RedirectResponse
    {
        if ($template->is_default && CertificateTemplate::count() > 1) {
            $other = CertificateTemplate::where('id', '!=', $template->id)->first();
            if ($other) {
                $other->update(['is_default' => true]);
            }
        }

        if ($template->background_image && File::exists(public_path($template->background_image))) {
            File::delete(public_path($template->background_image));
        }

        $name = $template->name;
        $template->delete();

        return redirect()
            ->route('admin.certificates.templates.index')
            ->with('success', 'Certificate template "' . $name . '" deleted successfully.');
    }

    /**
     * Mark template as default.
     */
    public function setDefault(CertificateTemplate $template): RedirectResponse
    {
        CertificateTemplate::where('id', '!=', $template->id)->update(['is_default' => false]);
        $template->update(['is_default' => true, 'is_active' => true]);

        return redirect()
            ->back()
            ->with('success', 'Template "' . $template->name . '" is now the system default certificate.');
    }

    /**
     * Duplicate an existing certificate template.
     */
    public function duplicate(CertificateTemplate $template): RedirectResponse
    {
        $newTemplate = $template->replicate();
        $newTemplate->name = $template->name . ' (Copy)';
        $newTemplate->slug = Str::slug($newTemplate->name) . '-' . Str::random(5);
        $newTemplate->is_default = false;
        $newTemplate->issued_count = 0;
        $newTemplate->created_by = auth()->id();
        $newTemplate->save();

        return redirect()
            ->route('admin.certificates.templates.edit', $newTemplate->id)
            ->with('success', 'Template duplicated successfully. You can now customize it.');
    }

    /**
     * Live preview of template with sample or realistic data.
     */
    public function preview(CertificateTemplate $template, Request $request): View
    {
        $sampleData = [
            'student_name' => $request->query('student_name', 'Alice Johnson'),
            'course_title' => $request->query('course_title', 'AML / CFT & KYC Regulatory Certification (BOT Compliance 2026)'),
            'instructor_name' => $request->query('instructor_name', 'Mwanaidi Ali'),
            'completion_date' => $request->query('completion_date', now()->format('F d, Y')),
            'certificate_number' => $request->query('certificate_number', 'CERT-000108-PBZ966'),
            'verification_url' => route('verify-certificate', ['code' => 'CERT-000108-PBZ966']),
            'site_name' => "People's Bank of Zanzibar",
            'is_pdf' => false,
            'template' => $template,
        ];

        return view('admin.certificates.templates.preview_modal', $sampleData);
    }
}

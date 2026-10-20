<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateTemplate;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * Certificate Controller
 *
 * This controller handles the management of certificates and certificate templates.
 *
 * @package App\Http\Controllers\Admin
 */
class CertificateController extends Controller
{
    /**
     * Display certificates management and templates.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'templates');
        $search = trim((string) $request->query('search', ''));
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        // Certificate Templates
        $templates = CertificateTemplate::withCount('courses')
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $statisticsBase = Enrollment::completed();
        $totalIssuedCount = (clone $statisticsBase)->count();

        // Update default template issued count if not set
        foreach ($templates as $tmpl) {
            if ($tmpl->is_default && $tmpl->issued_count === 0 && $totalIssuedCount > 0) {
                $tmpl->issued_count = $totalIssuedCount;
                $tmpl->saveQuietly();
            }
        }

        $statistics = [
            'total' => $totalIssuedCount,
            'this_month' => (clone $statisticsBase)
                ->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'last_seven_days' => (clone $statisticsBase)
                ->where('updated_at', '>=', now()->subDays(7))
                ->count(),
            'total_templates' => $templates->count(),
            'active_templates' => $templates->where('is_active', true)->count(),
        ];

        $certificatesQuery = Enrollment::completed()
            ->with(['user', 'course.instructor'])
            ->orderByDesc('updated_at');

        if ($search !== '') {
            $certificatesQuery->where(function ($builder) use ($search) {
                $builder
                    ->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('course', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    })
                    ->orWhere('id', $search);
            });
        }

        if ($dateFrom) {
            $certificatesQuery->whereDate('updated_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $certificatesQuery->whereDate('updated_at', '<=', $dateTo);
        }

        $certificates = $certificatesQuery->paginate(20)->withQueryString();

        return view('admin.certificates.index', [
            'certificates' => $certificates,
            'templates' => $templates,
            'activeTab' => $activeTab,
            'statistics' => $statistics,
            'search' => $search,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Download a certificate
     *
     * @param \App\Models\Enrollment $enrollment
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function download(Enrollment $enrollment): Response|RedirectResponse
    {
        if (! $enrollment->isCompleted()) {
            return redirect()
                ->back()
                ->withErrors('Certificate can only be downloaded for completed enrollments.');
        }

        $enrollment->loadMissing(['user', 'course.instructor']);

        // Fetch custom certificate template or fallback to default
        $template = $enrollment->course?->certificateTemplate ?? CertificateTemplate::getDefault();

        $certificateData = [
            'student_name' => $enrollment->user?->name ?? 'Student',
            'course_title' => $enrollment->course?->title ?? 'Course',
            'instructor_name' => $enrollment->course?->instructor?->name ?? 'Instructor',
            'completion_date' => optional($enrollment->updated_at)->format('F d, Y'),
            'certificate_number' => $enrollment->certificate_number,
            'background_base64' => $this->certificateBackgroundBase64($template),
            'template' => $template,
            'is_pdf' => true,
        ];

        $orientation = $template?->orientation ?? 'landscape';

        $pdf = Pdf::loadView('student.certificate', $certificateData)
            ->setPaper('a4', $orientation)
            ->setOption('enable-local-file-access', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('enable_remote', true)
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0);

        $filename = 'certificate-' . Str::slug($certificateData['course_title']) . '-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Get the certificate background base64
     *
     * @param \App\Models\CertificateTemplate|null $template
     * @return string|null
     */
    private function certificateBackgroundBase64(?CertificateTemplate $template = null): ?string
    {
        if ($template && $template->background_image) {
            $customPath = public_path($template->background_image);
            if (file_exists($customPath)) {
                return base64_encode(file_get_contents($customPath));
            }
        }

        $defaultPath = public_path('assets/front/img/certificate.png');
        if (file_exists($defaultPath)) {
            return base64_encode(file_get_contents($defaultPath));
        }

        return null;
    }
}

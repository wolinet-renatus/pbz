<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseLanguage;
use App\Models\CourseTopic;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Quiz;
use App\Models\Review;
use App\Models\User;
use App\Services\FileUploadService;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Course Controller
 *
 * This controller handles the management of courses.
 *
 * @package App\Http\Controllers\Admin
 */
class CourseController extends Controller
{
    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {}
    /**
     * Display all courses
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $query = Course::with(['instructor', 'enrollments']);

        if (request()->has('search') && request()->search) {
            $search = request()->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if (request()->has('status') && request()->status) {
            if (request()->status === 'archived') {
                $query->where('status', 'archived');
            } else {
                $query->where('status', request()->status);
            }
        } else {
            $query->where('status', '!=', 'archived');
        }

        if (request()->has('visibility') && request()->visibility) {
            $query->where('visibility', request()->visibility);
        }

        if (request()->has('pricing_model') && request()->pricing_model) {
            $query->where('pricing_model', request()->pricing_model);
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $pendingCount = Course::where('status', 'pending')->count();

        return view('admin.courses.index', compact('courses', 'pendingCount'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        return view('admin.courses.create', $this->courseFormData());
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $payload = $this->buildCoursePayload($request);
        $course = Course::create($payload);

        ToastMagic::success("Course '{$course->title}' created successfully. You can now add topics and lessons.");
        return redirect()->route('admin.courses.edit', $course->id);
    }

    /**
     * Display pending courses for approval
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function pending()
    {
        return redirect()->route('admin.courses.index', ['status' => 'pending']);
    }

    /**
     * Show the form for editing the specified course and its curriculum.
     */
    public function edit($id)
    {
        $course = Course::with([
            'instructor',
            'topics' => fn ($q) => $q->orderBy('order'),
            'topics.lessons' => fn ($q) => $q->orderBy('order'),
            'topics.quizzes',
            'topics.assignments',
        ])->findOrFail($id);

        return view('admin.courses.edit', array_merge(
            ['course' => $course],
            $this->courseFormData()
        ));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $payload = $this->buildCoursePayload($request, $course);
        $course->update($payload);

        ToastMagic::success("Course '{$course->title}' updated successfully.");
        return redirect()->route('admin.courses.edit', $course->id);
    }

    /**
     * Restore an archived course back to draft or published.
     */
    public function restore($id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $course->status = 'draft';
        $course->deleted_date = null;
        $course->save();

        ToastMagic::success("Course '{$course->title}' has been restored to draft.");
        return back();
    }

    /**
     * Add a curriculum topic to a course.
     */
    public function storeTopic(Request $request, $id): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $nextOrder = $validated['order'] ?? (($course->topics()->max('order') ?? -1) + 1);
        $course->topics()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => (int) $nextOrder,
        ]);

        ToastMagic::success('Topic added to curriculum.');
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Update a curriculum topic.
     */
    public function updateTopic(Request $request, $id, $topicId): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $topic = CourseTopic::where('course_id', $course->id)->findOrFail($topicId);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $topic->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => (int) ($validated['order'] ?? $topic->order),
        ]);

        ToastMagic::success('Topic updated.');
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Delete a curriculum topic and its child lessons.
     */
    public function destroyTopic($id, $topicId): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $topic = CourseTopic::with('lessons')->where('course_id', $course->id)->findOrFail($topicId);

        DB::transaction(function () use ($topic) {
            foreach ($topic->lessons as $lesson) {
                $this->deleteLessonMediaAndRecord($lesson);
            }
            $topic->delete();
        });

        ToastMagic::success("Topic '{$topic->title}' deleted.");
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Add a lesson to a course topic.
     */
    public function storeLesson(Request $request, $id, $topicId): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $topic = CourseTopic::where('course_id', $course->id)->findOrFail($topicId);

        $payload = $this->buildLessonPayload($request, $topic);
        $topic->lessons()->create($payload);

        ToastMagic::success('Lesson added.');
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Update a lesson in a course topic.
     */
    public function updateLesson(Request $request, $id, $topicId, $lessonId): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $topic = CourseTopic::where('course_id', $course->id)->findOrFail($topicId);
        $lesson = Lesson::where('course_topic_id', $topic->id)->findOrFail($lessonId);

        $payload = $this->buildLessonPayload($request, $topic, $lesson);
        $lesson->update($payload);

        ToastMagic::success('Lesson updated.');
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Delete a lesson and its uploaded video if present.
     */
    public function destroyLesson($id, $topicId, $lessonId): RedirectResponse
    {
        $course = Course::findOrFail($id);
        $topic = CourseTopic::where('course_id', $course->id)->findOrFail($topicId);
        $lesson = Lesson::where('course_topic_id', $topic->id)->findOrFail($lessonId);

        $this->deleteLessonMediaAndRecord($lesson);

        ToastMagic::success("Lesson '{$lesson->title}' deleted.");
        return redirect()->route('admin.courses.edit', [$course->id, '#curriculum']);
    }

    /**
     * Approve a course
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $course = Course::findOrFail($id);

        $request = request();
        $reason = $request->input('reason', '');

        $course->status = 'published';
        $course->approval_reason = $reason;
        $course->rejection_reason = null;
        $course->save();

        $message = "Course '{$course->title}' has been approved and published successfully.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        ToastMagic::success($message);
        return back();
    }

    /**
     * Reject a course
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $course = Course::findOrFail($id);

        $request = request();
        $reason = $request->input('reason', '');

        $courseTitle = $course->title;
        $course->status = 'draft';
        $course->rejection_reason = $reason;
        $course->approval_reason = null;
        $course->save();

        $message = "Course '{$courseTitle}' has been rejected and set back to draft.";
        if ($reason) {
            $message .= " Reason: {$reason}";
        }

        ToastMagic::info($message);
        return back();
    }

    /**
     * Display course details
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $course = Course::with([
            'instructor',
            'topics.lessons',
            'topics.quizzes',
            'topics.assignments',
            'enrollments',
            'reviews.user',
            'reviews.replies.user'
        ])->findOrFail($id);

        $lessonCount = $course->topics->sum(function ($topic) {
            return $topic->lessons->count();
        });

        $quizCount = $course->topics->sum(function ($topic) {
            return $topic->quizzes->count();
        });

        $assignmentCount = $course->topics->sum(function ($topic) {
            return $topic->assignments->count();
        });

        $totalDuration = $course->topics->sum(function ($topic) {
            return $topic->lessons->sum(function ($lesson) {
                return $lesson->duration ?? 0;
            });
        });

        $reviews = $course->reviews;
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

        return view('admin.courses.show', compact(
            'course',
            'lessonCount',
            'quizCount',
            'assignmentCount',
            'totalDuration',
            'totalReviews',
            'averageRating'
        ));
    }

    /**
     * Update course status
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus($id)
    {
        $course = Course::findOrFail($id);
        $request = request();

        $newStatus = $request->input('status');
        $oldStatus = $course->status;

        $validStatuses = ['draft', 'pending', 'published', 'archived'];
        if (!in_array($newStatus, $validStatuses)) {
            ToastMagic::error('Invalid status selected.');
            return back();
        }

        $course->status = $newStatus;

        if ($newStatus === 'archived') {
            $course->deleted_date = now();
        } else {
            $course->deleted_date = null;
        }

        if ($newStatus !== 'published' && $oldStatus === 'pending') {
            $course->approval_reason = null;
        }
        if ($newStatus !== 'draft' && $oldStatus === 'pending') {
            $course->rejection_reason = null;
        }

        $course->save();

        $statusLabels = [
            'draft' => 'Draft',
            'pending' => 'Pending',
            'published' => 'Published',
            'archived' => 'Archived'
        ];

        ToastMagic::success("Course '{$course->title}' status has been changed to {$statusLabels[$newStatus]}.");
        return back();
    }

    /**
     * Archive a course (soft delete)
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $courseTitle = $course->title;

        $course->status = 'archived';
        $course->deleted_date = now();
        $course->save();

        ToastMagic::success("Course '{$courseTitle}' has been archived successfully.");
        return back();
    }
    /**
     * Permanently delete a course and all related data (3-step confirmation)
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fullDelete($id)
    {
        $course = Course::with(['topics.lessons', 'topics.quizzes.questions', 'topics.assignments.files', 'enrollments.payment', 'reviews'])->findOrFail($id);
        $courseTitle = $course->title;

        try {
            DB::beginTransaction();

            // 1. Delete associated media files for the course
            if ($course->featured_image) {
                Storage::disk('public')->delete($course->featured_image);
            }
            if ($course->intro_video) {
                Storage::disk('public')->delete($course->intro_video);
            }

            // 2. Cascade delete topics, lessons, quizzes, assignments
            foreach ($course->topics as $topic) {
                // Delete lessons and their videos
                foreach ($topic->lessons as $lesson) {
                    if ($lesson->video_path) {
                        Storage::disk('public')->delete($lesson->video_path);
                    }
                    $lesson->progress()->delete();
                    $lesson->delete();
                }

                // Delete quizzes, questions, and attempts
                foreach ($topic->quizzes as $quiz) {
                    foreach ($quiz->questions as $question) {
                        $question->delete();
                    }
                    
                    foreach ($quiz->attempts as $attempt) {
                        $attempt->answers()->delete();
                        $attempt->delete();
                    }
                    $quiz->delete();
                }

                // Delete assignments, files, and submissions
                foreach ($topic->assignments as $assignment) {
                    foreach ($assignment->files as $file) {
                        if ($file->file_path) {
                            Storage::disk('public')->delete($file->file_path);
                        }
                        $file->delete();
                    }
                    foreach ($assignment->submissions as $submission) {
                        // Delete submission files
                        foreach ($submission->files as $subFile) {
                            if ($subFile->file_path) {
                                Storage::disk('public')->delete($subFile->file_path);
                            }
                            $subFile->delete();
                        }
                        $submission->delete();
                    }
                    $assignment->delete();
                }

                $topic->delete();
            }

            // 3. Delete enrollments and their related data
            foreach ($course->enrollments as $enrollment) {
                if ($enrollment->payment && !$enrollment->payment->bundle_id) {
                    if ($enrollment->payment->receipt_file) {
                        Storage::disk('public')->delete($enrollment->payment->receipt_file);
                    }
                    $enrollment->payment->delete();
                }
                
                $enrollment->lessonProgress()->delete();
                $enrollment->quizAttempts()->delete();
                $enrollment->assignmentSubmissions()->delete();
                $enrollment->delete();
            }

            // 4. Delete reviews and replies
            foreach ($course->reviews as $review) {
                $review->replies()->delete();
                $review->delete();
            }

            // 5. Remove from bundles
            DB::table('bundle_courses')->where('course_id', $course->id)->delete();

            // 6. Finally delete the course record
            $course->delete();

            DB::commit();

            ToastMagic::success("Course '{$courseTitle}' and all its related data have been permanently deleted.");
            return redirect()->route('admin.courses.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Course Deletion Error: " . $e->getMessage());
            ToastMagic::error("An error occurred while deleting the course: " . $e->getMessage());
            return back();
        }
    }

    /**
     * Shared lookup options for create and edit course forms.
     */
    private function courseFormData(): array
    {
        return [
            'instructors' => User::whereIn('role', ['instructor', 'admin'])
                ->orderBy('name')
                ->get(['id', 'name', 'email', 'role']),
            'categories' => CourseCategory::where('is_active', true)
                ->orderBy('display_order')
                ->orderBy('name')
                ->get(['id', 'name']),
            'languages' => CourseLanguage::where('is_active', true)
                ->orderBy('display_order')
                ->orderBy('name')
                ->get(['id', 'name']),
        ];
    }

    /**
     * Validate and build the attribute payload for creating or updating a course.
     */
    private function buildCoursePayload(Request $request, ?Course $existing = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'instructor_id' => ['required', 'exists:users,id'],
            'course_category_id' => ['nullable', 'exists:course_categories,id'],
            'course_language_id' => ['nullable', 'exists:course_languages,id'],
            'difficulty' => ['required', Rule::in(['beginner', 'intermediate', 'advanced'])],
            'visibility' => ['required', Rule::in(['public', 'private', 'draft'])],
            'status' => ['required', Rule::in(['draft', 'pending', 'published', 'archived'])],
            'pricing_model' => ['required', Rule::in(['free', 'paid'])],
            'regular_price' => ['nullable', 'required_if:pricing_model,paid', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'curriculum_type' => ['required', Rule::in(['conventional', 'islamic_amana', 'general_banking'])],
            'compliance_category' => ['nullable', Rule::in(['bot_mandate', 'aml_cft', 'kyc', 'cyber_hygiene', 'operational_risk'])],
            'validity_months' => ['nullable', 'integer', 'min:1', 'max:120'],
            'estimated_minutes' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'schedule_date' => ['nullable', 'date'],
            'tags' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:5120'],
            'intro_video' => ['nullable', 'file', 'mimes:mp4,avi,mov,webm', 'max:512000'],
        ]);

        $category = !empty($validated['course_category_id'])
            ? CourseCategory::find($validated['course_category_id'])
            : null;
        $language = !empty($validated['course_language_id'])
            ? CourseLanguage::find($validated['course_language_id'])
            : null;

        $featuredImagePath = $existing?->featured_image;
        if ($request->boolean('remove_featured_image') && $featuredImagePath) {
            Storage::disk('public')->delete($featuredImagePath);
            $featuredImagePath = null;
        }
        if ($request->hasFile('featured_image')) {
            if ($featuredImagePath) {
                Storage::disk('public')->delete($featuredImagePath);
            }
            $featuredImagePath = $this->fileUploadService->uploadCourseImage($request->file('featured_image'));
        }

        $introVideoPath = $existing?->intro_video;
        if ($request->boolean('remove_intro_video') && $introVideoPath) {
            Storage::disk('public')->delete($introVideoPath);
            $introVideoPath = null;
        }
        if ($request->hasFile('intro_video')) {
            if ($introVideoPath) {
                Storage::disk('public')->delete($introVideoPath);
            }
            $introVideoPath = $this->fileUploadService->uploadIntroVideo($request->file('intro_video'));
        }

        $isPublicCourse = $request->boolean('public_course');
        $scheduleEnabled = $request->boolean('schedule_enabled');
        $isPaid = $validated['pricing_model'] === 'paid';

        return [
            'instructor_id' => (int) $validated['instructor_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'featured_image' => $featuredImagePath,
            'intro_video' => $introVideoPath,
            'visibility' => $validated['visibility'],
            'public_course' => $isPublicCourse,
            'max_students' => $isPublicCourse ? null : ($validated['max_students'] ?? null),
            'difficulty' => $validated['difficulty'],
            'pricing_model' => $validated['pricing_model'],
            'regular_price' => $isPaid ? ($validated['regular_price'] ?? 0) : 0,
            'sale_price' => $isPaid ? ($validated['sale_price'] ?? null) : null,
            'schedule_enabled' => $scheduleEnabled,
            'schedule_date' => $scheduleEnabled ? ($validated['schedule_date'] ?? null) : null,
            'course_category_id' => $category?->id,
            'course_language_id' => $language?->id,
            'category' => $category?->name ?? $existing?->category,
            'language' => $language?->name ?? $existing?->language,
            'tags' => $validated['tags'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'objectives' => $validated['objectives'] ?? null,
            'status' => $validated['status'],
            'deleted_date' => $validated['status'] === 'archived' ? ($existing?->deleted_date ?? now()) : null,
            'is_live_course' => $request->boolean('is_live_course'),
            'curriculum_type' => $validated['curriculum_type'],
            'shariah_board_certified' => $request->boolean('shariah_board_certified'),
            'compliance_category' => $validated['compliance_category'] ?? null,
            'is_mandatory' => $request->boolean('is_mandatory'),
            'validity_months' => (int) ($validated['validity_months'] ?? 12),
            'estimated_minutes' => (int) ($validated['estimated_minutes'] ?? 15),
            'is_microlearning' => $request->boolean('is_microlearning'),
        ];
    }

    /**
     * Validate and build the attribute payload for creating or updating a lesson.
     */
    private function buildLessonPayload(Request $request, CourseTopic $topic, ?Lesson $existing = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content_type' => ['required', Rule::in(['video', 'text'])],
            'video_type' => ['nullable', Rule::in(['url', 'upload'])],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,avi,mov,webm', 'max:512000'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
        ]);

        $videoType = $validated['content_type'] === 'video'
            ? ($validated['video_type'] ?? 'url')
            : null;
        $videoUrl = null;
        $videoPath = $existing?->video_path;

        if ($videoType === 'url') {
            $videoUrl = $validated['video_url'] ?? null;
            if ($videoPath) {
                Storage::disk('public')->delete($videoPath);
                $videoPath = null;
            }
        } elseif ($videoType === 'upload' && $request->hasFile('video_file')) {
            if ($videoPath) {
                Storage::disk('public')->delete($videoPath);
            }
            $videoPath = $this->fileUploadService->uploadLessonVideo($request->file('video_file'));
        } elseif ($validated['content_type'] === 'text' && $videoPath) {
            Storage::disk('public')->delete($videoPath);
            $videoPath = null;
        }

        return [
            'title' => $validated['title'],
            'content_type' => $validated['content_type'],
            'description' => $validated['description'] ?? null,
            'video_type' => $videoType,
            'video_url' => $videoUrl,
            'video_path' => $videoPath,
            'duration' => (int) ($validated['duration'] ?? 0),
            'is_preview' => $request->boolean('is_preview'),
            'order' => (int) ($validated['order'] ?? ($existing?->order ?? (($topic->lessons()->max('order') ?? -1) + 1))),
        ];
    }

    /**
     * Delete lesson media, progress records, and the lesson row itself.
     */
    private function deleteLessonMediaAndRecord(Lesson $lesson): void
    {
        if ($lesson->video_path) {
            Storage::disk('public')->delete($lesson->video_path);
        }
        $lesson->progress()->delete();
        $lesson->delete();
    }
}


@extends('layouts.admin')

@section('title', 'Edit Course')

@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></div>
        <div class="breadcrumb-item active">{{ Str::limit($course->title, 35) }}</div>
    </div>
@endsection

@section('main-content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
            <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if ($course->status === 'archived')
                <form action="{{ route('admin.courses.restore', $course->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-undo"></i> Restore Course
                    </button>
                </form>
            @else
                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Archive this course?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fas fa-archive"></i> Archive
                    </button>
                </form>
            @endif
            <form action="{{ route('admin.courses.full-delete', $course->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Permanently delete this course and all topics, lessons, and enrollments? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i> Delete Permanently
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.courses._form')

        <div class="text-right mb-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Save Course Changes
            </button>
        </div>
    </form>

    <!-- Curriculum (Topics & Lessons CUD) -->
    <div class="card" id="curriculum">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Course Curriculum (Topics &amp; Lessons)</h4>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTopicModal">
                <i class="fas fa-plus"></i> Add Topic
            </button>
        </div>
        <div class="card-body">
            @forelse ($course->topics as $topic)
                <div class="border rounded p-3 mb-3 bg-light">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <h6 class="mb-1 font-weight-bold">
                                <span class="badge badge-dark mr-1">#{{ $topic->order + 1 }}</span>
                                {{ $topic->title }}
                            </h6>
                            @if ($topic->description)
                                <p class="text-muted small mb-0">{{ $topic->description }}</p>
                            @endif
                        </div>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#addLessonModal-{{ $topic->id }}">
                                <i class="fas fa-plus"></i> Add Lesson
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#editTopicModal-{{ $topic->id }}">
                                <i class="fas fa-edit"></i> Edit Topic
                            </button>
                            <form action="{{ route('admin.courses.topics.destroy', [$course->id, $topic->id]) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Delete this topic and all its lessons?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if ($topic->lessons->isNotEmpty())
                        <div class="table-responsive bg-white rounded border mt-2">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">Order</th>
                                        <th>Lesson Title</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th>Preview</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topic->lessons as $lesson)
                                        <tr>
                                            <td>{{ $lesson->order + 1 }}</td>
                                            <td>
                                                <strong>{{ $lesson->title }}</strong>
                                                @if ($lesson->getRawOriginal('video_url'))
                                                    <div class="small text-muted text-truncate" style="max-width: 280px;">
                                                        {{ $lesson->getRawOriginal('video_url') }}
                                                    </div>
                                                @elseif ($lesson->video_path)
                                                    <div class="small text-info">Uploaded video</div>
                                                @endif
                                            </td>
                                            <td><span class="badge badge-secondary">{{ ucfirst($lesson->content_type ?? 'video') }}</span></td>
                                            <td>{{ $lesson->duration ? $lesson->duration . ' min' : '—' }}</td>
                                            <td>
                                                @if ($lesson->is_preview)
                                                    <span class="badge badge-success">Free Preview</span>
                                                @else
                                                    <span class="text-muted small">Enrolled</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-xs btn-primary" data-toggle="modal"
                                                    data-target="#editLessonModal-{{ $lesson->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.courses.lessons.destroy', [$course->id, $topic->id, $lesson->id]) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this lesson?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted small mb-0 mt-2">No lessons in this topic yet.</p>
                    @endif
                </div>
            @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-layer-group fa-2x mb-2"></i>
                    <p class="mb-2">No topics added yet. Click <strong>Add Topic</strong> to build the curriculum.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Add Topic Modal -->
    <div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.courses.topics.store', $course->id) }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Curriculum Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Topic Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g., Module 1: Regulatory Foundations">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" min="0" value="{{ $course->topics->count() }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Topic</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($course->topics as $topic)
        <!-- Edit Topic Modal -->
        <div class="modal fade" id="editTopicModal-{{ $topic->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.courses.topics.update', [$course->id, $topic->id]) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Topic Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required value="{{ $topic->title }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $topic->description }}</textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label>Order</label>
                            <input type="number" name="order" class="form-control" min="0" value="{{ $topic->order }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Topic</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Lesson Modal -->
        <div class="modal fade" id="addLessonModal-{{ $topic->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('admin.courses.lessons.store', [$course->id, $topic->id]) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Lesson to "{{ $topic->title }}"</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Lesson Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Content Type</label>
                                    <select name="content_type" class="form-control">
                                        <option value="video">Video Lesson</option>
                                        <option value="text">Text / Reading</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Video Source</label>
                                    <select name="video_type" class="form-control">
                                        <option value="url">External URL (YouTube/Vimeo)</option>
                                        <option value="upload">Upload Video File</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Video URL (if External URL)</label>
                                    <input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Video File (if Upload)</label>
                            <input type="file" name="video_file" class="form-control-file" accept="video/mp4,video/webm,video/quicktime">
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duration (minutes)</label>
                                    <input type="number" name="duration" class="form-control" min="0" value="10">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" name="order" class="form-control" min="0" value="{{ $topic->lessons->count() }}">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <div class="custom-control custom-checkbox mt-3">
                                    <input type="checkbox" class="custom-control-input" id="new_preview_{{ $topic->id }}" name="is_preview" value="1">
                                    <label class="custom-control-label" for="new_preview_{{ $topic->id }}">Free Preview</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label>Lesson Notes / Content</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Lesson</button>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($topic->lessons as $lesson)
            <!-- Edit Lesson Modal -->
            <div class="modal fade" id="editLessonModal-{{ $lesson->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('admin.courses.lessons.update', [$course->id, $topic->id, $lesson->id]) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Lesson</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Lesson Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required value="{{ $lesson->title }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Content Type</label>
                                        <select name="content_type" class="form-control">
                                            <option value="video" {{ ($lesson->content_type ?? 'video') === 'video' ? 'selected' : '' }}>Video Lesson</option>
                                            <option value="text" {{ $lesson->content_type === 'text' ? 'selected' : '' }}>Text / Reading</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Video Source</label>
                                        <select name="video_type" class="form-control">
                                            <option value="url" {{ ($lesson->video_type ?? 'url') !== 'upload' ? 'selected' : '' }}>External URL</option>
                                            <option value="upload" {{ $lesson->video_type === 'upload' ? 'selected' : '' }}>Upload Video File</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Video URL (if External URL)</label>
                                        <input type="text" name="video_url" class="form-control" value="{{ $lesson->getRawOriginal('video_url') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Replace Video File (if Upload)</label>
                                @if ($lesson->video_path)
                                    <div class="small text-info mb-1">Current file: {{ basename($lesson->video_path) }}</div>
                                @endif
                                <input type="file" name="video_file" class="form-control-file" accept="video/mp4,video/webm,video/quicktime">
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Duration (minutes)</label>
                                        <input type="number" name="duration" class="form-control" min="0" value="{{ $lesson->duration }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Order</label>
                                        <input type="number" name="order" class="form-control" min="0" value="{{ $lesson->order }}">
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <div class="custom-control custom-checkbox mt-3">
                                        <input type="checkbox" class="custom-control-input" id="edit_preview_{{ $lesson->id }}" name="is_preview" value="1"
                                            {{ $lesson->is_preview ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="edit_preview_{{ $lesson->id }}">Free Preview</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Lesson Notes / Content</label>
                                <textarea name="description" class="form-control" rows="3">{{ $lesson->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Lesson</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection

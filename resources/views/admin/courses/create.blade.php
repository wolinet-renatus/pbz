@extends('layouts.admin')

@section('title', 'Create Course')

@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></div>
        <div class="breadcrumb-item active">Create Course</div>
    </div>
@endsection

@section('main-content')
    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Course &amp; Continue to Curriculum
            </button>
        </div>

        @include('admin.courses._form')

        <div class="text-right mb-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Create Course
            </button>
        </div>
    </form>
@endsection

@extends('layouts.student')

@section('content')
<div class="pbz-saas-shell">
    <!-- Dark Persistent Sidebar -->
    @include('student.partials.sidebar')

    <!-- Main Content Canvas -->
    <div class="pbz-saas-main">
        <!-- Integrated Topbar -->
        @include('student.partials.topbar', ['pageTitle' => 'Community Discussions'])

        <!-- Content Area -->
        <div class="pbz-saas-content-area p-3 p-md-4">
            
            <!-- Page Header Card with Compact KPIs -->
            <div class="card border rounded-3 p-3.5 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="d-inline-flex align-items-center gap-1.5 px-2.5 py-0.5 rounded-pill mb-1.5" style="background: #e0f2fe; color: #0099cc; font-size: 11px; font-weight: 700;">
                            <i class="fa-solid fa-users-line"></i> PEER EXCHANGE &amp; FACULTY FORUM
                        </div>
                        <h3 class="fw-bold mb-0" style="font-size: 1.25rem; color: #0f172a;">Academic Community &amp; Knowledge Base</h3>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Engage with fellow bankers, exchange operational compliance insights, and consult certified instructors.</p>
                    </div>

                    <!-- Action Button & Mini Badges -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2 d-inline-flex align-items-center gap-1.5"
                                data-bs-toggle="modal" data-bs-target="#askQuestionModal"
                                style="background-color: #006837; border-color: #006837; font-size: 12px;">
                            <i class="fa-solid fa-plus"></i> {{ __('student.ask_question') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Compact Filter Toolbar & Realtime Search -->
            <div class="card border rounded-3 p-3 mb-3 bg-white shadow-none" style="border-color: #e2e8f0;">
                <div class="row g-2 align-items-center">
                    <!-- Status Filter Pills -->
                    <div class="col-md-7 col-12">
                        <div class="d-flex align-items-center gap-1.5 flex-wrap">
                            <a href="{{ route('student.community.index', ['filter' => 'all', 'search' => request('search')]) }}"
                               class="btn btn-sm {{ $filter == 'all' ? 'active' : '' }}"
                               style="font-size: 11.5px; border-radius: 20px; padding: 4px 14px; font-weight: 600; {{ $filter == 'all' ? 'background: #006837; color: #fff; border: 1px solid #006837;' : 'background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;' }}">
                                {{ __('student.all_questions') }}
                            </a>
                            <a href="{{ route('student.community.index', ['filter' => 'unanswered', 'search' => request('search')]) }}"
                               class="btn btn-sm {{ $filter == 'unanswered' ? 'active' : '' }}"
                               style="font-size: 11.5px; border-radius: 20px; padding: 4px 14px; font-weight: 600; {{ $filter == 'unanswered' ? 'background: #0099cc; color: #fff; border: 1px solid #0099cc;' : 'background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;' }}">
                                {{ __('student.unanswered') }}
                            </a>
                            <a href="{{ route('student.community.index', ['filter' => 'my_questions', 'search' => request('search')]) }}"
                               class="btn btn-sm {{ $filter == 'my_questions' ? 'active' : '' }}"
                               style="font-size: 11.5px; border-radius: 20px; padding: 4px 14px; font-weight: 600; {{ $filter == 'my_questions' ? 'background: #006837; color: #fff; border: 1px solid #006837;' : 'background: #f8fafc; color: #64748b; border: 1px solid #cbd5e1;' }}">
                                {{ __('student.my_questions') }}
                            </a>
                        </div>
                    </div>

                    <!-- Search Input -->
                    <div class="col-md-5 col-12">
                        <form action="{{ route('student.community.index') }}" method="GET">
                            <input type="hidden" name="filter" value="{{ $filter }}">
                            <div class="position-relative">
                                <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 12px;"></i>
                                <input type="search" name="search" class="form-control form-control-sm ps-5 rounded-2"
                                       placeholder="{{ __('student.search_discussions') }}" value="{{ request('search') }}"
                                       style="font-size: 12px; border-color: #cbd5e1; height: 34px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Questions List (Compact Mobile-First Native Cards) -->
            <div class="questions-container">
                @forelse($questions as $question)
                    @include('student.community.partials.question-card', ['question' => $question])
                @empty
                    <div class="card p-5 text-center rounded-3 bg-white border shadow-none" style="border-color: #e2e8f0;">
                        <div class="mx-auto mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #e0f2fe; color: #0099cc; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ __('student.no_questions_found') }}</h5>
                        <p class="text-muted mb-3" style="font-size: 12.5px;">{{ __('student.no_questions_desc') }}</p>
                        <div>
                            <button type="button" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-2"
                                    data-bs-toggle="modal" data-bs-target="#askQuestionModal"
                                    style="background-color: #006837; border-color: #006837; font-size: 12px;">
                                <i class="fa-solid fa-plus me-1"></i> {{ __('student.ask_question') }}
                            </button>
                        </div>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($questions->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $questions->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Portal Footer -->
            @include('student.partials.footer')

        </div>
    </div>
</div>

@include('student.community.partials.ask-question-modal')

<style>
    .pbz-community-card:hover {
        border-color: #0099cc !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
    }
    .pbz-question-link:hover {
        color: #0099cc !important;
    }
</style>
@endsection
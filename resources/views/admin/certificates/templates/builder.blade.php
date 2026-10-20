@extends('layouts.admin')

@section('title', $isEdit ? 'Edit Certificate Template' : 'New Certificate Template')

@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.certificates.index') }}">Certificate Templates</a></div>
        <div class="breadcrumb-item">{{ $isEdit ? 'Edit Template' : 'New Template' }}</div>
    </div>
@endsection

@section('main-content')
    <form id="templateForm" method="POST" action="{{ $isEdit ? route('admin.certificates.templates.update', $template->id) : route('admin.certificates.templates.store') }}" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif
        <input type="hidden" name="elements_json" id="elementsJsonInput" value="">

        <!-- Top Header & Actions -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <h4 class="mb-0 text-dark fw-bold" style="font-size: 19px;">
                    {{ $isEdit ? 'Edit certificate template' : 'New certificate template' }}
                </h4>
                <p class="text-muted small mb-0">Drag and drop elements to design official accredited certificates.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.certificates.index') }}" class="btn btn-sm btn-outline-secondary py-1.5 px-3 rounded-2 fw-semibold">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
                <button type="button" class="btn btn-sm btn-outline-info py-1.5 px-3 rounded-2 fw-semibold" onclick="triggerTestPreview()">
                    <i class="fas fa-eye me-1"></i> Live Preview
                </button>
                <button type="submit" class="btn btn-sm btn-primary py-1.5 px-3.5 rounded-2 fw-bold" style="background: #006837; border-color: #006837;">
                    <i class="fas fa-save me-1"></i> Save Template
                </button>
            </div>
        </div>

        <!-- Template Meta Card (Top Configuration Row) -->
        <div class="card shadow-sm border-0 rounded-3 mb-3">
            <div class="card-body p-3">
                <div class="row g-3">
                    <!-- Template Name -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-bold text-dark mb-1">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="tmplName" class="form-control form-control-sm" required
                               value="{{ old('name', $template->name) }}" placeholder="e.g. PBZ Sovereign Executive Emerald">
                    </div>

                    <!-- Orientation -->
                    <div class="col-lg-2 col-md-3">
                        <label class="form-label small fw-bold text-dark mb-1">Orientation</label>
                        <select name="orientation" id="tmplOrientation" class="form-select form-select-sm">
                            <option value="landscape" {{ old('orientation', $template->orientation) === 'landscape' ? 'selected' : '' }}>Landscape</option>
                            <option value="portrait" {{ old('orientation', $template->orientation) === 'portrait' ? 'selected' : '' }}>Portrait</option>
                        </select>
                    </div>

                    <!-- Background Image -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-dark mb-1">Background image</label>
                        <div class="input-group input-group-sm">
                            <input type="file" name="background_image" id="tmplBgFile" class="form-control form-control-sm" accept="image/*">
                            @if(!empty($template->background_image))
                                <button type="button" class="btn btn-outline-danger btn-sm" id="btnRemoveBg" title="Remove Background">
                                    <i class="fas fa-times"></i>
                                </button>
                                <input type="hidden" name="remove_background" id="removeBgInput" value="0">
                            @endif
                        </div>
                        <span class="text-muted" style="font-size: 10.5px;">Recommended: 297mm x 210mm at 300dpi (PNG/JPEG)</span>
                    </div>

                    <!-- Valid For Months -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-dark mb-1">Valid for (months)</label>
                        <input type="number" name="valid_for_months" class="form-control form-control-sm"
                               value="{{ old('valid_for_months', $template->valid_for_months) }}" placeholder="Lifetime" min="1">
                        <span class="text-muted" style="font-size: 10.5px;">Empty = never expires. Expired holders must retake course.</span>
                    </div>
                </div>

                <!-- Checkbox flags -->
                <div class="d-flex align-items-center gap-4 mt-2.5 pt-2 border-top">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="is_default" id="isDefaultCheck" value="1" {{ old('is_default', $template->is_default) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="isDefaultCheck">Set as Default Academy Template</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" {{ old('is_active', $template->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label small fw-semibold text-dark" for="isActiveCheck">Active &amp; Ready for Issuance</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mode Toggle Tabs (Visual Designer vs HTML/CSS) -->
        <div class="d-flex align-items-center gap-2 mb-2.5">
            <button type="button" class="btn btn-sm mode-toggle-btn active" id="btnModeVisual" onclick="switchMode('visual')">
                <i class="fas fa-magic me-1.5"></i> Visual designer
            </button>
            <button type="button" class="btn btn-sm mode-toggle-btn" id="btnModeCode" onclick="switchMode('code')">
                <i class="fas fa-code me-1.5"></i> HTML / CSS
            </button>
        </div>

        <!-- VISUAL DESIGNER VIEW -->
        <div id="visualModeContainer">
            <!-- Toolbar: Add Elements & Controls -->
            <div class="card shadow-sm border-0 rounded-3 mb-3">
                <div class="card-body p-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <!-- Left: Add Elements -->
                    <div class="d-flex align-items-center gap-1.5 flex-wrap">
                        <span class="small fw-bold text-muted me-1" style="font-size: 11.5px; text-transform: uppercase;">Add</span>

                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('text')">
                            <i class="fas fa-font text-secondary"></i> Text
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addPlaceholderElement('{student_name}', 'Student Name', 'serif', 28, '#006837', true)">
                            <i class="fas fa-user-graduate text-primary"></i> Student name
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addPlaceholderElement('{course_title}', 'Course Title', 'serif', 19, '#072818', true)">
                            <i class="fas fa-book-open text-info"></i> Course
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addPlaceholderElement('{issued_at}', 'Date of Issue', 'sans-serif', 11, '#64748b')">
                            <i class="fas fa-calendar-day text-success"></i> Date
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addPlaceholderElement('{instructor_name}', 'Instructor Name', 'serif', 13, '#072818', true)">
                            <i class="fas fa-chalkboard-teacher text-warning"></i> Instructor
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addPlaceholderElement('{certificate_no}', 'Certificate No', 'sans-serif', 10, '#64748b')">
                            <i class="fas fa-fingerprint text-danger"></i> Cert. no
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('qr')">
                            <i class="fas fa-qrcode text-dark"></i> QR
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('logo')">
                            <i class="fas fa-shield-alt text-success"></i> Logo
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('signature')">
                            <i class="fas fa-signature text-secondary"></i> Image / signature
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('line')">
                            <i class="fas fa-minus text-muted"></i> Line
                        </button>
                        <button type="button" class="btn btn-sm btn-tool" onclick="addElement('box')">
                            <i class="far fa-square text-muted"></i> Box
                        </button>
                    </div>

                    <!-- Right: Canvas Utilities -->
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary p-1 px-2" title="Reset Canvas" onclick="resetToInitialElements()">
                            <i class="fas fa-undo"></i>
                        </button>
                        <div class="form-check form-switch mb-0 d-flex align-items-center gap-1.5">
                            <input class="form-check-input mt-0" type="checkbox" id="sampleDataSwitch" checked onchange="toggleSampleData()">
                            <label class="form-check-label small fw-bold text-dark cursor-pointer mb-0" for="sampleDataSwitch" style="font-size: 12px;">Sample data</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workspace: Canvas (Left Col-8/9) & Inspector (Right Col-4/3) -->
            <div class="row g-3">
                <!-- Center Canvas Area -->
                <div class="col-xl-9 col-lg-8">
                    <div class="card shadow-sm border-0 rounded-3 mb-0 overflow-hidden">
                        <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
                            <div class="small text-muted fw-semibold" style="font-size: 11px;">
                                <i class="fas fa-expand-arrows-alt me-1"></i> Interactive A4 Canvas (<span id="canvasDimsLabel">842 × 595 px</span>) &bull; Click to select, drag to position
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-secondary" id="selectedBadge" style="font-size: 10px;">No element selected</span>
                            </div>
                        </div>

                        <!-- Canvas Viewport Box -->
                        <div class="cert-canvas-wrapper" id="canvasWrapper">
                            <div id="certCanvas" class="cert-canvas-stage">
                                <!-- Draggable elements render here via JS -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Inspector & Placeholders -->
                <div class="col-xl-3 col-lg-4">
                    <!-- Inspector Card: Selected Element Properties -->
                    <div class="card shadow-sm border-0 rounded-3 mb-3">
                        <div class="card-header bg-white py-2.5 px-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0 fw-bold text-dark" style="font-size: 13.5px;">Selected element</h5>
                            <span id="selectedTypeBadge" class="badge bg-light text-secondary" style="font-size: 10px;">—</span>
                        </div>
                        <div class="card-body p-3" id="inspectorBody">
                            <!-- Empty State when nothing selected -->
                            <div id="inspectorEmptyState" class="text-center py-4 text-muted">
                                <i class="fas fa-mouse-pointer fs-3 text-secondary mb-2 d-block opacity-50"></i>
                                <span style="font-size: 12.5px;">Click an element on the canvas to edit its properties, drag to reposition, or add elements from the toolbar above.</span>
                            </div>

                            <!-- Active Inspector Controls -->
                            <div id="inspectorControls" style="display: none;">
                                <!-- Content Input -->
                                <div class="mb-2.5" id="groupContent">
                                    <label class="form-label small fw-bold text-dark mb-1">Text / Content</label>
                                    <textarea id="propContent" class="form-control form-control-sm" rows="2" style="font-size: 12.5px;"></textarea>
                                </div>

                                <!-- Font Family & Weight -->
                                <div class="row g-2 mb-2.5" id="groupTypography">
                                    <div class="col-7">
                                        <label class="form-label small fw-bold text-dark mb-1">Font Family</label>
                                        <select id="propFontFamily" class="form-select form-select-sm" style="font-size: 11.5px;">
                                            <option value="serif">Playfair / Serif</option>
                                            <option value="sans-serif">Inter / Sans-serif</option>
                                            <option value="cursive">Great Vibes (Script)</option>
                                            <option value="Dancing Script">Dancing Script</option>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label small fw-bold text-dark mb-1">Weight</label>
                                        <select id="propFontWeight" class="form-select form-select-sm" style="font-size: 11.5px;">
                                            <option value="normal">Normal</option>
                                            <option value="600">Semi-Bold</option>
                                            <option value="700">Bold</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Font Size & Color -->
                                <div class="row g-2 mb-2.5" id="groupSizeColor">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Font Size (px)</label>
                                        <input type="number" id="propFontSize" class="form-control form-control-sm" min="8" max="72">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Text Color</label>
                                        <div class="d-flex align-items-center gap-1.5">
                                            <input type="color" id="propColorPicker" class="form-control form-control-color form-control-sm p-0 border-0" style="width: 28px; height: 28px;">
                                            <input type="text" id="propColorHex" class="form-control form-control-sm text-uppercase" style="font-size: 11.5px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Text Alignment & Letter Spacing -->
                                <div class="row g-2 mb-2.5" id="groupAlign">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Alignment</label>
                                        <div class="btn-group w-100" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-1" onclick="setTextAlign('left')"><i class="fas fa-align-left"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-1" onclick="setTextAlign('center')"><i class="fas fa-align-center"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-1" onclick="setTextAlign('right')"><i class="fas fa-align-right"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Spacing (px)</label>
                                        <input type="number" id="propLetterSpacing" class="form-control form-control-sm" min="0" max="10" step="0.5">
                                    </div>
                                </div>

                                <!-- Position X, Y, Width, Height -->
                                <div class="row g-2 mb-2.5">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Pos X (px)</label>
                                        <input type="number" id="propX" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Pos Y (px)</label>
                                        <input type="number" id="propY" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Width (px)</label>
                                        <input type="number" id="propWidth" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-dark mb-1">Height (px)</label>
                                        <input type="number" id="propHeight" class="form-control form-control-sm">
                                    </div>
                                </div>

                                <!-- Box/Border Properties (when box or line) -->
                                <div id="groupBoxProps" style="display: none;" class="mb-2.5 pt-2 border-top">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-dark mb-1">Border Width</label>
                                            <input type="number" id="propBorderWidth" class="form-control form-control-sm" min="1" max="15">
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label small fw-bold text-dark mb-1">Border Color</label>
                                            <input type="color" id="propBorderColor" class="form-control form-control-color form-control-sm p-0 border-0" style="width: 100%; height: 28px;">
                                        </div>
                                        <div class="col-6 mt-1">
                                            <label class="form-label small fw-bold text-dark mb-1">Radius (px)</label>
                                            <input type="number" id="propBorderRadius" class="form-control form-control-sm" min="0" max="100">
                                        </div>
                                        <div class="col-6 mt-1">
                                            <label class="form-label small fw-bold text-dark mb-1">Fill Color</label>
                                            <input type="text" id="propBgColor" class="form-control form-control-sm" placeholder="transparent">
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Alignment Actions -->
                                <div class="d-flex gap-1.5 mb-2.5 pt-2 border-top">
                                    <button type="button" class="btn btn-sm btn-light border flex-grow-1" style="font-size: 11px;" onclick="centerHorizontally()">
                                        <i class="fas fa-arrows-alt-h me-1"></i> Center H
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light border flex-grow-1" style="font-size: 11px;" onclick="centerVertically()">
                                        <i class="fas fa-arrows-alt-v me-1"></i> Center V
                                    </button>
                                </div>

                                <!-- Layer & Actions -->
                                <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="font-size: 11.5px;" onclick="duplicateCurrentElement()">
                                        <i class="far fa-copy me-1"></i> Duplicate
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" style="font-size: 11.5px;" onclick="deleteCurrentElement()">
                                        <i class="far fa-trash-alt me-1"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Placeholders Cheat Sheet Card (Matching Image 2) -->
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-header bg-white py-2 px-3 border-bottom">
                            <h5 class="card-title mb-0 fw-bold text-dark" style="font-size: 13px;">Placeholders</h5>
                        </div>
                        <div class="card-body p-2.5" style="max-height: 280px; overflow-y: auto;">
                            <div class="d-flex flex-column gap-2" style="font-size: 12px;">
                                <div class="placeholder-row" onclick="insertPlaceholder('{student_name}')">
                                    <code>{student_name}</code>
                                    <span class="text-muted small d-block">The student's full name</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{course_title}')">
                                    <code>{course_title}</code>
                                    <span class="text-muted small d-block">Course title</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{instructor_name}')">
                                    <code>{instructor_name}</code>
                                    <span class="text-muted small d-block">Instructor's name</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{issued_at}')">
                                    <code>{issued_at}</code>
                                    <span class="text-muted small d-block">Issue date (e.g. 15 October 2026)</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{certificate_no}')">
                                    <code>{certificate_no}</code>
                                    <span class="text-muted small d-block">Certificate number</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{verification_code}')">
                                    <code>{verification_code}</code>
                                    <span class="text-muted small d-block">Verification code</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{verify_url}')">
                                    <code>{verify_url}</code>
                                    <span class="text-muted small d-block">Public verification link</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{qr}')">
                                    <code>{qr}</code>
                                    <span class="text-muted small d-block">QR code image of the verification link</span>
                                </div>
                                <div class="placeholder-row" onclick="insertPlaceholder('{site_name}')">
                                    <code>{site_name}</code>
                                    <span class="text-muted small d-block">Academy / site name</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CODE EDITOR VIEW (HTML / CSS MODE) -->
        <div id="codeModeContainer" style="display: none;">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-2.5 px-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark" style="font-size: 14px;">Custom CSS &amp; HTML Overrides</h5>
                </div>
                <div class="card-body p-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">Custom CSS</label>
                            <textarea name="custom_css" id="customCssInput" class="form-control font-monospace" rows="12" style="font-size: 12px;">{{ old('custom_css', $template->custom_css) }}</textarea>
                            <span class="text-muted small">Target custom classes or fine-tune canvas elements with custom typography and styles.</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark mb-1">Custom HTML Fragment / Template</label>
                            <textarea name="custom_html" id="customHtmlInput" class="form-control font-monospace" rows="12" style="font-size: 12px;">{{ old('custom_html', $template->custom_html) }}</textarea>
                            <span class="text-muted small">Optional custom HTML structure override for specialized printing engines.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Preview Modal -->
    <div class="modal fade" id="testPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document" style="max-width: 900px;">
            <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="modal-header py-2 px-3 bg-dark text-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-certificate text-warning"></i>
                        <h5 class="modal-title fs-6 fw-bold mb-0 text-white">Live Certificate Preview</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark d-flex justify-content-center align-items-center" style="min-height: 520px; overflow-x: auto;">
                    <div id="previewModalCanvasContainer" style="padding: 15px;"></div>
                </div>
                <div class="modal-footer py-2 px-3 bg-light d-flex justify-content-between">
                    <span class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> Live canvas representation with sample banking credentials</span>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Great+Vibes&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        .mode-toggle-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 14px;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .mode-toggle-btn.active {
            background: #0284c7 !important;
            border-color: #0284c7 !important;
            color: #ffffff !important;
        }
        .btn-tool {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #334155;
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
        }
        .btn-tool:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }
        .cert-canvas-wrapper {
            background: #475569;
            padding: 24px;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 640px;
        }
        .cert-canvas-stage {
            position: relative;
            background: #ffffff;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
            width: 842px;
            height: 595px;
            flex-shrink: 0;
            user-select: none;
            overflow: hidden;
            @if(!empty($template->background_image))
            background-image: url('{{ asset($template->background_image) }}');
            background-size: cover;
            background-position: center;
            @endif
        }
        .canvas-el {
            position: absolute;
            cursor: move;
            user-select: none;
            display: flex;
            align-items: center;
            box-sizing: border-box;
            border: 1px dashed transparent;
            transition: border-color 0.1s ease;
        }
        .canvas-el:hover {
            border-color: rgba(2, 132, 199, 0.4);
        }
        .canvas-el.selected {
            border: 1.5px solid #0284c7 !important;
            outline: 2px solid rgba(2, 132, 199, 0.25);
            z-index: 1000 !important;
        }
        .canvas-el.selected::after {
            content: '';
            position: absolute;
            right: -4px;
            bottom: -4px;
            width: 8px;
            height: 8px;
            background: #0284c7;
            border: 1px solid #ffffff;
            border-radius: 2px;
            cursor: se-resize;
        }
        .placeholder-row {
            padding: 4px 6px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.12s ease;
        }
        .placeholder-row:hover {
            background: #e0f2fe;
        }
        .placeholder-row code {
            color: #d946ef;
            font-size: 11px;
            font-weight: 700;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const initialElementsData = {!! json_encode($initialElements) !!};
        let elements = JSON.parse(JSON.stringify(initialElementsData));
        let selectedElId = null;
        let showSampleData = true;
        let isDragging = false;
        let dragStartX = 0, dragStartY = 0;
        let elStartX = 0, elStartY = 0;

        const sampleReplacements = {
            '{student_name}': 'Alice Johnson',
            '{course_title}': 'AML / CFT & KYC Regulatory Certification (BOT Compliance 2026)',
            '{instructor_name}': 'Mwanaidi Ali',
            '{issued_at}': '15 October 2026',
            '{completion_date}': '15 October 2026',
            '{certificate_no}': 'CERT-000108-PBZ966',
            '{certificate_number}': 'CERT-000108-PBZ966',
            '{verification_code}': 'CERT-000108-PBZ966',
            '{verify_url}': '{{ url("/verify-certificate/CERT-000108-PBZ966") }}',
            '{site_name}': "People's Bank of Zanzibar"
        };

        function switchMode(mode) {
            if (mode === 'visual') {
                $('#btnModeVisual').addClass('active');
                $('#btnModeCode').removeClass('active');
                $('#visualModeContainer').show();
                $('#codeModeContainer').hide();
            } else {
                $('#btnModeCode').addClass('active');
                $('#btnModeVisual').removeClass('active');
                $('#visualModeContainer').hide();
                $('#codeModeContainer').show();
            }
        }

        function renderCanvas() {
            const canvas = document.getElementById('certCanvas');
            canvas.innerHTML = '';

            elements.forEach(el => {
                const domEl = document.createElement('div');
                domEl.id = 'dom_' + el.id;
                domEl.className = 'canvas-el' + (el.id === selectedElId ? ' selected' : '');
                domEl.style.left = el.x + 'px';
                domEl.style.top = el.y + 'px';
                domEl.style.width = el.width + 'px';
                domEl.style.height = el.height + 'px';
                domEl.style.zIndex = el.z_index || 4;

                let content = el.content || '';
                if (showSampleData) {
                    Object.keys(sampleReplacements).forEach(k => {
                        content = content.replace(new RegExp(k, 'g'), sampleReplacements[k]);
                    });
                }

                if (el.type === 'line') {
                    domEl.style.borderTop = (el.border_width || 1.5) + 'px solid ' + (el.border_color || '#d4af37');
                } else if (el.type === 'box') {
                    domEl.style.border = (el.border_width || 1) + 'px ' + (el.border_style || 'solid') + ' ' + (el.border_color || '#006837');
                    domEl.style.borderRadius = (el.border_radius || 0) + 'px';
                    domEl.style.backgroundColor = el.background_color || 'transparent';
                } else if (el.type === 'logo') {
                    domEl.innerHTML = `<img src="{{ asset('assets/front/img/logo/logo.png') }}" style="max-width:100%; max-height:100%; object-fit:contain; pointer-events:none;">`;
                } else if (el.type === 'qr') {
                    domEl.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PBZ-CERT-VERIFY" style="width:100%; height:100%; object-fit:contain; pointer-events:none;">`;
                } else if (el.type === 'signature') {
                    domEl.innerHTML = `<div style="font-family:'Great Vibes', cursive; font-size:24px; color:#006837; pointer-events:none;">Araphat A. Haji</div>`;
                } else {
                    // Text / Placeholders
                    let fontFam = "'Playfair Display', Georgia, serif";
                    if (el.font_family === 'sans-serif' || el.font_family === 'Inter') {
                        fontFam = "'Inter', sans-serif";
                    } else if (el.font_family === 'cursive' || el.font_family === 'Great Vibes') {
                        fontFam = "'Great Vibes', cursive";
                    } else if (el.font_family === 'Dancing Script') {
                        fontFam = "'Dancing Script', cursive";
                    }

                    domEl.style.fontFamily = fontFam;
                    domEl.style.fontSize = (el.font_size || 14) + 'px';
                    domEl.style.fontWeight = el.font_weight || 'normal';
                    domEl.style.fontStyle = el.font_style || 'normal';
                    domEl.style.color = el.color || '#072818';
                    domEl.style.textAlign = el.text_align || 'center';
                    domEl.style.letterSpacing = (el.letter_spacing || 0) + 'px';
                    domEl.style.lineHeight = el.line_height || '1.2';
                    if (el.text_align === 'left') domEl.style.justifyContent = 'flex-start';
                    else if (el.text_align === 'right') domEl.style.justifyContent = 'flex-end';
                    else domEl.style.justifyContent = 'center';

                    if (el.background_color) domEl.style.backgroundColor = el.background_color;
                    if (el.border_color) domEl.style.border = (el.border_width || 1) + 'px solid ' + el.border_color;
                    if (el.border_radius) domEl.style.borderRadius = el.border_radius + 'px';
                    if (el.border_bottom) domEl.style.borderBottom = el.border_bottom;

                    domEl.innerText = content;
                }

                // Attach mouse drag & selection listener
                domEl.addEventListener('mousedown', function (e) {
                    e.stopPropagation();
                    selectElement(el.id);

                    isDragging = true;
                    dragStartX = e.clientX;
                    dragStartY = e.clientY;
                    elStartX = el.x;
                    elStartY = el.y;

                    function onMouseMove(moveEvent) {
                        if (!isDragging) return;
                        const dx = moveEvent.clientX - dragStartX;
                        const dy = moveEvent.clientY - dragStartY;

                        const newX = Math.round(elStartX + dx);
                        const newY = Math.round(elStartY + dy);

                        el.x = Math.max(0, Math.min(newX, getCanvasWidth() - el.width));
                        el.y = Math.max(0, Math.min(newY, getCanvasHeight() - el.height));

                        domEl.style.left = el.x + 'px';
                        domEl.style.top = el.y + 'px';

                        $('#propX').val(el.x);
                        $('#propY').val(el.y);
                    }

                    function onMouseUp() {
                        isDragging = false;
                        document.removeEventListener('mousemove', onMouseMove);
                        document.removeEventListener('mouseup', onMouseUp);
                    }

                    document.addEventListener('mousemove', onMouseMove);
                    document.addEventListener('mouseup', onMouseUp);
                });

                canvas.appendChild(domEl);
            });
        }

        function getCanvasWidth() {
            return $('#tmplOrientation').val() === 'portrait' ? 595 : 842;
        }

        function getCanvasHeight() {
            return $('#tmplOrientation').val() === 'portrait' ? 842 : 595;
        }

        function updateCanvasDimensions() {
            const w = getCanvasWidth();
            const h = getCanvasHeight();
            $('#certCanvas').css({ width: w + 'px', height: h + 'px' });
            $('#canvasDimsLabel').text(w + ' × ' + h + ' px');
            renderCanvas();
        }

        function selectElement(id) {
            selectedElId = id;
            $('.canvas-el').removeClass('selected');
            $('#dom_' + id).addClass('selected');

            const el = elements.find(item => item.id === id);
            if (!el) {
                clearSelection();
                return;
            }

            $('#selectedBadge').text(el.label || el.type);
            $('#selectedTypeBadge').text(el.type.toUpperCase());
            $('#inspectorEmptyState').hide();
            $('#inspectorControls').show();

            $('#propContent').val(el.content || '');
            $('#propFontFamily').val(el.font_family || 'serif');
            $('#propFontWeight').val(el.font_weight || 'normal');
            $('#propFontSize').val(el.font_size || 14);
            $('#propColorHex').val(el.color || '#072818');
            $('#propColorPicker').val(el.color || '#072818');
            $('#propLetterSpacing').val(el.letter_spacing || 0);

            $('#propX').val(el.x);
            $('#propY').val(el.y);
            $('#propWidth').val(el.width);
            $('#propHeight').val(el.height);

            if (el.type === 'box' || el.type === 'line') {
                $('#groupBoxProps').show();
                $('#propBorderWidth').val(el.border_width || 1);
                $('#propBorderColor').val(el.border_color || '#006837');
                $('#propBorderRadius').val(el.border_radius || 0);
                $('#propBgColor').val(el.background_color || 'transparent');
            } else {
                $('#groupBoxProps').hide();
            }
        }

        function clearSelection() {
            selectedElId = null;
            $('.canvas-el').removeClass('selected');
            $('#selectedBadge').text('No element selected');
            $('#selectedTypeBadge').text('—');
            $('#inspectorEmptyState').show();
            $('#inspectorControls').hide();
        }

        function getSelectedElement() {
            return elements.find(el => el.id === selectedElId);
        }

        // Inspector live updates
        $('#propContent').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.content = $(this).val(); renderCanvas(); }
        });
        $('#propFontFamily').on('change', function () {
            const el = getSelectedElement();
            if (el) { el.font_family = $(this).val(); renderCanvas(); }
        });
        $('#propFontWeight').on('change', function () {
            const el = getSelectedElement();
            if (el) { el.font_weight = $(this).val(); renderCanvas(); }
        });
        $('#propFontSize').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.font_size = parseInt($(this).val()) || 14; renderCanvas(); }
        });
        $('#propColorPicker').on('input', function () {
            const val = $(this).val();
            $('#propColorHex').val(val);
            const el = getSelectedElement();
            if (el) { el.color = val; renderCanvas(); }
        });
        $('#propColorHex').on('input', function () {
            const val = $(this).val();
            $('#propColorPicker').val(val);
            const el = getSelectedElement();
            if (el) { el.color = val; renderCanvas(); }
        });
        $('#propLetterSpacing').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.letter_spacing = parseFloat($(this).val()) || 0; renderCanvas(); }
        });
        $('#propX').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.x = parseInt($(this).val()) || 0; renderCanvas(); }
        });
        $('#propY').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.y = parseInt($(this).val()) || 0; renderCanvas(); }
        });
        $('#propWidth').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.width = parseInt($(this).val()) || 20; renderCanvas(); }
        });
        $('#propHeight').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.height = parseInt($(this).val()) || 20; renderCanvas(); }
        });
        $('#propBorderWidth').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.border_width = parseInt($(this).val()) || 1; renderCanvas(); }
        });
        $('#propBorderColor').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.border_color = $(this).val(); renderCanvas(); }
        });
        $('#propBorderRadius').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.border_radius = parseInt($(this).val()) || 0; renderCanvas(); }
        });
        $('#propBgColor').on('input', function () {
            const el = getSelectedElement();
            if (el) { el.background_color = $(this).val(); renderCanvas(); }
        });

        function setTextAlign(align) {
            const el = getSelectedElement();
            if (el) { el.text_align = align; renderCanvas(); }
        }

        function centerHorizontally() {
            const el = getSelectedElement();
            if (el) {
                el.x = Math.round((getCanvasWidth() - el.width) / 2);
                $('#propX').val(el.x);
                renderCanvas();
            }
        }

        function centerVertically() {
            const el = getSelectedElement();
            if (el) {
                el.y = Math.round((getCanvasHeight() - el.height) / 2);
                $('#propY').val(el.y);
                renderCanvas();
            }
        }

        function addElement(type) {
            const id = 'el_' + Date.now();
            let newEl = {
                id: id,
                type: type,
                label: type.charAt(0).toUpperCase() + type.slice(1),
                x: 100,
                y: 100,
                width: 250,
                height: 35,
                z_index: 10
            };

            if (type === 'text') {
                newEl.content = 'Custom Notice / Statement';
                newEl.font_family = 'sans-serif';
                newEl.font_size = 14;
                newEl.color = '#072818';
                newEl.text_align = 'center';
            } else if (type === 'line') {
                newEl.height = 2;
                newEl.width = 300;
                newEl.border_color = '#d4af37';
                newEl.border_width = 1.5;
            } else if (type === 'box') {
                newEl.width = 200;
                newEl.height = 100;
                newEl.border_color = '#006837';
                newEl.border_width = 1;
                newEl.border_style = 'solid';
                newEl.background_color = 'transparent';
            } else if (type === 'qr') {
                newEl.width = 80;
                newEl.height = 80;
            } else if (type === 'logo') {
                newEl.width = 160;
                newEl.height = 50;
            } else if (type === 'signature') {
                newEl.width = 200;
                newEl.height = 45;
            }

            elements.push(newEl);
            renderCanvas();
            selectElement(id);
        }

        function addPlaceholderElement(placeholder, label, fontFam, fontSize, color, isBold) {
            const id = 'el_' + Date.now();
            const newEl = {
                id: id,
                type: 'placeholder',
                label: label,
                content: placeholder,
                placeholder_key: placeholder,
                x: 120,
                y: 150,
                width: 600,
                height: Math.round(fontSize * 1.5),
                font_family: fontFam || 'serif',
                font_size: fontSize || 16,
                font_weight: isBold ? '700' : 'normal',
                color: color || '#072818',
                text_align: 'center',
                z_index: 10
            };
            elements.push(newEl);
            renderCanvas();
            selectElement(id);
        }

        function insertPlaceholder(token) {
            const el = getSelectedElement();
            if (el && (el.type === 'text' || el.type === 'placeholder')) {
                el.content = (el.content ? el.content + ' ' : '') + token;
                $('#propContent').val(el.content);
                renderCanvas();
            } else {
                addPlaceholderElement(token, token.replace(/[{}]/g, ''), 'serif', 18, '#006837', true);
            }
        }

        function duplicateCurrentElement() {
            const el = getSelectedElement();
            if (!el) return;
            const cloned = JSON.parse(JSON.stringify(el));
            cloned.id = 'el_' + Date.now();
            cloned.x += 15;
            cloned.y += 15;
            elements.push(cloned);
            renderCanvas();
            selectElement(cloned.id);
        }

        function deleteCurrentElement() {
            if (!selectedElId) return;
            elements = elements.filter(el => el.id !== selectedElId);
            clearSelection();
            renderCanvas();
        }

        function resetToInitialElements() {
            if (confirm('Reset canvas back to the default certified PBZ layout? Any unsaved element positions will be replaced.')) {
                elements = JSON.parse(JSON.stringify(initialElementsData));
                clearSelection();
                renderCanvas();
            }
        }

        function toggleSampleData() {
            showSampleData = $('#sampleDataSwitch').is(':checked');
            renderCanvas();
        }

        // Keyboard arrow nudging and deletion
        $(document).keydown(function (e) {
            if (!selectedElId) return;
            // Ignore if typing inside input / textarea
            if ($(e.target).is('input, textarea, select')) return;

            const el = getSelectedElement();
            if (!el) return;

            const step = e.shiftKey ? 5 : 1;
            if (e.key === 'ArrowLeft') {
                el.x = Math.max(0, el.x - step);
                $('#propX').val(el.x);
                renderCanvas();
                e.preventDefault();
            } else if (e.key === 'ArrowRight') {
                el.x = Math.min(getCanvasWidth() - el.width, el.x + step);
                $('#propX').val(el.x);
                renderCanvas();
                e.preventDefault();
            } else if (e.key === 'ArrowUp') {
                el.y = Math.max(0, el.y - step);
                $('#propY').val(el.y);
                renderCanvas();
                e.preventDefault();
            } else if (e.key === 'ArrowDown') {
                el.y = Math.min(getCanvasHeight() - el.height, el.y + step);
                $('#propY').val(el.y);
                renderCanvas();
                e.preventDefault();
            } else if (e.key === 'Delete' || e.key === 'Backspace') {
                deleteCurrentElement();
                e.preventDefault();
            }
        });

        // Form submission serialization
        $('#templateForm').on('submit', function (e) {
            $('#elementsJsonInput').val(JSON.stringify(elements));
        });

        $('#tmplOrientation').on('change', function () {
            updateCanvasDimensions();
        });

        // Live test preview trigger
        function triggerTestPreview() {
            const w = getCanvasWidth();
            const h = getCanvasHeight();
            const container = $('#previewModalCanvasContainer');
            container.empty();

            const previewCanvas = document.createElement('div');
            previewCanvas.className = 'cert-canvas-stage';
            previewCanvas.style.position = 'relative';
            previewCanvas.style.width = w + 'px';
            previewCanvas.style.height = h + 'px';
            previewCanvas.style.background = '#ffffff';
            previewCanvas.style.overflow = 'hidden';

            elements.forEach(el => {
                const domEl = document.createElement('div');
                domEl.style.position = 'absolute';
                domEl.style.left = el.x + 'px';
                domEl.style.top = el.y + 'px';
                domEl.style.width = el.width + 'px';
                domEl.style.height = el.height + 'px';
                domEl.style.zIndex = el.z_index || 4;

                let content = el.content || '';
                Object.keys(sampleReplacements).forEach(k => {
                    content = content.replace(new RegExp(k, 'g'), sampleReplacements[k]);
                });

                if (el.type === 'line') {
                    domEl.style.borderTop = (el.border_width || 1.5) + 'px solid ' + (el.border_color || '#d4af37');
                } else if (el.type === 'box') {
                    domEl.style.border = (el.border_width || 1) + 'px solid ' + (el.border_color || '#006837');
                    domEl.style.borderRadius = (el.border_radius || 0) + 'px';
                    domEl.style.backgroundColor = el.background_color || 'transparent';
                } else if (el.type === 'logo') {
                    domEl.innerHTML = `<img src="{{ asset('assets/front/img/logo/logo.png') }}" style="max-width:100%; max-height:100%; object-fit:contain;">`;
                } else if (el.type === 'qr') {
                    domEl.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=PBZ-CERT-VERIFY" style="width:100%; height:100%; object-fit:contain;">`;
                } else if (el.type === 'signature') {
                    domEl.innerHTML = `<div style="font-family:'Great Vibes', cursive; font-size:24px; color:#006837;">Araphat A. Haji</div>`;
                } else {
                    let fontFam = "'Playfair Display', Georgia, serif";
                    if (el.font_family === 'sans-serif' || el.font_family === 'Inter') fontFam = "'Inter', sans-serif";
                    else if (el.font_family === 'cursive' || el.font_family === 'Great Vibes') fontFam = "'Great Vibes', cursive";
                    else if (el.font_family === 'Dancing Script') fontFam = "'Dancing Script', cursive";

                    domEl.style.fontFamily = fontFam;
                    domEl.style.fontSize = (el.font_size || 14) + 'px';
                    domEl.style.fontWeight = el.font_weight || 'normal';
                    domEl.style.color = el.color || '#072818';
                    domEl.style.textAlign = el.text_align || 'center';
                    domEl.style.letterSpacing = (el.letter_spacing || 0) + 'px';
                    domEl.style.lineHeight = el.line_height || '1.2';
                    domEl.style.display = 'flex';
                    domEl.style.alignItems = 'center';
                    if (el.text_align === 'left') domEl.style.justifyContent = 'flex-start';
                    else if (el.text_align === 'right') domEl.style.justifyContent = 'flex-end';
                    else domEl.style.justifyContent = 'center';

                    if (el.background_color) domEl.style.backgroundColor = el.background_color;
                    if (el.border_color) domEl.style.border = (el.border_width || 1) + 'px solid ' + el.border_color;
                    if (el.border_radius) domEl.style.borderRadius = el.border_radius + 'px';
                    if (el.border_bottom) domEl.style.borderBottom = el.border_bottom;

                    domEl.innerText = content;
                }
                previewCanvas.appendChild(domEl);
            });

            container.append(previewCanvas);
            $('#testPreviewModal').modal('show');
        }

        // Click outside canvas deselects
        $('#canvasWrapper').on('click', function (e) {
            if ($(e.target).is('#canvasWrapper') || $(e.target).is('#certCanvas')) {
                clearSelection();
            }
        });

        // Initialize canvas
        $(document).ready(function () {
            updateCanvasDimensions();
        });
    </script>
@endpush

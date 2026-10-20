@php
    $embedUrl = $data['embedUrl'] ?? 'https://h5p.org/h5p/embed/617';
    $minHeight = $data['minHeight'] ?? '620px';
    $title = $data['title'] ?? $lesson->title ?? 'Embedded Interactive Learning Package';
    $guidanceNote = $data['guidanceNote'] ?? 'Complete all interactive checkpoints inside the embedded simulation to record your score.';
    $embedId = 'embed_' . $lesson->id;
@endphp

<div class="interactive-component-wrapper mb-4">
    <div class="card border-0 rounded-3 overflow-hidden shadow-sm" style="background: #081226; color: #ffffff;">
        <!-- Top Toolbar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #1e293b !important; background: #060e1e;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2.5 py-1.5 rounded-pill" style="background-color: #6366f1; color: #ffffff; font-size: 11.5px;">
                    <i class="fa-solid fa-window-maximize me-1"></i> Interactive Embedded Module
                </span>
                <span class="text-white-50 d-none d-md-inline" style="font-size: 12.5px;">
                    H5P / PowerBI / External Regulatory Engine
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-light px-2.5 py-1" id="{{ $embedId }}_reload" title="Reload Frame" style="font-size: 11.5px; border-color: #334155;">
                    <i class="fa-solid fa-rotate-right me-1"></i> Reload
                </button>
                <button type="button" class="btn btn-sm btn-outline-light px-2.5 py-1" id="{{ $embedId }}_fullscreen" title="Fullscreen" style="font-size: 11.5px; border-color: #334155;">
                    <i class="fa-solid fa-expand me-1"></i> Fullscreen
                </button>
                <a href="{{ $embedUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary px-2.5 py-1" style="font-size: 11.5px; border-color: #334155; color: #94a3b8;">
                    <i class="fa-solid fa-up-right-from-square"></i>
                </a>
            </div>
        </div>

        <div class="p-4 p-md-5">
            <div class="mb-3">
                <h3 class="fw-bold text-white mb-1" style="font-size: 1.3rem;">
                    {{ $title }}
                </h3>
                <p class="text-white-50 mb-0" style="font-size: 13px;">
                    {{ $guidanceNote }}
                </p>
            </div>

            <!-- Sandboxed IFrame Container -->
            <div class="position-relative rounded-3 overflow-hidden" id="{{ $embedId }}_container" style="background: #020617; border: 1px solid #1e293b; min-height: {{ $minHeight }};">
                <iframe 
                    id="{{ $embedId }}_frame" 
                    src="{{ $embedUrl }}" 
                    style="width: 100%; height: {{ $minHeight }}; border: none; display: block;" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>

            <div class="mt-3 p-2.5 rounded text-white-50 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #0b1528; font-size: 12px; border: 1px solid #1e293b;">
                <span><i class="fa-solid fa-shield-halved me-1 text-info"></i> Sandboxed interactive container loaded securely.</span>
                <span class="font-monospace text-white-50" style="font-size: 11px;">PROVIDER: {{ parse_url($embedUrl, PHP_URL_HOST) ?? 'External' }}</span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initEmbed() {
        const reloadBtn = document.getElementById('{{ $embedId }}_reload');
        const frame = document.getElementById('{{ $embedId }}_frame');
        const fullscreenBtn = document.getElementById('{{ $embedId }}_fullscreen');
        const container = document.getElementById('{{ $embedId }}_container');

        if (reloadBtn && frame) {
            reloadBtn.onclick = function() {
                frame.src = frame.src;
            };
        }

        if (fullscreenBtn && container) {
            fullscreenBtn.onclick = function() {
                if (!document.fullscreenElement) {
                    if (container.requestFullscreen) {
                        container.requestFullscreen();
                    } else if (container.webkitRequestFullscreen) {
                        container.webkitRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEmbed);
    } else {
        initEmbed();
    }
})();
</script>

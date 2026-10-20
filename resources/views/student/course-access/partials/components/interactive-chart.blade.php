@php
    $title = $data['title'] ?? $lesson->title ?? 'PBZ Prudential Ratio & Financial Performance Analytics';
    $chartType = $data['chartType'] ?? 'line';
    $labels = is_array($data['labels'] ?? null) 
        ? $data['labels'] 
        : (isset($data['labels']) && is_string($data['labels']) 
            ? array_map('trim', explode(',', $data['labels'])) 
            : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
    
    $series1Label = $data['series1Label'] ?? ($data['datasets'][0]['label'] ?? 'PBZ Observed Ratio (%)');
    $series1Raw = $data['series1Data'] ?? ($data['datasets'][0]['data'] ?? [28.4, 29.1, 27.8, 31.2, 33.0, 32.5, 30.8, 34.2, 35.1, 33.8, 36.0, 37.4]);
    $series1Data = is_array($series1Raw) ? $series1Raw : array_map('floatval', array_map('trim', explode(',', (string)$series1Raw)));

    $series2Label = $data['series2Label'] ?? ($data['datasets'][1]['label'] ?? 'BOT Statutory Minimum (20%)');
    $series2Raw = $data['series2Data'] ?? ($data['datasets'][1]['data'] ?? [20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20]);
    $series2Data = is_array($series2Raw) ? $series2Raw : array_map('floatval', array_map('trim', explode(',', (string)$series2Raw)));

    $guidanceNote = $data['guidanceNote'] ?? 'Staff must monitor prudential trajectories weekly. Under BOT Section 17, a negative variance below 20% warrants immediate liquidity escalation to ALCO and Executive Management.';
    $chartCanvasId = 'pbzInteractiveChart_' . $lesson->id;
@endphp

<div class="interactive-component-wrapper mb-4">
    <div class="card border-0 rounded-3 overflow-hidden shadow-sm" style="background: #081226; color: #ffffff;">
        <!-- Top Toolbar -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #1e293b !important; background: #060e1e;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2.5 py-1.5 rounded-pill" style="background-color: #0099cc; color: #ffffff; font-size: 11.5px;">
                    <i class="fa-solid fa-chart-line me-1"></i> BOT Interactive Learning Tool
                </span>
                <span class="text-white-50 d-none d-md-inline" style="font-size: 12.5px;">
                    Bank of Tanzania (BOT) Statutory Prudential Matrix
                </span>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-light btn-sm px-2.5 py-1 chart-type-toggle active" data-type="line" data-chart="{{ $chartCanvasId }}" style="font-size: 11.5px; border-color: #334155;">
                        <i class="fa-solid fa-chart-line me-1"></i> Line
                    </button>
                    <button type="button" class="btn btn-outline-light btn-sm px-2.5 py-1 chart-type-toggle" data-type="bar" data-chart="{{ $chartCanvasId }}" style="font-size: 11.5px; border-color: #334155;">
                        <i class="fa-solid fa-chart-column me-1"></i> Bar
                    </button>
                </div>
                <button type="button" class="btn btn-sm btn-outline-warning px-2.5 py-1 chart-stress-toggle" data-chart="{{ $chartCanvasId }}" style="font-size: 11.5px; border-color: #eab308;">
                    <i class="fa-solid fa-bolt me-1"></i> Stress Test Mode
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary px-2 py-1 chart-reset-btn" data-chart="{{ $chartCanvasId }}" title="Reset Chart" style="font-size: 11.5px; border-color: #334155; color: #94a3b8;">
                    <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>
        </div>

        <!-- Main Chart Container -->
        <div class="p-4 p-md-5">
            <!-- Header & KPIs -->
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h3 class="fw-bold text-white mb-1" style="font-size: 1.35rem;">
                        {{ $title }}
                    </h3>
                    <p class="text-white-50 mb-0" style="font-size: 13px;">
                        Interactive financial simulator with real-time statutory threshold surveillance.
                    </p>
                </div>

                <!-- KPI Metric Pills -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="px-3 py-2 rounded-2" style="background: #0f172a; border: 1px solid #1e293b;">
                        <span class="text-white-50 d-block" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">Latest Metric</span>
                        <span class="fw-bold font-monospace" id="{{ $chartCanvasId }}_kpi_latest" style="color: #00c0f3; font-size: 16px;">
                            {{ end($series1Data) }}%
                        </span>
                    </div>
                    <div class="px-3 py-2 rounded-2" style="background: #0f172a; border: 1px solid #1e293b;">
                        <span class="text-white-50 d-block" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">Regulatory Floor</span>
                        <span class="fw-bold font-monospace text-danger" id="{{ $chartCanvasId }}_kpi_floor" style="font-size: 16px;">
                            {{ end($series2Data) }}%
                        </span>
                    </div>
                    <div class="px-3 py-2 rounded-2" style="background: #0f172a; border: 1px solid #1e293b;">
                        <span class="text-white-50 d-block" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">Safety Buffer</span>
                        <span class="fw-bold font-monospace text-success" id="{{ $chartCanvasId }}_kpi_buffer" style="font-size: 16px;">
                            +{{ round(end($series1Data) - end($series2Data), 2) }}%
                        </span>
                    </div>
                    <div class="px-3 py-2 rounded-2" style="background: #0f172a; border: 1px solid #1e293b;">
                        <span class="text-white-50 d-block" style="font-size: 10.5px; text-transform: uppercase; letter-spacing: 0.5px;">BOT Audit Status</span>
                        <span class="badge bg-success-subtle text-success fw-bold" id="{{ $chartCanvasId }}_kpi_status" style="font-size: 11.5px;">
                            <i class="fa-solid fa-check-circle me-1"></i> FULLY COMPLIANT
                        </span>
                    </div>
                </div>
            </div>

            <!-- Chart Canvas -->
            <div class="position-relative p-3 rounded-3" style="background: #0b1528; border: 1px solid #1e293b; min-height: 380px;">
                <canvas id="{{ $chartCanvasId }}" height="110"></canvas>
            </div>

            <!-- Guidance & BOT Statutory Note -->
            <div class="mt-4 p-3 rounded-3 d-flex align-items-start gap-3" style="background: #0e1e38; border: 1px solid #1e3a66;">
                <div class="rounded-circle p-2 flex-shrink-0" style="background: rgba(0, 192, 243, 0.15); color: #00c0f3;">
                    <i class="fa-solid fa-scale-balanced fa-lg"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1" style="color: #00c0f3; font-size: 13px;">
                        Bank of Tanzania Regulatory Mandate &amp; Operational Directive
                    </h6>
                    <p class="text-white-50 mb-0" style="font-size: 12.5px; line-height: 1.6;">
                        {{ $guidanceNote }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initChart() {
        if (typeof Chart === 'undefined') {
            setTimeout(initChart, 150);
            return;
        }

        const canvas = document.getElementById('{{ $chartCanvasId }}');
        if (!canvas) return;

        // Destroy previous instance if exists on canvas
        if (window['instance_{{ $chartCanvasId }}']) {
            window['instance_{{ $chartCanvasId }}'].destroy();
        }

        const labels = @json($labels);
        const originalSeries1 = @json($series1Data);
        const originalSeries2 = @json($series2Data);
        let currentChartType = '{{ $chartType }}';
        let isStressed = false;

        const ctx = canvas.getContext('2d');

        const primaryGradient = ctx.createLinearGradient(0, 0, 0, 320);
        primaryGradient.addColorStop(0, 'rgba(0, 192, 243, 0.45)');
        primaryGradient.addColorStop(1, 'rgba(0, 192, 243, 0.0)');

        const buildConfig = (type, s1, s2) => {
            return {
                type: type,
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: '{{ $series1Label }}',
                            data: s1,
                            borderColor: '#00c0f3',
                            backgroundColor: type === 'line' ? primaryGradient : '#00c0f3',
                            borderWidth: 2.5,
                            fill: type === 'line',
                            tension: 0.35,
                            pointBackgroundColor: '#00c0f3',
                            pointBorderColor: '#081226',
                            pointBorderWidth: 2,
                            pointRadius: 4.5,
                            pointHoverRadius: 7
                        },
                        {
                            label: '{{ $series2Label }}',
                            data: s2,
                            borderColor: '#ef4444',
                            backgroundColor: type === 'line' ? 'transparent' : 'rgba(239, 68, 68, 0.4)',
                            borderWidth: 2,
                            borderDash: [6, 6],
                            fill: false,
                            tension: 0,
                            pointBackgroundColor: '#ef4444',
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#94a3b8',
                                font: { size: 12, family: 'Inter, sans-serif', weight: '600' },
                                boxWidth: 14
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleColor: '#ffffff',
                            bodyColor: '#00c0f3',
                            borderColor: '#1e293b',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.dataset.label + ': ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#64748b', font: { size: 11.5 } }
                        },
                        y: {
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: {
                                color: '#64748b',
                                font: { size: 11.5 },
                                callback: function(val) { return val + '%'; }
                            }
                        }
                    }
                }
            };
        };

        window['instance_{{ $chartCanvasId }}'] = new Chart(ctx, buildConfig(currentChartType, originalSeries1, originalSeries2));

        // Attach buttons handlers
        const wrapper = canvas.closest('.interactive-component-wrapper');
        if (wrapper) {
            // Type toggle
            const typeBtns = wrapper.querySelectorAll('.chart-type-toggle');
            typeBtns.forEach(btn => {
                btn.onclick = function() {
                    typeBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentChartType = this.getAttribute('data-type');
                    window['instance_{{ $chartCanvasId }}'].destroy();
                    const s1 = isStressed ? originalSeries1.map(v => Math.max(12, +(v - 9.5).toFixed(1))) : originalSeries1;
                    window['instance_{{ $chartCanvasId }}'] = new Chart(ctx, buildConfig(currentChartType, s1, originalSeries2));
                };
            });

            // Stress toggle
            const stressBtn = wrapper.querySelector('.chart-stress-toggle');
            if (stressBtn) {
                stressBtn.onclick = function() {
                    isStressed = !isStressed;
                    const s1 = isStressed 
                        ? originalSeries1.map(v => Math.max(12, +(v - 9.5).toFixed(1))) 
                        : originalSeries1;

                    this.classList.toggle('active', isStressed);
                    if (isStressed) {
                        this.classList.remove('btn-outline-warning');
                        this.classList.add('btn-warning', 'text-dark');
                    } else {
                        this.classList.remove('btn-warning', 'text-dark');
                        this.classList.add('btn-outline-warning');
                    }

                    // Update KPIs
                    const latest = s1[s1.length - 1];
                    const floor = originalSeries2[originalSeries2.length - 1];
                    const buffer = +(latest - floor).toFixed(1);

                    const kpiLatest = document.getElementById('{{ $chartCanvasId }}_kpi_latest');
                    const kpiBuffer = document.getElementById('{{ $chartCanvasId }}_kpi_buffer');
                    const kpiStatus = document.getElementById('{{ $chartCanvasId }}_kpi_status');

                    if (kpiLatest) kpiLatest.textContent = latest + '%';
                    if (kpiBuffer) {
                        kpiBuffer.textContent = (buffer >= 0 ? '+' : '') + buffer + '%';
                        kpiBuffer.className = buffer >= 0 ? 'fw-bold font-monospace text-success' : 'fw-bold font-monospace text-danger';
                    }
                    if (kpiStatus) {
                        if (buffer >= 0) {
                            kpiStatus.className = 'badge bg-success-subtle text-success fw-bold';
                            kpiStatus.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i> FULLY COMPLIANT';
                        } else {
                            kpiStatus.className = 'badge bg-danger text-white fw-bold';
                            kpiStatus.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> BOT PRUDENTIAL BREACH';
                        }
                    }

                    window['instance_{{ $chartCanvasId }}'].destroy();
                    window['instance_{{ $chartCanvasId }}'] = new Chart(ctx, buildConfig(currentChartType, s1, originalSeries2));
                };
            }

            // Reset
            const resetBtn = wrapper.querySelector('.chart-reset-btn');
            if (resetBtn) {
                resetBtn.onclick = function() {
                    isStressed = false;
                    currentChartType = '{{ $chartType }}';
                    typeBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-type') === currentChartType));
                    if (stressBtn) {
                        stressBtn.classList.remove('btn-warning', 'text-dark');
                        stressBtn.classList.add('btn-outline-warning');
                    }
                    const latest = originalSeries1[originalSeries1.length - 1];
                    const floor = originalSeries2[originalSeries2.length - 1];
                    const buffer = +(latest - floor).toFixed(1);

                    const kpiLatest = document.getElementById('{{ $chartCanvasId }}_kpi_latest');
                    const kpiBuffer = document.getElementById('{{ $chartCanvasId }}_kpi_buffer');
                    const kpiStatus = document.getElementById('{{ $chartCanvasId }}_kpi_status');

                    if (kpiLatest) kpiLatest.textContent = latest + '%';
                    if (kpiBuffer) {
                        kpiBuffer.textContent = (buffer >= 0 ? '+' : '') + buffer + '%';
                        kpiBuffer.className = 'fw-bold font-monospace text-success';
                    }
                    if (kpiStatus) {
                        kpiStatus.className = 'badge bg-success-subtle text-success fw-bold';
                        kpiStatus.innerHTML = '<i class="fa-solid fa-check-circle me-1"></i> FULLY COMPLIANT';
                    }

                    window['instance_{{ $chartCanvasId }}'].destroy();
                    window['instance_{{ $chartCanvasId }}'] = new Chart(ctx, buildConfig(currentChartType, originalSeries1, originalSeries2));
                };
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChart);
    } else {
        initChart();
    }
})();
</script>

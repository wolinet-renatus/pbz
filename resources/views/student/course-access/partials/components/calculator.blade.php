@php
    $calcType = $data['calculatorType'] ?? 'murabaha';
    $title = $data['title'] ?? ($calcType === 'murabaha' 
        ? 'PBZ Amana Murabaha Asset Financing & Profit Calculator' 
        : 'PBZ Core Banking Financial Simulator');
    $defaultPrincipal = (float)($data['defaultPrincipal'] ?? 50000000);
    $defaultProfitRate = (float)($data['defaultProfitRate'] ?? 11.5);
    $defaultTenor = (int)($data['defaultTenor'] ?? 24);
    $instructions = $data['instructions'] ?? 'Adjust financing parameters below to calculate client monthly repayment installments, total Shariah profit margin, and customer liability amortization schedule.';
    $calcId = 'calc_' . $lesson->id;
@endphp

<div class="interactive-component-wrapper mb-4">
    <div class="card border-0 rounded-3 overflow-hidden shadow-sm" style="background: #081226; color: #ffffff;">
        <!-- Header -->
        <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-color: #1e293b !important; background: #060e1e;">
            <div class="d-flex align-items-center gap-2">
                <span class="badge fw-bold px-2.5 py-1.5 rounded-pill" style="background-color: #006837; color: #ffffff; font-size: 11.5px;">
                    <i class="fa-solid fa-calculator me-1"></i> Interactive Banking Simulator
                </span>
                <span class="text-white-50 d-none d-md-inline" style="font-size: 12.5px;">
                    PBZ Amana Islamic Finance &amp; Credit Modeling Engine
                </span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge px-2.5 py-1 rounded" style="background: #0f172a; border: 1px solid #1e293b; color: #38bdf8; font-size: 11px;">
                    <i class="fa-solid fa-circle-check me-1 text-success"></i> Shariah Compliant
                </span>
            </div>
        </div>

        <div class="p-4 p-md-5">
            <div class="mb-4">
                <h3 class="fw-bold text-white mb-1" style="font-size: 1.35rem;">
                    {{ $title }}
                </h3>
                <p class="text-white-50 mb-0" style="font-size: 13px;">
                    {{ $instructions }}
                </p>
            </div>

            <div class="row g-4">
                <!-- Controls Column -->
                <div class="col-lg-6 col-12">
                    <div class="p-4 rounded-3" style="background: #0b1528; border: 1px solid #1e293b;">
                        <h5 class="fw-bold text-white mb-3 pb-2 border-bottom d-flex align-items-center justify-content-between" style="border-color: #1e293b !important; font-size: 14px;">
                            <span><i class="fa-solid fa-sliders me-2 text-info"></i> Financing Inputs</span>
                            <small class="text-white-50" style="font-size: 11px;">Real-Time Calculation</small>
                        </h5>

                        <!-- Purchase Cost -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="text-white-50 small mb-0">Total Asset Purchase Cost</label>
                                <span class="badge bg-dark font-monospace text-info" id="{{ $calcId }}_cost_badge">TZS 50,000,000</span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-dark border-secondary text-white-50">TZS</span>
                                <input type="number" class="form-control bg-dark border-secondary text-white font-monospace" id="{{ $calcId }}_cost" value="{{ $defaultPrincipal }}" step="500000" min="1000000" max="500000000">
                            </div>
                        </div>

                        <!-- Down Payment -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="text-white-50 small mb-0">Customer Down Payment (Hamish Jiddiyyah)</label>
                                <span class="badge bg-dark font-monospace text-white-50" id="{{ $calcId }}_down_badge">TZS 10,000,000 (20%)</span>
                            </div>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-dark border-secondary text-white-50">TZS</span>
                                <input type="number" class="form-control bg-dark border-secondary text-white font-monospace" id="{{ $calcId }}_down" value="{{ $defaultPrincipal * 0.2 }}" step="200000" min="0">
                            </div>
                        </div>

                        <!-- Tenor Slider -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="text-white-50 small mb-0">Financing Tenor (Duration)</label>
                                <span class="fw-bold font-monospace text-warning" id="{{ $calcId }}_tenor_label">{{ $defaultTenor }} Months ({{ round($defaultTenor/12, 1) }} Yrs)</span>
                            </div>
                            <input type="range" class="form-range" id="{{ $calcId }}_tenor" min="6" max="60" step="6" value="{{ $defaultTenor }}">
                            <div class="d-flex justify-content-between text-white-50" style="font-size: 10.5px;">
                                <span>6 Months</span>
                                <span>24 Months</span>
                                <span>48 Months</span>
                                <span>60 Months</span>
                            </div>
                        </div>

                        <!-- Profit Rate Slider -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="text-white-50 small mb-0">PBZ Agreed Profit Rate (Annual)</label>
                                <span class="fw-bold font-monospace text-success" id="{{ $calcId }}_rate_label">{{ $defaultProfitRate }}% p.a.</span>
                            </div>
                            <input type="range" class="form-range" id="{{ $calcId }}_rate" min="6" max="22" step="0.5" value="{{ $defaultProfitRate }}">
                            <div class="d-flex justify-content-between text-white-50" style="font-size: 10.5px;">
                                <span>6.0%</span>
                                <span>11.5% (Prime)</span>
                                <span>18.0%</span>
                                <span>22.0%</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 pt-2 border-top" style="border-color: #1e293b !important;">
                            <button type="button" class="btn btn-sm btn-outline-info flex-fill" id="{{ $calcId }}_preset_sme">
                                SME Asset Preset
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success flex-fill" id="{{ $calcId }}_preset_auto">
                                Auto Financing Preset
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-warning flex-fill" id="{{ $calcId }}_preset_commercial">
                                Corporate Preset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Outputs & Summary Column -->
                <div class="col-lg-6 col-12">
                    <div class="p-4 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: #0b1528; border: 1px solid #1e293b;">
                        <div>
                            <h5 class="fw-bold text-white mb-3 pb-2 border-bottom d-flex align-items-center justify-content-between" style="border-color: #1e293b !important; font-size: 14px;">
                                <span><i class="fa-solid fa-chart-pie me-2 text-success"></i> Financing Breakdown</span>
                                <span class="badge rounded-pill bg-success-subtle text-success px-2 py-0.5" style="font-size: 10px;">PROFIT PRE-AGREED</span>
                            </h5>

                            <!-- Monthly Installment Highlight Box -->
                            <div class="p-3.5 rounded-3 mb-3 text-center" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); border: 1px solid #059669;">
                                <span class="text-white-50 d-block mb-1" style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px;">Customer Equal Monthly Installment</span>
                                <h2 class="fw-bold text-white font-monospace mb-1" id="{{ $calcId }}_monthly_installment" style="font-size: 2rem;">
                                    TZS 2,050,000
                                </h2>
                                <small class="text-white-50" style="font-size: 11.5px;">Fixed monthly repayment without compounding interest penalties</small>
                            </div>

                            <!-- Metrics List -->
                            <div class="d-flex flex-column gap-2 mb-3">
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #0f172a; font-size: 13px;">
                                    <span class="text-white-50">Net PBZ Financed Principal:</span>
                                    <span class="fw-bold font-monospace text-white" id="{{ $calcId }}_net_principal">TZS 40,000,000</span>
                                </div>
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #0f172a; font-size: 13px;">
                                    <span class="text-white-50">Total PBZ Murabaha Profit Mark-up:</span>
                                    <span class="fw-bold font-monospace text-success" id="{{ $calcId }}_total_profit">TZS 9,200,000</span>
                                </div>
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #0f172a; font-size: 13px;">
                                    <span class="text-white-50">Total Customer Contract Liability:</span>
                                    <span class="fw-bold font-monospace text-info" id="{{ $calcId }}_total_liability">TZS 49,200,000</span>
                                </div>
                                <div class="d-flex justify-content-between p-2 rounded" style="background: #0f172a; font-size: 13px;">
                                    <span class="text-white-50">Shariah Structure:</span>
                                    <span class="fw-bold text-white">Murabaha Lil Amir Bi Al-Shira</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shariah Seal Note -->
                        <div class="p-3 rounded-2 d-flex align-items-center gap-3" style="background: #092015; border: 1px solid #134e2a;">
                            <i class="fa-solid fa-stamp text-success fa-2x"></i>
                            <div style="font-size: 11.5px; line-height: 1.5;" class="text-white-50">
                                <strong class="text-success d-block">Approved by PBZ Shariah Supervisory Board</strong>
                                Contract guarantees certainty of markup. Under AAOIFI Shariah Standard No. 8, rollover interest or hidden variable fees are strictly prohibited.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amortization Schedule Preview -->
            <div class="mt-4 p-4 rounded-3" style="background: #0b1528; border: 1px solid #1e293b;">
                <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                    <h5 class="fw-bold text-white mb-0" style="font-size: 14px;">
                        <i class="fa-solid fa-table-list me-2 text-info"></i> Repayment Schedule Preview
                    </h5>
                    <span class="badge bg-dark border border-secondary text-white-50" style="font-size: 11px;">First 6 Months Scheduled Tranche</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-dark table-borderless table-sm mb-0 align-middle" style="font-size: 12.5px; background: transparent;">
                        <thead>
                            <tr class="text-white-50 border-bottom" style="border-color: #1e293b !important; font-size: 11px; text-transform: uppercase;">
                                <th class="py-2">Month</th>
                                <th class="py-2">Installment</th>
                                <th class="py-2">Principal Repayment</th>
                                <th class="py-2">Profit Element</th>
                                <th class="py-2 text-end">Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody id="{{ $calcId }}_schedule_body">
                            <!-- Populated dynamically by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function initCalculator() {
        const costInput = document.getElementById('{{ $calcId }}_cost');
        const downInput = document.getElementById('{{ $calcId }}_down');
        const tenorInput = document.getElementById('{{ $calcId }}_tenor');
        const rateInput = document.getElementById('{{ $calcId }}_rate');

        if (!costInput || !downInput || !tenorInput || !rateInput) return;

        function fmtTZS(val) {
            return 'TZS ' + Math.round(val).toLocaleString('en-US');
        }

        function calculate() {
            const cost = parseFloat(costInput.value) || 0;
            const down = parseFloat(downInput.value) || 0;
            const tenor = parseInt(tenorInput.value) || 12;
            const rate = parseFloat(rateInput.value) || 10;

            const netPrincipal = Math.max(0, cost - down);
            const totalProfit = netPrincipal * (rate / 100) * (tenor / 12);
            const totalLiability = netPrincipal + totalProfit;
            const monthlyInstallment = tenor > 0 ? totalLiability / tenor : 0;

            // Update Labels
            const costBadge = document.getElementById('{{ $calcId }}_cost_badge');
            const downBadge = document.getElementById('{{ $calcId }}_down_badge');
            const tenorLabel = document.getElementById('{{ $calcId }}_tenor_label');
            const rateLabel = document.getElementById('{{ $calcId }}_rate_label');

            if (costBadge) costBadge.textContent = fmtTZS(cost);
            if (downBadge) {
                const pct = cost > 0 ? Math.round((down / cost) * 100) : 0;
                downBadge.textContent = `${fmtTZS(down)} (${pct}%)`;
            }
            if (tenorLabel) tenorLabel.textContent = `${tenor} Months (${(tenor/12).toFixed(1)} Yrs)`;
            if (rateLabel) rateLabel.textContent = `${rate.toFixed(1)}% p.a.`;

            // Outputs
            const elMonthly = document.getElementById('{{ $calcId }}_monthly_installment');
            const elNet = document.getElementById('{{ $calcId }}_net_principal');
            const elProfit = document.getElementById('{{ $calcId }}_total_profit');
            const elLiability = document.getElementById('{{ $calcId }}_total_liability');

            if (elMonthly) elMonthly.textContent = fmtTZS(monthlyInstallment);
            if (elNet) elNet.textContent = fmtTZS(netPrincipal);
            if (elProfit) elProfit.textContent = fmtTZS(totalProfit);
            if (elLiability) elLiability.textContent = fmtTZS(totalLiability);

            // Populate table first 6 months
            const tableBody = document.getElementById('{{ $calcId }}_schedule_body');
            if (tableBody) {
                tableBody.innerHTML = '';
                const monthlyPrincipal = tenor > 0 ? netPrincipal / tenor : 0;
                const monthlyProfit = tenor > 0 ? totalProfit / tenor : 0;
                let balance = totalLiability;

                const rowsToShow = Math.min(6, tenor);
                for (let m = 1; m <= rowsToShow; m++) {
                    balance -= monthlyInstallment;
                    const tr = document.createElement('tr');
                    tr.style.borderBottom = '1px solid #1e293b';
                    tr.innerHTML = `
                        <td class="py-2.5 font-monospace text-white-50">Month ${m}</td>
                        <td class="py-2.5 font-monospace text-white fw-bold">${fmtTZS(monthlyInstallment)}</td>
                        <td class="py-2.5 font-monospace text-info">${fmtTZS(monthlyPrincipal)}</td>
                        <td class="py-2.5 font-monospace text-success">${fmtTZS(monthlyProfit)}</td>
                        <td class="py-2.5 font-monospace text-end text-white-50">${fmtTZS(Math.max(0, balance))}</td>
                    `;
                    tableBody.appendChild(tr);
                }
            }
        }

        costInput.addEventListener('input', calculate);
        downInput.addEventListener('input', calculate);
        tenorInput.addEventListener('input', calculate);
        rateInput.addEventListener('input', calculate);

        // Presets
        const btnSME = document.getElementById('{{ $calcId }}_preset_sme');
        const btnAuto = document.getElementById('{{ $calcId }}_preset_auto');
        const btnCorporate = document.getElementById('{{ $calcId }}_preset_commercial');

        if (btnSME) {
            btnSME.onclick = function() {
                costInput.value = 75000000;
                downInput.value = 15000000;
                tenorInput.value = 36;
                rateInput.value = 12.0;
                calculate();
            };
        }
        if (btnAuto) {
            btnAuto.onclick = function() {
                costInput.value = 35000000;
                downInput.value = 7000000;
                tenorInput.value = 24;
                rateInput.value = 11.0;
                calculate();
            };
        }
        if (btnCorporate) {
            btnCorporate.onclick = function() {
                costInput.value = 250000000;
                downInput.value = 50000000;
                tenorInput.value = 48;
                rateInput.value = 10.5;
                calculate();
            };
        }

        calculate();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCalculator);
    } else {
        initCalculator();
    }
})();
</script>

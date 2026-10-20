<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PBZ Academy - Certificate of Completion</title>
    <style>
        @page {
            size: 297mm 210mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Base Typography & Canvas Defaults */
        html, body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            font-family: 'DejaVu Serif', 'Times New Roman', Georgia, serif;
            color: #072818;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @if (!empty($is_pdf))
        /* ========================================================
           STRICT SINGLE-PAGE PDF PRINT ENGINE (DomPDF)
           Strict landscape A4: 297mm x 210mm
           Calculated heights & paddings to strictly prevent page 2
           ======================================================== */
        body {
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        .cert-canvas {
            position: absolute;
            top: 6mm;
            left: 6mm;
            right: 6mm;
            bottom: 6mm;
            border: 6px solid #006837;
            background: #ffffff;
            box-sizing: border-box;
        }

        .cert-inner {
            position: absolute;
            top: 2.5mm;
            left: 2.5mm;
            right: 2.5mm;
            bottom: 2.5mm;
            border: 1.5px solid #d4af37;
            background: #ffffff;
            box-sizing: border-box;
            padding: 6mm 10mm 4mm 10mm;
            text-align: center;
        }

        .crest-pill {
            display: inline-block;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8pt;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #006837;
            text-transform: uppercase;
            padding: 2px 10px;
            border: 1px solid #006837;
            border-radius: 3px;
            background: #f4fbf7;
            margin-bottom: 2mm;
        }

        .bank-name {
            font-size: 20pt;
            font-weight: 700;
            letter-spacing: 2px;
            color: #006837;
            text-transform: uppercase;
            margin-bottom: 1mm;
            line-height: 1.1;
        }

        .academy-name {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8.5pt;
            font-weight: 600;
            letter-spacing: 3px;
            color: #8c6d20;
            text-transform: uppercase;
            margin-bottom: 2mm;
        }

        .gold-rule {
            width: 40%;
            margin: 0 auto 3mm auto;
            border: 0;
            border-top: 1px solid #d4af37;
        }

        .cert-award-title {
            font-size: 20pt;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #072818;
            margin-bottom: 1mm;
            line-height: 1.1;
        }

        .cert-subtitle {
            font-size: 8.5pt;
            font-style: italic;
            color: #4a5d52;
            margin-bottom: 2.5mm;
        }

        .recipient-area {
            margin-bottom: 2.5mm;
        }

        .recipient-name {
            font-size: 23pt;
            font-weight: 700;
            color: #006837;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 2px;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            min-width: 300px;
        }

        .completion-lead {
            font-size: 8.5pt;
            color: #3e4a42;
            margin-bottom: 1.5mm;
        }

        .course-title {
            font-size: 15.5pt;
            font-weight: 700;
            color: #072818;
            margin-bottom: 2mm;
            line-height: 1.2;
        }

        .regulatory-text {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7.5pt;
            color: #5b6e62;
            max-width: 82%;
            margin: 0 auto 3.5mm auto;
            line-height: 1.35;
        }

        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }

        .sig-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .sig-col {
            width: 36%;
        }

        .seal-col {
            width: 28%;
        }

        .sig-line {
            width: 180px;
            margin: 0 auto 3px auto;
            border-top: 1.5px solid #006837;
        }

        .sig-person {
            font-size: 10pt;
            font-weight: 700;
            color: #072818;
            margin-bottom: 1px;
        }

        .sig-title {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7pt;
            color: #607268;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .seal-circle {
            display: inline-block;
            border: 2px solid #8c6d20;
            border-radius: 50%;
            padding: 5px 8px;
            background: #fdfaf0;
        }

        .seal-text {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 6.5pt;
            font-weight: 700;
            color: #006837;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.25;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 2mm;
            border-top: 1px solid #e1e7e3;
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 7.5pt;
            color: #6a7c72;
        }

        .meta-table td {
            padding-top: 2mm;
        }

        @else
        /* ========================================================
           SCREEN PREVIEW ENGINE (Browser / Modal Iframe)
           Styled to perfectly mirror the PDF download without scroll
           ======================================================== */
        html, body {
            width: 100%;
            height: 100%;
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
        }

        .cert-canvas {
            position: relative;
            width: 100%;
            max-width: 820px;
            aspect-ratio: 297 / 210;
            border: 6px solid #006837;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            box-sizing: border-box;
        }

        .cert-inner {
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 2px solid #d4af37;
            background: #ffffff;
            box-sizing: border-box;
            padding: 18px 24px 14px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }

        .crest-pill {
            display: inline-block;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #006837;
            text-transform: uppercase;
            padding: 2px 10px;
            border: 1px solid #006837;
            border-radius: 4px;
            background: #f4fbf7;
            margin-bottom: 4px;
        }

        .bank-name {
            font-size: 21px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #006837;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .academy-name {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            color: #8c6d20;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .gold-rule {
            width: 45%;
            margin: 4px auto 8px auto;
            border: 0;
            border-top: 1px solid #d4af37;
        }

        .cert-award-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #072818;
            margin-bottom: 2px;
            line-height: 1.1;
        }

        .cert-subtitle {
            font-size: 11.5px;
            font-style: italic;
            color: #4a5d52;
            margin-bottom: 6px;
        }

        .recipient-area {
            margin: 4px 0 6px 0;
        }

        .recipient-name {
            font-size: 24px;
            font-weight: 700;
            color: #006837;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 3px;
            border-bottom: 2px solid #d4af37;
            display: inline-block;
            min-width: 300px;
        }

        .completion-lead {
            font-size: 11.5px;
            color: #3e4a42;
            margin-bottom: 3px;
        }

        .course-title {
            font-size: 17px;
            font-weight: 700;
            color: #072818;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .regulatory-text {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 10px;
            color: #5b6e62;
            max-width: 82%;
            margin: 0 auto 8px auto;
            line-height: 1.35;
        }

        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .sig-table td {
            vertical-align: bottom;
            text-align: center;
        }

        .sig-col {
            width: 36%;
        }

        .seal-col {
            width: 28%;
        }

        .sig-line {
            width: 170px;
            margin: 0 auto 4px auto;
            border-top: 1.5px solid #006837;
        }

        .sig-person {
            font-size: 12px;
            font-weight: 700;
            color: #072818;
            margin-bottom: 1px;
        }

        .sig-title {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 9.5px;
            color: #607268;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .seal-circle {
            display: inline-block;
            border: 2px solid #8c6d20;
            border-radius: 50%;
            padding: 6px 12px;
            background: #fdfaf0;
        }

        .seal-text {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 8px;
            font-weight: 700;
            color: #006837;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.25;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            padding-top: 6px;
            border-top: 1px solid #e1e7e3;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 9.5px;
            color: #6a7c72;
        }

        .meta-table td {
            padding-top: 4px;
        }
        @endif
    </style>
</head>

<body>
    @php
        $activeTemplate = $template ?? \App\Models\CertificateTemplate::getDefault();
        $tmplElements = collect($activeTemplate?->elements ?? []);

        $bankNameText = $tmplElements->firstWhere('id', 'el_bank_name')['content'] ?? "People's Bank of Zanzibar";
        $academyNameText = $tmplElements->firstWhere('id', 'el_academy_name')['content'] ?? "PBZ Academy of Banking & Financial Excellence";
        $pillText = $tmplElements->firstWhere('id', 'el_pill')['content'] ?? "Bank of Tanzania (BOT) Regulated";
        $awardTitleText = $tmplElements->firstWhere('id', 'el_cert_title')['content'] ?? "Certificate of Regulatory Achievement";
        $awardSubtitleText = $tmplElements->firstWhere('id', 'el_cert_subtitle')['content'] ?? "This certifies that the recipient has satisfied all proficiency requirements";
        $completionLeadText = $tmplElements->firstWhere('id', 'el_completion_lead')['content'] ?? "has successfully completed the executive banking competency curriculum for";
        $complianceText = $tmplElements->firstWhere('id', 'el_regulatory_text')['content'] ?? "Conducted in accordance with PBZ Sovereign Banking Competency Guidelines and verified compliance standards of the Bank of Tanzania (BOT).";
        
        $sigLeftTitle = $tmplElements->firstWhere('id', 'el_sig_left_title')['content'] ?? "Head of Learning & Development, PBZ Academy";
        $sigRightName = $tmplElements->firstWhere('id', 'el_sig_right_name')['content'] ?? "Araphat A. Haji";
        $sigRightTitle = $tmplElements->firstWhere('id', 'el_sig_right_title')['content'] ?? "Managing Director & CEO, PBZ Bank";
    @endphp

    <div class="cert-canvas" style="@if(!empty($activeTemplate?->background_image) && file_exists(public_path($activeTemplate->background_image))) background-image: url('{{ public_path($activeTemplate->background_image) }}'); background-size: cover; @endif">
        <div class="cert-inner">
            <!-- Header Section -->
            <div>
                <span class="crest-pill">{{ $pillText }}</span>
                <div class="bank-name">{{ $bankNameText }}</div>
                <div class="academy-name">{{ $academyNameText }}</div>
                <hr class="gold-rule">
            </div>

            <!-- Award Title -->
            <div>
                <div class="cert-award-title">{{ $awardTitleText }}</div>
                <div class="cert-subtitle">{{ $awardSubtitleText }}</div>
            </div>

            <!-- Recipient Name -->
            <div class="recipient-area">
                <div class="recipient-name">{{ $student_name }}</div>
            </div>

            <!-- Course Info -->
            <div>
                <div class="completion-lead">{{ $completionLeadText }}</div>
                <div class="course-title">{{ $course_title }}</div>
                <div class="regulatory-text">
                    {{ $complianceText }}
                </div>
            </div>

            <!-- Signatures & Official Gold Seal -->
            <table class="sig-table">
                <tr>
                    <td class="sig-col">
                        <div class="sig-line"></div>
                        <div class="sig-person">{{ $instructor_name }}</div>
                        <div class="sig-title">{{ $sigLeftTitle }}</div>
                    </td>
                    <td class="seal-col">
                        <div class="seal-circle">
                            <div class="seal-text">
                                ★ OFFICIAL SEAL ★<br>
                                PEOPLE'S BANK OF ZANZIBAR<br>
                                ACCREDITED 1966
                            </div>
                        </div>
                    </td>
                    <td class="sig-col">
                        <div class="sig-line"></div>
                        <div class="sig-person">{{ $sigRightName }}</div>
                        <div class="sig-title">{{ $sigRightTitle }}</div>
                    </td>
                </tr>
            </table>

            <!-- Verification Metadata Footer -->
            <table class="meta-table">
                <tr>
                    <td style="text-align: left; width: 33%;">
                        <strong>Certificate No:</strong> {{ $certificate_number }}
                    </td>
                    <td style="text-align: center; width: 34%;">
                        <strong>Date of Issue:</strong> {{ $completion_date }}
                    </td>
                    <td style="text-align: right; width: 33%;">
                        <strong>Verification:</strong> {{ route('verify-certificate', ['code' => $certificate_number]) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>

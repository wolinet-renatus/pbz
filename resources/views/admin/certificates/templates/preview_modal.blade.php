<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->name ?? 'Certificate Preview' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Great+Vibes&family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 16px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        .cert-viewport {
            position: relative;
            background: #ffffff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            width: {{ $template->canvas_width ?? 842 }}px;
            height: {{ $template->canvas_height ?? 595 }}px;
            @if(!empty($template->background_image))
            background-image: url('{{ asset($template->background_image) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            @endif
        }
        .cert-element {
            position: absolute;
            user-select: none;
            display: flex;
            align-items: center;
            word-break: break-word;
        }
        .cert-element.text-left { justify-content: flex-start; }
        .cert-element.text-center { justify-content: center; }
        .cert-element.text-right { justify-content: flex-end; }
        {!! $template->custom_css ?? '' !!}
    </style>
</head>
<body>
    @php
        $elements = $template->elements ?? [];
        $replacements = [
            '{student_name}' => $student_name ?? 'Alice Johnson',
            '{course_title}' => $course_title ?? 'AML / CFT & KYC Regulatory Certification (BOT Compliance 2026)',
            '{instructor_name}' => $instructor_name ?? 'Mwanaidi Ali',
            '{issued_at}' => $completion_date ?? now()->format('F d, Y'),
            '{completion_date}' => $completion_date ?? now()->format('F d, Y'),
            '{certificate_no}' => $certificate_number ?? 'CERT-000108-PBZ966',
            '{certificate_number}' => $certificate_number ?? 'CERT-000108-PBZ966',
            '{verification_code}' => $certificate_number ?? 'CERT-000108-PBZ966',
            '{verify_url}' => $verification_url ?? route('verify-certificate', ['code' => 'CERT-000108-PBZ966']),
            '{site_name}' => $site_name ?? "People's Bank of Zanzibar",
        ];
    @endphp

    <div class="cert-viewport">
        @foreach($elements as $el)
            @php
                $content = $el['content'] ?? '';
                foreach ($replacements as $key => $val) {
                    $content = str_replace($key, $val, $content);
                }

                $fontFamily = 'serif';
                if (($el['font_family'] ?? '') === 'sans-serif' || ($el['font_family'] ?? '') === 'Inter') {
                    $fontFamily = "'Inter', sans-serif";
                } elseif (($el['font_family'] ?? '') === 'cursive' || ($el['font_family'] ?? '') === 'Great Vibes') {
                    $fontFamily = "'Great Vibes', cursive";
                } elseif (($el['font_family'] ?? '') === 'Dancing Script') {
                    $fontFamily = "'Dancing Script', cursive";
                } elseif (($el['font_family'] ?? '') === 'Playfair Display' || ($el['font_family'] ?? '') === 'serif') {
                    $fontFamily = "'Playfair Display', Georgia, serif";
                }

                $textAlign = $el['text_align'] ?? 'center';
            @endphp

            @if(($el['type'] ?? '') === 'line')
                <div class="cert-element" style="
                    left: {{ $el['x'] }}px;
                    top: {{ $el['y'] }}px;
                    width: {{ $el['width'] }}px;
                    height: {{ $el['height'] ?? 2 }}px;
                    border-top: {{ $el['border_width'] ?? 1 }}px solid {{ $el['border_color'] ?? '#d4af37' }};
                    z-index: {{ $el['z_index'] ?? 3 }};
                "></div>
            @elseif(($el['type'] ?? '') === 'box')
                <div class="cert-element" style="
                    left: {{ $el['x'] }}px;
                    top: {{ $el['y'] }}px;
                    width: {{ $el['width'] }}px;
                    height: {{ $el['height'] }}px;
                    border: {{ $el['border_width'] ?? 1 }}px {{ $el['border_style'] ?? 'solid' }} {{ $el['border_color'] ?? '#006837' }};
                    border-radius: {{ $el['border_radius'] ?? 0 }}px;
                    background-color: {{ $el['background_color'] ?? 'transparent' }};
                    z-index: {{ $el['z_index'] ?? 1 }};
                "></div>
            @elseif(($el['type'] ?? '') === 'image' || ($el['type'] ?? '') === 'logo' || ($el['type'] ?? '') === 'signature')
                <div class="cert-element text-{{ $textAlign }}" style="
                    left: {{ $el['x'] }}px;
                    top: {{ $el['y'] }}px;
                    width: {{ $el['width'] }}px;
                    height: {{ $el['height'] }}px;
                    z-index: {{ $el['z_index'] ?? 4 }};
                ">
                    @if(!empty($el['image_url']))
                        <img src="{{ $el['image_url'] }}" alt="{{ $el['label'] ?? 'Certificate Asset' }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @else
                        <img src="{{ asset('assets/front/img/logo/logo.png') }}" alt="PBZ Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    @endif
                </div>
            @elseif(($el['type'] ?? '') === 'qr')
                <div class="cert-element text-{{ $textAlign }}" style="
                    left: {{ $el['x'] }}px;
                    top: {{ $el['y'] }}px;
                    width: {{ $el['width'] }}px;
                    height: {{ $el['height'] }}px;
                    z-index: {{ $el['z_index'] ?? 4 }};
                ">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($replacements['{verify_url}']) }}" alt="QR Code" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
            @else
                <div class="cert-element text-{{ $textAlign }}" style="
                    left: {{ $el['x'] }}px;
                    top: {{ $el['y'] }}px;
                    width: {{ $el['width'] }}px;
                    height: {{ $el['height'] }}px;
                    font-family: {!! $fontFamily !!};
                    font-size: {{ $el['font_size'] ?? 14 }}px;
                    font-weight: {{ $el['font_weight'] ?? 'normal' }};
                    font-style: {{ $el['font_style'] ?? 'normal' }};
                    color: {{ $el['color'] ?? '#072818' }};
                    text-align: {{ $textAlign }};
                    letter-spacing: {{ $el['letter_spacing'] ?? 0 }}px;
                    line-height: {{ $el['line_height'] ?? 1.2 }};
                    @if(!empty($el['background_color'])) background-color: {{ $el['background_color'] }}; @endif
                    @if(!empty($el['border_color'])) border: {{ $el['border_width'] ?? 1 }}px solid {{ $el['border_color'] }}; @endif
                    @if(!empty($el['border_radius'])) border-radius: {{ $el['border_radius'] }}px; @endif
                    @if(!empty($el['border_bottom'])) border-bottom: {{ $el['border_bottom'] }}; @endif
                    z-index: {{ $el['z_index'] ?? 4 }};
                    white-space: pre-line;
                ">{!! nl2br(e($content)) !!}</div>
            @endif
        @endforeach
    </div>
</body>
</html>

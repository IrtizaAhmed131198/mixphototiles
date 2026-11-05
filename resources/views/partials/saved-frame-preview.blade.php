@php
    $config = json_decode($previewProduct->frame_config ?? '{}', true) ?: [];
    $designClass = $config['design']['designClass'] ?? 'classic-card-design';
    $shadowClass = $config['color']['shadowClass'] ?? 'box-shadow-black';
    $imgSrc = $config['color']['img_src'] ?? null;
    $width = (float) ($config['size']['width'] ?? 0);
    $height = (float) ($config['size']['height'] ?? 0);
    // Older records may only have the selected size label.
    if ($width <= 0 || $height <= 0) {
        preg_match_all('/\d+(?:\.\d+)?/', $config['size']['frameSizeText'] ?? '', $dimensions);
        $width = (float) ($dimensions[0][0] ?? 1);
        $height = (float) ($dimensions[0][1] ?? 1);
    }
    $width = max(1, $width);
    $height = max(1, $height);
    $previewWidth = round(340 * min(1, $width / $height), 2);
    $borderStyle = '';
    if ($designClass !== 'frameless-card-design' && $imgSrc) {
        $fullImgUrl = (str_starts_with($imgSrc, 'http') || str_starts_with($imgSrc, '/')) ? $imgSrc : asset($imgSrc);
        $borderStyle = "border-image-source: url('{$fullImgUrl}'); border-image-slice: 30; border-image-repeat: stretch;";
    }
@endphp
<style>
    .frame-main-wrap.saved-frame-preview {
        display: block;
        width: min(100%, var(--saved-preview-width)) !important;
        height: auto !important;
        aspect-ratio: var(--saved-frame-ratio);
        margin: 12px auto;
        box-sizing: border-box;
    }
    .saved-frame-preview .frameborder,
    .saved-frame-preview .frameinner-manual {
        width: 100%; height: 100%; min-width: 0; min-height: 0;
    }
    .saved-frame-preview .frameinner-manual img {
        display: block; width: 100%; height: 100%; object-fit: contain !important;
    }
</style>
<div class="frame-main-wrap {{ $designClass }} {{ $shadowClass }} frame-main-wrap-main saved-frame-preview"
     style="--saved-preview-width: {{ $previewWidth }}px; --saved-frame-ratio: {{ $width }} / {{ $height }}; {{ $borderStyle }}">
    <div class="frameborder inherit-design">
        <div class="frameinner-manual child-inherit-design">
            <img src="{{ asset($previewProduct->image) }}" class="img-fluid" alt="Saved cropped photo">
        </div>
    </div>
</div>
<p class="small text-muted mt-3">Selected size: {{ $config['size']['frameSizeText'] ?? 'Not recorded' }}</p>

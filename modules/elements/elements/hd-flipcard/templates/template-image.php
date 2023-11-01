<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2019-2023 Thomas Weidlich GNU GPL v3 */

// Image
if ($props['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-border-{image_border}' => !$props['panel_style'] || ($props['panel_style'] && (!$props['panel_image_no_padding'] || $props['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',

            'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_image_no_padding'])),
        ],

        'src' => $props['image'],
        'alt' => $props['image_alt'],
        'loading' => $props['image_loading'] ? false : null,
        'width' => $props['image_width'],
        'height' => $props['image_height'],
        'focal_point' => $props['image_focal_point'],
        'uk-svg' => $props['image_svg_inline'],
        'uk-cover' => $props['panel_style'] && $props['panel_image_no_padding'] && in_array($props['image_align'], ['left', 'right']),
        'thumbnail' => true,
    ]);

    echo $image($props, []);

    // Placeholder image if card and layout left or right
    if ($image->attrs['uk-cover']) {
        echo $image($props, [
            'class' => ['uk-invisible'],
            'uk-cover' => false,
        ]);
    }

// Icon
} elseif ($props['icon']) {

    $icon = $this->el('span', [

        'class' => [
            'el-image',
            'uk-text-{icon_color}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_image_no_padding'])),
        ],

        'uk-icon' => [
            'icon: {icon};',
            'width: {icon_width};',
            'height: {icon_width};',
        ],

    ]);

    echo $icon($props, '');
}

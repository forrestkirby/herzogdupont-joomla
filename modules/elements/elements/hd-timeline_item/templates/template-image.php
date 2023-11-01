<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2019-2023 Thomas Weidlich GNU GPL v3 */

// Image
if ($props['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-transition-{image_transition} uk-transition-opaque' => $props['link'] && ($element['image_link'] || $element['panel_link']),

            'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
        ],

        'src' => $props['image'],
        'alt' => $props['image_alt'],
        'loading' => $element['image_loading'] ? false : null,
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'focal_point' => $props['image_focal_point'],
        'uk-svg' => $element['image_svg_inline'],
        'uk-cover' => $element['panel_style'] && $element['panel_image_no_padding'] && in_array($element['image_align'], ['left', 'right']),
        'thumbnail' => true,
    ]);

    if (!$element['image_transition'] && !$element['image_transition_border']) {
        $image->attr([

            'class' => [
                'uk-border-{image_border}' => !$element['panel_style'] || ($element['panel_style'] && (!$element['panel_image_no_padding'] || $element['image_align'] == 'between')),
                'uk-box-shadow-{image_box_shadow} {@!panel_style}',
                'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style}' => $props['link'] && ($element['image_link'] || $element['panel_link']),

                'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_image_no_padding'])),
            ],
        
        ]);
    }

    echo $image($element, []);

    // Placeholder image if card and layout left or right
    if ($image->attrs['uk-cover']) {
        echo $image($element, [
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
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_image_no_padding'])),
        ],

        'uk-icon' => [
            'icon: {0};' => $props['icon'],
            'width: {icon_width};',
            'height: {icon_width};',
        ],

    ]);

    echo $icon($element, '');
}

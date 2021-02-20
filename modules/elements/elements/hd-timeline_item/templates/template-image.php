<?php

// Image
if ($props['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-border-{image_border} {@!image_transition}' => !$element['panel_style'] || ($element['panel_style'] && (!$element['panel_card_image'] || $element['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style} {@!image_transition}',
            'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style} {@!image_transition}' => $props['link'] && ($element['image_link'] || $element['panel_link']),
            'uk-transition-{image_transition} uk-transition-opaque' => $props['link'] && ($element['image_link'] || $element['panel_link']),

            'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration} {@!image_transition}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_card_image'])),
        ],

        'src' => $props['image'],
        'alt' => $props['image_alt'],
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'uk-svg' => $element['image_svg_inline'],
        'uk-cover' => $element['panel_style'] && $element['panel_card_image'] && in_array($element['image_align'], ['left', 'right']),
        'thumbnail' => true,
    ]);

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
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_card_image'])),
        ],

        'uk-icon' => [
            'icon: {0};' => $props['icon'],
            'width: {icon_width};',
            'height: {icon_width};',
        ],

    ]);

    echo $icon($element, '');
}

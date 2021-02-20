<?php

// Image
if ($props['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-border-{image_border}' => !$props['panel_style'] || ($props['panel_style'] && (!$props['panel_card_image'] || $props['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',

            'uk-text-{image_svg_color} {@image_svg_inline}' => $this->isImage($props['image']) == 'svg',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_card_image'])),
        ],

        'src' => $props['image'],
        'alt' => $props['image_alt'],
        'width' => $props['image_width'],
        'height' => $props['image_height'],
        'uk-svg' => $props['image_svg_inline'],
        'uk-cover' => $props['panel_style'] && $props['panel_card_image'] && in_array($props['image_align'], ['left', 'right']),
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
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_card_image'])),
        ],

        'uk-icon' => [
            'icon: {icon};',
            'width: {icon_width};',
            'height: {icon_width};',
        ],

    ]);

    echo $icon($props, '');
}

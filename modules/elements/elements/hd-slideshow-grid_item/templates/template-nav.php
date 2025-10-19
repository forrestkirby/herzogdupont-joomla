<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2024 YOOtheme GmbH, 2021-2024 Thomas Weidlich GNU GPL v3 */

$nav = $this->el('ul', [

    'class' => [

        'el-nav',
        'uk-{nav} [uk-flex-nowrap {@nav: thumbnav} {@thumbnav_nowrap}]',

        // Alignment
        'uk-flex-{nav_align} {@nav_below}',

        // Vertical
        'uk-{nav}-vertical {@nav_vertical} {@!nav_below}',

        // Wrapping
        'uk-flex-right {@!nav_vertical} {@!nav_below} {@nav_position: .*-right}',
        'uk-flex-center {@!nav_vertical} {@!nav_below} {@nav_position: bottom-center}',
    ],

    'uk-margin' => !$element['nav_vertical'],
]);

$container = $this->el('div', [

    'class' => [

        // Margin
        'uk-margin[-{nav_margin}]-top {@nav_below}',

        // Color
        'uk-{nav_color} {@nav_below}',

        // Position
        'uk-position-{nav_position} {@!nav_below}',

        // Margin
        'uk-position-{nav_position_margin} {@!nav_below}',

        // Text Color
        'uk-{text_color} {@!nav_below}',

        // Breakpoint
        'uk-visible@{nav_breakpoint}',
    ],

]);

?>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
<?= $container($element) ?>
<?php endif ?>

<?= $nav($element, $element['nav_below'] && !$element['nav_color'] ? $container->attrs : []) ?>
    <?php for($i = 1, $j = 0; $i <= 4; $i++) :

        // Image
        $image = $this->el('image', [
            'class' => [
                'uk-text-{thumbnav_svg_color}' => $element['thumbnav_svg_inline'] && $element['thumbnav_svg_color'] && $this->isImage($props['thumbnail_' . $i] ?: $props['image_' . $i]) == 'svg',
            ],
            'src' => $props['thumbnail_' . $i] ?: $props['image_' . $i],
            'alt' => $props['image_' . $i . '_alt'],
            'loading' => $element['image_loading'] ? false : null,
            'width' => $element['thumbnav_width'],
            'height' => $element['thumbnav_height'],
            'focal_point' => $props["thumbnail_$i"] ? $props["thumbnail_{$i}_focal_point"] : $props["image_{$i}_focal_point"],
            'uk-svg' => (bool) $element['thumbnav_svg_inline'],
            'thumbnail' => true,
        ]);

        $thumbnail = $image->attrs['src'] && $element['nav'] == 'thumbnav' ? $image($element) : '';
    ?>
    <?php if ($props['image_' . $i] || $props['video_' . $i]) : ?>
    <li uk-slideshow-item="<?= $j++ ?>">
        <a href="#"><?= $thumbnail ?></a>
    </li>
    <?php endif ?>
    <?php endfor ?>
</ul>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
</div>
<?php endif ?>

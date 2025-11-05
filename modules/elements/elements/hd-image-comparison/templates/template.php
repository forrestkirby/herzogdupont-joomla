<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2020-2025 Thomas Weidlich GNU GPL v3 */

$uniqid = uniqid('hd-');

$el = $this->el('div', [

    'class' => [
        'uk-inverse-{text_color}',
    ],

]);

// Image Before
$image_before = $this->el('image', [

    'class' => [
        'el-image-before',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
    ],

    'src' => $props['image_before'],
    'alt' => $props['image_before_alt'],
    'loading' => $props['image_loading'] ? false : null,
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'focal_point' => $props['image_before_focal_point'],
    'thumbnail' => true,
]);

// Image After
$image_after = $this->el('image', [

    'class' => [
        'el-image-after',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
    ],

    'src' => $props['image_after'],
    'alt' => $props['image_after_alt'],
    'loading' => $props['image_loading'] ? false : null,
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'focal_point' => $props['image_after_focal_point'],
    'thumbnail' => true,
]);

// Range
$range = $this->el('input', [

    'class' => [
        'hd-image-comparison-range',
    ],

    'type' => 'range',
    'min' => 0,
    'max' => 100,
    'aria-label' => $props['slider_aria_label'],

]);

// Slider
$slider = $this->el('div', [

    'class' => [
        'hd-image-comparison-slider',
        'uk-text-{icon_color}',
        'uk-background-{slider_background}',
    ],

    'uk-icon' => [
        'icon: {icon};',
        'width: {icon_width}; height: {icon_width}',
    ],

    'data-start' => [
        '{slider_start}',
    ],

    'data-width' => [
        '{icon_width}',
    ],

    'data-onmousemove' => [
        '{slider_onmousemove}',
    ],

    'data-margin-remove' => [
        '{slider_margin_remove}',
    ],

]);

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <style>
    #<?= $uniqid ?> .hd-image-comparison-range::-webkit-slider-thumb {
        height: <?= $props['icon_width'] ?>px;
        width: <?= $props['icon_width'] ?>px;
    }
    #<?= $uniqid ?> .hd-image-comparison-range::-moz-range-thumb {
        height: <?= $props['icon_width'] ?>px;
        width: <?= $props['icon_width'] ?>px;
    }
    </style>

    <?php if ($props['image_before'] && $props['image_after']) : ?>
    <div id ="<?= $uniqid ?>" class="hd-image-comparison">
        <?php if ($props['image_box_decoration']) : ?>
        <?= $decoration($props) ?>
        <?php endif ?>
            <div class="hd-image-comparison-after">
                <?php if ($props['show_image_labels'] && $props['image_after_label']) : ?>
                <div class="hd-image-comparison-after-label"><?= $props['image_after_label'] ?></div>
                <?php endif ?>
                <?= $image_after($props) ?>
            </div>
            <div class="hd-image-comparison-before">
                <?php if ($props['show_image_labels'] && $props['image_before_label']) : ?>
                <div class="hd-image-comparison-before-label"><?= $props['image_before_label'] ?></div>
                <?php endif ?>
                <?= $image_before($props) ?>
            </div>
        <?php if ($props['image_box_decoration']) : ?>
        <?= $decoration->end() ?>
        <?php endif ?>
        <?= $range($props) ?>
        <?= $slider($props) ?></div>
    </div>
    <?php elseif ($props['image_before']) : ?>
        <?php if ($props['image_box_decoration']) : ?>
        <?= $decoration($props, $image_before($props)) ?>
        <?php else : ?>
        <?= $image_before($props) ?>
        <?php endif ?>
    <?php elseif ($props['image_after']) : ?>
        <?php if ($props['image_box_decoration']) : ?>
        <?= $decoration($props, $image_after($props)) ?>
        <?php else : ?>
        <?= $image_after($props) ?>
        <?php endif ?>
    <?php endif ?>

</div>

<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2020�2022 Thomas Weidlich GNU GPL v3 */

$uniqid = uniqid('hd-');

$el = $this->el('div');

// Image Before
$image_before = $this->el('image', [

    'class' => [
        'el-image-before',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
    ],

    'src' => $props['image_before'],
    'alt' => $props['image_before_alt'],
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'thumbnail' => true,
    'target' => $props['position'] === 'absolute' ? '!*' : '',
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
    'width' => $props['image_width'],
    'height' => $props['image_height'],
    'thumbnail' => true,
    'target' => $props['position'] === 'absolute' ? '!*' : '',
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
            <div class="hd-image-comparison-after"><?= $image_after($props) ?></div>
            <div class="hd-image-comparison-before"><?= $image_before($props) ?></div>
        <?php if ($props['image_box_decoration']) : ?>
        <?= $decoration->end() ?>
        <?php endif ?>
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

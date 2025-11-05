<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2025 YOOtheme GmbH, 2021-2025 Thomas Weidlich GNU GPL v3 */

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

if (!$element['show_image']) { $props['image_1'] = $props['image_2'] = $props['image_3'] = $props['video_1'] = $props['video_2'] = $props['video_3'] = ''; }

// Override default settings
$element['panel_style'] = $props['panel_style'] ?: $element['panel_style'];
if ($element['grid_masonry']) {
    $element['panel_expand'] = '';
}

// Image
$image = trim($this->render("{$__dir}/template-slideshow", compact('props')));

// New logic shortcuts
$element['has_panel_image_no_padding'] = $image && (!$element['panel_style'] || $element['panel_image_no_padding']) && $element['image_align'] != 'between';
$element['has_no_padding'] = !$element['panel_style'] && (!$image || ($image && $element['image_align'] == 'between'));

// Panel/Card/Tile
$el = $this->el($props['item_element'] ?: 'div', [

    'class' => [
        'el-item',
        'uk-margin-auto uk-width-{item_maxwidth}',
        'uk-panel [uk-{panel_style: tile-.*}] {@panel_style: |tile-.*}',
        'uk-card uk-{panel_style: card-.*} [uk-card-{!panel_padding: |default}]',
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-margin-remove-first-child' => !in_array($element['image_align'], ['left', 'right']) || !($element['panel_padding'] && $element['has_panel_image_no_padding']),
        'uk-flex {@panel_style} {@has_panel_image_no_padding} {@image_align: left|right}', // Let images cover the card/tile height if they have different heights
    ],

]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $element['panel_style'] && $element['has_panel_image_no_padding']
            ? 'uk-grid-collapse uk-grid-match'
            : ($element['image_grid_column_gap'] == $element['image_grid_row_gap']
                ? 'uk-grid-{image_grid_column_gap}'
                : '[uk-grid-column-{image_grid_column_gap}] [uk-grid-row-{image_grid_row_gap}]'),
        'uk-flex-middle {@image_vertical_align}' => !($element['panel_style'] && $element['panel_image_no_padding']),
        'uk-flex-1 {@panel_expand}',
    ],

    'uk-grid' => true,
]);

$cell_image = $this->el('div', [

    'class' => [
        'uk-width-{image_grid_width}[@{image_grid_breakpoint}]',
        'uk-flex-last[@{image_grid_breakpoint}] {@image_align: right}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@has_panel_image_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@has_panel_image_no_padding}',
        'uk-margin-remove-first-child {@panel_padding} {@has_panel_image_no_padding}',
        // 1 Column Content Width
        'uk-container uk-container-{panel_content_width}' => $image && $element['image_align'] == 'top' && !$element['panel_style'] && !$element['panel_padding'] && !$element['item_maxwidth'] && (!$element['grid_default'] || $element['grid_default'] == '1') && (!$element['grid_small'] || $element['grid_small'] == '1') && (!$element['grid_medium'] || $element['grid_medium'] == '1') && (!$element['grid_large'] || $element['grid_large'] == '1') && (!$element['grid_xlarge'] || $element['grid_xlarge'] == '1'),
        'uk-flex-1 uk-flex uk-flex-column {@panel_expand}',
        'uk-margin-remove-first-child {@panel_expand}' => !$image,
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => !($element['panel_padding'] && $element['has_panel_image_no_padding']),
        'uk-flex uk-flex-middle {@image_vertical_align}' => $element['panel_style'] && $element['panel_image_no_padding'],
        'uk-flex {@panel_expand}',
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($element['panel_style'] && $element['has_panel_image_no_padding']) {
    $image = $this->el('div', [

        'class' => [
            'uk-card-media-{image_align} {@panel_style: card-.*}',
            'uk-cover-container{@image_align: left|right}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_align} uk-card-media-top; mode: media; media: @{image_grid_breakpoint} {@image_align: left|right} {@panel_style: card-.*}',
        ],

    ], $image)->render($element);
}

?>

<?= $el($element, $attrs) ?>

    <?php if ($image && in_array($element['image_align'], ['left', 'right'])) : ?>

        <?= $grid($element) ?>
            <?= $cell_image($element, $image) ?>
            <?= $cell_content($element) ?>

                <?php if ($this->expr($content->attrs['class'], $element)) : ?>
                    <?= $content($element, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
                <?php else : ?>
                    <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
                <?php endif ?>

            <?= $cell_content->end() ?>
        </div>

    <?php else : ?>

        <?php if ($element['image_align'] == 'top') : ?>
        <?= $image ?>
        <?php endif ?>

        <?php if ($this->expr($content->attrs['class'], $element)) : ?>
            <?= $content($element, $this->render("{$__dir}/template-content", compact('props', 'image', 'link'))) ?>
        <?php else : ?>
            <?= $this->render("{$__dir}/template-content", compact('props', 'image', 'link')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $image ?>
        <?php endif ?>

    <?php endif ?>

<?= $el->end() ?>

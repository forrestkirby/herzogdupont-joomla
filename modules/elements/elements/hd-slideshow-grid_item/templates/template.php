<?php

/* Herzog Dupont Copyright (C) 2016–2021 YOOtheme GmbH, 2021 Thomas Weidlich GNU GPL v3 */

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

if (!$element['show_image']) { $props['image_1'] = $props['image_2'] = $props['image_3'] = $props['video_1'] = $props['video_2'] = $props['video_3'] = ''; }

// Override default settings
$element['panel_style'] = $props['panel_style'] ?: $element['panel_style'];

// New logic shortcuts
$element['has_image'] = $props['image_1'] || $props['image_2'] || $props['image_3'] || $props['video_1'] || $props['video_2'] || $props['video_3'];
$element['has_panel_card_image'] = $element['has_image'] && $element['panel_card_image'] && ($element['image_align'] != 'left' || $element['image_align'] != 'right' || $element['image_align'] != 'between');
$element['has_content_padding'] = $element['has_image'] && $element['panel_content_padding'] && $element['image_align'] != 'between';

// Image
$image = $this->render("{$__dir}/template-slideshow", compact('props'));

// Panel/Card
$el = $this->el('div', [

    'class' => [
        'el-item',
        'uk-margin-auto uk-width-{item_maxwidth}',
        'uk-panel {@!panel_style}',
        'uk-card uk-{panel_style} [uk-card-{panel_size}]',
        'uk-card-body {@panel_style} {@!has_panel_card_image}',
        'uk-margin-remove-first-child' => (!$element['panel_style'] && !$element['has_content_padding']) || ($element['panel_style'] && !$element['has_panel_card_image']),
    ],

]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $element['panel_style'] && $element['has_panel_card_image']
            ? 'uk-grid-collapse uk-grid-match'
            : ($element['image_grid_column_gap'] == $element['image_grid_row_gap']
                ? 'uk-grid-{image_grid_column_gap}'
                : '[uk-grid-column-{image_grid_column_gap}] [uk-grid-row-{image_grid_row_gap}]'),
        'uk-flex-middle {@image_vertical_align}',
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
        'uk-card-body uk-margin-remove-first-child {@panel_style} {@has_panel_card_image}',
        'uk-padding[-{!panel_content_padding: |default}] uk-margin-remove-first-child {@!panel_style} {@has_content_padding}',
        // 1 Column Content Width
        'uk-container uk-container-{panel_content_width}' => $element['has_image'] && $element['image_align'] == 'top' && !$element['panel_style'] && !$element['panel_content_padding'] && !$element['item_maxwidth'] && (!$element['grid_default'] || $element['grid_default'] == '1') && (!$element['grid_small'] || $element['grid_small'] == '1') && (!$element['grid_medium'] || $element['grid_medium'] == '1') && (!$element['grid_large'] || $element['grid_large'] == '1') && (!$element['grid_xlarge'] || $element['grid_xlarge'] == '1'),
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => (!$element['panel_style'] && !$element['has_content_padding']) || ($element['panel_style'] && !$element['has_panel_card_image']),
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($element['panel_style'] && $element['has_panel_card_image']) {
    $image = $this->el('div', [
        
        'class' => [
            'uk-card-media-{image_align}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_align} uk-card-media-top; mode: media; media: @{image_grid_breakpoint} {@image_align: left|right}',
        ],

    ], $image)->render($element);
}

?>

<?= $el($element, $attrs) ?>

    <?php if ($element['has_image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

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

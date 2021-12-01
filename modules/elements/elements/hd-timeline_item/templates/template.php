<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016–2021 YOOtheme GmbH, 2019–2021 Thomas Weidlich GNU GPL v3 */

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

if (!$element['show_image']) { $props['image'] = $props['icon'] = ''; }

// Resets
if ($props['icon'] && !$props['image']) { $element['panel_image_no_padding'] = ''; }

// Override default settings
$element['panel_style'] = $props['panel_style'] ?: $element['panel_style'];

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));

// New logic shortcuts
$element['has_panel_image_no_padding'] = $props['image'] && (!$element['panel_style'] || $element['panel_image_no_padding']) && $element['image_align'] != 'between';
$element['has_no_padding'] = !$element['panel_style'] && (!$props['image'] || ($props['image'] && $element['image_align'] == 'between'));

// Transition
if ($element['image_transition']) {

    $transition_toggle = $this->el('div', [
        'class' => [
            'uk-inline-clip [uk-transition-toggle {@image_link}]',
            'uk-border-{image_border}' => !$element['panel_style'] || ($element['panel_style'] && (!$element['panel_image_no_padding'] || $element['image_align'] == 'between')),
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',
            'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style}' => $props['link'] && ($element['image_link'] || $element['panel_link']),
            'uk-margin[-{image_margin}]-top {@!image_margin: remove} {@!image_box_decoration}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_image_no_padding'])),
        ],
    ]);
    $props['image'] = $transition_toggle($element, $props['image']);

}

// Decoration
if ($props['image'] && $element['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $element['image_align'] == 'between' || ($element['image_align'] == 'bottom' && !($element['panel_style'] && $element['panel_image_no_padding'])),
        ],

    ]);

    $props['image'] = $decoration($element, $props['image']);
}

// Timeline icon
$props['timeline_icon'] = $this->render("{$__dir}/template-timeline_icon", compact('props'));

// Panel/Card/Tile
$el = $this->el($props['link'] && $element['panel_link'] ? 'a' : 'div', [

    'class' => [
        'el-item',
        'uk-margin-auto uk-width-{item_maxwidth}',
        'uk-panel [uk-{panel_style: tile-.*}] {@panel_style: |tile-.*}',
        'uk-card uk-{panel_style: card-.*} [uk-card-{!panel_padding: |default}]',
        'uk-tile-hover {@panel_style: tile-.*} {@panel_link}' => $props['link'],
        'uk-card-hover {@!panel_style: |card-hover|tile-.*} {@panel_link}' => $props['link'],
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-margin-remove-first-child' => !in_array($element['image_align'], ['left', 'right']) || !($element['panel_padding'] && $element['has_panel_image_no_padding']),
        'uk-flex {@panel_style} {@has_panel_image_no_padding} {@image_align: left|right}', // Let images cover the card/tile height if they have different heights
        'uk-transition-toggle {@image_transition} {@panel_link}' => $props['image'],
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
        'uk-container uk-container-{panel_content_width}' => $props['image'] && $element['image_align'] == 'top' && !$element['panel_style'] && !$element['panel_padding'] && !$element['item_maxwidth'] && (!$element['grid_default'] || $element['grid_default'] == '1') && (!$element['grid_small'] || $element['grid_small'] == '1') && (!$element['grid_medium'] || $element['grid_medium'] == '1') && (!$element['grid_large'] || $element['grid_large'] == '1') && (!$element['grid_xlarge'] || $element['grid_xlarge'] == '1'),
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => !($element['panel_padding'] && $element['has_panel_image_no_padding']),
        'uk-flex uk-flex-middle {@image_vertical_align}' => $element['panel_style'] && $element['panel_image_no_padding'],
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($element['panel_style'] && $element['has_panel_image_no_padding']) {
    $props['image'] = $this->el('div', [

        'class' => [
            'uk-card-media-{image_align} {@panel_style: card-.*}',
            'uk-cover-container{@image_align: left|right}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_align} uk-card-media-top; mode: media; media: @{image_grid_breakpoint} {@image_align: left|right} {@panel_style: card-.*}',
        ],

    ], $props['image'])->render($element);
}

?>

<?= $props['timeline_icon'] ?>

<div class="hd-timeline-item-container">

<?= $el($element, $attrs) ?>

    <?php if ($props['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

        <?= $grid($element) ?>
            <?= $cell_image($element, $props['image']) ?>
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
        <?= $props['image'] ?>
        <?php endif ?>

        <?php if ($this->expr($content->attrs['class'], $element)) : ?>
            <?= $content($element, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
        <?php else : ?>
            <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $props['image'] ?>
        <?php endif ?>

    <?php endif ?>

<?= $el->end() ?>

</div>
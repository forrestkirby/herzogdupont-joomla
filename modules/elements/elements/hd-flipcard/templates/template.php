<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2019-2023 Thomas Weidlich GNU GPL v3 */

// Front
// Resets
if ($props['icon'] && !$props['image']) { $props['panel_image_no_padding'] = ''; }
if ($props['panel_style'] || !$props['image']) { $props['image_box_decoration'] = ''; }

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));

// New logic shortcuts
$props['has_panel_image_no_padding'] = $props['image'] && (!$props['panel_style'] || $props['panel_image_no_padding']) && $props['image_align'] != 'between';
$props['has_no_padding'] = !$props['panel_style'] && (!$props['image'] || ($props['image'] && $props['image_align'] == 'between'));

// Decoration
if ($props['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_image_no_padding'])),
        ],

    ]);

    $props['image'] = $decoration($props, $props['image']);
}

// Panel/Card/Tile
$front = $this->el('div', [

    'class' => [
        'el-card',
        'uk-panel [uk-{panel_style: tile-.*}] {@panel_style: |tile-.*}',
        'uk-card uk-{panel_style: card-.*} [uk-card-{!panel_padding: |default}]',
        'uk-padding[-{!panel_padding: default}] {@panel_style: |tile-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-card-body {@panel_style: card-.*} {@panel_padding} {@!has_panel_image_no_padding} {@!has_no_padding}',
        'uk-margin-remove-first-child' => !in_array($props['image_align'], ['left', 'right']) || !($props['panel_padding'] && $props['has_panel_image_no_padding']),
        'uk-flex {@panel_style} {@has_panel_image_no_padding} {@image_align: left|right}', // Let images cover the card/tile height if they have different heights
    ],
]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_style'] && $props['has_panel_image_no_padding']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_grid_column_gap'] == $props['image_grid_row_gap']
                ? 'uk-grid-{image_grid_column_gap}'
                : '[uk-grid-column-{image_grid_column_gap}] [uk-grid-row-{image_grid_row_gap}]'),
        'uk-flex-middle {@image_vertical_align}' => !($props['panel_style'] && $props['panel_image_no_padding']),
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
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => !($props['panel_padding'] && $props['has_panel_image_no_padding']),
        'uk-flex uk-flex-middle {@image_vertical_align}' => $props['panel_style'] && $props['panel_image_no_padding'],
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($props['panel_style'] && $props['has_panel_image_no_padding']) {
    $props['image'] = $this->el('div', [

        'class' => [
            'uk-card-media-{image_align} {@panel_style: card-.*}',
            'uk-cover-container{@image_align: left|right}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_align} uk-card-media-top; mode: media; media: @{image_grid_breakpoint} {@image_align: left|right} {@panel_style: card-.*}',
        ],

    ], $props['image'])->render($props);
}

// Back
// Resets
if ($props['icon_back'] && !$props['image_back']) { $props['panel_back_image_no_padding'] = ''; }
if ($props['panel_back_style'] || !$props['image_back']) { $props['image_back_box_decoration'] = ''; }
if ($props['panel_back_link']) {
    $props['title_back_link'] = '';
    $props['image_back_link'] = '';
}

// Image
$props['image_back'] = $this->render("{$__dir}/template-image_back", compact('props'));

// New logic shortcuts
$props['has_panel_back_image_no_padding'] = $props['image_back'] && (!$props['panel_back_style'] || $props['panel_back_image_no_padding']) && $props['image_back_align'] != 'between';
$props['has_no_back_padding'] = !$props['panel_back_style'] && (!$props['image_back'] || ($props['image_back'] && $props['image_back_align'] == 'between'));

// Transition
if ($props['image_back_transition']) {

    $transition_toggle = $this->el('div', [
        'class' => [
            'uk-inline-clip [uk-transition-toggle {@image_back_link}]',
            'uk-border-{image_back_border}' => !$props['panel_back_style'] || ($props['panel_back_style'] && (!$props['panel_back_image_no_padding'] || $props['image_back_align'] == 'between')),
            'uk-box-shadow-{image_back_box_shadow} {@!panel_back_style}',
            'uk-box-shadow-hover-{image_back_hover_box_shadow} {@!panel_back_style} {@link_back}' => $props['image_back_link'] || $props['panel_back_link'],
            'uk-margin[-{image_back_margin}]-top {@!image_back_margin: remove} {@!image_back_box_decoration}' => $props['image_back_align'] == 'between' || ($props['image_back_align'] == 'bottom' && !($props['panel_back_style'] && $props['panel_back_image_no_padding'])),
        ],
    ]);
    $props['image'] = $transition_toggle($props, $props['image']);

}

// Decoration
if ($props['image_back_box_decoration']) {

    $decoration_back = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_back_box_decoration: shadow}',
            'tm-mask-default {@image_back_box_decoration: mask}',
            'tm-box-decoration-{image_back_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_back_box_decoration_inverse} {@image_back_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_back_box_decoration: |shadow}',
            'uk-margin[-{image_back_margin}]-top {@!image_back_margin: remove}' => $props['image_back_align'] == 'between' || ($props['image_back_align'] == 'bottom' && !($props['panel_back_style'] && $props['panel_back_image_no_padding'])),
        ],

    ]);

    $props['image_back'] = $decoration_back($props, $props['image_back']);
}

// Panel/Card/Tile
$back = $this->el($props['link_back'] && $props['panel_back_link'] ? 'a' : 'div', [

    'class' => [
        'el-card-back',
        'uk-panel [uk-{panel_back_style: tile-.*}] {@panel_back_style: |tile-.*}',
        'uk-card uk-{panel_back_style: card-.*} [uk-card-{!panel_back_padding: |default}]',
        'uk-tile-hover {@panel_back_style: tile-.*} {@panel_back_link} {@link_back}',
        'uk-card-hover {@!panel_back_style: |card-hover|tile-.*} {@panel_back_link} {@link_back}',
        'uk-padding[-{!panel_back_padding: default}] {@panel_back_style: |tile-.*} {@panel_back_padding} {@!has_panel_back_image_no_padding} {@!has_no_back_padding}',
        'uk-card-body {@panel_back_style: card-.*} {@panel_back_padding} {@!has_panel_back_image_no_padding} {@!has_no_back_padding}',
        'uk-margin-remove-first-child' => !in_array($props['image_back_align'], ['left', 'right']) || !($props['panel_back_padding'] && $props['has_panel_back_image_no_padding']),
        'uk-flex {@panel_back_style} {@has_panel_back_image_no_padding} {@image_back_align: left|right}', // Let images cover the card/tile height if they have different heights
        'uk-transition-toggle {@image_back} {@image_back_transition} {@panel_back_link}',
    ],
]);

// Image align
$grid_back = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_back_style'] && $props['has_panel_back_image_no_padding']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_back_grid_column_gap'] == $props['image_back_grid_row_gap']
                ? 'uk-grid-{image_back_grid_column_gap}'
                : '[uk-grid-column-{image_back_grid_column_gap}] [uk-grid-row-{image_back_grid_row_gap}]'),
        'uk-flex-middle {@image_back_vertical_align}' => !($props['panel_back_style'] && $props['panel_back_image_no_padding']),
    ],

    'uk-grid' => true,
]);

$cell_image_back = $this->el('div', [

    'class' => [
        'uk-width-{image_back_grid_width}[@{image_back_grid_breakpoint}]',
        'uk-flex-last[@{image_back_grid_breakpoint}] {@image_back_align: right}',
    ],

]);

// Content
$content_back = $this->el('div', [

    'class' => [
        'uk-padding[-{!panel_back_padding: default}] {@panel_back_style: |tile-.*} {@panel_back_padding} {@has_panel_back_image_no_padding}',
        'uk-card-body {@panel_back_style: card-.*} {@panel_back_padding} {@has_panel_back_image_no_padding}',
        'uk-margin-remove-first-child {@panel_back_padding} {@has_panel_back_image_no_padding}',
    ],

]);

$cell_content_back = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => !($props['panel_back_padding'] && $props['has_panel_back_image_no_padding']),
        'uk-flex uk-flex-middle {@image_back_vertical_align}' => $props['panel_back_style'] && $props['panel_back_image_no_padding'],
    ],

]);

// Link
$link_back = include "{$__dir}/template-link_back.php";

// Card media
if ($props['panel_back_style'] && $props['has_panel_back_image_no_padding']) {
    $props['image_back'] = $this->el('div', [

        'class' => [
            'uk-card-media-{image_back_align} {@panel_back_style: card-.*}',
        	'uk-cover-container{@image_back_align: left|right}',
        ],

        'uk-toggle' => [
            'cls: uk-card-media-{image_back_align} uk-card-media-top; mode: media; media: @{image_back_grid_breakpoint} {@image_back_align: left|right} {@panel_back_style: card-.*}',
        ],

    ], $props['image_back'])->render($props);
}

// Container
$el = $this->el($props['html_element'] ?: 'div', [

    'class' => [
        'hd-flipcard',
        'hd-flipcard-{flip_animation}',
        'hd-flipcard-3d {@3d_effect}',

        // Expand to column height
        'uk-flex-1 {@height_expand}',
    ],

    'data-flipmode' => [
        '{flip_mode}',
    ],

    'data-flipmodetouch' => [
        '{flip_mode_touch}',
    ],

]);

// Inner
$inner = $this->el('div', [

    'class' => [
        'hd-flipcard-inner',
    ],

]);

?>

<?= $el($props, $attrs) ?>

    <?= $inner ?>

        <?= $front($props) ?>

            <?php if ($props['image'] && in_array($props['image_align'], ['left', 'right'])) : ?>

                <?= $grid($props) ?>
                    <?= $cell_image($props, $props['image']) ?>
                    <?= $cell_content($props) ?>

                        <?php if ($this->expr($content->attrs['class'], $props)) : ?>
                            <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
                        <?php else : ?>
                            <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
                        <?php endif ?>

                    <?= $cell_content->end() ?>
                </div>

            <?php else : ?>

                <?php if ($props['image_align'] == 'top') : ?>
                <?= $props['image'] ?>
                <?php endif ?>

                <?php if ($this->expr($content->attrs['class'], $props)) : ?>
                    <?= $content($props, $this->render("{$__dir}/template-content", compact('props', 'link'))) ?>
                <?php else : ?>
                    <?= $this->render("{$__dir}/template-content", compact('props', 'link')) ?>
                <?php endif ?>

                <?php if ($props['image_align'] == 'bottom') : ?>
                <?= $props['image'] ?>
                <?php endif ?>

            <?php endif ?>

        <?= $front->end() ?>

        <?= $back($props) ?>

            <?php if ($props['image_back'] && in_array($props['image_back_align'], ['left', 'right'])) : ?>

                <?= $grid_back($props) ?>
                    <?= $cell_image_back($props, $props['image_back']) ?>
                    <?= $cell_content_back($props) ?>

                        <?php if ($this->expr($content_back->attrs['class'], $props)) : ?>
                            <?= $content_back($props, $this->render("{$__dir}/template-content_back", compact('props', 'link_back'))) ?>
                        <?php else : ?>
                            <?= $this->render("{$__dir}/template-content_back", compact('props', 'link_back')) ?>
                        <?php endif ?>

                    <?= $cell_content_back->end() ?>
                </div>

            <?php else : ?>

                <?php if ($props['image_back_align'] == 'top') : ?>
                <?= $props['image_back'] ?>
                <?php endif ?>

                <?php if ($this->expr($content_back->attrs['class'], $props)) : ?>
                    <?= $content_back($props, $this->render("{$__dir}/template-content_back", compact('props', 'link_back'))) ?>
                <?php else : ?>
                    <?= $this->render("{$__dir}/template-content_back", compact('props', 'link_back')) ?>
                <?php endif ?>

                <?php if ($props['image_back_align'] == 'bottom') : ?>
                <?= $props['image_back'] ?>
                <?php endif ?>

            <?php endif ?>

        <?= $back->end() ?>

    <?= $inner->end() ?>

<?= $el->end() ?>

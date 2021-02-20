<?php

// Front
// Resets
if ($props['icon'] && !$props['image']) { $props['panel_card_image'] = ''; }
if ($props['panel_style'] || !$props['image']) { $props['image_box_decoration'] = ''; }

// New logic shortcuts
$props['has_panel_card_image'] = $props['image'] && $props['panel_card_image'] && $props['image_align'] != 'between';
$props['has_panel_content_padding'] = $props['image'] && $props['panel_content_padding'] && $props['image_align'] != 'between';

// Image
$props['image'] = $this->render("{$__dir}/template-image", compact('props'));



if ($props['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
            'uk-margin[-{image_margin}]-top {@!image_margin: remove}' => $props['image_align'] == 'between' || ($props['image_align'] == 'bottom' && !($props['panel_style'] && $props['panel_card_image'])),
        ],

    ]);

    $props['image'] = $decoration($props, $props['image']);
}

// Panel/Card
$front = $this->el('div', [

    'class' => [
        'el-card',
        'uk-panel {@!panel_style}',
        'uk-card uk-{panel_style} [uk-card-{panel_size}]',
        'uk-card-hover {@!panel_style: |card-hover}',
        'uk-card-body {@panel_style} {@!has_panel_card_image}',
        'uk-margin-remove-first-child' => (!$props['panel_style'] && !$props['has_panel_content_padding']) || ($props['panel_style'] && !$props['has_panel_card_image']),
    ],

]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_style'] && $props['has_panel_card_image']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_grid_column_gap'] == $props['image_grid_row_gap']
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
        'uk-padding[-{!panel_content_padding: |default}] uk-margin-remove-first-child {@!panel_style} {@has_panel_content_padding}',
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => (!$props['panel_style'] && !$props['has_panel_content_padding']) || ($props['panel_style'] && !$props['has_panel_card_image']),
    ],

]);

// Link
$link = include "{$__dir}/template-link.php";

// Card media
if ($props['panel_style'] && $props['has_panel_card_image']) {
    $props['image'] = $this->el('div', ['class' => [
        'uk-card-media-{image_align}',
        'uk-cover-container{@image_align: left|right}',
    ]], $props['image'])->render($props);
}

// Back
// Resets
if ($props['icon_back'] && !$props['image_back']) { $props['panel_back_card_image'] = ''; }
if ($props['panel_back_style'] || !$props['image_back']) { $props['image_back_box_decoration'] = ''; }
if ($props['panel_back_link']) {
    $props['title_back_link'] = '';
    $props['image_back_link'] = '';
}

// New logic shortcuts
$props['has_panel_back_card_image'] = $props['image_back'] && $props['panel_back_card_image'] && $props['image_back_align'] != 'between';
$props['has_panel_back_content_padding'] = $props['image_back'] && $props['panel_back_content_padding'] && $props['image_back_align'] != 'between';

// Image
$props['image_back'] = $this->render("{$__dir}/template-image_back", compact('props'));

if ($props['image_back_transition']) {

    $transition_toggle = $this->el('div', [
        'class' => [
            'uk-inline-clip [uk-transition-toggle {@image_back_link}]',
            'uk-border-{image_back_border}' => !$props['panel_back_style'] || ($props['panel_back_style'] && (!$props['panel_back_card_image'] || $props['image_back_align'] == 'between')),
            'uk-box-shadow-{image_back_box_shadow} {@!panel_back_style}',
            'uk-box-shadow-hover-{image_back_hover_box_shadow} {@!panel_back_style} {@link_back}' => $props['image_back_link'] || $props['panel_back_link'],
            'uk-margin[-{image_back_margin}]-top {@!image_back_margin: remove} {@!image_back_box_decoration}' => $props['image_back_align'] == 'between' || ($props['image_back_align'] == 'bottom' && !($props['panel_back_style'] && $props['panel_back_card_image'])),
        ],
    ]);
    $props['image'] = $transition_toggle($props, $props['image']);

}

if ($props['image_back_box_decoration']) {

    $decoration_back = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_back_box_decoration: shadow}',
            'tm-mask-default {@image_back_box_decoration: mask}',
            'tm-box-decoration-{image_back_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_back_box_decoration_inverse} {@image_back_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_back_box_decoration: |shadow}',
            'uk-margin[-{image_back_margin}]-top {@!image_back_margin: remove}' => $props['image_back_align'] == 'between' || ($props['image_back_align'] == 'bottom' && !($props['panel_back_style'] && $props['panel_back_card_image'])),
        ],

    ]);

    $props['image_back'] = $decoration_back($props, $props['image_back']);
}

// Panel/Card
$back = $this->el($props['link_back'] && $props['panel_back_link'] ? 'a' : 'div', [

    'class' => [
        'el-card-back',
        'uk-panel {@!panel_back_style}',
        'uk-card uk-{panel_back_style} [uk-card-{panel_back_size}]',
        'uk-card-hover {@!panel_back_style: |card-hover} {@panel_back_link} {@link_back}',
        'uk-card-body {@panel_back_style} {@!has_panel_back_card_image}',
        'uk-margin-remove-first-child' => (!$props['panel_back_style'] && !$props['has_panel_back_content_padding']) || ($props['panel_back_style'] && !$props['has_panel_back_card_image']),
        'uk-transition-toggle {@image_back} {@image_back_transition} {@panel_back_link}',
    ],

]);

// Image align
$grid_back = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['panel_back_style'] && $props['has_panel_back_card_image']
            ? 'uk-grid-collapse uk-grid-match'
            : ($props['image_back_grid_column_gap'] == $props['image_back_grid_row_gap']
                ? 'uk-grid-{image_back_grid_column_gap}'
                : '[uk-grid-column-{image_back_grid_column_gap}] [uk-grid-row-{image_back_grid_row_gap}]'),
        'uk-flex-middle {@image_back_vertical_align}',
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
        'uk-card-body uk-margin-remove-first-child {@panel_back_style} {@has_panel_back_card_image}',
        'uk-padding[-{!panel_back_content_padding: |default}] uk-margin-remove-first-child {@!panel_back_style} {@has_panel_back_content_padding}',
    ],

]);

$cell_content_back = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child' => (!$props['panel_back_style'] && !$props['has_panel_back_content_padding']) || ($props['panel_back_style'] && !$props['has_panel_back_card_image']),
    ],

]);

// Link
$link_back = include "{$__dir}/template-link_back.php";

// Card media
if ($props['panel_back_style'] && $props['has_panel_back_card_image']) {
    $props['image_back'] = $this->el('div', ['class' => [
        'uk-card-media-{image_back_align}',
        'uk-cover-container{@image_back_align: left|right}',
    ]], $props['image_back'])->render($props);
}

// Container
$el = $this->el('div', [

    'class' => [
        'hd-flipcard',
        'hd-flipcard-{flip_animation}',
        'hd-flipcard-3d {@3d_effect}',
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

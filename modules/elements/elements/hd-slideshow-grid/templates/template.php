<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2024 YOOtheme GmbH, 2021-2024 Thomas Weidlich GNU GPL v3 */

$el = $this->el('div', [

    'uk-filter' => $tags ? [
        'target: .js-filter;',
        'animation: {filter_animation};',
    ] : false,

]);

// Grid
$grid = $this->el('div', [

    'class' => [
        'js-filter' => $tags,
        'uk-child-width-[1-{@!grid_default: auto}]{grid_default}',
        'uk-child-width-[1-{@!grid_small: auto}]{grid_small}@s',
        'uk-child-width-[1-{@!grid_medium: auto}]{grid_medium}@m',
        'uk-child-width-[1-{@!grid_large: auto}]{grid_large}@l',
        'uk-child-width-[1-{@!grid_xlarge: auto}]{grid_xlarge}@xl',
        'uk-flex-center {@grid_column_align}',
        'uk-flex-middle {@grid_row_align}',
        $props['grid_column_gap'] == $props['grid_row_gap'] ? 'uk-grid-{grid_column_gap}' : '[uk-grid-column-{grid_column_gap}] [uk-grid-row-{grid_row_gap}]',
        'uk-grid-divider {@grid_divider} {@!grid_column_gap:collapse} {@!grid_row_gap:collapse}',
        'uk-grid-match {@!grid_masonry}',
    ],

    'uk-grid' => $this->expr([
        'masonry: {grid_masonry};',
        'parallax: {grid_parallax};',
        'parallax-justify: true {grid_parallax} {grid_parallax_justify};',
    ], $props) ?: true,

]);

// Filter
$filter_grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['filter_grid_column_gap'] == $props['filter_grid_row_gap'] ? 'uk-grid-{filter_grid_column_gap}' : '[uk-grid-column-{filter_grid_column_gap}] [uk-grid-row-{filter_grid_row_gap}]',
    ],

    'uk-grid' => true,
]);

$filter_cell = $this->el('div', [

    'class' => [
        'uk-width-{filter_grid_width}@{filter_grid_breakpoint}',
        'uk-flex-last@{filter_grid_breakpoint} {@filter_position: right}',
    ],

]);

?>

<?php if ($tags) : ?>
<?= $el($props, $attrs) ?>

    <?php if ($filter_horizontal = in_array($props['filter_position'], ['left', 'right'])) : ?>
    <?= $filter_grid($props) ?>
        <?= $filter_cell($props) ?>
    <?php endif ?>

        <?= $this->render("{$__dir}/template-nav", compact('props')) ?>

    <?php if ($filter_horizontal) : ?>
        </div>
        <div>
    <?php endif ?>

        <?= $grid($props) ?>
        <?php foreach ($children as $child) : ?>
        <?= $this->el('div', ['data-tag' => $child->tags], $builder->render($child, ['element' => $props])) ?>
        <?php endforeach ?>
        </div>

    <?php if ($filter_horizontal) : ?>
        </div>
    </div>
    <?php endif ?>

</div>
<?php else : ?>
<?= $el($props, $attrs) ?>

    <?= $grid($props) ?>
    <?php foreach ($children as $child) : ?>
    <div><?= $builder->render($child, ['element' => $props]) ?></div>
    <?php endforeach ?>
    </div>

</div>
<?php endif ?>

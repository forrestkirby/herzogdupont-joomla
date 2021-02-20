<?php

// Title
$title = $this->el($props['title_element'], [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-card-title {@panel_style} {@!title_style}',
        'uk-heading-{title_decoration}',
        'uk-font-{title_font_family}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove}',
        'uk-margin-remove-top {@title_margin: remove}',
        'uk-margin-remove-bottom',
    ],

]);

// Meta
$meta = $this->el($props['meta_element'], [

    'class' => [
        'el-meta',
        'uk-[text-{@meta_style: meta}]{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{meta_margin: remove}-top]' => !in_array($props['meta_style'], ['', 'meta']) || $props['meta_element'] != 'div',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-panel',
        'uk-text-{content_style}',
        '[uk-text-left{@content_align}]',
        'uk-dropcap {@content_dropcap}',
        'uk-column-{content_column}[@{content_column_breakpoint}]',
        'uk-column-divider {@content_column} {@content_column_divider}',
        'uk-margin[-{content_margin}]-top {@!content_margin: remove}',
    ],

]);

// Link
$link_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_margin}]-top {@!link_margin: remove}',
    ],

]);

// Title Grid
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['title_grid_column_gap'] == $props['title_grid_row_gap'] ? 'uk-grid-{title_grid_column_gap}' : '[uk-grid-column-{title_grid_column_gap}] [uk-grid-row-{title_grid_row_gap}]',
        'uk-margin[-{title_margin}]-top {@!title_margin: remove} {@image_align: top}' => !$props['meta'] || $props['meta_align'] != 'above-title',
        'uk-margin[-{meta_margin}]-top {@!meta_margin: remove} {@image_align: top} {@meta} {@meta_align: above-title}',
    ],

    'uk-grid' => true,
]);

$cell_title = $this->el('div', [

    'class' => [
        'uk-width-{title_grid_width}[@{title_grid_breakpoint}]',
        'uk-margin-remove-first-child',
    ],

]);

$cell_content = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child',
    ],

]);

?>

<?php if ($props['title'] && $props['title_align'] == 'left') : ?>
<?= $grid($props) ?>
    <?= $cell_title($props) ?>
<?php endif ?>

        <?php if ($props['meta'] && $props['meta_align'] == 'above-title') : ?>
        <?= $meta($props, $props['meta']) ?>
        <?php endif ?>

        <?php if ($props['title']) : ?>
        <?= $title($props) ?>
            <?php if ($props['title_color'] == 'background') : ?>
            <span class="uk-text-background"><?= $props['title'] ?></span>
            <?php elseif ($props['title_decoration'] == 'line') : ?>
            <span><?= $props['title'] ?></span>
            <?php else : ?>
            <?= $props['title'] ?>
            <?php endif ?>
        <?= $title->end() ?>
        <?php endif ?>

        <?php if ($props['meta'] && $props['meta_align'] == 'below-title') : ?>
        <?= $meta($props, $props['meta']) ?>
        <?php endif ?>

    <?php if ($props['title'] && $props['title_align'] == 'left') : ?>
    <?= $cell_title->end() ?>
    <?= $cell_content($props) ?>
    <?php endif ?>

        <?php if ($props['image_align'] == 'between') : ?>
        <?= $props['image'] ?>
        <?php endif ?>

        <?php if ($props['meta'] && $props['meta_align'] == 'above-content') : ?>
        <?= $meta($props, $props['meta']) ?>
        <?php endif ?>

        <?php if ($props['content']) : ?>
        <?= $content($props, $props['content']) ?>
        <?php endif ?>

        <?php if ($props['meta'] && $props['meta_align'] == 'below-content') : ?>
        <?= $meta($props, $props['meta']) ?>
        <?php endif ?>

        <?php if ($props['link_text']) : ?>
        <?= $link_container($props, $link($props, $props['link_text'])) ?>
        <?php endif ?>

<?php if ($props['title'] && $props['title_align'] == 'left') : ?>
    <?= $cell_content->end() ?>
<?= $grid->end() ?>
<?php endif ?>
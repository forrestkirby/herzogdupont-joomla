<?php

// Title
$title_back = $this->el($props['title_back_element'], [

    'class' => [
        'el-title-back',
        'uk-{title_back_style}',
        'uk-card-title {@panel_back_style} {@!title_back_style}',
        'uk-heading-{title_back_decoration}',
        'uk-font-{title_back_font_family}',
        'uk-text-{title_back_color} {@!title_back_color: background}',
        'uk-margin[-{title_back_margin}]-top {@!title_back_margin: remove}',
        'uk-margin-remove-top {@title_back_margin: remove}',
        'uk-margin-remove-bottom',
    ],

]);

// Meta
$meta_back = $this->el($props['meta_back_element'], [

    'class' => [
        'el-meta-back',
        'uk-[text-{@meta_back_style: meta}]{meta_back_style}',
        'uk-text-{meta_back_color}',
        'uk-margin[-{meta_back_margin}]-top {@!meta_back_margin: remove}',
        'uk-margin-remove-bottom [uk-margin-{meta_back_margin: remove}-top]' => !in_array($props['meta_back_style'], ['', 'meta']) || $props['meta_back_element'] != 'div',
    ],

]);

// Content
$content_back = $this->el('div', [

    'class' => [
        'el-content-back uk-panel',
        'uk-text-{content_back_style}',
        '[uk-text-left{@content_back_align}]',
        'uk-dropcap {@content_back_dropcap}',
        'uk-column-{content_back_column}[@{content_back_column_breakpoint}]',
        'uk-column-divider {@content_back_column} {@content_back_column_divider}',
        'uk-margin[-{content_back_margin}]-top {@!content_back_margin: remove}',
    ],

]);

// Link
$link_back_container = $this->el('div', [

    'class' => [
        'uk-margin[-{link_back_margin}]-top {@!link_back_margin: remove}',
    ],

]);

// Title Grid
$grid_back = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $props['title_back_grid_column_gap'] == $props['title_back_grid_row_gap'] ? 'uk-grid-{title_back_grid_column_gap}' : '[uk-grid-column-{title_back_grid_column_gap}] [uk-grid-row-{title_back_grid_row_gap}]',
        'uk-margin[-{title_back_margin}]-top {@!title_back_margin: remove} {@image_back_align: top}' => !$props['meta_back'] || $props['meta_back_align'] != 'above-title',
        'uk-margin[-{meta_back_margin}]-top {@!meta_back_margin: remove} {@image_back_align: top} {@meta_back} {@meta_back_align: above-title}',
    ],

    'uk-grid' => true,
]);

$cell_title_back = $this->el('div', [

    'class' => [
        'uk-width-{title_back_grid_width}[@{title_back_grid_breakpoint}]',
        'uk-margin-remove-first-child',
    ],

]);

$cell_content_back = $this->el('div', [

    'class' => [
        'uk-margin-remove-first-child',
    ],

]);

?>

<?php if ($props['title_back'] && $props['title_back_align'] == 'left') : ?>
<?= $grid_back($props) ?>
    <?= $cell_title_back($props) ?>
<?php endif ?>

        <?php if ($props['meta_back'] && $props['meta_back_align'] == 'above-title') : ?>
        <?= $meta_back($props, $props['meta_back']) ?>
        <?php endif ?>

        <?php if ($props['title_back']) : ?>
        <?= $title_back($props) ?>
            <?php if ($props['title_back_color'] == 'background') : ?>
            <span class="uk-text-background"><?= $props['title_back'] ?></span>
            <?php elseif ($props['title_back_decoration'] == 'line') : ?>
            <span><?= $props['title_back'] ?></span>
            <?php else : ?>
            <?= $props['title_back'] ?>
            <?php endif ?>
        <?= $title_back->end() ?>
        <?php endif ?>

        <?php if ($props['meta_back'] && $props['meta_back_align'] == 'below-title') : ?>
        <?= $meta_back($props, $props['meta_back']) ?>
        <?php endif ?>

    <?php if ($props['title_back'] && $props['title_back_align'] == 'left') : ?>
    <?= $cell_title_back->end() ?>
    <?= $cell_content_back($props) ?>
    <?php endif ?>

        <?php if ($props['image_back_align'] == 'between') : ?>
        <?= $props['image_back'] ?>
        <?php endif ?>

        <?php if ($props['meta_back'] && $props['meta_back_align'] == 'above-content') : ?>
        <?= $meta_back($props, $props['meta_back']) ?>
        <?php endif ?>

        <?php if ($props['content_back']) : ?>
        <?= $content_back($props, $props['content_back']) ?>
        <?php endif ?>

        <?php if ($props['meta_back'] && $props['meta_back_align'] == 'below-content') : ?>
        <?= $meta_back($props, $props['meta_back']) ?>
        <?php endif ?>

        <?php if ($props['link_back'] && $props['link_back_text']) : ?>
        <?= $link_back_container($props, $link_back($props, $props['link_back_text'])) ?>
        <?php endif ?>

<?php if ($props['title_back'] && $props['title_back_align'] == 'left') : ?>
    <?= $cell_content_back->end() ?>
<?= $grid_back->end() ?>
<?php endif ?>
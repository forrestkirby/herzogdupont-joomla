<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2022 YOOtheme GmbH, 2021-2022 Thomas Weidlich GNU GPL v3 */

// => gallery
$nav = $this->el('ul', [

    'class' => [
        'el-nav',
        'uk-{filter_style} {@filter_style: tab}',
        'uk-margin[-{filter_margin}] {@filter_position: top}',
    ],

    'uk-scrollspy-class' => in_array($props['animation'], ['none', 'parallax']) || !$props['item_animation'] ? false : (!empty($props['animation'])
                            ? ['uk-animation-{0}' => $props['animation']]
                            : true),

]);

$nav_horizontal = [
    'uk-subnav {@filter_style: subnav.*}',
    'uk-{filter_style}  {@filter_style: subnav-.*}',
    'uk-flex-{filter_align: right|center}',
    'uk-child-width-expand {@filter_align: justify}',
];

$nav_vertical = [
    'uk-nav uk-nav-{0} [uk-text-left {@text_align}] {@filter_style: subnav.*}' => $props['filter_style_primary'] ? 'primary' : 'default',
    'uk-tab-{filter_position} {@filter_style: tab}',
];

$nav_attrs = $props['filter_position'] === 'top'
    ? ['class' => $nav_horizontal]
    : [
        'class' => $nav_vertical,
        'uk-toggle' => [
            "cls: {$this->expr(array_merge($nav_vertical, $nav_horizontal), $props)};",
            'mode: media;',
            'media: @{filter_grid_breakpoint};',
        ],
    ];

?>

<?= $nav($props, $nav_attrs) ?>

    <?php if ($props['filter_all']) : ?>
    <li class="uk-active" uk-filter-control><a href="#"><?= $this->trans($props['filter_all_label'] ?: 'All') ?></a></li>
    <?php endif ?>

    <?php foreach ($tags as $tag => $name) : ?>
    <?php $selector = htmlspecialchars("[data-tag~='" . str_replace("'", "\'", $tag) . "']", ENT_QUOTES, null, false) ?>
    <li <?= $tag === key($tags) && !$props['filter_all'] ? 'class="uk-active" ' : '' ?>uk-filter-control="<?= $selector ?>">
        <a href="#"><?= $name ?></a>
    </li>
    <?php endforeach ?>

</ul>

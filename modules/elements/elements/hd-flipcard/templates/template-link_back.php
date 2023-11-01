<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2019-2023 Thomas Weidlich GNU GPL v3 */

$link_back = $props['link_back'] ? $this->el('a', [
    'href' => ['{link_back}'],
    'aria-label' => ['{link_back_aria_label}'],
    'target' => ['_blank {@link_back_target}'],
    'uk-scroll' => str_starts_with((string) $props['link_back'], '#'),
]) : null;

if ($link_back && $props['panel_back_link']) {

    $back->attr($link_back->attrs + [

        'class' => [
            'uk-link-toggle',
            // Only if `uk-flex` is not already set in `template.php` to let images cover the card height if the cards have different heights
            'uk-display-block' => !($props['panel_back_style'] && $props['has_panel_back_image_no_padding'] && in_array($props['image_back_align'], ['left', 'right'])),
        ],

    ]);

    $props['title_back'] = $this->striptags($props['title_back']);
    $props['meta_back'] = $this->striptags($props['meta_back']);
    $props['content_back'] = $this->striptags($props['content_back']);

    if ($props['title_back'] && $props['title_back_hover_style'] != 'reset') {
        $props['title_back'] = $this->el('span', [
            'class' => [
                'uk-link-{title_back_hover_style: heading}',
                'uk-link {!title_back_hover_style}',
            ],
        ], $props['title_back'])->render($props);
    }

}

if ($link_back && $props['title_back'] && $props['title_back_link']) {

    $props['title_back'] = $link_back($props, [
        'class' => [
            'uk-link-{title_back_hover_style}',
        ],
    ], $this->striptags($props['title_back']));

}

if ($link_back && $props['image_back'] && $props['image_back_link']) {

    $props['image_back'] = $link_back($props, ['class' => [

        'uk-display-block' => $props['panel_back_style'] && $props['has_panel_back_image_no_padding'] && in_array($props['image_back_align'], ['left', 'right']),

    ]], $props['image_back']);

}

if ($link_back && $props['link_back_text']) {

    if ($props['panel_back_link']) {
        $link_back = $this->el('div');
    }

    $link_back->attr([

        'class' => [
            'el-link-back',
            'uk-{link_back_style: link-(muted|text)}',
            'uk-button uk-button-{!link_back_style: |link-muted|link-text} [uk-button-{link_back_size}] [uk-width-1-1 {@link_back_fullwidth}]',
            // Keep link style if panel link
            'uk-link {@link_back_style:} {@panel_back_link}',
            'uk-text-muted {@link_back_style: link-muted} {@panel_back_link}',
        ],

    ]);

}

return $link_back;

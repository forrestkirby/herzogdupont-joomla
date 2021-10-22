<?php

/* Herzog Dupont Copyright (C) 2016–2021 YOOtheme GmbH, 2019–2021 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

/**
 * @var ImageProvider $imageProvider
 */
$imageProvider = app(ImageProvider::class);

$link = $props['link'] ? $this->el('a', [
    'href' => $props['link'],
]) : null;

if ($link) {

    $link->attr([
        'target' => ['_blank {@link_target}'],
        'uk-scroll' => str_starts_with((string) $props['link'], '#'),
    ]);

}

if ($link && $element['panel_link']) {

    $el->attr($link->attrs + [

        'class' => [
            'uk-link-toggle',
            // Only if `uk-flex` is not already set in `template.php` to let images cover the card height if the cards have different heights
            'uk-display-block' => !($element['panel_style'] && $element['has_panel_card_image'] && in_array($element['image_align'], ['left', 'right'])),
        ],

    ]);

    $props['title'] = $this->striptags($props['title']);
    $props['meta'] = $this->striptags($props['meta']);
    $props['content'] = $this->striptags($props['content']);

    if ($props['title'] && $element['title_hover_style'] != 'reset') {
        $props['title'] = $this->el('span', [
            'class' => [
                'uk-link-{title_hover_style: heading}',
                'uk-link {!title_hover_style}',
            ],
        ], $props['title'])->render($element);
    }

}

if ($link && $props['title'] && $element['title_link']) {

    $props['title'] = $link($element, [
        'class' => [
            'uk-link-{title_hover_style}',
        ],
    ], $this->striptags($props['title']));

}

if ($link && $props['image'] && $element['image_link']) {

    $props['image'] = $link($element, ['class' => [

        'uk-display-block' => $element['panel_style'] && $element['has_panel_card_image'] && in_array($element['image_align'], ['left', 'right']),

    ]], $props['image']);

}

if ($link && ($props['link_text'] || $element['link_text'])) {

    if ($element['panel_link']) {
        $link = $this->el('div');
    }

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
            // Keep link style if panel link
            'uk-link {@link_style:} {@panel_link}',
            'uk-text-muted {@link_style: link-muted} {@panel_link}',
        ],

    ]);

}

return $link;

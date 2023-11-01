<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2021-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

$link = $props['link'] ? $this->el('a', [
    'href' => $props['link'],
    'aria-label' => $props['link_aria_label'] ?: $element['link_aria_label'],
]) : null;

if ($link && $props['title'] && $element['title_link']) {

    $props['title'] = $link($element, [
        'class' => [
            'uk-link-{title_hover_style}',
        ],
    ], $this->striptags($props['title']));

}

if ($link && ($props['link_text'] || $element['link_text'])) {

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
        ],

    ]);

}

return $link;

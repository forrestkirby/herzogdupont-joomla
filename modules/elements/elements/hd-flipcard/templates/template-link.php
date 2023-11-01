<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2019-2023 Thomas Weidlich GNU GPL v3 */

$link = $props['link_text'] ? $this->el('p', [
    //
]) : null;

if ($link) {

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}] [uk-width-1-1 {@link_fullwidth}]',
        ],

    ]);

}

return $link;

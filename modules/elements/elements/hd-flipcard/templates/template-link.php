<?php

$link = $props['link_text'] ? $this->el('p', [
    //
]) : null;

if ($link && $props['link_text']) {

    $link->attr([

        'class' => [
            'el-link',
            'uk-{link_style: link-(muted|text)}',
            'uk-button uk-button-{!link_style: |link-muted|link-text} [uk-button-{link_size}]',
        ],

    ]);

}

return $link;

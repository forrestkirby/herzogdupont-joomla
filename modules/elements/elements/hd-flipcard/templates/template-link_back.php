<?php

$link_back = $props['link_back'] ? $this->el('a', [
    'href' => ['{link_back}'],
    'target' => ['_blank {@link_back_target}'],
    'uk-scroll' => strpos($props['link_back'], '#') === 0,
]) : null;

if ($link_back && $props['panel_back_link']) {

    $back->attr($link_back->attrs + [

        'class' => [
            'uk-display-block uk-link-toggle',
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

        'uk-display-block' => $props['panel_back_style'] && $props['has_panel_back_card_image'] && in_array($props['image_back_align'], ['left', 'right']),

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
            'uk-button uk-button-{!link_back_style: |link-muted|link-text} [uk-button-{link_back_size}]',
        ],

    ]);

}

return $link_back;

<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2021-2023 Thomas Weidlich GNU GPL v3 */

$slidenav = $this->el('a', [

    'class' => [
        'el-slidenav',
        'uk-slidenav-large {@slidenav_large}',
        'uk-position-{slidenav_margin} {@slidenav: default|outside}',
    ],

    'href' => '#', // WordPress Preview reloads if `href` is empty
]);

$attrs_slidenav_next = [

    'class' => [
        'uk-position-center-right {@slidenav: default}',
        'uk-position-center-right-out {@slidenav: outside}',
    ],

    'uk-slidenav-next' => true,
    'uk-slideshow-item' => 'next',
    'uk-toggle' => [
        'cls: uk-position-center-right-out uk-position-center-right; mode: media; media: @{slidenav_outside_breakpoint} {@slidenav: outside}',
    ],

];

$attrs_slidenav_previous = [

    'class' => [
        'uk-position-center-left {@slidenav: default}',
        'uk-position-center-left-out {@slidenav: outside}',
    ],

    'uk-slidenav-previous' => true,
    'uk-slideshow-item' => 'previous',
    'uk-toggle' => [
        'cls: uk-position-center-left-out uk-position-center-left; mode: media; media: @{slidenav_outside_breakpoint} {@slidenav: outside}',
    ],

];

$el = $this->el('div', [

    'class' => [

        // Hover
        'uk-hidden-hover uk-hidden-touch {@slidenav_hover}',

        // Breakpoint
        'uk-visible@{slidenav_breakpoint}',
        'uk-slidenav-container uk-position-{!slidenav: default|outside} [uk-position-{slidenav_margin}]',

        // Color
        'uk-{slidenav_color} {@!outsideColor}',
        'js-color-state uk-{slidenav_outside_color} {@!slidenav_color}{@outsideColor}',
        'js-color-state {@!slidenav_outside_color}{@outsideColor}',
    ],

]);

// Color
if ($element['slidenav'] == 'outside' && $element['text_color'] != $element['slidenav_outside_color']) {

    if (!$element['text_color']) {
        $el->attr('uk-toggle', ['cls: js-color-state uk-{slidenav_outside_color}; mode: media; media: @{slidenav_outside_breakpoint}']);
        $el->attr('class', ['js-color-state uk-{slidenav_outside_color}']);
    } elseif (!$element['slidenav_outside_color']) {
        $el->attr('uk-toggle', ['cls: js-color-state uk-{text_color}; mode: media; media: @{slidenav_outside_breakpoint}']);
        $el->attr('class', ['js-color-state']);
    } else {
        $el->attr('uk-toggle', ['cls: uk-{slidenav_outside_color} uk-{text_color}; mode: media; media: @{slidenav_outside_breakpoint}']);
        $el->attr('class', ['uk-{slidenav_outside_color}']);
    }

} else {
    $el->attr('class', ['uk-{text_color}']);
}

echo $el($element, $slidenav($element, $attrs_slidenav_previous, '') . $slidenav($element, $attrs_slidenav_next, ''));

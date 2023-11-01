<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            // Don't render element if content fields are empty
            return (Str::length($node->props['btn_label']) || $node->props['icon']) && (Str::length($node->props['content']) || Str::length($node->props['content2']) || Str::length($node->props['target']));
        },
    ],

    'updates' => [
        '2.4.15' => function ($node) {
            if (Arr::get($node->props, 'btn_size') === 'uk-button-small') {
                $node->props['btn_size'] = 'small';
            }

            if (Arr::get($node->props, 'btn_size') === 'uk-button-large') {
                $node->props['btn_size'] = 'large';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-default') {
                $node->props['btn_style'] = 'default';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-primary') {
                $node->props['btn_style'] = 'primary';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-secondary') {
                $node->props['btn_style'] = 'secondary';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-danger') {
                $node->props['btn_style'] = 'danger';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-text') {
                $node->props['btn_style'] = 'text';
            }

            if (Arr::get($node->props, 'btn_style') === 'uk-button-link') {
                $node->props['btn_style'] = 'link';
            }
        },
    ],
];

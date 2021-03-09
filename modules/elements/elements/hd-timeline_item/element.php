<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return Str::length($node->props['title'])
                || Str::length($node->props['meta'])
                || Str::length($node->props['content'])
                || $node->props['image']
                || $node->props['icon'];

        },

    ],

    'updates' => [

        '2.1.0-beta.0.1' => function ($node) {

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

            if (!empty($node->props['timeline_icon_ratio'])) {
                $node->props['timeline_icon_width'] = round(20 * $node->props['timeline_icon_ratio']);
                unset($node->props['timeline_icon_ratio']);
            }

        },

    ]

];

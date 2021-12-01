<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016–2021 YOOtheme GmbH, 2021 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return Str::length($node->props['title']) ||
                Str::length($node->props['meta']) ||
                Str::length($node->props['content']) ||
                $node->props['image_1'] ||
                $node->props['video_1'] ||
                $node->props['image_2'] ||
                $node->props['video_2'] ||
                $node->props['image_3'] ||
                $node->props['video_3'];
        },
    ],
];

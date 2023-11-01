<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2021-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node, $params) {
            // Display
            foreach (['title', 'meta', 'content', 'link', 'image', 'thumbnail'] as $key) {
                if (!$params['parent']->props["show_{$key}"]) {
                    $node->props[$key] = '';
                    if ($key === 'image') {
                        $node->props['image_1'] = '';
                        $node->props['video_1'] = '';
                        $node->props['image_2'] = '';
                        $node->props['video_2'] = '';
                        $node->props['image_3'] = '';
                        $node->props['video_3'] = '';
                    }
                    if ($key === 'thumbnail') {
                        $node->props['thumbnail_1'] = '';
                        $node->props['thumbnail_2'] = '';
                        $node->props['thumbnail_3'] = '';
                    }
                }
            }

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

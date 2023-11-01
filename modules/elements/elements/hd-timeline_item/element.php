<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node, $params) {
            // Display
            foreach (['title', 'meta', 'content', 'link', 'image'] as $key) {
                if (!$params['parent']->props["show_{$key}"]) {
                    $node->props[$key] = '';
                    if ($key === 'image') {
                        $node->props['icon'] = '';
                    }
                }
            }

            // Don't render element if content fields are empty
            return Str::length($node->props['title']) ||
                Str::length($node->props['meta']) ||
                Str::length($node->props['content']) ||
                $node->props['image'] ||
                $node->props['icon'] ||
                $node->props['link'];
        },
    ],

    'updates' => [
        //
    ],
];

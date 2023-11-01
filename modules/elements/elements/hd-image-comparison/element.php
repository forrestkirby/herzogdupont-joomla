<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2020-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            /**
             * @var Metadata $metadata
             */
            $metadata = app(Metadata::class);

            $metadata->set('style:builder-hd-image-comparison', ['href' => Path::get('./css/hd-image-comparison.css')]);
            $metadata->set('script:builder-hd-image-comparison', ['src' => Path::get('./js/hd-image-comparison.js'), 'defer' => true]);

            // Don't render element if content fields are empty
            return ($node->props['image_before'] || $node->props['image_after']);
        },
    ],

    'updates' => [
        '3.0.0' => function ($node) {
            if (!isset($node->props['show_image_labels'])) {
                $node->props['show_image_labels'] = false;
            }
        },
    ],
];

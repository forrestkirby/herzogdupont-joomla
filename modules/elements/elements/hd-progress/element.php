<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2018-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            /**
             * @var Metadata $metadata
             */
            $metadata = app(Metadata::class);

            $metadata->set('script:builder-hd-progress', ['src' => Path::get('./js/hd-progress.js'), 'defer' => true]);

            // Don't render element if content fields are empty
            return Str::length($node->props['content']) || ($node->props['max'] && $node->props['stop'] && $node->props['animation_step'] && $node->props['animation_speed']);
        },
    ],

    'updates' => [
        '2.4.12' => function ($node) {
            Arr::updateKeys($node->props, [
                'value' => 'start',
            ]);
        },
    ],
];
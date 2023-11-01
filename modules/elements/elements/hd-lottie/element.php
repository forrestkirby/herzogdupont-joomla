<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
    'transforms' => [
        'render' => function ($node) {
            /**
             * @var Metadata $metadata
             */
            $metadata = app(Metadata::class);

            $metadata->set('script:builder-lottie', ['src' => Path::get('./app/lottie.min.js'), 'defer' => true]);
            $metadata->set('script:builder-hd-lottie', ['src' => Path::get('./js/hd-lottie.js'), 'defer' => true]);

            // Don't render element if content fields are empty
            return (bool) strlen($node->props['path']);
        },
    ],
];

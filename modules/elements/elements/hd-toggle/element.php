<?php

/* Herzog Dupont Copyright (C) 2018–2021 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return (Str::length($node->props['btn_label']) || $node->props['icon']) && (Str::length($node->props['content']) || Str::length($node->props['content2']));

        },

    ],

    'updates' => [

        //

    ],

];

<?php

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

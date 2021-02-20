<?php

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            // Don't render element if content fields are empty
            return ($node->props['btn_label'] || $node->props['icon']) && ($node->props['content'] || $node->props['content2']);

        },

    ],

    'updates' => [

        //

    ],

];

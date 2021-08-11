<?php

/* Herzog Dupont Copyright (C) 2016–2021 YOOtheme GmbH, 2021 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            $node->tags = [];

            // Filter tags
            if (!empty($node->props['filter'])) {

                foreach ($node->children as $child) {

                    $child->tags = [];

                    foreach (explode(',', $child->props['tags']) as $tag) {

                        // Strip tags as precaution if tags are mapped dynamically
                        $tag = strip_tags($tag);

                        if ($key = str_replace(' ', '-', trim($tag))) {
                            $child->tags[$key] = trim($tag);
                        }
                    }

                    $node->tags += $child->tags;
                }

                natsort($node->tags);

                if ($node->props['filter_reverse']) {
                    $node->tags = array_reverse($node->tags, true);
                }
            }

        },

    ],

    'updates' => [

        '2.5.10' => function ($node) {

            if (!empty($node->props['panel_padding'])) {
                $node->props['panel_padding'] = $node->props['panel_padding'];
                unset($node->props['panel_padding']);
            }

            if (!empty($node->props['panel_card_size'])) {
                $node->props['panel_card_size'] = $node->props['panel_card_size'];
                unset($node->props['panel_card_size']);
            }

            if (!empty($node->props['panel_image_no_padding'])) {
                $node->props['panel_image_no_padding'] = $node->props['panel_image_no_padding'];
                unset($node->props['panel_image_no_padding']);
            }

        },

    ],

];

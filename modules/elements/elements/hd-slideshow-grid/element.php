<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016–2021 YOOtheme GmbH, 2021 Thomas Weidlich GNU GPL v3 */

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
        '2.7.3.1' => function ($node) {
            if (empty($node->props['panel_style']) && empty($node->props['panel_padding'])) {
                foreach ($node->children as $child) {
                    if (
                        isset($child->props->panel_style) &&
                        preg_match('/^card-/', $child->props->panel_style)
                    ) {
                        $node->props['panel_padding'] = 'default';
                        break;
                    }
                }
            }
        },

        '2.7.0' => function ($node) {
            if (isset($node->props['panel_content_padding'])) {
                $node->props['panel_padding'] = $node->props['panel_content_padding'];
                unset($node->props['panel_content_padding']);
            }

            if (isset($node->props['panel_card_image'])) {
                $node->props['panel_image_no_padding'] = $node->props['panel_card_image'];
                unset($node->props['panel_card_image']);
            }

            if (isset($node->props['panel_style']) && preg_match('/^card-/', $node->props['panel_style'])) {
                if (empty($node->props['panel_size'])) {
                    $node->props['panel_size'] = 'default';
                }
                $node->props['panel_padding'] = $node->props['panel_size'];
                unset($node->props['panel_size']);
            }
        },

    ],

];

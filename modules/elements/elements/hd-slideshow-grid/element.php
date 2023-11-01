<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2016-2023 YOOtheme GmbH, 2021-2023 Thomas Weidlich GNU GPL v3 */

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
        '2.8.0-beta.0.13' => function ($node) {
            foreach (['title_style', 'meta_style', 'content_style'] as $prop) {
                if (in_array(Arr::get($node->props, $prop), ['meta', 'lead'])) {
                    $node->props[$prop] = 'text-' . Arr::get($node->props, $prop);
                }
            }
        },
        
        '2.7.3.1' => function ($node) {
            if (empty($node->props['panel_style']) && empty($node->props['panel_padding'])) {
                foreach ($node->children as $child) {
                    if (
                        isset($child->props->panel_style) &&
                        str_starts_with($child->props->panel_style, 'card-')
                    ) {
                        $node->props['panel_padding'] = 'default';
                        break;
                    }
                }
            }
        },

        '2.7.0-beta.0.5' => function ($node) {
            if (
                isset($node->props['panel_style']) &&
                str_starts_with($node->props['panel_style'], 'card-')
            ) {
                if (empty($node->props['panel_card_size'])) {
                    $node->props['panel_card_size'] = 'default';
                }
                $node->props['panel_padding'] = $node->props['panel_card_size'];
                unset($node->props['panel_card_size']);
            }
        },

        '2.7.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'panel_content_padding' => 'panel_padding',
                'panel_size' => 'panel_card_size',
                'panel_card_image' => 'panel_image_no_padding',
            ]);
        },
    ],
];

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

            $metadata->set('style:builder-hd-flipcard', ['href' => Path::get('./css/hd-flipcard.css')]);
            $metadata->set('script:builder-hd-flipcard', ['src' => Path::get('./js/hd-flipcard.js'), 'defer' => true]);

            // Don't render element if content fields are empty
            return ( Str::length($node->props['title']) ||
                    Str::length($node->props['meta']) ||
                    Str::length($node->props['content']) ||
                    $node->props['image'] ||
                    $node->props['icon'] ) && ( Str::length($node->props['title_back']) ||
                    Str::length($node->props['meta_back']) ||
                    Str::length($node->props['content_back']) ||
                    $node->props['image_back'] ||
                    $node->props['icon_back'] );
        },
    ],

    'updates' => [
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

            if (
                isset($node->props['panel_back_style']) &&
                str_starts_with($node->props['panel_back_style'], 'card-')
            ) {
                if (empty($node->props['panel_back_card_size'])) {
                    $node->props['panel_back_card_size'] = 'default';
                }
                $node->props['panel_back_padding'] = $node->props['panel_back_card_size'];
                unset($node->props['panel_back_card_size']);
            }
        },

        '2.7.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'panel_content_padding' => 'panel_padding',
                'panel_size' => 'panel_card_size',
                'panel_card_image' => 'panel_image_no_padding',
                'panel_back_content_padding' => 'panel_back_padding',
                'panel_back_size' => 'panel_back_card_size',
                'panel_back_card_image' => 'panel_back_image_no_padding',
            ]);
        },

        '2.1.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'title_grid_width') === 'xxlarge') {
                $node->props['title_grid_width'] = '2xlarge';
            }

            if (Arr::get($node->props, 'image_grid_width') === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

            if (Arr::get($node->props, 'title_back_grid_width') === 'xxlarge') {
                $node->props['title_back_grid_width'] = '2xlarge';
            }

            if (Arr::get($node->props, 'image_back_grid_width') === 'xxlarge') {
                $node->props['image_back_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_back_ratio'])) {
                $node->props['icon_back_width'] = round(20 * $node->props['icon_back_ratio']);
                unset($node->props['icon_back_ratio']);
            }
    
        },

        '2.0.0-beta.5.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'link_back_type' => function ($value) {
                    if ($value === 'content') {
                        return [
                            'title_back_link' => true,
                            'image_back_link' => true,
                            'link_back_text' => '',
                        ];
                    } elseif ($value === 'element') {
                        return [
                            'panel_back_link' => true,
                            'link_back_text' => '',
                        ];
                    }
                },
            ]);
        },
    ],
];

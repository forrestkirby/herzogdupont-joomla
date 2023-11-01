<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019-2023 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [
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

        '2.4.14.2' => function ($node) {
            $node->props['animation'] = Arr::get($node->props, 'item_animation');
            $node->props['item_animation'] = true;
        },

        '2.1.0-beta.0.1' => function ($node) {
            if (Arr::get($node->props, 'item_maxwidth') === 'xxlarge') {
                $node->props['item_maxwidth'] = '2xlarge';
            }

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
        },

        '2.0.0-beta.9.1' => function ($node) {

            foreach ($node->children as &$child) {
                if (isset($child->props->icon)) {
                    $child->props->timeline_icon = $child->props->icon;
                    unset($child->props->icon);
                }
            }

            if (isset($node->props['icon_color'])) {
                $node->props['timeline_icon_color'] = $node->props['icon_color'];
                unset($node->props['icon_color']);
            }

            if (isset($node->props['icon_ratio'])) {
                $node->props['timeline_icon_ratio'] = $node->props['icon_ratio'];
                unset($node->props['icon_ratio']);
            }

            if (isset($node->props['icon_background'])) {
                $node->props['timeline_icon_background'] = $node->props['icon_background'];
                unset($node->props['icon_background']);
            }

            if (isset($node->props['icon_border'])) {
                $node->props['timeline_icon_border'] = $node->props['icon_border'];
                unset($node->props['icon_border']);
            }

        },

        '2.0.0-beta.5.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'link_type' => function ($value) {
                    if ($value === 'content') {
                        return [
                            'title_link' => true,
                            'image_link' => true,
                            'link_text' => '',
                        ];
                    } elseif ($value === 'element') {
                        return [
                            'panel_link' => true,
                            'link_text' => '',
                        ];
                    }
                },
            ]);
        },

        '1.22.0-beta.0.1' => function ($node) {
            Arr::updateKeys($node->props, [
                'title_breakpoint' => 'title_grid_breakpoint',
                'image_breakpoint' => 'image_grid_breakpoint',
                'title_gutter' => function ($value) {
                    return ['title_grid_column_gap' => $value, 'title_grid_row_gap' => $value];
                },
                'image_gutter' => function ($value) {
                    return ['image_grid_column_gap' => $value, 'image_grid_row_gap' => $value];
                },
            ]);
        },
    ],
];

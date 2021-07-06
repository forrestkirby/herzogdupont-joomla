<?php

/* Herzog Dupont Copyright (C) 2019–2021 Thomas Weidlich GNU GPL v3 */

namespace YOOtheme;

return [

    'transforms' => [

        'render' => function ($node) {

            /**
             * @var Metadata $metadata
             */
            $metadata = app(Metadata::class);

            $metadata->set('style:builder-hd-timeline', ['href' => Path::get('./css/timeline.css')]);

        },

    ],

    'updates' => [

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

            if (Arr::get($node->props, 'link_type') === 'content') {
                $node->props['title_link'] = true;
                $node->props['image_link'] = true;
                $node->props['link_text'] = '';
            } elseif (Arr::get($node->props, 'link_type') === 'element') {
                $node->props['panel_link'] = true;
                $node->props['link_text'] = '';
            }
            unset($node->props['link_type']);

        },

        '1.22.0-beta.0.1' => function ($node) {


            if (isset($node->props['image_gutter'])) {
                $node->props['image_grid_column_gap'] = $node->props['image_gutter'];
                $node->props['image_grid_row_gap'] = $node->props['image_gutter'];
                unset($node->props['image_gutter']);
            }

            if (isset($node->props['image_breakpoint'])) {
                $node->props['image_grid_breakpoint'] = $node->props['image_breakpoint'];
                unset($node->props['image_breakpoint']);
            }

        },

    ],

];

<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2019�2021 Thomas Weidlich GNU GPL v3 */

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
            return (
                Str::length($node->props['title'])
                    || Str::length($node->props['meta'])
                    || Str::length($node->props['content'])
                    || $node->props['image']
                    || $node->props['icon']
            ) && (
                Str::length($node->props['title_back'])
                    || Str::length($node->props['meta_back'])
                    || Str::length($node->props['content_back'])
                    || $node->props['image_back']
                    || $node->props['icon_back']
            );

        },

    ],

    'updates' => [

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

            if (Arr::get($node->props, 'link_back_type') === 'content') {
                $node->props['title_back_link'] = true;
                $node->props['image_back_link'] = true;
                $node->props['link_back_text'] = '';
            } elseif (Arr::get($node->props, 'link_back_type') === 'element') {
                $node->props['panel_back_link'] = true;
                $node->props['link_back_text'] = '';
            }
            unset($node->props['link_back_type']);

        },
    ],

];

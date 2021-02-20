<?php

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
            return ($node->props['title'] || $node->props['meta'] || $node->props['content'] || $node->props['image'] || $node->props['icon']) && ($node->props['title_back'] || $node->props['meta_back'] || $node->props['content_back'] || $node->props['image_back'] || $node->props['icon_back']);

        },

    ],

    'updates' => [

        '2.1.0-beta.0.1' => function ($node, array $params) {

            if (@$node->props['title_grid_width'] === 'xxlarge') {
                $node->props['title_grid_width'] = '2xlarge';
            }

            if (@$node->props['image_grid_width'] === 'xxlarge') {
                $node->props['image_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_ratio'])) {
                $node->props['icon_width'] = round(20 * $node->props['icon_ratio']);
                unset($node->props['icon_ratio']);
            }

            if (@$node->props['title_back_grid_width'] === 'xxlarge') {
                $node->props['title_back_grid_width'] = '2xlarge';
            }

            if (@$node->props['image_back_grid_width'] === 'xxlarge') {
                $node->props['image_back_grid_width'] = '2xlarge';
            }

            if (!empty($node->props['icon_back_ratio'])) {
                $node->props['icon_back_width'] = round(20 * $node->props['icon_back_ratio']);
                unset($node->props['icon_back_ratio']);
            }
    
        },

        '2.0.0-beta.5.1' => function ($node) {

            if (@$node->props['link_back_type'] === 'content') {
                $node->props['title_back_link'] = true;
                $node->props['image_back_link'] = true;
                $node->props['link_back_text'] = '';
            } elseif (@$node->props['link_back_type'] === 'element') {
                $node->props['panel_back_link'] = true;
                $node->props['link_back_text'] = '';
            }
            unset($node->props['link_back_type']);

        },
    ],

];

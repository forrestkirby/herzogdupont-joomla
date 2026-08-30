<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2021-2026 Thomas Weidlich GNU GPL v3 */

namespace HerzogDupont;

// No direct access to this file
defined('_JEXEC') or die();

use YOOtheme\Builder;
use YOOtheme\Config;
use YOOtheme\Path;
use YOOtheme\Theme\Styler\StylerConfig;

include_once __DIR__ . '/src/SettingsListener.php';
include_once __DIR__ . '/src/StyleListener.php';

return [

    'theme' => [
        'styles' => [
            'components' => [
                'hd-timeline' => Path::get('./assets/less/hd-timeline.less'),
            ],
        ],
    ],

    'events' => [

        // Add settings Panels
        'customizer.init' => [
            SettingsListener::class => 'initCustomizer',
        ],

        // Recompile LESS style on installation
        StylerConfig::class => [StyleListener::class => 'config'],

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            $elements = $app->config->get('~theme.hd.elements');

            if (is_null($elements)) {
                $builder->addTypePath(Path::get('./elements/*/element.json'));
                return;
            }

            // Container elements whose child element must be registered along with them
            $childElements = [
                'hd-timeline' => 'hd-timeline_item',
                'hd-slideshow-grid' => 'hd-slideshow-grid_item',
            ];

            foreach ($elements as $key => $enabled) {
                if ($enabled !== true) {
                    continue;
                }

                $builder->addTypePath(Path::get("./elements/{$key}/element.json"));

                if (isset($childElements[$key])) {
                    $builder->addTypePath(Path::get("./elements/{$childElements[$key]}/element.json"));
                }
            }
        }

    ]

];

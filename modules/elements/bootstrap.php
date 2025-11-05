<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2021-2025 Thomas Weidlich GNU GPL v3 */

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
            if (is_null($app->config->get('~theme.hd.elements'))) {
                $builder->addTypePath(Path::get('./elements/*/element.json'));
            } else {
                foreach ($app->config->get('~theme.hd.elements') as $key => $value) {
                    if ($value === true) {
                        $builder->addTypePath(Path::get('./elements/' . $key . '/element.json'));
                        if ($key === 'hd-timeline' || $key === 'hd-slideshow-grid') {
                            $builder->addTypePath(Path::get('./elements/' . $key . '_item/element.json'));
                        }
                    }
                }
            }
        }

    ]

];

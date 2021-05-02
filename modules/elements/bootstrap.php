<?php

/* Herzog Dupont Copyright (C) 2021 Thomas Weidlich GNU GPL v3 */

// No direct access to this file
defined('_JEXEC') or die();

use YOOtheme\Builder;
use YOOtheme\Path;

include_once __DIR__ . '/src/SettingsListener.php';

return [

    'events' => [

        // Add settings Panels
        'customizer.init' => [
            SettingsListener::class => 'initCustomizer',
        ]

    ],

    'extend' => [

        Builder::class => function (Builder $builder, $app) {
            if (is_null($app->config->get('~theme.hd.elements'))) {
                $builder->addTypePath(Path::get('./elements/*/element.json'));
            } else {
                foreach ($app->config->get('~theme.hd.elements') as $key => $value) {
                    if ($value === true) {
                        $builder->addTypePath(Path::get('./elements/' . $key . '/element.json'));
                        if ($key === 'hd-timeline') {
                            $builder->addTypePath(Path::get('./elements/' . $key . '_item/element.json'));
                        }
                    }
                }
            }
        }

    ]

];

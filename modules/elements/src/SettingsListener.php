<?php

use YOOtheme\Config;

class SettingsListener
{
    public static function initCustomizer(Config $config)
    {
        // Add panel using a dynamic PHP configuration
        $config->set('customizer.panels.herzogdupont', [
            'title'  => 'Herzog Dupont',
            'width'  => 400,
            'fields' => [
                'hd.elements.hd-counter' => [
                    'type' => 'checkbox',
                    'label' => 'Counter element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
                'hd.elements.hd-flipcard' => [
                    'type' => 'checkbox',
                    'label' => 'Flipcard element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
                'hd.elements.hd-image-comparison' => [
                    'type' => 'checkbox',
                    'label' => 'Image Comparison element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
                'hd.elements.hd-progress' => [
                    'type' => 'checkbox',
                    'label' => 'Progress element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
                'hd.elements.hd-timeline' => [
                    'type' => 'checkbox',
                    'label' => 'Timeline element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
                'hd.elements.hd-toggle' => [
                    'type' => 'checkbox',
                    'label' => 'Toggle element',
                    'default' => 1,
                    'text' => 'Add to the element library',
                ],
            ],
        ]);

        $config->set('customizer.sections.settings.fields.settings.items.herzogdupont', 'Herzog Dupont');
    }
}

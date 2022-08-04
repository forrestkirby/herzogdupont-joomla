<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2021–2022 Thomas Weidlich GNU GPL v3 */

namespace HerzogDupont;

// No direct access to this file
defined('_JEXEC') or die();

use YOOtheme\Config;
use YOOtheme\Path;

class SettingsListener
{
    public static function initCustomizer(Config $config)
    {
        // Add settings panel and style customizer components
        $config->addFile('customizer', Path::get('./customizer.json'));

        // Recompile LESS style on installation
        if ($config->get('~theme.hd.recompile-style') !== true) {
            $config->set('customizer.sections.styler.update', true);
            $config->set('~theme.hd.recompile-style', true);
        }
    }
}

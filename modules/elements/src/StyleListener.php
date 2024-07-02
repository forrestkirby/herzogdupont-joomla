<?php

/* Herzog Dupont for YOOtheme Pro Copyright (C) 2021-2024 Thomas Weidlich GNU GPL v3 */

namespace HerzogDupont;

// No direct access to this file
defined('_JEXEC') or die();

use YOOtheme\Config;
use YOOtheme\Theme\Styler\StylerConfig;

class StyleListener
{
    public static function config(Config $config, StylerConfig $stylerConfig): StylerConfig
    {
        // Recompile LESS style on installation
        if ($config->get('~theme.hd.recompile-style') !== true) {
            // Style needs to be re-compiled
            $stylerConfig['update'] = true;
            $config->set('~theme.hd.recompile-style', true);
        }

        return $stylerConfig;
    }
}
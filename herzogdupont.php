<?php

/**
 * @package   Herzog Dupont
 * @author    Thomas Weidlich
 * @copyright Copyright (C) 2021 Thomas Weidlich
 * @license   GNU General Public License version 3, see LICENSE
 */

// No direct access to this file
defined('_JEXEC') or die();

use Joomla\CMS\Plugin\CMSPlugin;
use YOOtheme\Application;

class plgSystemHerzogdupont extends CMSPlugin
{
    public function onAfterInitialise()
    {
        // Check if YOOtheme Pro is loaded
        if (!class_exists(Application::class, false)) {
            return;
        }

        // Load all modules
        $app = Application::getInstance();
        $app->load(__DIR__ . '/modules/*/bootstrap.php');
   }
}
<?php

/**
 * @package   Herzog Dupont for YOOtheme Pro
 * @author    Thomas Weidlich
 * @copyright Copyright (C) 2021-2026 Thomas Weidlich
 * @license   GNU General Public License version 3, see LICENSE
 */

declare(strict_types=1);

// No direct access
defined('_JEXEC') or die;

use HerzogDupont\Plugin\System\Herzogdupont\Extension\Herzogdupont;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $plugin = new Herzogdupont(
                    $container->get(DispatcherInterface::class),
                    (array) PluginHelper::getPlugin('system', 'herzogdupont')
                );
                $plugin->setApplication(Factory::getApplication());

                return $plugin;
            }
        );
    }
};

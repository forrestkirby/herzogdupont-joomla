<?php

/**
 * @package   Herzog Dupont for YOOtheme Pro
 * @author    Thomas Weidlich
 * @copyright Copyright (C) 2021-2026 Thomas Weidlich
 * @license   GNU General Public License version 3, see LICENSE
 */

declare(strict_types=1);

namespace HerzogDupont\Plugin\System\Herzogdupont\Extension;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\SubscriberInterface;
use YOOtheme\Application;

final class Herzogdupont extends CMSPlugin implements SubscriberInterface
{
    /**
     * Events are declared via getSubscribedEvents(), so the slower
     * reflection-based legacy listener discovery can be skipped.
     *
     * @var boolean
     */
    protected $allowLegacyListeners = false;

    public static function getSubscribedEvents(): array
    {
        return [
            'onAfterInitialise' => 'onAfterInitialise',
        ];
    }

    public function onAfterInitialise(): void
    {
        // Check if YOOtheme Pro is loaded
        if (!class_exists(Application::class, false)) {
            return;
        }

        // Load all modules of this plugin
        Application::getInstance()->load(JPATH_PLUGINS . '/system/herzogdupont/modules/*/bootstrap.php');
    }
}

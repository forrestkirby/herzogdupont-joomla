<?php

/**
 * @package   Herzog Dupont for YOOtheme Pro
 * @author    Thomas Weidlich
 * @copyright Copyright (C) 2021-2024 Thomas Weidlich
 * @license   GNU General Public License version 3, see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

class plgSystemHerzogdupontInstallerScript
{
    protected $minimumPHPVersion = '8.1.0';
    protected $minimumJoomlaVersion = '5.0.0';
    protected $minimumYOOthemeVersion = '5.0.0';

    public function install($parent)
    {
        // Enable the extension
        $this->enablePlugin();

        return true;
    }

    public function uninstall($parent)
    {
    }

    public function update($parent)
    {
    }

    public function preflight($type, $parent)
    {
        // Check the minimum PHP version
        if (!version_compare(PHP_VERSION, $this->minimumPHPVersion, '>='))
        {
            $msg = '<p>You need PHP ' . $this->minimumPHPVersion . ' or later to install this plugin.</p>';
            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        // Check the minimum Joomla! version
        if (!version_compare(JVERSION, $this->minimumJoomlaVersion, '>='))
        {
            $msg = '<p>You need Joomla! ' . $this->minimumJoomlaVersion . ' or later to install this plugin.</p>';
            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        // Check the minimum YOOtheme Pro version
        $yoothemeManifest = simplexml_load_file(JPATH_SITE . '/templates/yootheme/templateDetails.xml');
        if (!$yoothemeManifest or !version_compare((string) $yoothemeManifest->version, $this->minimumYOOthemeVersion, '>='))
        {
            $msg = '<p>You need YOOtheme Pro ' . $this->minimumYOOthemeVersion . ' or later to install this plugin.</p>';
            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        return true;
    }

    public function postflight($type, $parent)
    {
    }

    private function enablePlugin()
    {
        try
        {
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true)
                        ->update($db->qn('#__extensions'))
                        ->set($db->qn('enabled') . ' = ' . $db->q(1))
                        ->where('type = ' . $db->q('plugin'))
                        ->where('folder = ' . $db->q('system'))
                        ->where('element = ' . $db->q('herzogdupont'));
            $db->setQuery($query);
            $db->execute();
        }
        catch (\Exception $e)
        {
            return;
        }
    }
}

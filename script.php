<?php

/**
 * @package   Herzog Dupont for YOOtheme Pro
 * @author    Thomas Weidlich https://herzog-dupont.de
 * @copyright Copyright (C) Thomas Weidlich
 * @license   GNU General Public License version 3, see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die();

class plgSystemHerzogdupontInstallerScript
{
    protected $minimumPHPVersion = '7.3.0';
    protected $minimumJoomlaVersion = '3.9.0';
    protected $minimumYOOthemeVersion = '2.3.0';

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
        if (!version_compare(PHP_VERSION, $this->minimumPHPVersion, 'ge'))
        {
            $msg = '<p>You need PHP ' . $this->minimumPHPVersion . ' or later to install this plugin.</p>';
            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        // Check the minimum Joomla! version
        if (!version_compare(JVERSION, $this->minimumJoomlaVersion, 'ge'))
        {
            $msg = '<p>You need Joomla! ' . $this->minimumJoomlaVersion . ' or later to install this plugin.</p>';
            JLog::add($msg, JLog::WARNING, 'jerror');

            return false;
        }

        // Check the minimum YOOtheme Pro version
        $yoothemeManifest = simplexml_load_file(JPATH_SITE . '/templates/yootheme/templateDetails.xml');
        if (!$yoothemeManifest or !version_compare((string) $yoothemeManifest->version, $this->minimumYOOthemeVersion, 'ge'))
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
                        ->update('#__extensions')
                        ->set($db->qn('enabled') . ' = ' . $db->q(1))
                        ->where('type = ' . $db->quote('plugin'))
                        ->where('folder = ' . $db->quote('system'))
                        ->where('element = ' . $db->quote('herzogdupont'));
            $db->setQuery($query);
            $db->execute();
        }
        catch (\Exception $e)
        {
            return;
        }
    }
}

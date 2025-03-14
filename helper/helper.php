<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Access\Access;  // Import JAccess for access handling

class HelloHelper {
    public static function addSubmenu($vName) {
        HTMLHelper::_('sidebar.addEntry', 
            Text::_('COM_HELLO_HELLO'),
            'index.php?option=com_hello&view=hellos',
            $vName == 'hellos'
        );

        HTMLHelper::_('sidebar.addEntry', 
            Text::_('COM_HELLO_IMAGES'),
            'index.php?option=com_hello&view=images',
            $vName == 'images'
        );
    }

    protected static $actions;

    public static function getActions() {
        // Check if actions have already been loaded
        if (empty(self::$actions)) {
            $user = Factory::getUser(); // Get the current user
            self::$actions = new CMSObject();

            // Correct method to load actions from the access.xml file
            $actions = JAccess::getActionsFromFile(JPATH_ADMINISTRATOR . '/components/com_hello/access.xml');

            // Iterate through actions and check if the user is authorized
            foreach ($actions as $action) {
                self::$actions->set($action->name, $user->authorise($action->name, "com_hello"));
            }
        }

        return self::$actions;
    }
}

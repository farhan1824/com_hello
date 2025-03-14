<?php

use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
defined('_JEXEC') or die('Restricted access');

class HelloModelHellos extends ListModel
{
    public function __construct($config = array())
    {
        if (empty($config["filter_fields"])) {
            $config["filter_fields"] = array(
                "name", "name",
                "description", "description"
            );
        }
        parent::__construct($config);
    }

    public function populateState($ordering = null, $direction = null)
    {
        $search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);
        parent::populateState('id', 'asc');
    }

    public function getListQuery()
    {
        $db = Factory::getContainer()->get("DatabaseDriver");
        $query = $db->getQuery(true);
        $query->select('*')
              ->from($db->quoteName("fb__facebook_friends"));
        if ($this->getState("filter_search") !== '') {
            $token = '%' . $db->escape($this->getState('filter.search')) . '%';
            $searches = array();
            $searches[] = $db->quoteName("name") . ' LIKE ' . $db->quote($token);
            $searches[] = $db->quoteName("description") . ' LIKE ' . $db->quote($token);
            $query->where('(' . implode(' OR ', $searches) . ')');
        }

        $query->order(
            $db->escape($this->getState("list.ordering", "id")) . ' ' .
            $db->escape($this->getState("list.direction", "ASC"))
        );

        // Debugging:
        // echo '<pre>SQL Query: ' . $query->dump() . '</pre>';
        return $query;
    }

    public function getItems()
    {
        try {
            $items = parent::getItems();
            //Debugging
            // echo '<pre>Items Count: '.count($items).'</pre>';
            return $items;
        } catch (RuntimeException $e) {
            JFactory::getApplication()->enqueueMessage(Text::sprintf('JLIB_DATABASE_ERROR', $e->getMessage()), 'error');
            return false;
        }
    }
}
?>
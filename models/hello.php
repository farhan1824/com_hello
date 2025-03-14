<?php

use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Factory;
defined('_JEXEC') or die('Restricted access');

class HelloModelHello extends FormModel
{
    public function getForm($data = array(), $loadData = true)
    {
        $options = array('control' => 'jform', 'load_data' => $loadData);
        $form = $this->loadForm('com_hello.hello', 'hello', $options);

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    public function delete($id){
        $db = Factory::getContainer()->get("DatabaseDriver");
            try {
                $query = $db->getQuery(true);
                $query->delete('fb__facebook_friends')
                      ->where($db->quoteName("id") . "=" . $db->quote($id));
        
                $db->setQuery($query);
                $db->execute();
            } catch (Exception $e) {
                Factory::getApplication()->enqueueMessage($e->getMessage(), "error");
                return false;
            }
            return true;
    }



    public function getItem()
    {
        $input = Factory::getApplication()->input; // Corrected input retrieval
        $pk = $input->get("id", array(), "array");
        if (is_array($pk)) {
            $pk = (int) $pk[0];
        }
        if ($pk == 0) {
            return false;
        }
        $db = Factory::getContainer()->get("DatabaseDriver");
        $query = $db->getQuery(true);
        $query->select('*')
              ->from($db->quoteName("fb__facebook_friends"))
              ->where($db->quoteName("id") . "=" . $db->quote($pk));

        $db->setQuery($query);
        try {
            $result = $db->loadObject(); // Corrected typo
            echo '<pre>Item: ';
        var_dump($result);
        echo '</pre>';
        } catch (Exception $e) {
            Factory::getApplication()->enqueueMessage($e->getMessage(), "error");
            return false;
        }
        return $result;
    }

    public function loadData()
    {
        return $this->getItem();
    }

    public function save($data)
    {
        $db = Factory::getContainer()->get("DatabaseDriver");
        $obj = (object) $data;
        try {
            if ($obj->id) {
                $db->updateObject("fb__facebook_friends", $obj, "id");
            } else {
                $db->insertObject("fb__facebook_friends", $obj, "id");
            }
        } catch (Exception $e) {
            $this->setMessage("Successfully Saved: " . $e->getMessage(), "error");
            return false;
        }
        return true;
    }
}
?>
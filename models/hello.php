<?php

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Model\FormModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
defined('_JEXEC') or die('Restricted access');

// class HelloModelHello extends FormModel
class HelloModelHello extends AdminModel
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

    // public function delete($id){
    //     $db = Factory::getContainer()->get("DatabaseDriver");
    //     $query = $db->getQuery(true);
    //         try {
    //             $query->delete('fb__facebook_friends')
    //                   ->where($db->quoteName("id") . "=" . $db->quote($id));
        
    //             $db->setQuery($query);
    //             $db->execute();
    //         } catch (Exception $e) {
    //             Factory::getApplication()->enqueueMessage($e->getMessage(), "error");
    //             return false;
    //         }
    //         return true;
    // }

    public function getTable($type="Hello", $prefix="HelloTable",$config=array()){
        return Table::getInstance($type,$prefix,$config);
    }




//     public function delete($ids)
// {
//     if (empty($ids) || !is_array($ids)) {
//         return false;
//     }

//     $db = Factory::getContainer()->get("DatabaseDriver");

//     try {
//         // Convert array of IDs into a comma-separated string for SQL query
//         $ids = array_map('intval', $ids);
//         $query = $db->getQuery(true)
//             ->delete($db->quoteName('fb__facebook_friends'))
//             ->where($db->quoteName("id") . " IN (" . implode(',', $ids) . ")");

//         $db->setQuery($query);
//         $db->execute();

//         return true;
//     } catch (Exception $e) {
//         Factory::getApplication()->enqueueMessage($e->getMessage(), "error");
//         return false;
//     }
// }

public function delete(&$pks)
{
    if (empty($pks) || !is_array($pks)) {
        return false;
    }

    $db = Factory::getContainer()->get("DatabaseDriver");

    try {
        // Convert array of IDs into a comma-separated string for SQL query
        $ids = array_map('intval', $pks);
        $query = $db->getQuery(true)
            ->delete($db->quoteName('fb__facebook_friends'))
            ->where($db->quoteName("id") . " IN (" . implode(',', $ids) . ")");

        $db->setQuery($query);
        $db->execute();

        return true;
    } catch (Exception $e) {
        Factory::getApplication()->enqueueMessage($e->getMessage(), "error");
        return false;
    }
}


    // public function getItem()
    public function getItem($pk = null)
    {
        $input = Factory::getApplication()->input; // Corrected input retrieval
        $pk = $input->get("id", array(), "array");
        // $pk = $this->getState($this->context . '.id');
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
        //     echo '<pre>Item: ';
        // var_dump($result);
        // echo '</pre>';
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
    // public function loadFormData()
    // {
    //     return $this->getItem();
    // }
    public function loadFormData()
{
    $data = $this->getItem();
    if ($data === false) {
        $data = (object) []; // Or $data = [];
    }
    return $data;
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
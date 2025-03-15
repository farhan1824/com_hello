<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;

// class HelloController extends BaseController
class HelloController extends AdminController
{
    public function display($cachable = false, $urlparams = array())
    {
/*
here i was showing the default view model of hellos
*/

        // $viewName = $this->input->getCmd('view', 'hellos');
        // $this->input->set('view', $viewName);
        // parent::display($cachable, $urlparams);
/*

the cause of this change is we are adding a table task and it is gonnna dictate which view and model are to show

*/

       // Get the task from the request
    $task = $this->input->getCmd('task', '');
    
    // Check if the task is add or edit, otherwise use the default view
    if ($task == "add" || $task == "edit") {
        $viewName = "hello"; // Single item view
    } else {
        $viewName = $this->input->getCmd('view', 'hellos'); // Default to list view
    }

    // Set the view parameter
    $this->input->set('view', $viewName);

    // Call parent display method
    parent::display($cachable, $urlparams);
    }

    public function edit()
    {
        $app = Factory::getApplication();
        $model = $this->getModel('Hello'); 
        $id = $this->input->getInt("id", 0); // Get ID from request
        $data = $model->getItem($id); // Fetch the item
        
        $view = $this->getView('Hello', 'html');
        $view->item = $data; // ✅ Assign item correctly
    
        $this->input->set('view', "hello");
        parent::display();
    }

    // public function delete(){
    //     $app = Factory::getApplication();
    //     Session::checkToken()or die("Token not valid");
    //     $input=$app->input;
    //     $cid=$input->get("id",array(),"array");
    //     $model = $this->getModel('hello');
    //     foreach($cid as $id){
    //         if($model->delete($id)){
    //                 $this->setMessage('Delete SuccessFully');
    //         }
    //         else{
    //             Factory::getApplication()->enqueueMessage('Delete Failed','error');
    //         }
    //     }
    //     $this->setRedirect(Route::_("index.php?option=com_hello&view=hellos",false));
    // }


    public function delete()
    {
        $app = Factory::getApplication();
        Session::checkToken() or die("Token not valid");
    
        $input = $app->input;
        $cid = $input->get("id", array(), "array"); // Fix the input name
    
        if (!empty($cid)) {
            $model = $this->getModel('hello');
    
            if ($model->delete($cid)) {
                $this->setMessage('Deleted Successfully');
            } else {
                $this->setMessage('Delete Failed', 'error');
            }
        } else {
            $this->setMessage('No item selected', 'error');
        }
    
        // ✅ Redirect to "hellos" view after delete
        $this->setRedirect(Route::_("index.php?option=com_hello&c=hellos", false));
    }
    

    public function cancel()
    {
        // Redirect back to the list view after cancel
        $this->setRedirect(Route::_('index.php?option=com_hello&view=hellos'));
    }

    public function save()
    {
        if (!Session::checkToken("post")) {
            throw new Exception("Invalid Token");
        }

        $data = $this->input->post->get("jform", array(), "array");
        $model = $this->getModel("Hello");

        try {
            if ($model->save($data)) {
                $this->setMessage("Successfully Saved");
            } else {
                throw new Exception("Failed to Save");
            }
        } catch (Exception $e) {
            $this->setMessage("Error: " . $e->getMessage(), "error");
        }

        $this->setRedirect(Route::_("index.php?option=com_hello&view=hellos"), false);
    }
}
?>

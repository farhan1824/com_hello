<?php
// i have called the form here 
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;
defined('_JEXEC') or die;
class HelloViewHellos extends BaseHtmlView{
    function display($tpl = null)
    {
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->addToolbar();
        parent::display($tpl);
    }


    function addToolbar()
    {
        ToolbarHelper::title("Titles");
        ToolbarHelper::addNew("hello.add");
        ToolbarHelper::editList("hello.edit");
        ToolbarHelper::deleteList("Sure to Delete","hello.delete");
        // ToolbarHelper::save();
        // ToolbarHelper::cancel();
    }
    
}
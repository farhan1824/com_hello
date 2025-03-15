<?php
// i have called the form here 
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;
defined('_JEXEC') or die;
class HelloViewHello extends BaseHtmlView{
    function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->addToolbar();
        parent::display($tpl);
    }


    function addToolbar()
    {
        ToolbarHelper::save();
       // In your view or controller's display method (for example, in the edit or add view)
        ToolbarHelper::cancel('cancel', 'Cancel');

    }
}
<?php
defined('_JEXEC') or die;

use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;

class HelloViewHellos extends BaseHtmlView
{
    function display($tpl = null)
    {
        HelloHelper::addSubmenu("hellos"); // Adds submenu
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');
        $this->addToolbar();
        
        // Properly render the sidebar
        $this->sidebar = HTMLHelper::_('sidebar.render');

        parent::display($tpl);
    }

    function addToolbar()
    {
        $canDo=HelloHelper::getActions();

        if($canDo->get("core.create")){
            ToolbarHelper::addNew('hello.add');
        }
        if($canDo->get("core.edit")){
            ToolbarHelper::editList('hello.edit');
        }
        if($canDo->get("core.delete")){
            ToolbarHelper::deleteList('Are you sure you want to delete?', 'hello.delete');
        }


        ToolbarHelper::title("Titles");
        ToolbarHelper::addNew('hello.add', 'JTOOLBAR_NEW'); // Redirects to the form
        ToolbarHelper::editList('hello.edit', 'JTOOLBAR_EDIT'); // Edits selected item
        ToolbarHelper::deleteList('Are you sure you want to delete?', 'hello.delete'); // Deletes selected items
        // options
        ToolbarHelper::preferences('com_hello'); // Corrected method name

        // Set action for sidebar
        HTMLHelper::_('sidebar.setAction', 'index.php?option=com_hello&view=hellos'); // Ensure view is correct

        // Add filter dropdown for published state
        HTMLHelper::_(
            'sidebar.addFilter',
            'Select Publish State',
            'filter_published',
            HTMLHelper::_(
                'select.options',
                HTMLHelper::_('jgrid.publishedOptions'),
                'value',
                'text',
                $this->state->get('filter.published')
            )
        );
    }
}

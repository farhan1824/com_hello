<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
$listOrder = $this->escape($this->state->get("list.ordering"));
$listDirn = $this->escape($this->state->get("list.direction"));
$searchValue = $this->escape($this->state->get("filter.search"));
$wa=Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseStyle("com_hello.style",Uri::root()."administrator\components\com_hello\media\css\style.css");
$wa=Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->registerAndUseScript("com_hello.js",Uri::root()."administrator\components\com_hello\media\js\script.js");
?>



<form action="<?php echo Route::_('index.php?option=com_hello&view=hello'); ?>"
      name="adminForm" id="adminForm" method="post" class="form-validate form-horizontal">

    <div id="j-main-container">
        <div id="filter-bar" class="btn-toolbar">
            <div class="filter-search btn-group pull-left">
                <input type="text" name="filter_search" id="filter_search"
                       placeholder="<?php echo Text::_('JSEARCH_FILTER'); ?>"
                       class="form-control" value="<?php echo $searchValue; ?>">
            </div>
            <div class="btn-group pull-left">
                <button type="submit" class="btn btn-primary" title="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
                    <i class="icon-search"></i> <?php echo Text::_('JSEARCH'); ?>
                </button>
                <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('filter_search').value=''; document.adminForm.submit();">
                    <i class="icon-remove"></i> <?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
                </button>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="1%" class="nowrap center">
                            <input type="checkbox" id="checkall-toggle" name="checkall-toggle" value=""
                                   title="<?php echo Text::_('JGLOBAL_CHECK_ALL'); ?>"
                                   onclick="Joomla.checkAll(this);">
                        </th>
                        <th width="1%" class="nowrap center">
                            ID
                        </th>
                        <th width="20%" class="nowrap center">
                            <?php
                            echo HTMLHelper::_('grid.sort', 'Name', 'name', $listOrder, $listDirn);
                            ?>
                        </th>
                        <th width="20%" class="nowrap center">
                            <?php
                            echo HTMLHelper::_('grid.sort', 'Description', 'description', $listOrder, $listDirn);
                            ?>
                        </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($this->items as $i => $item) : ?>
                        <?php $url = Route::_('index.php?option=com_hello&c=hello&task=edit&id=' . $item->id); ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center">
                                <?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td class="center">
                                <?php echo $item->id; ?>
                            </td>
                            <td class="left">
                                <a href="<?php echo $url; ?>">
                                    <?php echo $this->escape($item->name); ?>
                                </a>
                            </td>
                            <td class="center">
                                <?php echo $this->escape($item->description); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" name="task">
            <input type="hidden" name="boxchecked" value="">
            <input type="hidden" name="c" value="hello">
            <input type="hidden" name="filter_order" value="<?php echo $listOrder ?>">
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn ?>">
            <?php echo HTMLHelper::_("form.token"); ?>
        </div>
    </div>
</form>
<img src="<?php echo JUri::root() . 'administrator/components/com_hello/media/img/download (18).jpeg'; ?>" alt="" srcset="" height="120px">
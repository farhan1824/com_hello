<?php
// controller er shate add kore dei
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Controller\BaseController;

$app = Factory::getApplication();
$input = $app->input;

ComponentHelper::getComponent('com_hello');

$controllerName = $input->getCmd('controller', 'hello');
$controllerName = $controllerName ?: 'hello';
$controllerClass = 'HelloController' . ucfirst($controllerName);

$controllerPath = __DIR__ . '/controllers/' . strtolower($controllerName) . '_controller.php';

if (file_exists($controllerPath)) {
    require_once $controllerPath;
}

if (!class_exists($controllerClass)) {
    $controllerClass = 'HelloController';
    require_once __DIR__ . '/controllers/hello_controller.php';
}

$controller = new $controllerClass();
$controller->execute($input->get('task'));
$controller->redirect();
?>
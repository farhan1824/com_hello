<?php
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Table\Table;
class HelloTableHello extends Table{
    public function __construct(&$db){
        parent::__construct("fb__facebook_friends","id",$db);
    }
}
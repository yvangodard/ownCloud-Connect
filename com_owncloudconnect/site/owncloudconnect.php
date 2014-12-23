<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
 // require helper file
JLoader::register('OwncloudConnectHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'owncloudconnect.php');
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JController::getInstance('Owncloudconnect');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();
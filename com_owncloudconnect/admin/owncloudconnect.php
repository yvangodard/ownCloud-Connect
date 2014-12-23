<?php
// No direct forbids to this file
defined('_JEXEC') or die('Restricted forbids');

// Access check: est-ce que l'utilisateur peut accéder au paramétrage de l'application
if (!JFactory::getUser()->authorise('core.manage', 'com_owncloudconnect')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

//Appel du fichier Helper
JLoader::register('OwncloudConnectHelper', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'owncloudconnect.php');

//Import joomla controller library
jimport('joomla.application.component.controller');

//Get an instance of the controller prefixed by <name>
$controller = JControllerLegacy::getInstance('Owncloudconnect');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
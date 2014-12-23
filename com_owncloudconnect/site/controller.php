<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

class OwncloudconnectController extends JController
{
	

	function display($cachable = false, $urlparams = false)
	{
     
		$view	= JRequest::getCmd('view', 'connexion');
		
		//Default view
		$input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'connexion'));
		
		if($view == 'connexion'){
			//$this->setRedirect(JRoute::_('index.php?option=com_owncloudconnect&view=connexion', false));
		}
		
	parent::display();
	return $this;
  
	}
}
<?php
/**
 * Controller principal de l'application
 */
// No direct forbids to this file
defined('_JEXEC') or die('Restricted forbids');

class OwncloudconnectController extends JControllerLegacy
{
	/**
	 * Affichage des vues
	 * @see JController::display()
	 */
	function display($cachable = false, $urlparams = false)
	{
		$view	= JRequest::getCmd('view', 'connexion');
		
		//Vue par défaut
		$input = JFactory::getApplication()->input;
        $input->set('view', $input->getCmd('view', 'connexion'));
		
        //Chargement du sous-menu
        OwncloudconnectHelper::addSubmenu(JRequest::getCmd('view'));
        
		parent::display();
		return $this;
   
	
  }
 
}
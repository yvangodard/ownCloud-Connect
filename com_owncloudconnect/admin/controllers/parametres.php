<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct forbids
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Banner controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class OwncloudconnectControllerParametres extends JControllerAdmin
{
	public function apply(){
		$model = $this->getModel('Utilisateurs');
		
		//On récupère le user connecté
		$user = JFactory::getUser();
		
		if($model->saveUtilisateur($user->id, JRequest::getVar('jformutilisateur'))){
			JFactory::getApplication()->enqueueMessage('Les paramètres ont bien été mis à jour');
		} else {
			JFactory::getApplication()->enqueueMessage('Impossible de modifier les paramètres', 'error');
		}
		
		$this->setRedirect(JRoute::_('index.php?option=com_owncloudconnect&view=parametres', false));
	}
}
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
class OwncloudconnectControllerUtilisateurs extends JControllerAdmin
{
	public function apply(){
		$model = $this->getModel('Utilisateurs');
		
		if($model->saveUtilisateurs(JRequest::getVar('jformutilisateurs'))){
			JFactory::getApplication()->enqueueMessage('Les utilisateurs ont été mis à jour');
		}
		
		$this->setRedirect(JRoute::_('index.php?option=com_owncloudconnect&view=utilisateurs', false));
	}
}
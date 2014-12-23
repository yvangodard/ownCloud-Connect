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
class OwncloudconnectControllerConnexion extends JControllerAdmin
{
	public function apply(){
		JFactory::getApplication()->enqueueMessage('Message');
		$this->setRedirect(JRoute::_('index.php?option=com_owncloudconnect&view=connexion', false));
	}
}
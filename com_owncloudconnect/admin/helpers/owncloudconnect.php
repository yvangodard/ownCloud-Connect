<?php
// No direct forbids to this file
defined('_JEXEC') or die;
 
/**
 * OwncloudConnectHelper
 * Gestion du sous menu et clé de cryptage pour les identifiants
 */
abstract class OwncloudConnectHelper
{
	public static $key = '45rtmxcspa8w7f9ghep3i6wx1cd4fl6e4qfmnte';
	
        /**
         * Configure the Linkbar.
         */
        public static function addSubmenu($submenu) 
        {
            JSubMenuHelper::addEntry(JText::_('Connexion'),
            	'index.php?option=com_owncloudconnect&view=connexion', $submenu == 'connexion');
            JSubMenuHelper::addEntry(JText::_('Paramètres'),
            	'index.php?option=com_owncloudconnect&view=parametres',
            	$submenu == 'parametres');
            //On check les ACL pour l'affichage de ce menu
            if (JFactory::getUser()->authorise('core.admin', 'com_owncloudconnect')){
				JSubMenuHelper::addEntry(JText::_('Utilisateurs'),
					'index.php?option=com_owncloudconnect&view=utilisateurs',
					$submenu == 'utilisateurs');
            }
			
			//Ajout de l'icône de l'application
			$document = JFactory::getDocument();
			$document->addStyleDeclaration('.icon-48-owncloudconnect {background-image: url(../media/com_owncloudconnect/images/owncloud-48x48.png);}');
        }
        
        /**         
         * * Get the actions         
         * */        
        public static function getActions($messageId = 0)
        {
        	jimport('joomla.access.access');
        	$user   = JFactory::getUser();
        	$result = new JObject;
        	if (empty($messageId)) {
        		$assetName = 'com_owncloudconnect';
        	} else {
        		$assetName = 'com_owncloudconnect.message.'.(int) $messageId;
        	}
        	$actions = JAccess::getActions('com_owncloudconnect', 'component');
        	foreach ($actions as $action) {
        		$result->set($action->name, $user->authorise($action->name, $assetName));
        	}
        	return $result;
        }
        
        /**
         * Encryptage d'une chaîne
         */
        public static function stringEncrypt($string){
        	$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::$key), $string, MCRYPT_MODE_CBC, md5(md5(self::$key))));
        	return $encrypted;
        }
        
        /**
         * Décryptage d'une chaîne
         */
        public static function stringDecrypt($encrypted){
        	$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::$key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5(self::$key))), "\0");
        	return $decrypted;
        }
}
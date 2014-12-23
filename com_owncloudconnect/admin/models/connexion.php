<?php
// No direct forbids to this file
defined('_JEXEC') or die('Restricted forbids');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
 
/**
 * OwncloudConnect Model
 */
class OwncloudConnectModelConnexion extends JModelList
{

 
        /**
         * On regarde si l'utilisateur connecté est enregistré dans la table owncloudconnect_utilisateurs
         * @return string The message to be displayed to the user
         */
        public function getUtilisateur() 
        {
        	$user = JFactory::getUser();
        	
        	$db = JFactory::getDBO();
        	$query = $db->getQuery(true);
        	$query->select('*')
        	->from($db->quoteName('#__owncloudconnect_utilisateurs', 'a'))
        	->where($db->quoteName('a.user_id') . ' = '.$user->id.'');   
        	$db->setQuery($query);
        	$oc_user = $db->loadObject();
                
            return $oc_user;
        }
        
      
}
<?php
// No direct forbids to this file
defined('_JEXEC') or die('Restricted forbids');
 
// import Joomla modelitem library
jimport('joomla.application.component.modellist');
 
/**
 * OwncloudConnect Model Utilisateurs
 */
class OwncloudConnectModelUtilisateurs extends JModelList
{
	/**
	 * Constructeur de la classe
	 * @param unknown $config
	 */
	public function __construct($config = array()) {
		$config['filter_fields']= array('a.username', 'a.name', 'a.email');
		parent::__construct($config);
	}
	
	/**
	 * Liste des utilisateurs
	 * @see JModelList::getListQuery()
	 */
 	protected function getListQuery()
    {        
    	$db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('b.*, a.*')
		->from($db->quoteName('#__users', 'a'))
		->join('LEFT', $db->quoteName('#__owncloudconnect_utilisateurs', 'b') . ' ON (' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.user_id') . ')')
		->order($db->escape($this->getState('list.ordering', 'a.username')).' '.
         	$db->escape($this->getState('list.direction', 'ASC')));

        // Filtre de recherche
        $regex = str_replace(' ', '|', $this->getState('filter.search'));
        if (!empty($regex)) {
        	$query->where($db->quoteName('a.username') . ' LIKE \'%'.$regex.'%\'');
        }
        
        return $query;
    }
    
    /**
     * Auto populate
     * @see JModelList::populateState()
     */
    protected function populateState($ordering = null, $direction = null)
    {    	
    	// Initialise variables.
    	$app = JFactory::getApplication('administrator');
    
    	//Recherche
    	$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
    	$this->setState('filter.search', preg_replace('/\s+/',' ', $search)); //Supprime les doubles espaces

    	//Order par défaut
    	parent::populateState('a.username', 'asc');
    }
	
	/**
	 * Modification des utilisateurs dans le pannel d'adminisation
	 * forbid_admin = 1 -> connexion refusé dans le BO
	 * forbid_public = 1 -> connexion interdite sur le site front
	 * @param array $users Liste des utilisateurs envoyé par le formulaire
	 * @return object
	 */
	public function saveUtilisateurs($users){
		
		$db = JFactory::getDBO();
		
		foreach($users['User'] as $user){
			$user_id = $user['OC']['user_id'];
			$forbid_admin = (isset($user['OC']['forbid_admin']))? $user['OC']['forbid_admin'] : 0;
			$forbid_public = (isset($user['OC']['forbid_public']))? $user['OC']['forbid_public'] : 0;
			$login = (!empty($user['OC']['login']))? $user['OC']['login'] : '';
			$password = (!empty($user['OC']['password']))? OwncloudconnectHelper::stringEncrypt($user['OC']['password']): '';
			$data_user = new stdClass(); // Create and populate an object.
		
			//On check si l'utilsateur est dans la table Owncloud
        	$query = $db->getQuery(true);
        	$query->select('*')
        	->from($db->quoteName('#__owncloudconnect_utilisateurs', 'a'))
        	->where($db->quoteName('a.user_id') . ' = '.$user_id.'');
        	// Reset the query using our newly populated query object.
			$db->setQuery($query);
			 
			
			$oc_user = $db->loadResult();
			
			//Si utilisateur connu on MAJ
			if($oc_user){
				//Si connexion interdite on MAJ
				if($forbid_admin == 1){		
					// Must be a valid primary key value.
					$data_user = new stdClass();
					$data_user->user_id = $user_id;
					$data_user->forbid_admin= $forbid_admin;
					$data_user->forbid_public = $forbid_public;
					$data_user->admin = 1;
					$data_user->oc_login= '';
					$data_user->oc_password = '';
					$data_user->modified = date('Y-m-d H:i:s');
					// Update their details in the users table using id as the primary key.
					$result = JFactory::getDbo()->updateObject('#__owncloudconnect_utilisateurs', $data_user, 'user_id');
					
				} //Si Utilisateur non désactivé, on MAJ user + password
				elseif($forbid_admin == 0 && $login && $password){
					$data_user->user_id = $user_id;
					$data_user->forbid_admin= $forbid_admin;
					$data_user->forbid_public = $forbid_public;
					$data_user->admin= 1;
					$data_user->oc_login= $login;
					$data_user->oc_password = $password;
					$data_user->modified = date('Y-m-d H:i:s');
					
					// Update their details in the users table using id as the primary key.
					$result = JFactory::getDbo()->updateObject('#__owncloudconnect_utilisateurs', $data_user, 'user_id');
					
				} elseif($forbid_admin == 0 && !$login && !$password){
					if($forbid_public == 0){
						$query = $db->getQuery(true);
						
						// delete all custom keys for user 1001.
						$conditions = array(
							$db->quoteName('user_id') .' = '.$user_id.''
						);
						
						$query->delete($db->quoteName('#__owncloudconnect_utilisateurs'));
						$query->where($conditions);
						
						$db->setQuery($query);
						
						
						$result = $db->query();
					} else {
						$data_user->user_id = $user_id;
						$data_user->forbid_admin= $forbid_admin;
						$data_user->forbid_public = $forbid_public;
						$data_user->admin= 1;
						$data_user->oc_login= $login;
						$data_user->oc_password = $password;
						$data_user->modified = date('Y-m-d H:i:s');
							
						// Update their details in the users table using id as the primary key.
						$result = JFactory::getDbo()->updateObject('#__owncloudconnect_utilisateurs', $data_user, 'user_id');
					}
					
				}
			} else {
				var_dump($forbids_public);
				if($forbid_admin == 1 || $forbid_public == 1 || $login && $password){
					$admin = ($login && $password)? 1 : 0;
					
					$data_user->user_id = $user_id;
					$data_user->forbid_admin= $forbid_admin;
					$data_user->forbid_public = $forbid_public;
					$data_user->admin= $admin;
					$data_user->oc_login= $login;
					$data_user->oc_password = $password;
					$data_user->created = date('Y-m-d H:i:s');
					$data_user->modified = date('Y-m-d H:i:s');
					
					// Insert the object into the user profile table.
					$result = JFactory::getDbo()->insertObject('#__owncloudconnect_utilisateurs', $data_user);
					
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Enregistre les paramètres de connexion pour un utilisateur
	 * @param string $id
	 */
	public function saveUtilisateur($user_id, $user){
		
		
		$login = (!empty($user['OC']['login']))? $user['OC']['login'] : '';
		$password = (!empty($user['OC']['password']))? OwncloudconnectHelper::stringEncrypt($user['OC']['password']): '';
		$data_user = new stdClass(); // Create and populate an object.
				
		$db = JFactory::getDBO();
		//On check si l'utilsateur est dans la table Owncloud
		$query = $db->getQuery(true);
		$query->select('*')
		->from($db->quoteName('#__owncloudconnect_utilisateurs', 'a'))
		->where($db->quoteName('a.user_id') . ' = '.$user_id.'');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$oc_user = $db->loadObject();
		
		//var_dump($oc_user);
			
		if(isset($user['OC']['login']) && $user['OC']['login'] && isset($user['OC']['password']) && $user['OC']['login']){
			
			if($_POST['data']['OC']['password'] != $_POST['data']['OC']['password_confirm']){
				$result = false;
			} else {
					
				//Si l'utilisateur n'a jamais saisi d'identifiants, on insère ses identifiants en BDD sinon on met à jour
				if(!$oc_user){
					
					$data_user->user_id = $user_id;
					$data_user->oc_login= $login;
					$data_user->oc_password = $password;
					$data_user->forbid_admin = 0;
					$data_user->created = date('Y-m-d H:i:s');
					$data_user->modified = date('Y-m-d H:i:s');
						
					// Insert the object into the user profile table.
					$result = JFactory::getDbo()->insertObject('#__owncloudconnect_utilisateurs', $data_user);
					
				} else {					
					$data_user->user_id = $user_id;
					$data_user->oc_login= $login;
					$data_user->oc_password = $password;
					$data_user->forbid_admin = 0;
					$data_user->modified = date('Y-m-d H:i:s');
						
					// Update their details in the users table using id as the primary key.
					$result = JFactory::getDbo()->updateObject('#__owncloudconnect_utilisateurs', $data_user, 'user_id');
					
				}
		
				$this->message = '<div class="updated below-h2" id="message"><p>Vos identifiants ont bien été enregistrés.</p></div>';
			}
		} else {
			//Si utilisateur en BDD et identifiants non définis par admin alors on supprime ses identifiants
			if($oc_user && $oc_user->admin == 0){
				$query = $db->getQuery(true);
					
				// delete all custom keys for user 1001.
				$conditions = array(
						$db->quoteName('user_id') .' = '.$user_id.''
				);
					
				$query->delete($db->quoteName('#__owncloudconnect_utilisateurs'));
				$query->where($conditions);
				$db->setQuery($query);
				$result = $db->query();
			} else {
				$result = true;
			}
		}
		
		return $result;
	}
	
	/**
	 * Récupération des informations utilisateurs dans la table owncloudconnect_utilisateurs
	 * @param number $id
	 * @return Ambigous <mixed, NULL>
	 */
	public function getUtilisateur($id = 0){
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('*')
		->from($db->quoteName('#__owncloudconnect_utilisateurs', 'a'))
		->where($db->quoteName('a.user_id').' = '.$id);
		$db->setQuery($query);
		
		$oc_user = $db->loadObject();
		
		return $oc_user;
	}
	
 
}
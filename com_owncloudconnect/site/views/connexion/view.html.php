<?php
defined('_JEXEC') or die;
/**
 * Connexion à Owncloud dans l'administration
 * @author Jérôme LAFFORGUE
 *
 */

class OwncloudconnectViewConnexion extends JViewLegacy
{
	/**
	 * Affichage de la vue par défaut
	 * @see JView::display()
	 */
	function display($tpl = null)
	{		
  		//Chargement des scripts
		$document = JFactory::getDocument();
		$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
		$document->addScript(JUri::root().'media/com_owncloudconnect/js/owncloudconnect.js');

		//On récupère les variables de session
		$session = JFactory::getSession();
		
		//On récupère le nom du HOST pour connexion sécurisée via iFrame
		$this->ref = urlencode(OwncloudconnectHelper::stringEncrypt($_SERVER['HTTP_HOST']));
		
		//On récupère l'adresse de la plateforme ownCloud
		$param  = JComponentHelper::getParams('com_owncloudconnect');
		$this->owncloud_platformurl = $param->get('owncloud_platformurl');
		
		//On va chercher si l'utilisateur connecté est enregistré dans la table du composant
		$this->oc_user = $this->get('Utilisateur');
		
		//Si l'utilisateur peut se connecter à ownCloud, on regarde si d'autres identifiants sont définis, sinon l'utilisateur accède à la plateforme via ses ident en session
		if(!isset($this->oc_user->forbid_public) || $this->oc_user->forbid_public == 0){
			if($this->oc_user && $this->oc_user->oc_login && $this->oc_user->oc_password){
				$this->login = urlencode(OwncloudconnectHelper::stringEncrypt(json_encode(array('login' => $this->oc_user->oc_login, 'pass' => OwncloudconnectHelper::stringDecrypt($this->oc_user->oc_password)))));
			} else {
				$this->login = urlencode(OwncloudconnectHelper::stringEncrypt(json_encode(array('login' => $session->get('oc_user'), 'pass' => $session->get('oc_password')))));
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		parent::display($tpl);
  }
}
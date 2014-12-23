<?php
defined('_JEXEC') or die;
/**
 * Paramétrage individuel des identifiants ownCloud pour un utilisateur
 * @author Jérôme LAFFORGUE
 *
 */
class OwncloudconnectViewParametres extends JViewLegacy
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
		
		//On récupère le user connecté
		$user = JFactory::getUser();

		$model = JModelLegacy::getInstance('Utilisateurs', 'OwncloudConnectModel');
		$this->oc_user = $model->getUtilisateur($user->id);
		
		$this->admin = (isset($this->oc_user->admin))? $this->oc_user->forbid_admin : null;
		$this->forbid_admin = (isset($this->oc_user->forbid_admin))? $this->oc_user->forbid_admin : null;
		$this->forbid_public = (isset($this->oc_user->forbid_public))? $this->oc_user->forbid_public : null;
		$this->oc_login = (isset($this->oc_user->oc_login))? $this->oc_user->oc_login : null;
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		$this->addToolbar();
		
		parent::display($tpl);
	}
  
	/**
	* Affichage la toolbar
	*/
	protected function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_OWNCLOUDCONNECT'), 'owncloudconnect' );
      	JToolBarHelper::apply('parametres.apply');
	}
}
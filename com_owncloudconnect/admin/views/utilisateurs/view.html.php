<?php
defined('_JEXEC') or die;
/**
 * Liste des utilisateurs dans l'administration
 * @author Jer
 *
 */
class OwncloudconnectViewUtilisateurs extends JViewLegacy
{
	protected $canDo;
	
	/**
	 * Affichage du tableau
	 * @see JView::display()
	 */
	  function display($tpl = null)
	  {
	  	
	  	if (!JFactory::getUser()->authorise('core.admin', 'com_owncloudconnect')){
	  		$app = JFactory::getApplication();
	  		$url = JRoute::_('index.php?option=com_owncloudconnect&view=connexion', false);
	  		JFactory::getApplication()->enqueueMessage('Accès refusé, vous n\'avez pas les droits suffisants', 'error');
	  		$app->redirect($url);
	  	}
	  	
	  	//Chargement des scripts
		$document = JFactory::getDocument();
		$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');

		//On récupère la liste des utilisateurs en provenance du modèle, on prépare la pagniation, l'order, la recherche
		$users = $this->get('Items');
		$pagination = $this->get('Pagination');
		$state = $this->get('State');
			
		$this->sortDirection = $state->get('list.direction');
		$this->sortColumn = $state->get('list.ordering');
		
		$this->users = $users;
		$this->pagination = $pagination;
		
		//Paramètres de recherche
		$this->searchterms = $state->get('filter.search');
		
		//On récupère les permissions
		$this->canDo = OwncloudConnectHelper::getActions();
		
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
	   * Affichage le toolbar
	   */
		protected function addToolbar()
		{
			JToolBarHelper::title(JText::_('COM_OWNCLOUDCONNECT'), 'owncloudconnect' );
	      	JToolBarHelper::apply('utilisateurs.apply');
	      	//Si l'utilisateur a accès à l'administration, il peut modifier les paramètres
	      	if (JFactory::getUser()->authorise('core.admin', 'com_owncloudconnect')){
	      		JToolBarHelper::preferences('com_owncloudconnect', '500');
	      	}
	  	}
	  	
	  	/**
	  	 * Method to set up the document properties
	  	 *
	  	 * @return void
	  	 */
	  	protected function setDocument()
	  	{
	  		$document = JFactory::getDocument();
	  		$document->setTitle(JText::_('COM_OWNCLOUDCONNECT_ADMINISTRATION'));
	  	}
}
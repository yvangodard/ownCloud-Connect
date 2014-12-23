<?php
// No direct forbids.
defined('_JEXEC') or die;

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

<form id="adminForm" name="adminForm" action="<?php echo JRoute::_('index.php?option=com_owncloudconnect&view=utilisateurs'); ?>" method="post">
	<!-- Recherche -->
	<fieldset id="filter-bar">
		<div class="filter-search">
			<div class="btn-wrapper input-append">
		  		<input type="text" name="filter_search" placeholder="Identifiant" id="filter_search" value="<?php echo $this->escape($this->searchterms); ?>" title="<?php //echo JText::_('Search in company, etc.'); ?>" />
				<button type="submit" class="btn">
					<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
				</button>
			</div>
			<div class="btn-wrapper input-append">
				<button type="button" onclick="document.id('filter_search').value='';this.form.submit();" class="btn">
					<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
				</button>
			</div>
		</div>
	</fieldset>
	<!-- End recherche -->
	
	<!-- Table des utilisateurs -->
	<table class="table table-striped adminlist">
		<thead>
			<tr>
				<th><?php echo JHTML::_( 'grid.sort', 'Identifiant', 'a.username', $this->sortDirection, $this->sortColumn); ?></th>
				<th><?php echo JHTML::_( 'grid.sort', 'Nom', 'a.name', $this->sortDirection, $this->sortColumn); ?></th>
				<th><?php echo JHTML::_( 'grid.sort', 'Email', 'a.email', $this->sortDirection, $this->sortColumn); ?></th>
				<th>Interdire la connexion</th>
				<th>Identifiants différents</th>
				<th>Accès public</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->users as $i => $user):
			
			$user->forbid_admin = (isset($user->forbid_admin))? $user->forbid_admin : null;
			$user->forbid_public = (isset($user->forbid_public))? $user->forbid_public : null;
			$user->oc_login = (isset($user->oc_login))? $user->oc_login : null;
			
			$disabled = ($user->forbid_admin == 1)? 'disabled="disabled"' : '';
			$admin_checked = ($user->forbid_admin == 1)? 'checked="checked"' : '';
			$public_checked = ($user->forbid_public == 1)? 'checked="checked"' : '';
			?>
				<tr class="row<?php echo $i % 2; ?>">
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->name; ?></td>
					<td><?php echo $user->email; ?></td>
					<td>
					<input type="hidden" name=jformutilisateurs[User][<?php echo $i; ?>][OC][user_id]" value="<?php echo $user->id; ?>" />
					<input type="checkbox" name="jformutilisateurs[User][<?php echo $i; ?>][OC][forbid_admin]" class="disable-user" value="1" <?php echo $admin_checked; ?>><label>Interdire</label></td>
					<td>
						<div class="user-login">
							<label for="<?php echo $i;?>OcLogin">Login</label>
							<input id="<?php echo $i;?>OcLogin" type="text" name="jformutilisateurs[User][<?php echo $i; ?>][OC][login]" value="<?php echo $user->oc_login; ?>" <?php echo $disabled; ?> style="width:150px;">
							<label for="<?php echo $i;?>OcPassword">Mot de passe</label>
							<input id="<?php echo $i;?>OcPassword" type="password" name="jformutilisateurs[User][<?php echo $i; ?>][OC][password]" <?php echo $disabled; ?> style="width:150px;">
						</div>
					</td>
					<td><input type="checkbox" name="jformutilisateurs[User][<?php echo $i; ?>][OC][forbid_public]" value="1" <?php echo $public_checked; ?>/><label>Interdire</label></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
			<tr>
	        	<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
	<!-- End table des utilisateurs -->
	<input type="hidden" name="option" value="com_owncloudconnect"/>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<script>
	$(function(){
		$(document).on('click', '.disable-user', function(){
			if($(this).is(':checked')){
				console.log('l');
				$(this).parent().next().children().find('input').attr('value', '');
				$(this).parent().next().children().find('input').attr('disabled', true).css('background-color', '#e1e1e1');
			} else {
				$(this).parent().next().children().find('input').attr('disabled', false).css('background-color', 'inherit');
			}
		});
	});
</script>
<style>
#adminForm .adminlist input[disabled="disabled"]{
	background-color:#e1e1e1;
}

#adminForm .adminlist label, #adminForm .adminlist input{
	display:inline;
	margin:0;
}
</style>
<?php
// No direct forbids.
defined('_JEXEC') or die;

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>

<?php
if(isset($this->oc_user->admin) && $this->oc_user->admin == 1){?>
	<p>Vous ne pouvez pas modifier vos identifiants car il ont été modifiés par votre administrateur.</p>
<?php } else { 

	$checked = 'checked="checked"';
	$disabled = '';
	if(!isset($this->oc_login) || $this->forbid_admin == 1){
		$checked = ''; 
		$disabled = 'disabled="disabled"';
	}
?>

<form id="OcFormParametres" action="<?php echo JRoute::_('index.php?option=com_owncloudconnect&view=parametres'); ?>" method="post" name="adminForm" autocomplete="off" class="form-horizontal">
	<fieldset class="adminform">
		<legend>Paramètres de connexion</legend>
		<input type="hidden" name="option" value="com_owncloudconnect"/>
		<input type="hidden" name="task" value=""/>
		
		<div class="control-group">
			<input type="checkbox" id="OcMapUser" value="1" name="jformutilisateur[OC][map_user]" style="display:inline;margin: 0;" <?php echo $checked; ?>><label style="display:inline;clear:none;margin: 0 0 0 7px;" for="OcMapUser">Mapper de nouveaux identifiants</label>
		</div>
		
		<div class="control-group">
			<div class="control-label">
				<label for="OcLogin">Identifiant</label>
			</div>
			<div class="controls">
				<input type="text" name="jformutilisateur[OC][login]" id="OcLogin" style="width:20%;" value="<?php echo $this->oc_login; ?>" <?php echo $disabled;?>>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="OcPassword">Mot de passe</label>
			</div>
			<div class="controls">
				<input type="password" required="required" name="jformutilisateur[OC][password]" id="OcPassword" value="" style="width:20%;" <?php echo $disabled;?>>
			</div>
		</div>
		<div class="control-group">
			<div class="control-label">
				<label for="OcPasswordConfirm">Confirmation</label>
			</div>
			<div class="controls">
				<input type="password" required="required" name="jformutilisateur[OC][password_confirm]" id="OcPasswordConfirm" value="" style="width:20%;" <?php echo $disabled;?>>
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</fieldset>
</form>
<?php }?>

<script>
$(function(){
	Joomla.submitbutton = function(task)
	{
		if(($('#OcLogin').val() != '' && $('#OcPassword').val() != '' && $('#OcPassword').val() == $('#OcPasswordConfirm').val()) || $('#OcMapUser').is(':checked') == false){
			Joomla.submitform(task, document.getElementById('OcFormParametres'));
		} else {
			//On check si le login est bien saisi
			if($('#OcLogin').val() == ''){
				$('#OcLogin').css('border', '1px solid red');
			} else {
				$('#OcLogin').css('border', '1px solid #ccc');
			}
			
			//On check si les Password sont identiques
			if($('#OcPassword').val() != $('#OcPasswordConfirm').val() || $('#OcPassword').val() == ''){
				$('#error-password').remove();
				$('#OcPassword').after('<div id="error-password" style="float:left;color:red;">Mot de passe manquant ou différent du mot de passe de confirmation</div>');
			} else {
				$('#error-password').remove();
			}
		}
		
	}
	
	$('#OcMapUser').on('click', function(){
		if(!$(this).is(':checked')){
			$('#OcFormParametres #OcLogin, #OcFormParametres #OcPassword, #OcFormParametres #OcPasswordConfirm').attr('disabled', true);
		} else {
			$('#OcFormParametres #OcLogin, #OcFormParametres #OcPassword, #OcFormParametres #OcPasswordConfirm').attr('disabled', false);
		}
	});
});
</script>
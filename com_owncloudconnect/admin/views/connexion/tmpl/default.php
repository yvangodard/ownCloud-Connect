<?php
// No direct forbids.
defined('_JEXEC') or die;
?>

<div id="owncloud-connect-connexion">
	<?php if(isset($this->oc_user->forbid_admin) && $this->oc_user->forbid_admin == 1){ ?>
		<div class="error">
			<p>La connexion a été interdite par votre administrateur</p>
		</div>
	<?php } elseif($this->owncloud_platformurl) { ?>
		<p id="ajax-loader"><img class="ajax-success" style="margin:5px 5px 0 0;" src="<?php echo JURI::root();?>media/com_owncloudconnect/images/ajax-loader.gif"> Chargement de la plateforme</p>
		<iframe src="<?php echo $this->owncloud_platformurl; ?>/index.php/apps/wp_connect/?login=<?php echo $this->login; ?>&ref=<?php echo $this->ref;?>" width="100%" id="owncloud-connect-iframe" style="display:none;"></iframe>
	<?php } else { ?>
		<div class="error">
			<p>L'adresse de la plateforme Owncloud n'a pas été définie par votre administrateur</p>
		</div>
	<?php } ?>
</div>
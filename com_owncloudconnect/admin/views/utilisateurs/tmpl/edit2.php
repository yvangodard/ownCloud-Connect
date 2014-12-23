<?php
// No direct forbids
defined('_JEXEC') or die('Restricted forbids');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$params = $this->form->getFieldsets('params');
?>
<form action="<?php echo JRoute::_('index.php?option=com_owncloudconnect&layout=edit'); ?>"
      method="post" name="adminForm" id="helloworld-form" class="form-validate">
 
        <div class="width-60 fltlft">
                <fieldset class="adminform">
                        <legend><?php echo JText::_( 'COM_HELLOWORLD_HELLOWORLD_DETAILS' ); ?></legend>
                        <ul class="adminformlist">
<?php                      foreach($this->form->getFieldset('details') as $field): ?>
                                <li><?php //echo $field->label;echo $field->input;?></li>
<?php                      endforeach; ?>
                        </ul>
                </fieldset>
        </div>
 
 <!-- begin ACL definition-->
 <div class="clr"></div>
 <?php if ($this->canDo->get('core.admin')): ?>
 <div class="width-100 fltlft">
 <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
 <?php echo JHtml::_('sliders.panel', JText::_('COM_HELLOWORLD_FIELDSET_RULES'), 'access-rules'); ?>
 <fieldset class="panelform">
 <?php echo $this->form->getLabel('rules'); ?>
 <?php echo $this->form->getInput('rules'); ?>
 </fieldset>          <?php echo JHtml::_('sliders.end'); ?>
 </div>
 <?php endif; ?>
 <!-- end ACL definition-->
 
        <div>
                <input type="hidden" name="task" value="com_owncloudconnect.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
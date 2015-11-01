<?php
defined( '_JEXEC' ) or die( 'Restricted access' );


?>


<form method="post" action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=add'); ?>">
<div class="row-fluid">
	<div class="span4">
	<?php foreach($this->form->getFieldset("default_left") as $field): ?>
		<?php if ($field->hidden):// If the field is hidden, just display the input.?>
			<div><?php echo $field->input;?></div>
		<?php else:?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
				</div>
				<div class="controls">
					<?php echo $field->input;?>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach; ?>
	<div class="clearfix"></div>
	</div>
	<div class="span4">
	<?php foreach($this->form->getFieldset("default_right") as $field): ?>
		<?php if ($field->hidden):// If the field is hidden, just display the input.?>
			<?php echo $field->input;?>
		<?php else:?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
				</div>
				<div class="controls">
					<?php echo $field->input;?>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach; ?>
	</div>
	<div class="clearfix"></div>
	<button class="btn"><?php echo JText::_('COM_DDC_SUBMIT'); ?></button>
</div>
<input name="jform[user_id]" type="hidden" id="jform_user_id" value="<?php echo JFactory::getUser()->id;?>" />
</form>

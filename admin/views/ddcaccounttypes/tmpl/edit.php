<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=add'); ?>"
      method="post" name="adminForm" id="adminForm">
        <fieldset class="adminform">
                <legend><?php echo JText::_( 'COM_DDC_ACCOUNT_TYPES' ); ?></legend>
                <div class="adminformlist">
					<div class="span9">
					<div class="row-fluid">
					<?php foreach($this->form->getFieldset('left') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"></span>
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
					</div>
					<div class="span3">
					<?php foreach($this->form->getFieldset('right') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div class="control-group">
							<div class="control-label">
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span class="optional"></span>
							<?php endif; ?>
							</div>
							<div class="controls">
								<?php echo $field->input;?>
							</div>
						</div>
						<?php endif;?>
					<?php endforeach; ?>
					</div>
				</div>
        </fieldset>
        <div>
                <input type="hidden" name="task" value="accounttype.edit" />
                <?php echo JHtml::_('form.token'); ?>
        </div>
	</form>
</div>

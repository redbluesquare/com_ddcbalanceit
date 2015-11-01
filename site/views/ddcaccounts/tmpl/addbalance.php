<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<table class="table">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_DDC_ID'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NAME'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_TYPE'); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $this->item->ddcbi_account_id; ?></td>
				<td><?php echo $this->item->account_name;  ?></td>
				<td><?php echo $this->item->at;  ?></td>
			</tr>
		</tbody>
	</table>
<form method="post" action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=add'); ?>">
<?php echo "<h3>".JText::_('COM_DDC_BALANCE')."</h3>";?>
	<div class=row-fluid">
	<div class="span4">
	<?php foreach($this->form->getFieldset("default_date") as $field): ?>
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
	<div class="span2">
		<div class="control-group" style="text-align:center;">
			<div class="control-label">
				<label id="jform_balance_dr-lbl" for="jform_balance_dr"><?php echo JText::_('COM_DDC_DEBIT'); ?></label>
			</div>
			<div class="controls">
				<input type="text" style="text-align:right;" id="jform_balance_dr" name="jform[balance_dr]" class="span10" value="<?php if($this->balance->balance>=0){echo number_format($this->balance->balance,2);} ?>" />
			</div>
		</div>
	</div>
	<div class="span2">
		<div class="control-group" style="text-align:center;">
			<div class="control-label">
				<label id="jform_balance_cr-lbl" for="jform_balance_cr"><?php echo JText::_('COM_DDC_CREDIT'); ?></label>
			</div>
			<div class="controls">
				<input type="text" style="text-align:right;" id="jform_balance_cr" name="jform[balance_cr]" class="span10" value="<?php if($this->balance->balance<0){echo number_format($this->balance->balance,2);} ?>" />
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
	<button class="btn"><?php echo JText::_('COM_DDC_SUBMIT'); ?></button>
		<?php foreach($this->form->getFieldset("default_left") as $field): ?>
		<?php if ($field->hidden):// If the field is hidden, just display the input.?>
			<div><?php echo $field->input;?></div>
		<?php else:?>
			<div class="span2">
			<div class="control-group" style="text-align:center;">
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
			</div>
		<?php endif;?>
	<?php endforeach; ?>
<input name="jform[user_id]" type="hidden" id="jform_user_id" value="<?php echo JFactory::getUser()->id;?>" />
<input name="jform[account_name]" type="hidden" id="jform_account_name" value="<?php echo $this->item->ddcbi_account_id;?>" />
</form>

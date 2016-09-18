<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$user = JFactory::getUser();
?>
<div class="row-fluid">
	<div class="span12">
		<a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit'); ?>"><i class="icon-arrow-left"></i><?php echo JText::_('COM_DDC_BACK_TO_DASHBOARD'); ?></a>
	</div>
</div>
<div class="row-fluid">
	<div class="span4">
		
	</div>
	<div class="span8">
		<h3><?php echo JText::_('COM_DDC_USER_CONFIGURATION'); ?></h3>
		<form method="post" action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=update'); ?>">
			<label for="default_currency"><?php echo JText::_('COM_DDC_DEFAULT_CURRENCY'); ?></label>
			<select name="default_currency" id="default_currency">
				<option value="EURO" <?php if($user->getParam('default_currency','EURO')=='EURO'){echo 'selected="selected"';}?>><?php echo JText::_('EURO');?></option>
				<option value="GBP" <?php if($user->getParam('default_currency','EURO')=='GBP'){echo 'selected="selected"';}?>><?php echo JText::_('GBP');?></option>
				<option value="ZAR" <?php if($user->getParam('default_currency','EURO')=='ZAR'){echo 'selected="selected"';}?>><?php echo JText::_('ZAR');?></option>
			</select>
			<label for="use_dr_cr"><?php echo JText::_('COM_DDC_USE_DEBIT_CREDIT'); ?></label>
			<select name="use_dr_cr" id="use_dr_cr">
				<option value="1" <?php if($user->getParam('use_dr_cr','1')=='1'){echo 'selected="selected"';}?>><?php echo JText::_('YES');?></option>
				<option value="0" <?php if($user->getParam('use_dr_cr','1')=='0'){echo 'selected="selected"';}?>><?php echo JText::_('NO');?></option>
			</select>
			<label for="record_transactions"><?php echo JText::_('COM_DDC_RECORD_TRANSACTIONS'); ?></label>
			<select name="record_transactions" id="record_transactions">
				<option value="1" <?php if($user->getParam('record_transactions','0')=='1'){echo 'selected="selected"';}?>><?php echo JText::_('YES');?></option>
				<option value="0" <?php if($user->getParam('record_transactions','0')=='0'){echo 'selected="selected"';}?>><?php echo JText::_('NO');?></option>
			</select>
			<label for="send_reminders"><?php echo JText::_('COM_DDC_SEND_REMINDERS'); ?></label>
			<select name="send_reminders" id="send_reminders">
				<option value="0" <?php if($user->getParam('send_reminders','0')=='0'){echo 'selected="selected"';}?>><?php echo JText::_('NEVER');?></option>
				<option value="1" <?php if($user->getParam('send_reminders','0')=='1'){echo 'selected="selected"';}?>><?php echo JText::_('DAILY');?></option>
				<option value="2" <?php if($user->getParam('send_reminders','0')=='2'){echo 'selected="selected"';}?>><?php echo JText::_('WEEKLY');?></option>
				<option value="3" <?php if($user->getParam('send_reminders','0')=='3'){echo 'selected="selected"';}?>><?php echo JText::_('FORTH NIGHTLY');?></option>
				<option value="4" <?php if($user->getParam('send_reminders','0')=='4'){echo 'selected="selected"';}?>><?php echo JText::_('MONTHLY');?></option>
			</select>
			<input type="hidden" name="table" value="configuration" />
			<br/>
			<button type="submit" class="btn btn-primary"><?php echo JText::_('COM_DDC_SAVE')?></button>
		</form>
	</div>
</div>
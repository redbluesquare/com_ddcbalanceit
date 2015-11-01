<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');
$user = JFactory::getUser();
?>

<div class="row-fluid">
<script>

	data = <?php echo json_encode($this->balances);?>;

	window.onload = function(){
		draw("myCanvas",data);
			var activeAccount = document.getElementById("activeAccount");
			activeAccount.addEventListener("mouseover", function (){
				jQuery("#activeAccountBtn").show();
			});
			activeAccount.addEventListener("mouseout", function (){
				jQuery("#activeAccountBtn").hide();
			});
	};
</script>
<div class="row-fluid">
	<div class="span12">
		<a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit'); ?>">
			<i class="icon-arrow-left"></i><?php echo JText::_('COM_DDC_BACK_TO_ACCOUNTS'); ?></a>
	</div>
</div>
	<div class="span9">
		<form id="chngdates" method="get" action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=filter'); ?>">
		<?php echo JHTML::calendar('','datestart','datestart','%d-%m-%Y',array('class'=>'','placeholder'=>'Start Date'));?>
		<?php echo JHTML::calendar('','dateend','dateend','%d-%m-%Y',array('class'=>'','placeholder'=>'End Date'));?>
		<input id="ddcaccount_id" type="hidden" name="ddcaccount_id" value="<?php echo $this->item->ddcbi_account_id; ?>"/>
		<button id="btn-submit" class="btn pull-right"><?php echo JText::_('COM_DDC_UPDATE'); ?></button>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="span12" id="activeAccount">
		<span style="padding-top:5px;font-weight:400;" class="pull-right">
			<?php echo JText::_('COM_DDC_TARGET_DATE').": ";?><span style="font-weight:400;color:rgb(100,100,100)" class="pull-right"><?php echo JHtml::date($this->item->target_date,"d/m/Y"); ?></span><br/>
			<?php echo JText::_('COM_DDC_TARGET').": ";?><span style="font-weight:400;color:rgb(100,100,100)" class="pull-right"><?php echo "&pound; ".number_format($this->item->target_balance,2); ?></span><br/>
			<?php echo JText::_('COM_DDC_BALANCE').": ";?><span class="pull-right"><?php echo "&pound; ".number_format($this->item->balance,2); ?></span><br />
		</span>
		<h3>
			<?php echo JText::_('COM_DDC_ACCOUNT_NAME').": ".$this->item->account_name?>
			<a href="<?php echo JRoute::_('index.php?view=ddcaccounts&layout=add&ddcaccount_id='.$this->item->ddcbi_account_id); ?>" id="activeAccountBtn" class="btn" style="display:none;"><i class="icon-pencil"></i></a>
		</h3>
		<div class="span12">
			<a href="#targetModal" role="button" class="btn pull-right" data-toggle="modal"><?php echo JText::_('COM_DDC_ADD_TARGET'); ?></a>
			<a href="#balanceModal" role="button" class="btn pull-right" data-toggle="modal"><?php echo JText::_('COM_DDC_ADD_BALANCE'); ?></a>  
			<a  class="btn btn-small" data-toggle="collapse" data-target="#account_info">
  				<?php echo JText::_('COM_DDC_VIEW_DETAILS'); ?>
			</a>
			<div id="account_info" class="collapse out">
				<table  class="span8">
					<tr><td><b><?php echo JText::_('COM_DDC_ACCOUNT_TYPE');?></b></td><td><?php echo $this->item->account_type;?></td></tr>
					<tr><td class="span7"><b><?php echo JText::_('COM_DDC_ACCOUNT_NUMBER');?></b></td><td class="span5"><?php echo $this->item->account_number;?></td></tr>
  					<tr><td><b><?php echo JText::_('COM_DDC_SORT_CODE');?></b></td><td><?php echo $this->item->sort_code;?></td></tr>
  					<tr><td><b><?php echo JText::_('COM_DDC_INTEREST_RATE');?></b></td><td><?php echo $this->item->interest_rate;?></td></tr>
				</table>
			</div>
		</div>
	</div>
	<hr />
	<div class="clearfix"></div>
</div>
<div class="row-fluid">
	<div class="span6">
		<table class="table table-border">
			<thead>
				<tr>
					<th><?php echo JText::_('COM_DDC_DATE')?></th>
					<th style="text-align:right;"><?php echo JText::_('COM_DDC_BALANCE')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($this->balances as $balance):?>
				<tr>
					<td><a href="#balanceModal" data-toggle="modal" onclick="updateBalance(<?php echo $balance->ddcbi_balance_id; ?>)"><?php echo $balance->record_date; ?></a></td>
					<td style="text-align:right;"><?php echo "&pound; ".number_format($balance->balance, 2); ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<canvas height="300" id="myCanvas" width="450" ></canvas>
	</div>
	<div class="clearfix"></div>
</div>
<div>

</div>

<div id="balanceModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo JText::_('COM_DDC_ADD_BALANCE'); ?></h3>
  </div>
  <div class="modal-body">
  	<form id="updateBalanceForm">
    <table class="table">
		<tbody>
			<tr>
				<th class="span5"><?php echo JText::_('COM_DDC_ID'); ?></th>
				<td class="span7"><?php echo $this->item->ddcbi_account_id;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NAME'); ?></th>
				<td><?php echo $this->item->account_name; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_TYPE'); ?></th>
				<td><?php echo $this->item->at;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_SORT_CODE'); ?></th>
				<td><?php echo $this->item->sort_code;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NUMBER'); ?></th>
				<td><?php echo $this->item->account_number;  ?></td>
			</tr>
		</tbody>
	</table>
	<div class="span12">
		<?php foreach($this->form->getFieldset("default_date") as $field): ?>
		<?php if ($field->hidden):// If the field is hidden, just display the input.?>
			<?php echo $field->input;?>
		<?php else:?>
			<div class="control-group">
				<div class="control-label span5">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
				</div>
				<div class="controls span7">
					<?php echo $field->input;?>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach; ?>
		<div class="control-group">
			<div class="span5">
				<label for=""><?php echo JText::_('COM_DDC_BALANCE')?></label>
			</div>
			<div class="span7">
				<?php if($user->getParam('use_dr_cr','1') == '0'){?>
				<select id="jform_plus_minus" name="jform[plus_minus]" style="width:77px;">
					<option value="1"><?php echo JText::_('COM_DDC_PLUS'); ?></option>
					<option value="0"><?php echo JText::_('COM_DDC_MINUS'); ?></option>
				</select>
				<?php } ?>
				<input type="text" style="text-align:right; width:150px;" id="jform_balance" name="jform[balance]" value="" />
				
				<?php if($user->getParam('use_dr_cr','1') == '1'){?>
				<select id="jform_debit_credit" name="jform[debit_credit]" style="width:77px;">
					<option value="dr"><?php echo JText::_('COM_DDC_DEBIT'); ?></option>
					<option value="cr"><?php echo JText::_('COM_DDC_CREDIT'); ?></option>
				</select>
				<?php } ?>
				
			</div>
		</div>
				<input type="hidden" id="jform_ddcbi_account_id" name="jform[ddcbi_account_id]" value="<?php echo $this->item->ddcbi_account_id; ?>" />
				<input type="hidden" id="jform_account_nature" name="jform[account_nature]" value="<?php echo $this->item->account_nature?>" />
				<input type="hidden" id="jform_table" name="jform[table]" value="ddcbalances" />
				<input type="hidden" id="jform_ddcbi_balance_id" name="jform[ddcbi_balance_id]" value="" />
	</div>
	</form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger" onclick="deleteBalance()"><?php echo JText::_('COM_DDC_DELETE');?></button>
    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDC_CANCEL');?></button>
    <button type="button" onclick="saveBalance()" class="btn btn-primary"><?php echo JText::_('COM_DDC_SAVE_CHANGES'); ?></a>
  </div>
</div>

<div id="targetModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo JText::_('COM_DDC_ADD_BALANCE'); ?></h3>
  </div>
  <div class="modal-body">
  	<form id="updateTargetForm">
    <table class="table">
		<tbody>
			<tr>
				<th class="span5"><?php echo JText::_('COM_DDC_ID'); ?></th>
				<td class="span7"><?php echo $this->item->ddcbi_account_id;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NAME'); ?></th>
				<td><?php echo $this->item->account_name; ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_TYPE'); ?></th>
				<td><?php echo $this->item->at;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_SORT_CODE'); ?></th>
				<td><?php echo $this->item->sort_code;  ?></td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NUMBER'); ?></th>
				<td><?php echo $this->item->account_number;  ?></td>
			</tr>
		</tbody>
	</table>
	<div class="span12">
		<?php foreach($this->formtb->getFieldset("default_date") as $field): ?>
		<?php if ($field->hidden):// If the field is hidden, just display the input.?>
			<?php echo $field->input;?>
		<?php else:?>
			<div class="control-group">
				<div class="control-label span5">
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type != 'Spacer') : ?>
						<span class="optional"><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
					<?php endif; ?>
				</div>
				<div class="controls span7">
					<?php echo $field->input;?>
				</div>
			</div>
		<?php endif;?>
	<?php endforeach; ?>
		<div class="control-group">
			<div class="span5">
				<label for=""><?php echo JText::_('COM_DDC_TARGET_BALANCE')?></label>
			</div>
			<div class="span7">
				<?php if($user->getParam('use_dr_cr','1') == '0'){?>
				<select id="jform_plus_minus" name="jform[plus_minus]" style="width:77px;">
					<option value="1"><?php echo JText::_('COM_DDC_PLUS'); ?></option>
					<option value="0"><?php echo JText::_('COM_DDC_MINUS'); ?></option>
				</select>
				<?php } ?>
				<input type="text" style="text-align:right; width:150px;" id="jform_target_balance" name="jform[target_balance]" value="" />
				
				<?php if($user->getParam('use_dr_cr','1') == '1'){?>
				<select id="jform_debit_credit" name="jform[debit_credit]" style="width:77px;">
					<option value="dr"><?php echo JText::_('COM_DDC_DEBIT'); ?></option>
					<option value="cr"><?php echo JText::_('COM_DDC_CREDIT'); ?></option>
				</select>
				<?php } ?>
				
			</div>
		</div>
				<input type="hidden" id="jform_account_id" name="jform[ddcbi_account_id]" value="<?php echo $this->item->ddcbi_account_id; ?>" />
				<input type="hidden" id="jform_accounttype_id" name="jform[ddcbi_accounttype_id]" value="<?php echo $this->item->ddcbi_account_type_id; ?>" />
				<input type="hidden" id="jform_account_nature" name="jform[account_nature]" value="<?php echo $this->item->account_nature?>" />
				<input type="hidden" id="jform_table" name="jform[table]" value="ddctargets" />
				<input type="hidden" id="jform_ddcbi_target_id" name="jform[ddcbi_target_id]" value="" />
	</div>
	</form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger" onclick="deleteTargetBalance()"><?php echo JText::_('COM_DDC_DELETE');?></button>
    <button type="button" class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_DDC_CANCEL');?></button>
    <button type="button" onclick="saveTargetBalance()" class="btn btn-primary"><?php echo JText::_('COM_DDC_SAVE_CHANGES'); ?></a>
  </div>
</div>
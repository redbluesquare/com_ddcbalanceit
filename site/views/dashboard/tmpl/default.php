<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$blnce = null;
$target = null;
$ddcgoalsModel = new DdcbalanceitModelsDdcgoals();
$user = JFactory::getUser();
foreach( $this->items as $item ):
	$blnce += $item->balance;
	$target += $item->target_balance;
endforeach;

?>
<div class="row-fluid">
	<div class="col-xs-12">
	<table class="table">
		<thead>
			<tr>
				<td colspan="3">
					<a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcprofile'); ?>" class="btn btn-default"><?php echo JText::_('COM_DDC_VIEW_PROFILE'); ?></a>
					<a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcgoals&layout=add'); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> <?php echo JText::_('COM_DDC_GOAL'); ?></a>
					<a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcaccounts&layout=add'); ?>" class="pull-right btn btn-success"><i class="glyphicon glyphicon-plus"></i> <?php echo JText::_('COM_DDC_ACCOUNT'); ?></a>
				</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->goals as $goal):?>
			<?php $late = $ddcgoalsModel->isLate($goal->target_date,$goal->end_date)?>
			<tr>
				<td><a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcgoals&layout=default&ddcgoal_id='.$goal->ddc_goal_id) ?>" class="goal-title"><?php echo $goal->title; ?></span><br>
				<span class="goal-subtitle"><?php echo $goal->motivation; ?></a></td>
				<td><?php JHtml::date($goal->target_date,"dd MMM YYYY"); ?></td>
				<td class="goal-date"><span class="<?php echo $late; ?>"><?php echo JHtml::date($goal->target_date,"d M Y"); ?></span></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<div class="clearfix"></div>
</div>

<div class="row-fluid">
	<div class="col-xs-12">
	<table class="table">
		<thead>
			<tr>
				<td colspan="6">
				</td>
				<td>
					<?php echo JText::_('COM_DDC_TARGET_BALANCE').": "; ?><br/>
					<?php echo JText::_('COM_DDC_BALANCE').": "; ?>
				</td>
				<td>
				<span style="padding-top:5px;font-weight:600; text-align:right;" class="pull-right">
					<?php echo number_format($target,2); ?><br />
					<?php echo number_format($blnce,2); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><?php echo JText::_('COM_DDC_ID'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NAME'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_TYPE'); ?></th>
				<th><?php echo JText::_('COM_DDC_INTEREST_RATE'); ?></th>
				<th><?php echo JText::_('COM_DDC_BALANCE_DATE'); ?></th>
				<th style="text-align:center"><?php echo JText::_('COM_DDC_BALANCE'); ?></th>
				<th style="text-align:center"><?php echo JText::_('COM_DDC_TARGET_DATE'); ?></th>
				<th style="text-align:center"><?php echo JText::_('COM_DDC_TARGET'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $this->items as $item ):?>
			<tr>
				<td><?php echo $item->ddcbi_account_id; ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcaccounts&ddcaccount_id='.$item->ddcbi_account_id); ?>"><?php echo $item->account_name;  ?></a></td>
				<td><?php echo $item->acc_type_title;  ?></td>
				<td style="text-align:center"><?php echo number_format($item->interest_rate,2);  ?></td>
				<td style="text-align:center"><?php echo JHtml::date($item->record_date,"d/m/Y");  ?></td>
				<?php if($user->getParam('use_dr_cr','1') == '0'){?>
				<td style="text-align:center"><?php if($item->balance<0 ){echo "-".number_format(-$item->balance,2); }else{echo number_format($item->balance,2);}  ?></td>
				<?php }else{?>
				<td style="text-align:center"><?php if($item->balance<0 ){echo number_format(-$item->balance,2)." ".ucwords(JText::_('COM_DDC_CREDIT')); }else{echo number_format($item->balance,2);}  ?></td>
				<?php } ?>
				<td style="text-align:center"><?php if($item->target_date!=null){echo JHtml::date($item->target_date,"d/m/Y");}else{echo "-";} ?></td>
				<?php if($user->getParam('use_dr_cr','1') == '0'){?>
				<td style="text-align:center"><?php if($item->target_balance<0 ){echo "-".number_format(-$item->target_balance,2); }elseif($item->target_balance==0){echo '-';}else{echo number_format($item->target_balance,2);}  ?></td>
				<?php }else{?>
				<td style="text-align:center"><?php if($item->target_balance<0 ){echo number_format(-$item->target_balance,2)." ".ucwords(JText::_('COM_DDC_CREDIT')); }elseif($item->target_balance==0){echo '-';}else{echo number_format($item->target_balance,2);}  ?></td>
				<?php } ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
</div>

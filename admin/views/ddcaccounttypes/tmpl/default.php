<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$an = array("1"=>"Asset", "2"=>"Liability");
?>
<form action="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&controller=add'); ?>" method="post" name="adminForm" id="adminForm">
<div class="row-fluid">
	<table class="table table-striped" id="adminList">
		<thead>
			<tr>
				<th><?php echo JText::_('COM_DDC_STATUS'); ?></th>
				<th><?php echo JText::_('COM_DDC_ID'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_TYPE'); ?></th>
				<th><?php echo JText::_('COM_DDC_ACCOUNT_NATURE'); ?></th>
				<th><?php echo JText::_('COM_DDC_MODIFIED'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php for($i = 0; $i < count($this->items); $i++):?>
			<tr>
				<td><?php echo JHtml::_('jgrid.published', $this->items[$i]->state, $i); ?></td>
				<td><?php echo $this->items[$i]->ddcbi_account_type_id; ?></td>
				<td><a href="<?php echo JRoute::_('index.php?option=com_ddcbalanceit&view=ddcaccounttypes&layout=edit&ddcaccounttype_id='.$this->items[$i]->ddcbi_account_type_id); ?>"><?php echo $this->items[$i]->account_type; ?></a></td>
				<td><?php echo $an[$this->items[$i]->account_nature]; ?></td>
				<td><?php echo $this->items[$i]->modified; ?></td>
			</tr>
			<?php endfor; ?>
		</tbody>
	</table>
	<div class="clearfix"></div>
	<input type="hidden" name="jform[table]" value="ddcaccounttypes" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</div>
</form>
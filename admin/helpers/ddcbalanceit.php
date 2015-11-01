<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ddcbalanceit
 */

defined('_JEXEC') or die;

/**
 * Ddcbalanceit component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_ddcbalanceit
 * @since       1.6
 */
class DdcbalanceitHelpersDdcbalanceit
{
	public static $extension = 'com_ddcbalanceit';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_ddcbalanceit';
		$level = 'component';

		$actions = JAccess::getActions('com_ddcbalanceit', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
	
	public static function addSubmenu($submenu)
	{
		JSubMenuHelper::addEntry(JText::_('COM_DDC_DASHBOARD'),
		'index.php?option=com_ddcbalanceit&view=dashboard', $submenu == 'dashboard');
		JSubMenuHelper::addEntry(JText::_('COM_DDC_ACCOUNT_TYPES'),
		'index.php?option=com_ddcbalanceit&view=ddcaccounttypes', $submenu == 'ddcaccounttypes');
		// set some global property
		$document = JFactory::getDocument();

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_DDCBALANCEIT_ADMINISTRATION_CATEGORIES'));
		}
	}
}
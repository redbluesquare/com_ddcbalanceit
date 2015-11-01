<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 


function DdcbalanceitBuildRoute(&$query)
{

	$segments = array();
	//$segments = array( 'view' => 'ddcaccounts', 'ddcaccount_id' => 1 );
	if (isset($query['view']))
	{
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if (isset($query['layout']))
	{
		$segments[] = $query['layout'];
		unset($query['layout']);
	}
	if (isset($query['ddcaccount_id']))
	{
		// Make sure we have the id and the alias
		if (strpos($query['ddcaccount_id'], ':') === false)
		{
 			$db = JFactory::getDbo();
 			$dbQuery = $db->getQuery(true)
 			->select('alias')
 			->from('#__ddcbi_accounts')
 			->where('ddcbi_account_id=' . (int) $query['ddcaccount_id']);
 			$db->setQuery($dbQuery);
 			$alias = $db->loadResult();
 			$query['ddcaccount_id'] = $query['ddcaccount_id'].":".$alias;
			
			$segments[] = $query['ddcaccount_id'];
			unset($query['ddcaccount_id']);
		}
		
		
	}

	return $segments;
}

function ddcbalanceitParseRoute($segments) 
{
	$total = count($segments);
	$vars = array();
	switch($segments[0])
	{
		case 'ddcaccounts':
			$vars['view'] = 'ddcaccounts';
			if($total == 3)
			{
				$vars['layout'] = 'add';
				$ddcaccount_id = explode('-', $segments[2]);
				$vars['ddcaccount_id'] =  (int)$ddcaccount_id[0];
			}
			elseif($total==2)
			{
				if($segments[1]=='add')
				{
					$vars['layout'] = 'add';
				}
				else 
				{
					$ddcaccount_id = explode('-', $segments[1]);
					$vars['ddcaccount_id'] =  (int)$ddcaccount_id[0];
				}
			}
			break;
		case 'ddcprofile':
			$vars['view'] = 'ddcprofile';
			break;
		case 'dashboard':
				$vars['view'] = 'dashboard';
				$ddcaccount_id = explode('-', $segments[1]);
				$vars['ddcaccount_id'] =  (int)$ddcaccount_id[0];
				break;
	}
	$count = count($segments);
	return $vars;
}
//}
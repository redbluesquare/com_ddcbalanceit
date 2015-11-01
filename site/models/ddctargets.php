<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDdctargets extends DdcbalanceitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_holiday_id    		= null;
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  var $_user_id     	= null;
  var $_formdata		= null;
  var $_datestart		= null;
  var $_dateend			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);

  	$this->_ddcaccount_id = $app->input->get('ddcaccount_id', null);
  	$this->_residence_id = $app->input->get('residence_id', null);
  	$this->_cat_id = $app->input->get('id', null);
  	$this->_datestart = $app->input->get('datestart', null);
  	$this->_dateend = $app->input->get('dateend', null);
  	
  	$jinput = JFactory::getApplication()->input;
	$this->_formdata    = $jinput->get('jform', array(),'array');
  	  	
    parent::__construct();       
  }
   
	
  /**
  * Builds the query to be used by the product model
  * @return   object  Query object
  *
  *
  */
  protected function _buildQuery()
  {
 	
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('a.*');
    $query->from('#__ddcbi_accounts as a');
    
    $query->select('u.name as user');
    $query->rightJoin('#__users as u on u.id = a.user_id');
    
    $query->select('at.ddcbi_account_type_id, at.account_nature');
    $query->select('at.account_type as at');
    $query->rightJoin('#__ddcbi_account_types as at on at.ddcbi_account_type_id = a.account_type');
    
    $query->select('(SELECT bb.balance FROM #__ddcbi_balances as bb WHERE bb.record_date = max(b.record_date) AND (bb.state = 1) AND bb.account_name = a.ddcbi_account_id GROUP BY bb.account_name) as balance');
    $query->select('max(b.record_date) as record_date');
    $query->select('b.account_name as an');
    $query->select('t.target_balance, t.target_date');
    $query->select('datediff(t.target_date,b.record_date) as days_to_go');
    $query->select('Format(t.target_balance / datediff(t.target_date,b.record_date),2)) as target_per_day');
    $query->select('#__ddcbi_targets as t on t.account_id = a.ddcbi_account_id');
    $query->rightJoin('#__ddcbi_balances as b on b.account_name = a.ddcbi_account_id');
    
    
    $query->group('a.ddcbi_account_id');
    $query->order('at.account_type ASC');
    $query->order('b.record_date DESC');
    return $query;
    
  }

  /**
  * Builds the filter for the query
  * @param    object  Query object
  * @return   object  Query object
  *
  */
  protected function _buildWhere(&$query)
  {
  	if($this->_ddcaccount_id!=null)
  	{
  		$query->where('a.ddcbi_account_id = "'.(int)$this->_ddcaccount_id.'"');
  	}
  	if($this->_published != null)
  	{
  	//	$query->where('b.state = '.$this->_published);
  	}
  	if($this->_user_id!=null)
  	{
  		$query->where('a.user_id = "'.(int)$this->_user_id.'"');
  	}
   return $query;
  }
  
  public function saveTarget($data = null)
  {
  	$date = date("Y-m-d H:i:s");
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$account_id = $data['ddcbi_account_id'];
  	$account_nature = $data['account_nature'];
  	$accounttype_id = $data['accounttype_id'];
  	$target_date = JHtml::date($data['target_date'], 'Y-m-d');
  	$target_balance = $data['target_balance'];
  	$plus_minus = $data['plus_minus'];
  	$debit_credit = $data['debit_credit'];
  	$state = 1;
  	$table = $data['table'];
  	$ddcbi_target_id = $data['ddcbi_target_id'];
  	$catid = 0;
  	$user = JFactory::getUser();
  	if($user->getParam('use_dr_cr','1') == '0'){
  		if( $plus_minus == 0 )
  		{
  			$balance = -$balance;
  			//check if debit_credit is set
  		}
  	}else
  	{
  		if( $account_nature == 1)
  		{
  			if($debit_credit == 'cr')
  			{
  				$target_balance = -$target_balance;
  			}
  		}
  		if( $account_nature == 2)
  		{
  			if($debit_credit == 'cr')
  			{
  				$target_balance = -$target_balance;
  			}
  		}
  	}
  	 
  	if( ($ddcbi_target_id == null) or ($ddcbi_target_id == 0))
  	{
  		// Get a db connection.
  		$db = JFactory::getDbo();
  
  		// Create a new query object.
  		$query = $db->getQuery(true);
  
  		// Insert columns.
  		$columns = array('account_id', 'target_balance', 'target_date', 'accounttype_id', 'state', 'created', 'modified', 'catid');
  
  		// Insert values.
  		$values = array($account_id, $db->quote($target_balance), $db->quote($target_date), $db->quote($accounttype_id), $db->quote($state), $db->quote($date), $db->quote($date), $db->quote($catid));
  
  		// Prepare the insert query.
  		$query
  		->insert($db->quoteName('#__ddcbi_targets'))
  		->columns($db->quoteName($columns))
  		->values(implode(',', $values));
  
  		// Reset the query using our newly populated query object.
  		$db->setQuery($query);
  
  		try {
  			// Execute the query in Joomla 3.0.
  			$result = $db->execute();
  		} catch (Exception $e) {
  			// catch any database errors.
  		}
  		return $result;
  	}
  	else
  	{
  		$db = JFactory::getDbo();
  		$query = $db->getQuery(true);
  			
  		// Fields to update.
  		$fields = array(
  				$db->quoteName('target_date') . ' = '.$db->quote($target_date),
  				$db->quoteName('target_balance') . ' = '.$db->quote($target_balance),
  				$db->quoteName('modified') . ' = ' . $db->quote($date)
  		);
  			
  		// Conditions for which records should be updated.
  		$conditions = array(
  				$db->quoteName('ddcbi_target_id') . ' = '.$ddcbi_target_id,
  		);
  			
  		$query->update($db->quoteName('#__ddcbi_targets'))->set($fields)->where($conditions);
  			
  		$db->setQuery($query);
  			
  		$result = $db->execute();
  		return $result;
  	}
  	 
  }
  
  public function deleteItem($data = null)
  {
  	$date = date("Y-m-d H:i:s");
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$table = $data['table'];
  	$ddcbi_balance_id = $data['ddcbi_target_id'];
  	 
  	if( ($ddcbi_target_id != null) or ($ddcbi_target_id != 0))
  	{
  		$db = JFactory::getDbo();
  		$query = $db->getQuery(true);
  			
  		// Fields to update.
  		$fields = array(
  				$db->quoteName('state') . ' = 0',
  				$db->quoteName('modified') . ' = ' . $db->quote($date)
  		);
  			
  		// Conditions for which records should be updated.
  		$conditions = array(
  				$db->quoteName('ddcbi_target_id') . ' = '.$ddcbi_target_id,
  		);
  			
  		$query->update($db->quoteName('#__ddcbi_targets'))->set($fields)->where($conditions);
  			
  		$db->setQuery($query);
  			
  		$result = $db->execute();
  
  		return $result;
  	}
  }
  
  
}
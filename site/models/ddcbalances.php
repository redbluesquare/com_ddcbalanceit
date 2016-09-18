<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDdcbalances extends DdcbalanceitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_ddcbalance_id  	= null;
  var $_pagination  	= null;
  var $_published   	= 1;
  var $_user_id     	= null;
  var $_formdata		= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication('site');
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	$this->_ddcbalance_id = $app->input->getInt('ddcbalance_id', null);
  	$this->_ddcaccount_id = $app->input->get('ddcaccount_id',null,'integer');
  	$this->_datestart = $app->input->get('datestart', null);
  	$this->_dateend = $app->input->get('dateend', null);
  	  	
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

    $query->select('b.*');
    $query->select('b.ddcbi_balance_id');
    $query->select('DATE_FORMAT(b.record_date, "%d %M %Y") as record_date');
    $query->select('b.account_name as an');
    //$query->select('at.account_nature');
    //$query->from('#__ddcbi_accounts as a');
    $query->from('#__ddcbi_balances as b');
    //$query->select('(SELECT tt.target_balance FROM #__ddcbi_targets as tt WHERE tt.target_date = max(t.target_date) AND (tt.state = 1) AND tt.account_id = a.ddcbi_account_id GROUP BY tt.account_id) as target_balance');
    $query->select(' max(t.target_date) as target_date');
    //$query->select(' DATEDIFF(t.target_date,b.record_date) as days_to_go');
    $query->leftJoin('#__ddcbi_accounts as a on a.ddcbi_account_id = b.account_name');
    $query->leftjoin('#__ddcbi_targets as t on t.account_id = a.ddcbi_account_id');
    $query->rightJoin('#__ddcbi_account_types as at on at.ddcbi_account_type_id = a.account_type');
    $query->group('b.ddcbi_balance_id');
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
  	if($this->_ddcbalance_id!=null)
  	{
  		$query->where('b.ddcbi_balance_id = "'.(int)$this->_ddcbalance_id.'"');
  	}
  	if($this->_published!=null)
  	{
  		$query->where('b.state = "'.(int)$this->_published.'"');
  	}
  	if($this->_ddcaccount_id!=null)
  	{
  		$query->where('b.account_name = "'.(int)$this->_ddcaccount_id.'"');
  	}
  	if(($this->_datestart!=null) || ($this->_dateend!=null))
  	{
  		//$query->where('b.record_date between "'.JHtml::date($this->_datestart,"Y-m-d").'" AND "'.JHtml::date($this->_dateend,"Y-m-d").'"');
  	}else
  	{
  		//$query->where('b.record_date between "'.JHtml::date(date("Y-m-d",(time()-(60*60*24*28))),"Y-m-d").'" AND "'.JHtml::date("","Y-m-d").'"');
  	}
   return $query;
  }
  
  public function saveBalance($data = null)
  {
  	$date = date("Y-m-d H:i:s");
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$account_id = $data['ddcbi_account_id'];
  	$account_nature = $data['account_nature'];
  	$record_date = JHtml::date($data['record_date'], 'Y-m-d');
  	$balance = $data['balance'];
  	$plus_minus = $data['plus_minus'];
  	$debit_credit = $data['debit_credit'];
  	$state = 1;
  	$table = $data['table'];
  	$ddcbi_balance_id = $data['ddcbi_balance_id'];
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
  				$balance = -$balance;
  			}
  		}
  		if( $account_nature == 2)
  		{
  			if($debit_credit == 'cr')
  			{
  				$balance = -$balance;
  			}
  		}
  	}
  	
  	if( ($ddcbi_balance_id == null) or ($ddcbi_balance_id == 0))
  	{
  		// Get a db connection.
		$db = JFactory::getDbo();
	
		// Create a new query object.
		$query = $db->getQuery(true);
	
		// Insert columns.
		$columns = array('account_name', 'balance', 'record_date', 'state', 'created', 'modified', 'catid');
	
		// Insert values.
		$values = array($account_id, $db->quote($balance), $db->quote($record_date), $db->quote($state), $db->quote($date), $db->quote($date), $db->quote($catid));
	
		// Prepare the insert query.
		$query
		->insert($db->quoteName('#__ddcbi_balances'))
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
  				$db->quoteName('record_date') . ' = '.$db->quote($record_date),
  				$db->quoteName('balance') . ' = '.$db->quote($balance),
  				$db->quoteName('modified') . ' = ' . $db->quote($date)
  		);
  			
  		// Conditions for which records should be updated.
  		$conditions = array(
  				$db->quoteName('ddcbi_balance_id') . ' = '.$ddcbi_balance_id,
  		);
  			
  		$query->update($db->quoteName('#__ddcbi_balances'))->set($fields)->where($conditions);
  			
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
  	$ddcbi_balance_id = $data['ddcbi_balance_id'];
  	
  	if( ($ddcbi_balance_id != null) or ($ddcbi_balance_id != 0))
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
  				$db->quoteName('ddcbi_balance_id') . ' = '.$ddcbi_balance_id,
  		);
  		 
  		$query->update($db->quoteName('#__ddcbi_balances'))->set($fields)->where($conditions);
  		 
  		$db->setQuery($query);
  		 
  		$result = $db->execute();
  		
  		return $result;
  	}
  }
  
  
}
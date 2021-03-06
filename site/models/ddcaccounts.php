<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDdcaccounts extends DdcbalanceitModelsDefault
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

    $query->select('a.account_name, a.account_number, a.sort_code, a.interest_rate,ddcbi_account_id');
    $query->from('#__ddcbi_accounts as a');
    
    $query->select('u.name as user');
    $query->rightJoin('#__users as u on u.id = a.user_id');
    
    $query->select('at.ddcbi_account_type_id, at.account_nature, at.account_type as acc_type_title');
    $query->select('at.account_type');
    $query->rightJoin('#__ddcbi_account_types as at on at.ddcbi_account_type_id = a.account_type');
    
    $query->select('(SELECT bb.balance FROM #__ddcbi_balances as bb WHERE bb.record_date = max(b.record_date) AND (bb.state = 1) AND bb.account_name = a.ddcbi_account_id GROUP BY bb.account_name) as balance');
    $query->select(' max(b.record_date) as record_date');
    $query->select(' b.account_name as an');
    $query->select('(SELECT tt.target_balance FROM #__ddcbi_targets as tt WHERE tt.target_date = max(t.target_date) AND (tt.state = 1) AND tt.account_id = a.ddcbi_account_id GROUP BY tt.account_id) as target_balance');
    $query->select(' max(t.target_date) as target_date');
    $query->select(' DATEDIFF(t.target_date,b.record_date) as days_to_go');
    $query->leftjoin('#__ddcbi_targets as t on t.account_id = a.ddcbi_account_id');
    $query->leftJoin('#__ddcbi_balances as b on b.account_name = a.ddcbi_account_id');
    
    
    $query->group('a.ddcbi_account_id');
    $query->order('a.account_name ASC');
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
  	//	$query->where('t.state = '.$this->_published);
  	}
  	if($this->_user_id!=null)
  	{
  		$query->where('a.user_id = "'.(int)$this->_user_id.'"');
  	}
   return $query;
  }
}
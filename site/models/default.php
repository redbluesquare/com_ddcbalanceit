<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDefault extends JModelBase
{
  protected $__state_set  = null;
  protected $_total       = null;
  protected $_pagination  = null;
  protected $_db          = null;
  protected $id           = null;
  protected $catid        = null;
  protected $limitstart   = 0;
  protected $limit        = 100;
 
  function __construct()
  {
  	parent::__construct();
  	$this->_db = JFactory::getDBO();
  	
  	$app = JFactory::getApplication();
  	$ids = $app->input->get("cids",null,'array');
  	
  	$id = $app->input->get("account_id");
  	if ( $id && $id > 0 ){
  		$this->id = $id;
  	}else if ( count($ids) == 1 ){
  		$this->id = $ids[0];
  	}else{
  		$this->id = $ids;
  	}
  
  }
  public function store($data=null)
  {
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$row = JTable::getInstance($data['table'],'Table');
  
  	$date = date("Y-m-d H:i:s");
  
  	// Bind the form fields to the table
  	if (!$row->bind($data))
  	{
  		return false;
  	}
  	$row->modified = $date;
  	if ( !$row->created )
  	{
  		$row->created = $date;
  	}
  	if($data['table']=='ddcaccounts'){
  		if($this->data['alias'] == null){
  			$row->alias = JFilterOutput::stringURLSafe($data['account_name']);
  		}
  	}
  	if($data['table']=='ddcgoals'){
  		if($data['alias'] == null){
  			$row->alias = JFilterOutput::stringURLSafe($data['title']);
  		}
  		$row->target_date = JHtml::date($data['target_date'],"Y-m-d");
  		if($data['end_date']!=null)
  		{
  			$row->end_date = JHtml::date($data['end_date'],"Y-m-d");
  		}
  		
  	}
  	if($data['table']=='ddcaccount_types'){
  		if($data['alias']==null){
  			$row->alias = JFilterOutput::stringURLSafe($data['account_type']);
  		}
  	}
  	if($data['table']=="ddcbalances")
  	{
  		$row->balance = $data['balance_dr']-$data['balance_cr'];
  		$row->record_date = JHtml::date($data['record_date'],"Y-m-d");	
  	}
  
  	// Make sure the record is valid
  	if (!$row->check())
  	{
  		return false;
  	}
  
  	if (!$row->store())
  	{
  		return false;
  	}
  	return $row;
  
  }
  
  /**
   * Modifies a property of the object, creating it if it does not already exist.
   *
   * @param   string  $property  The name of the property.
   * @param   mixed   $value     The value of the property to set.
   *
   * @return  mixed  Previous value of the property.
   *
   * @since   11.1
   */
  public function set($property, $value = null)
  {
  	$previous = isset($this->$property) ? $this->$property : null;
  	$this->$property = $value;
  
  	return $previous;
  }
  
  public function get($property, $default = null)
  {
  	return isset($this->$property) ? $this->$property : $default;
  }
  
  /**
   * Build a query, where clause and return an object
   *
   */
  public function getItem()
  {
  	$db = JFactory::getDBO();
  
  	$query = $this->_buildQuery();
  	$this->_buildWhere($query);
  	$db->setQuery($query);
  
  	$item = $db->loadObject();
  	return $item;
  }
  
  /**
   * Build query and where for protected _getList function and return a list
   *
   * @return array An array of results.
   */
  public function listItems($user=null, $date=null, $start=null, $finish=null)
  {
  	$query = $this->_buildQuery();
  	$this->_buildWhere($query, $user, $date, $start, $finish);
  
  	$list = $this->_getList($query, $this->limitstart, $this->limit);
  	return $list;
  }
  
  /**
   * Gets an array of objects from the results of database query.
   *
   * @param   string   $query       The query.
   * @param   integer  $limitstart  Offset.
   * @param   integer  $limit       The number of records.
   *
   * @return  array  An array of results.
   *
   * @since   11.1
   */
  protected function _getList($query, $limitstart = 0, $limit = 0)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query, $limitstart, $limit);
  	$result = $db->loadObjectList();
  
  	return $result;
  }
  
  /**
   * Returns a record count for the query
   *
   * @param   string  $query  The query.
   *
   * @return  integer  Number of rows for query
   *
   * @since   11.1
   */
  protected function _getListCount($query)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query);
  	$db->query();
  
  	return $db->getNumRows();
  }
  
  /* Method to get model state variables
   *
  * @param   string  $property  Optional parameter name
  * @param   mixed   $default   Optional default value
  *
  * @return  object  The property where specified, the state object where omitted
  *
  * @since   11.1
  */
  public function getState($property = null, $default = null)
  {
  	if (!$this->__state_set)
  	{
  		// Protected method to auto-populate the model state.
  		$this->populateState();
  
  		// Set the model state set flag to true.
  		$this->__state_set = true;
  	}
  
  	return $property === null ? $this->state : $this->state->get($property, $default);
  }
  
  /**
   * Get total number of rows for pagination
   */
  function getTotal()
  {
  	if ( empty ( $this->_total ) )
  	{
  		$query = $this->_buildQuery();
  		$this->_total = $this->_getListCount($query);
  	}
  
  	return $this->_total;
  }
  
  /**
   * Generate pagination
   */
  function getPagination()
  {
  	// Lets load the content if it doesn't already exist
  	if (empty($this->_pagination))
  	{
  		$this->_pagination = new JPagination( $this->getTotal(), $this->getState($this->_view.'_limitstart'), $this->getState($this->_view.'_limit'),null,JRoute::_('index.php?view='.$this->_view.'&layout='.$this->_layout));
  	}
  
  	return $this->_pagination;
  }
  function dateDiff($start, $end) {
  	$start_ts = strtotime($start);
  	$end_ts = strtotime($end);
  	$diff = $end_ts - $start_ts;
  	return round($diff / 86400);
  }
  /**
   * Method to auto-populate the model state.
   *
   * This method should only be called once per instantiation and is designed
   * to be called on the first call to the getState() method unless the model
   * configuration flag to ignore the request is set.
   *
   * @return  void
   *
   * @note    Calling getState in this method will result in recursion.
   * @since   12.2
   */
  protected function populateState()
  {
  	$app = JFactory::getApplication('site');
  	
  	// Load state from the request.
  	//$this->_ddcbalance_id = $app->input->getInt('ddcbalance_id', null);
  	$this->_ddcaccount_id = $app->input->getInt('ddcaccount_id',null);
  	$this->setState('ddcbi_accounts.ddcbi_account_id', $this->_ddcaccount_id);
  	
  }
  
  /**
   * Method to populate the options of a custom select input field
   * 
   * @param selected value		$value
   * @param array of all values	$options
   * @return the option Tags
   * 
   */
  	public function getSelectOptions($value, $options = array())
  	{
  		
  	}
		
}
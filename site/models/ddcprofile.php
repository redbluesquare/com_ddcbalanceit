<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDdcprofile extends DdcbalanceitModelsDefault
{

  /**
  * Protected fields
  **/
  var $_cat_id		    = null;
  var $_pagination  	= null;
  var $_published   	= 1;
  var $_user_id     	= null;
  var $_formdata		= null;
  var $_datestart		= null;
  var $_dateend			= null;
  var $_jinput			= null;
  protected $messages;

  
  function __construct()
  {
  	$app = JFactory::getApplication();
  	//If no User ID is set to current logged in user
  	$this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
  	
  	$this->_jinput = JFactory::getApplication()->input;
	$this->_formdata    = $this->_jinput->get('jform', array(),'array');
  	  	
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
    
    $query->select('u.name');
    $query->select('u.username');
    $query->select('u.email');
    $query->from('#__users as u');

    $query->group('u.id');
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
  	if($this->_user_id!=null)
  	{
  		$query->where('u.id = "'.(int)$this->_user_id.'"');
  	}
   return $query;
  }
  
  public function updateddcprofile()
  {
  	$user = JFactory::getUser();
  	//$user->setParam('trialPeriod',"Now");
  	$user->setParam('default_currency', $this->_jinput->get('default_currency', null));
  	$user->setParam('use_dr_cr', $this->_jinput->get('use_dr_cr', null));
  	$user->setParam('record_transactions', $this->_jinput->get('record_transactions', null));
  	$user->setParam('send_reminders', $this->_jinput->get('send_reminders', null));
  	$user->save();
  	
  	
  	return true;
  }
}
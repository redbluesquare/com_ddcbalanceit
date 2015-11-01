<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitModelsDdcaccounttypes extends DdcbalanceitModelsDefault
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

  	$this->_ddcaccounttype_id = $app->input->get('ddcaccounttype_id', null);
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

    $query->select('at.*');
    $query->from('#__ddcbi_account_types as at');
    
    $query->order('at.account_type ASC');

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
  	if($this->_ddcaccounttype_id!=null)
  	{
  		$query->where('at.ddcbi_account_type_id = "'.(int)$this->_ddcaccounttype_id.'"');
  	}
  	
   return $query;
  }
}
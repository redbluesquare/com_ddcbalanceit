<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcaccounttypes extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbi_account_type_id 			= null;

	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbi_account_types', 'ddcbi_account_type_id', $db);
  	}
}
<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcaccounts extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbi_account_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbi_accounts', 'ddcbi_account_id', $db);
  	}
}
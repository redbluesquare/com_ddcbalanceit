<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdcbalances extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbi_balance_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbi_balances', 'ddcbi_balance_id', $db);
  	}
}
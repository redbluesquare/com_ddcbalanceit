<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableDdctargets extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
	var $ddcbi_target_id 			= null;
	
	function __construct( &$db )
	{
    	parent::__construct('#__ddcbi_targets', 'ddcbi_target_id', $db);
  	}
}
<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbalanceitControllersFilter extends DdcbalanceitControllersDefault {
	
	private $data = Null;
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		
		if($_filtertype=='datefilter')
		{
			$viewName     = $app->input->getWord('view', 'Ddcaccounts');
    		$viewFormat   = $document->getType();
    		$layoutName   = $app->input->getWord('layout', 'default');
			//$modelName  = 'DdcbalanceitModels'.ucwords($modelName);		
			
    		$app->input->set('view', $viewName);
    		
			parent::execute();
		}

	}
		
}

<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbalanceitControllersUpdate extends DdcbalanceitControllersDefault {
	
	private $data = Null;
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		//$data = $data ? $data : JRequest::getVar('jform', 'post');
		
		if($jinput->get('table')=='configuration')
		{
			$modelName  = $app->input->get('models', 'ddcprofile');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
			$model = new $modelName();
			
			if ( $row = $model->updateddcprofile() )
			{
				$return['success'] = true;
				$viewName = $app->input->getWord('view', 'dashboard');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
				
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
			 
		}
		echo json_encode($return);
		return parent::execute();
	}
		
}

<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbalanceitControllersGet extends DdcbalanceitControllersDefault {
	
	private $data = Null;
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		
		if($jinput->get('table')=='ddcbalances')
		{
			$modelName  = $app->input->get('models', 'ddcbalances');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
				
			$model = new $modelName();
				
			if ( $row = $model->getItem() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_GET_SUCCESS');
				$return['html'] = $row;
		
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
		
		}
		echo json_encode($return);
	}
		
}

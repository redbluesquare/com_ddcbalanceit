<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbalanceitControllersDelete extends DdcbalanceitControllersDefault {
	
	private $data = Null;
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
		$jinput = JFactory::getApplication()->input;
		
		if($data['table']=='ddcbalances')
		{
			$modelName  = $app->input->get('models', 'ddcbalances');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
				
			$model = new $modelName();
				
			if ( $row = $model->deleteItem() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_DELETE_SUCCESS');
		
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_DELETE_FAILURE');
			}
		
		}
		echo json_encode($return);
	}
		
}

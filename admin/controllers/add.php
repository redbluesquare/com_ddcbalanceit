<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcbalanceitControllersAdd extends DdcbalanceitControllersDefault {
	
	private $data = Null;
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$data = $app->input->get('jform', array(),'array');
		$task = $app->input->get('task', "", 'STR' );
		
		if($data['table']=='ddcaccounttypes')
		{
			$modelName  = $app->input->get('models', 'ddcaccounttypes');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
			$model = new $modelName();
			
			if($task=="accounttype.save")
			{
				if ( $row = $model->store() )
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$viewName = $app->input->getWord('view', 'ddcaccounttypes');
					$app->input->set('layout','default');
					$app->input->set('view', $viewName);
					//$app->input->set('ddcaccounttype_id', $row->ddcbi_account_type_id);
					
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			elseif($task=="accounttype.cancel")
			{
				$viewName = $app->input->getWord('view', 'ddcaccounttypes');
    			$app->input->set('layout','default');
			    $app->input->set('view', $viewName);
			}
			elseif($task=="ddcaccounttype.add")
			{
				$viewName = $app->input->getWord('view', 'ddcaccounttypes');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
			}
		}
		
		return parent::execute();
	}
		
}

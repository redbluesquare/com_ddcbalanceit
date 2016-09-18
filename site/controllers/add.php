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
		$this->data = $this->data ? $this->data : JRequest::getVar('jform', array(), 'post', 'array');
		if($this->data['table']=='ddcaccounts')
		{
			$modelName  = $app->input->get('models', 'ddcaccounts');
			$view       = $app->input->get('view', 'ddcaccounts');
			$layout     = $app->input->get('layout', 'default');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
			
			$model = new $modelName();
			
			if ( $row = $model->store() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_SUCCESS');
				$viewName = $app->input->getWord('view', 'Ddcaccounts');
				$app->input->set('layout','default');
				$app->input->set('view', 'ddcaccounts');
				$app->input->set('ddcaccount_id', $row->ddcbi_account_id);
				
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
			return parent::execute();
		}
		if($this->data['table']=='ddcbalances')
		{
			$modelName  = $app->input->get('models', 'ddcbalances');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
				
			$model = new $modelName();
				
			if ( $row = $model->saveBalance() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_SUCCESS');
				$return['html'] = $row;
		
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
			echo json_encode($return);
		}
		if($this->data['table']=='ddctargets')
		{
			$modelName  = $app->input->get('models', 'ddctargets');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
		
			$model = new $modelName();
		
			if ( $row = $model->saveTarget() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_SUCCESS');
				$return['html'] = $row;
		
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
			echo json_encode($return);
		}
		if($this->data['table']=='ddcgoals')
		{
			$modelName  = $app->input->get('models', 'ddcgoals');
			$view       = $app->input->get('view', 'Ddcgoals');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
				
			$model = new $modelName();
				
			if ( $row = $model->store() )
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_SUCCESS');
				$viewName = $app->input->getWord('view', 'ddcgoals');
				$app->input->set('layout','default');
				$app->input->set('view', 'ddcgoals');
				$app->input->set('ddcgoal_id', $row->ddc_goal_id);
		
			}else{
				$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
			}
			return parent::execute();
		}
		if($this->data['table']=='ddctasks')
		{
			$modelName  = $app->input->get('models', 'ddctasks');
			$modelName  = 'DdcbalanceitModels'.ucwords($modelName);
		
			$model = new $modelName();
			if($this->data['submit']=='Save'):
				if ( $row = $model->store() )
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_SUCCESS');
					$viewName = $app->input->getWord('view', 'ddcgoals');
					$app->input->set('layout','default');
					$app->input->set('view', 'ddcgoals');
					$app->input->set('ddcgoal_id', $row->parent_id);
			
				}else{
					$return['msg'] = JText::_('COM_DDCBALANCEIT_SAVE_FAILURE');
				}
			else:
				$viewName = $app->input->getWord('view', 'ddcgoals');
				$app->input->set('layout','default');
				$app->input->set('view', 'ddcgoals');
				$app->input->set('ddcgoal_id', $this->data['parent_id']);
			endif;
			return parent::execute();
		}
		
	}
		
}

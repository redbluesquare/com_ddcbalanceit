<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitViewsDdcaccounttypesHtml extends JViewHtml
{
	protected $data;
	protected $form;
	protected $params;
	protected $state;
	/**
	 * Method to display the view.
	 *
	 * @param   string	The template file to include
	 * @since   1.6
	 */
  function render()
  {
    $layout = $this->getLayout();
    $accounttypesModel = new DdcbalanceitModelsDDcaccounttypes;
    $atFormModel = new DdcbalanceitModelsDdcaccounttype();
 
    switch($layout) {

     	case "default":
     		default:
     			$this->items = $accounttypesModel->listItems();
     			$this->addToolbar();
     			DdcbalanceitHelpersDdcbalanceit::addSubmenu('ddcaccounttypes');
    	break;
    	case "edit":
    		$this->form = $atFormModel->getForm();
    		$this->item = $accounttypesModel->getItem();
    		$this->addUpdToolBar();
    		break;
    }
   
 
    //display
    return parent::render();
  }
  
  protected function addToolbar()
  {
  	$canDo  = DdcbalanceitHelpersDdcbalanceit::getActions();
  
  	// Get the toolbar object instance
  	$bar = JToolBar::getInstance('toolbar');
  
  	JToolBarHelper::title(JText::_('COM_DDC_DASHBOARD'));
  	JToolBarHelper::help('JHELP_DDCBALANCEIT',true,'');
	
  	JToolBarHelper::addNew('ddcaccounttype.add');
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcbalanceit');
  	}
  }
  protected function addUpdToolBar()
  {
  	$input = JFactory::getApplication()->input;
  	$input->set('hidemainmenu', true);
  	$isNew = ($input->get('ddcaccounttype_id',null)==null);
  	JToolBarHelper::title($isNew ? JText::_('COM_DDC_ACCOUNT_TYPE_NEW'): JText::_('COM_DDC_ACCOUNT_TYPE_EDIT'));
  	JToolBarHelper::save('accounttype.save');
  	JToolBarHelper::cancel('accounttype.cancel', $isNew ? 'JTOOLBAR_CANCEL': 'JTOOLBAR_CLOSE');
  }
  
}
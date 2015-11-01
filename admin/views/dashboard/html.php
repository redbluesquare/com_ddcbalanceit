<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitViewsDashboardHtml extends JViewHtml
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
 
    switch($layout) {

     	case "default":
     		default:
     			$this->addToolbar();
     			DdcbalanceitHelpersDdcbalanceit::addSubmenu('dashboard');
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
  
  	if ($canDo->get('core.admin'))
  	{
  		JToolbarHelper::preferences('com_ddcbalanceit');
  	}
  }
  
}
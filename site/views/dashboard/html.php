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
    $ddcaccountsModel = new DdcbalanceitModelsDdcaccounts();
    $ddcgoalsModel = new DdcbalanceitModelsDdcgoals();
 
    switch($layout) {

     	case "default":
     		default:
     		$this->items = $ddcaccountsModel->listItems();
     		$this->goals = $ddcgoalsModel->listItems();
    	break;
    	
    }
   
 
    //display
    return parent::render();
  }
}
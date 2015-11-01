<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitViewsDdcprofileHtml extends JViewHtml
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
    $profileModel = new DdcbalanceitModelsDdcprofile();
 
    switch($layout) {

     	case "default":
     		default:
     		$this->item = $profileModel->getItem();
    	break;
    }
   
 
    //display
    return parent::render();
  }
}
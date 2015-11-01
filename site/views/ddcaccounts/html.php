<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcbalanceitViewsDdcaccountsHtml extends JViewHtml
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
    $accountForm = new DdcbalanceitModelsDdcaccount();
    $accountModel = new DdcbalanceitModelsDdcaccounts();
    $balanceModel = new DdcbalanceitModelsDdcbalances();
    $balanceForm = new DdcbalanceitModelsDdcbalance();
    $targbalForm = new DdcbalanceitModelsDdctarget();
 
    switch($layout) {

     	case "default":
     		default:
     		$this->item = $accountModel->getItem();
     		$this->balances = $balanceModel->listItems();
     		$this->form = $balanceForm->getForm();
     		$this->formtb = $targbalForm->getForm();
     		$this->balance = $balanceModel->getItem();
    	break;
    	case "add":
    		$this->form = $accountForm->getForm();
    	break;
    	case "addbalance":
    		$this->item = $accountModel->getItem();
    		$this->form = $balanceForm->getForm();
    		$this->balance = $balanceModel->getItem();
    		break;
    }
   
 
    //display
    return parent::render();
  }
}
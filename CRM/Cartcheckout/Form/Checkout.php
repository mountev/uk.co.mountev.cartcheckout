<?php

use CRM_Cartcheckout_ExtensionUtil as E;
use CRM_Cartcheckout_Utils as U;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Cartcheckout_Form_Checkout extends CRM_Core_Form {
  public function buildQuickForm() {

    $cart = CRM_Cartcheckout_BAO_Cart::getUserCart(TRUE);
    if (!$cart || empty($cart->getItems())) {
      $this->assign('message', ts('There are no items in the Cart. Please add items to the cart before making any payment.'));
    } else if (Civi::settings()->get('cartcheckout_force_login') == 1 &&
      empty(CRM_Core_Session::singleton()->get('userID'))
    ) {
      U::loginRedirect();
    } else {
      $url = CRM_Utils_System::url('civicrm/contribute/transact', "reset=1&id=" . Civi::settings()->get('cartcheckout_page_id'));
      CRM_Utils_System::redirect($url);
    }

    //$this->addButtons(array(
    //  array(
    //    'type' => 'submit',
    //    'name' => E::ts('Proceed'),
    //    'isDefault' => TRUE,
    //  ),
    //));

    //// export form elements
    //$this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    //$values = $this->exportValues();
    parent::postProcess();
  }

}

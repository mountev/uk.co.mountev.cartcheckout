<?php

use CRM_Cartcheckout_ExtensionUtil as E;

/**
 * Class CRM_Cartcheckout_Utils
 */
class CRM_Cartcheckout_Utils {
  
  /**
   * Get the list of events
   *
   * @return array
   *   Array (int $event-id => string $event-title).
   */
  public static function getEvents() {
    return CRM_Event_PseudoConstant::event(NULL, FALSE, "is_template IS NULL OR is_template != 1");
  }

  public static function addCartItem() {
    $item   = FALSE; 
    $result = ['is_added' => FALSE];
    $type   = CRM_Utils_Request::retrieve('type', 'String');
    $pnum   = CRM_Utils_Request::retrieve('pnum', 'String');
    // fixme: we 'll need to limit the number of additions. A count lookup may be required
    // before adding a new one. 
    if ($type == 'paper' && Civi::settings()->get('cartcheckout_paper_amount')) {
      if ($pnum) {
        $sql = "SELECT id, filename FROM civicrm_custom_pdfpapers WHERE paper_number = %1";
        $paper = CRM_Core_DAO::executeQuery($sql, [1 => [$pnum, 'String']]);
        $paper->fetch();
        if ($paper->id && $paper->filename) {
          $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
          if (!$cart->entityExist('civicrm_custom_pdfpapers', $paper->id)) {
            $item = $cart->addLabelItem(ts('Paper') . " - {$paper->filename}", Civi::settings()->get('cartcheckout_paper_amount'));
            $item->setEntity('civicrm_custom_pdfpapers', $paper->id);
            CRM_Core_Session::setStatus(ts("Paper %1 added to the Cart.", [1 => $pnum]), ts('Cart Item Added'), 'success');
          } else {
            CRM_Core_Session::setStatus(ts("Paper %1 already exist in the Cart.", [1 => $pnum]), ts('Paper Already In Cart'), 'success');
            $item = TRUE;
          }
        }
      }
    } else if ($amount > 0) {
      // general item add. 
      // $label  = CRM_Utils_Request::retrieve('label', 'String');
      // $amount = CRM_Utils_Request::retrieve('amount', 'Money');
      // $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
      // $item = $cart->addLabelItem($label, $amount);
    }
    if ($item) {
      CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/cart/checkout', "reset=1"));
      //$result = ['is_added' => TRUE];
    }
    CRM_Utils_JSON::output($result);
  }

  public function addPriceFieldItem($label, $amount) {
    $pfId = CRM_Core_DAO::getFieldValue('CRM_Price_DAO_PriceField', 'cart_items', 'id', 'name');
    $params = [
      'price_field_id'    => $pfId,
      'financial_type_id' => 1,
      'label'      => $label,
      'amount'     => $amount,
      'is_active'  => 1,
      'is_default' => 1,
    ];
    try{
      $result = civicrm_api3('PriceFieldValue', 'create', $params);
    }
    catch (CiviCRM_API3_Exception $e) {
      // Handle error here.
      $errorMessage = $e->getMessage();
      $errorCode = $e->getErrorCode();
      $errorData = $e->getExtraParams();
      return [
        'is_error' => 1,
        'error_message' => $errorMessage,
        'error_code' => $errorCode,
        'error_data' => $errorData,
      ];
    }
    return $result;
  }

  public static function loginRedirect() {
    $path   = Civi::settings()->get('cartcheckout_login_path');
    $config = CRM_Core_Config::singleton();
    $uf     = $config->userFramework;
    $query  = '';
    if ($uf == 'WordPress') {
    } else if ($config->userSystem->is_drupal) {
      $query = "destination=civicrm/cart/checkout";
    }
    $url = CRM_Utils_System::url($path, $query);
    CRM_Utils_System::redirect($url);
  }

}

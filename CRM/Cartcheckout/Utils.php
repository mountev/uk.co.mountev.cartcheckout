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
    $result = ['is_added' => FALSE];
    $label  = CRM_Utils_Request::retrieve('label', 'String');
    $amount = CRM_Utils_Request::retrieve('amount', 'Money');
    // fixme: we 'll need to limit the number of additions. A count lookup may be required
    // before adding a new one. 
    if ($amount > 0) {
      $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
      $item = $cart->addLabelItem($label, $amount);
      if ($item) {
        $result = ['is_added' => TRUE];
      }
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
}

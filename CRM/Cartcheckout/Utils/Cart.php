<?php

class CRM_Cartcheckout_Utils_Cart {

  /**
   * Cart Id
   *
   * @var int
   */
  public $id;

  /**
   * FK to civicrm_contact who created this cart
   *
   * @var int
   */
  public $user_id;

  /**
   * @var bool
   */
  public $is_completed;

  public function __construct() {
    $session  = CRM_Core_Session::singleton();
    $this->id = $session->get('cartcheckout_cart_id');
    $userID   = $session->get('userID');
    if ($this->id) {
      // find uncompleted
      $sql  = "SELECT * FROM civicrm_cartcheckout_cart WHERE id = %1 AND is_completed = 0";
      $cart = CRM_Core_DAO::executeQuery($sql, [1 => [$this->id, 'Integer']]);
      if ($cart->fetch() && $userID) {
        if (!$cart->user_id) {
          $sql  = "SELECT * FROM civicrm_cartcheckout_cart WHERE user_id = %1 AND is_completed = 0";
          $savedCart = CRM_Core_DAO::executeQuery($sql, [1 => [$userID, 'Integer']]);
          if ($savedCart->fetch()) {
            // just delete for now
            $sql = "DELETE FROM civicrm_cartcheckout_cart WHERE id = %1";
            CRM_Core_DAO::executeQuery($sql, [1 => [$savedCart->id, 'Integer']]);
          } else {
            // update cart user-id
            $sql = "UPDATE civicrm_cartcheckout_cart SET user_id = %1 WHERE id = %2";
            CRM_Core_DAO::executeQuery($sql, [1 => [$userID, 'Integer'], 2 => [$cart->id, 'Integer']]);
          }
        }
      }  
    } else {
    }
  }

  protected addItem()
}

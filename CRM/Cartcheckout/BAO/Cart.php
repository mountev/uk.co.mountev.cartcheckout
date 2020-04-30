<?php
use CRM_Cartcheckout_ExtensionUtil as E;

class CRM_Cartcheckout_BAO_Cart extends CRM_Cartcheckout_DAO_Cart {

  /**
   * Create a new Cart based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Cartcheckout_DAO_Cart|NULL
   *
   */
  public static function create($params) {
    $className  = 'CRM_Cartcheckout_BAO_Cart';
    $entityName = 'Cart';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  public function setCompleted($paymentId = NULL) {
    if (!empty($this->id)) {
      $params = ['id' => $this->id, 'is_completed' => 1];
      if ($paymentId) {
        $params['payment_id'] = $paymentId;
      }
      return self::create($params);
    }
  }

  public static function getUserCart() {
    $session = CRM_Core_Session::singleton();
    $cartId  = $session->get('cartcheckout_cart_id');
    $userId  = $session->get('userID');
    $cart    = FALSE;
    if ($cartId) {
      $cart = self::getCart(['id' => $cartId, 'is_completed' => 0]);
      if ($cart && $userId) {
        if (!$cart->user_id) {
          $savedCart = self::getCart(['id' => $userId, 'is_completed' => 0]);
          if ($savedCart) {
            // just delete for now
            $savedCart->delete();
          } else {
            $cart->user_id = $userId;
            $cart->save();
          }
        }
      }  
    }
    if ($cart === FALSE) {
      if (empty($userId)) {
        $cart = self::create([]);
      }
      else {
        $cart = self::getCart(['id' => $userId, 'is_completed' => 0]);
        if ($cart === FALSE) {
          $cart = self::create(['user_id' => $userId]);
        }
      }
      $session->set('cartcheckout_cart_id', $cart->id);
    }
    return $cart;
  }

  /**
   * @param array $params
   *
   * @return bool|CRM_Event_Cart_BAO_Cart
   */
  public static function getCart($params) {
    $cart = new CRM_Cartcheckout_BAO_Cart();
    $cart->copyValues($params);
    if ($cart->find(TRUE)) {
      return $cart;
    }
    return FALSE;
  }

  public function addItem($entityTable, $entityID) {
    $item = FALSE;
    if ($this->id && $entityTable && $entityID) {
      $params = [
        'cart_id'      => $this->id, 
        'entity_table' => $entityTable,
        'entity_id'    => $entityID, 
      ];
      $item = CRM_Cartcheckout_BAO_CartItem::create($params);
    }
    return $item;
  }

  public function getItems($params = []) {
    $items = [];
    if (!empty($this->id)) {
      $item = new CRM_Cartcheckout_BAO_CartItem();
      $item->copyValues($params);
      $item->cart_id = $this->id; 
      $item->find();
      while ($item->fetch()) {
        $items[] = clone $item;
      }
    }
    return $items;
  }

  public function getCheckedOutItems() {
    return $this->getItems(['is_checkedout' => 1]);
  }

  public function linkItemsToPriceSetFields() {
    $num = 0;
    $priceSet = CRM_Cartcheckout_BAO_CartItem::getCartPriceSet();
    $feeBlock = $priceSet['fields'];
    $items    = $this->getItems();
    $linkedItems = [];
    foreach ($feeBlock as $pfId => &$fee) {
      if ($fee['name'] == 'cart_items' && is_array($fee['options'])) {
        foreach ($fee['options'] as $opId => &$option) {
          if (array_key_exists($num, $items)) {
            $items[$num]->setPriceFieldValueId($opId);
            $linkedItems[$opId] = $items[$num];
            $num++;
          }
        }
      }
    }
    return $linkedItems;
  }

  public function checkoutItems($params) {
    $checkedOut = FALSE;
    $pfId = CRM_Core_DAO::getFieldValue('CRM_Price_DAO_PriceField', 'cart_items', 'id', 'name');
    if (!empty($params["price_$pfId"])) {
      foreach ($this->getItems() as $item) {
        if ($item->pfv_id && CRM_Utils_Array::value($item->pfv_id, $params["price_$pfId"]) == 1) {
          $item->checkout();
          $checkedOut = TRUE;
        }
      }
    }
    return $checkedOut;
  }

}

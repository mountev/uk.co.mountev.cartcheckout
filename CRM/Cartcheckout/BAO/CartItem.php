<?php
use CRM_Cartcheckout_ExtensionUtil as E;

class CRM_Cartcheckout_BAO_CartItem extends CRM_Cartcheckout_DAO_CartItem {
  public $label  = 'Unknown';
  public $amount = 10000000;// some high number

  /**
   * Create a new CartItem based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Cartcheckout_DAO_CartItem|NULL
   */
  public static function create($params) {
    CRM_Core_Error::debug_var('item create params', $params);
    $className = 'CRM_Cartcheckout_DAO_CartItem';
    $entityName = 'CartItem';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  public function getContribution() {
    if (empty($this->entity_table) || empty($this->entity_id)) {
      return FALSE;
    }
    if ($this->entity_table == 'civicrm_participant') {
      $contributionId = CRM_Core_DAO::getFieldValue('CRM_Event_DAO_ParticipantPayment', $this->entity_id, 'contribution_id', 'participant_id');
      if ($contributionId) {
        return CRM_Contribute_BAO_Contribution::getValues(['id' => $contributionId]);
      }
    } else if ($this->entity_table == 'civicrm_membership') {
      $contributionId = CRM_Core_DAO::getFieldValue('CRM_Member_DAO_MembershipPayment', $this->entity_id, 'contribution_id', 'membership_id');
      if ($contributionId) {
        return CRM_Contribute_BAO_Contribution::getValues(['id' => $contributionId]);
      }
    }
    return FALSE;
  }

  public static function getCartPriceSet() {
    $priceSetEntity = new CRM_Price_DAO_PriceSetEntity();
    $priceSetEntity->entity_table = 'civicrm_contribution_page';
    $priceSetEntity->entity_id = Civi::settings()->get('cartcheckout_page_id');
    $priceSetEntity->find(TRUE);

    $priceSet = CRM_Price_BAO_PriceSet::getSetDetail($priceSetEntity->price_set_id);
    return CRM_Utils_Array::value($priceSetEntity->price_set_id, $priceSet);
  }

  public function setPriceFieldValueId($pfvId) {
    if (!empty($this->id)) {
      // also reset checked out flag everytime we set pfv-id, as it 'd be recomputed 
      // during checkout.
      $dao = self::create(['id' => $this->id, 'pfv_id' => $pfvId, 'is_checkedout' => 0]);
      $this->pfv_id = $dao->pfv_id;
      // reset checkedout flag
      $this->is_checkedout = $dao->is_checkedout;
      return TRUE;
    }
    return FALSE;
  }

  public function checkout() {
    if (!empty($this->id)) {
      $dao = self::create(['id' => $this->id, 'is_checkedout' => 1]);
      $this->is_checkedout = $dao->is_checkedout;
      return TRUE;
    }
    return FALSE;
  }

  public function getLabelAndAmount() {
    if (empty($this->entity_table) || empty($this->entity_id)) {
      return FALSE;
    }
    $labels = [];
    if ($this->entity_table == 'civicrm_participant') {
      $labels[] = ts('Event');
    } else if ($this->entity_table == 'civicrm_membership') {
      $labels[] = ts('Membership');
    }
    $lineItems = CRM_Price_BAO_LineItem::getLineItems($this->entity_id, substr($this->entity_table, 8));
    foreach ($lineItems as $line) {
      $labels[] = $line['label'];
      $contributionId = $line['contribution_id'];
    }
    if ($contributionId) {
      $this->amount = CRM_Core_DAO::getFieldValue('CRM_Contribute_BAO_Contribution', $contributionId, 'total_amount');
    }
    $this->label  = implode(' - ', $labels);

    return TRUE;
  }
}

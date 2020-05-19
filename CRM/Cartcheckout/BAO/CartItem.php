<?php
use CRM_Cartcheckout_ExtensionUtil as E;

class CRM_Cartcheckout_BAO_CartItem extends CRM_Cartcheckout_DAO_CartItem {

  /**
   * Create a new CartItem based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Cartcheckout_DAO_CartItem|NULL
   */
  public static function create($params) {
    $className = 'CRM_Cartcheckout_BAO_CartItem';
    $entityName = 'CartItem';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    if (CRM_Utils_Array::value('id', $params)) {
      $instance->id = $params['id'];
      $instance->find(TRUE);
    }
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  public function getContribution() {
    if (!empty($this->contribution_id)) {
      return CRM_Contribute_BAO_Contribution::getValues(['id' => $this->contribution_id]);
    }
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
    if ($this->label && $this->amount) {
      return TRUE;
    }
    if (empty($this->entity_table) || empty($this->entity_id)) {
      return FALSE;
    }
    $labels = [];
    // fixme: if label exists in DB, return that
    if ($this->entity_table == 'civicrm_participant') {
      $labels[] = ts('Event');
    } else if ($this->entity_table == 'civicrm_membership') {
      $labels[] = ts('Membership');
    }
    $lineItems = CRM_Price_BAO_LineItem::getLineItems($this->entity_id, substr($this->entity_table, 8));
    foreach ($lineItems as $line) {
      if ($this->contribution_id && ($this->contribution_id != $line['contribution_id'])) {
        continue;
      }
      $labels[] = $line['label'];
      $contributionId = $line['contribution_id'];
    }
    if ($contributionId) {
      $this->amount = CRM_Core_DAO::getFieldValue('CRM_Contribute_BAO_Contribution', $contributionId, 'total_amount');
    }
    $this->label  = implode(' - ', $labels);

    if (!empty($this->id)) {
      $dao = self::create([
        'id'     => $this->id, 
        'label'  => $this->label, 
        'amount' => $this->amount
      ]);
    }

    return TRUE;
  }

  public function setEntity($entityTable, $entityID, $contributionID = NULL) {
    if ($this->id && $entityTable && $entityID) {
      $params = [
        'id'           => $this->id, 
        'entity_table' => $entityTable,
        'entity_id'    => $entityID, 
        'contribution_id' => $contributionID, 
      ];
      $item = CRM_Cartcheckout_BAO_CartItem::create($params);
      $this->entity_table = $item->entity_table;
      $this->entity_id = $item->entity_id;
      $this->contribution_id = $item->contribution_id;
      return TRUE;
    }
    return FALSE;
  }

}

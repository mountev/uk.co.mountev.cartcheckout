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

}

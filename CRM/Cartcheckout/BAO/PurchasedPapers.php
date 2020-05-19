<?php
use CRM_Cartcheckout_ExtensionUtil as E;

class CRM_Cartcheckout_BAO_PurchasedPapers extends CRM_Cartcheckout_DAO_PurchasedPapers {

  /**
   * Create a new PurchasedPapers based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Cartcheckout_DAO_PurchasedPapers|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Cartcheckout_DAO_PurchasedPapers';
    $entityName = 'PurchasedPapers';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  public static function addPaper($paperId, $contributionId, $contactId) {
    $sql   = "SELECT paper_number, filename FROM civicrm_custom_pdfpapers WHERE id = %1";
    $paper = CRM_Core_DAO::executeQuery($sql, [1 => [$paperId, 'Positive']]);
    $paper->fetch();
    if ($paper->paper_number) {
      $params = [
        'contact_id'      => $contactId,
        'contribution_id' => $contributionId,
        'paper_number'    => $paper->paper_number,
        'paper'           => $paper->filename,
      ];
      return self::create($params);
    }
    return FALSE;
  }

  public static function getPapers() {
    $session = CRM_Core_Session::singleton();
    $cid     = $session->get('userID');
    $papers  = [];
    if ($cid) {
      $sql   = "SELECT p.*, c.receive_date, c.invoice_number
        FROM civicrm_purchased_papers p
        LEFT JOIN civicrm_contribution c on p.contribution_id = c.id
        WHERE p.contact_id = %1";
      $paper = CRM_Core_DAO::executeQuery($sql, [1 => [$cid, 'Positive']]);
      while ($paper->fetch()) {
        $papers[$paper->id] = $paper->toArray();
        $papers[$paper->id]['paper_url'] = rtrim(Civi::settings()->get('cartcheckout_paper_path'), '/') . '/' . $paper->paper;
      }
      return $papers;
    }
  }

}

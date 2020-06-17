<?php

require_once 'cartcheckout.civix.php';
use CRM_Cartcheckout_ExtensionUtil as E;
use CRM_Cartcheckout_Utils as U;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function cartcheckout_civicrm_config(&$config) {
  _cartcheckout_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function cartcheckout_civicrm_xmlMenu(&$files) {
  _cartcheckout_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function cartcheckout_civicrm_install() {
  _cartcheckout_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function cartcheckout_civicrm_postInstall() {
  _cartcheckout_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function cartcheckout_civicrm_uninstall() {
  _cartcheckout_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function cartcheckout_civicrm_enable() {
  _cartcheckout_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function cartcheckout_civicrm_disable() {
  _cartcheckout_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function cartcheckout_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _cartcheckout_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function cartcheckout_civicrm_managed(&$entities) {
  _cartcheckout_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function cartcheckout_civicrm_caseTypes(&$caseTypes) {
  _cartcheckout_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function cartcheckout_civicrm_angularModules(&$angularModules) {
  _cartcheckout_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function cartcheckout_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _cartcheckout_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function cartcheckout_civicrm_entityTypes(&$entityTypes) {
  _cartcheckout_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function cartcheckout_civicrm_themes(&$themes) {
  _cartcheckout_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function cartcheckout_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function cartcheckout_civicrm_navigationMenu(&$menu) {
  _cartcheckout_civix_insert_navigation_menu($menu, 'Administer/System Settings', [
    'label' => E::ts('Cart Checkout'),
    'name' => 'cart_checkout',
    'url' => CRM_Utils_System::url('civicrm/admin/setting/cart-checkout', 'reset=1'),
    'permission' => 'administer CiviCRM',
    //'operator' => 'OR',
    'separator' => 0,
  ]);
  _cartcheckout_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokenValues
 */
function cartcheckout_civicrm_buildForm($formName, &$form) {
  $eventIds = Civi::settings()->get('cartcheckout_addtocart_event_id');
  $pageIds = Civi::settings()->get('cartcheckout_addtocart_page_id');
  if (($formName == 'CRM_Event_Form_Registration_Register' && in_array($form->_eventId, $eventIds)) ||
    ($formName == 'CRM_Contribute_Form_Contribution_Main' && in_array($form->_id, $pageIds))
  ) {
    if (!empty($form->get('cartcheckoutHidePayLater'))) {
      $form->assign('cartcheckoutHidePayLater', 1);
    }
    $form->addRadio('add_to_cartcheckout', ts('Add to Cart'), [1 => "<i id='cart_icon' class='fa fa-shopping-cart'></i>&nbsp;" . ts('Add to Cart')], ['allowClear' => TRUE]);
    // Assumes templates are in a templates folder relative to this file
    $templatePath = realpath(dirname(__FILE__)."/templates");
    // dynamically insert a template block in the page
    // fixme: tpl path might need adjustments
    CRM_Core_Region::instance('page-body')->add([
      'template' => "{$templatePath}/AddToCartOption.tpl"
    ]);
  }
  if ($formName == 'CRM_Event_Form_Registration_Confirm' || $formName == 'CRM_Contribute_Form_Contribution_Confirm') {
    $params = $form->get('params');
    $isAddToCart = ($formName == 'CRM_Event_Form_Registration_Confirm') ? (!empty($params[0]['add_to_cartcheckout'])) : !empty($params['add_to_cartcheckout']);
    if ($isAddToCart) {
      $msg = "Please continue to finish adding item to the cart.";
      $form->assign('pay_later_receipt', $msg);
    }
  }
  if ($formName == 'CRM_Event_Form_Registration_ThankYou' || $formName == 'CRM_Contribute_Form_Contribution_ThankYou') {
    $params = $form->get('params');
    $isAddToCart = ($formName == 'CRM_Event_Form_Registration_ThankYou') ? (!empty($params[0]['add_to_cartcheckout'])) : !empty($params['add_to_cartcheckout']);
    if ($isAddToCart) {
      $url = CRM_Utils_System::url('civicrm/cart/checkout', "reset=1");
      $msg = "Visit <a href='{$url}'>checkout page</a> to pay for your cart items.";
      $form->assign('pay_later_receipt', $msg);
    }
  }
}

function cartcheckout_civicrm_preProcess($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_Contribution_Main'      &&
    $form->_id == Civi::settings()->get('cartcheckout_page_id')
  ) {
    if (Civi::settings()->get('cartcheckout_force_login') == 1 &&
      empty(CRM_Core_Session::singleton()->get('userID'))
    ) {
      U::loginRedirect();
    } 
  }
  $eventIds = Civi::settings()->get('cartcheckout_addtocart_event_id');
  $pageIds = Civi::settings()->get('cartcheckout_addtocart_page_id');
  if (($formName == 'CRM_Event_Form_Registration_Register' && in_array($form->_eventId, $eventIds)) ||
    ($formName == 'CRM_Contribute_Form_Contribution_Main' && in_array($form->_id, $pageIds))
  ) {
    $pps = $form->getVar('_paymentProcessors');
    if (empty($pps[0])) {
      $resetDefaultProcessor = TRUE;
      $ppID = $form->getVar('_paymentProcessorID');
      if (count($pps) == 1 && $pps[$ppID]['is_default'] == 1) {
        // If there was only one processor with default, make sure it's set as default
        // before we add pay later
        $form->setDefaults(['payment_processor_id' => $ppID]);
        $resetDefaultProcessor = FALSE;
      }
      // add pay later option to be used by the cart
      $pps[0] = CRM_Financial_BAO_PaymentProcessor::getPayment(0);
      $form->setVar('_paymentProcessors', $pps);
      $form->set('paymentProcessors', $pps);
      // enable pay later to be used by cart
      $form->_values['event']['is_pay_later'] = 1;
      $form->set('values', $form->_values);

      // make sure to hide pay later option for user, as it's not supposed 
      // to be used by user as a payment option.
      $form->set('cartcheckoutHidePayLater', 1);

      if ($resetDefaultProcessor) {
        $form->setVar('_paymentProcessorID', NULL);
        $form->assign('paymentProcessorID', $ppID);
        $form->_paymentProcessor = [];
        $form->set('type', $ppID);
        $form->set('paymentProcessor', $form->_paymentProcessor);
        $form->assign('paymentProcessor', $form->_paymentProcessor);
      }
    }
  }
  if ($formName == 'CRM_Event_Form_Registration_Confirm') {
    $params = $form->get('params');
    if (!empty($params[0]['add_to_cartcheckout'])) {
      // disable receipts
      $form->_values['event']['is_email_confirm'] = 0;
    }
  }
  if ($formName == 'CRM_Contribute_Form_Contribution_Confirm') {
    $params = $form->_params;
    if (!empty($params['add_to_cartcheckout'])) {
      // suppress notificaton
      $form->_values['is_email_receipt'] = 0;
      // set it back in session so thankyou page knows about it, and shows instructions accordingly.
      $form->set('values', $form->_values);
    }
  }
}

/**
 * Implements hook_civicrm_postProcess().
 *
 * @param string $formName
 * @param CRM_Core_Form $form
 */
function cartcheckout_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Event_Form_Registration_Register') {
    $session = CRM_Core_Session::singleton();
    $params  = $form->get('params');
    // always unset the session var, so previous session var doesn't cause any problems
    $session->set("cartcheckout_{$params[0]['qfKey']}_event_id", 0);
    if (!empty($params[0]['add_to_cartcheckout'])) {
      $session->set("cartcheckout_{$params[0]['qfKey']}_event_id", $form->_eventId);
      $form->_allowConfirmation = FALSE;
    }
  }
  if ($formName == 'CRM_Contribute_Form_Contribution_Main') {
    $params = $form->_params;
    if ($form->_id == Civi::settings()->get('cartcheckout_page_id')) {
      // for checkout payment
      $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
      $cart->checkoutItems($params);
    } else if (!empty($params['selectMembership'])) {
      // for membership pages
      $session = CRM_Core_Session::singleton();
      // reset the flag first
      // fixme: qfkey not known
      $session->set("cartcheckout_{$qfKey}_membership_page_id", 0);
      if (!empty($params['add_to_cartcheckout'])) {
        $session->set("cartcheckout_{$params['qfKey']}_membership_page_id", $form->_id);
      }
    }
  }
  if ($formName == 'CRM_Contribute_Form_Contribution_Confirm') {
    if ($form->_id == Civi::settings()->get('cartcheckout_page_id')) {
      // completing the payment and sending receipt could be done in DB post hook.
      // It's the linking the entity with new payment that needs to be done here
      // so checkout payment doesn't get confused (otherwise it treats checkout payment
      // as one of the linked payment - but only to one entity).
      cartcheckout_civicrm_completeCheckout($form->_params['contributionID']);
    }
  }
}

function cartcheckout_civicrm_pre($op, $objectName, $objectId, &$objectRef) {
  if ($op == 'create' && $objectName == 'Participant') {
    $session = CRM_Core_Session::singleton();
    $qfKey   = CRM_Utils_Request::retrieve('qfKey', 'String', CRM_Core_DAO::$_nullObject);
    $participantStatus = CRM_Event_PseudoConstant::participantStatus();
    $participantStatus = array_flip($participantStatus);
    if ($objectRef['status_id'] == $participantStatus['Pending from pay later'] && 
      $session->get("cartcheckout_{$qfKey}_event_id") == $objectRef['event_id']
    ) {
      $objectRef['status_id'] = $participantStatus['Pending in cart'];
    } 
  }
  if ($op == 'create' && $objectName == 'LineItem') {
    if ($objectRef['entity_table'] == 'civicrm_contribution') {
      $pageId = CRM_Core_DAO::getFieldValue('CRM_Contribute_DAO_Contribution', $objectRef['entity_id'], 'contribution_page_id', 'id');
      if ($pageId == Civi::settings()->get('cartcheckout_page_id')) {
        $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
        foreach ($cart->getCheckedOutItems() as $item) {
          if ($objectRef['price_field_value_id'] == $item->pfv_id && $item->financial_type_id) {
            $objectRef['financial_type_id'] = $item->financial_type_id;
          }
        }
      }
    }
  }
  //if ($op == 'create' && $objectName == 'Membership') {
  //  $session = CRM_Core_Session::singleton();
  //  $qfKey   = CRM_Utils_Request::retrieve('qfKey', 'String', CRM_Core_DAO::$_nullObject);
  //  $membershipStatus = CRM_Member_PseudoConstant::membershipStatus();
  //  $membershipStatus = array_flip($membershipStatus);
  //  if ($objectRef['status_id'] == $membershipStatus['Pending'] && 
  //    $session->get("cartcheckout_{$qfKey}_membership_page_id") == $objectRef['contribution']->contribution_page_id
  //  ) {
  //    // NOTE: changing status to a new one like pending in cart (other than pending) causes problems with
  //    //       completing or renewals.
  //    // Error: it looks like there is no valid membership status corresponding to the membership start 
  //    //        and end dates for this membership
  //    //
  //    //
  //    //$objectRef['status_id'] = $membershipStatus['Pending in cart'];
  //    //$objectRef['some_new_field'] = 'asd';
  //    // see if override is needed
  //    // $objectRef['is_override'] = 1;
  //  }
  //}
}

// CART CHECKOUT PAYMENT
function cartcheckout_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($op == 'create' && $objectName == 'Participant' && $objectId) {
    $session = CRM_Core_Session::singleton();
    $qfKey   = CRM_Utils_Request::retrieve('qfKey', 'String', CRM_Core_DAO::$_nullObject);
    $participantStatus = CRM_Event_PseudoConstant::participantStatus();
    $participantStatus = array_flip($participantStatus);
    if ($objectRef->status_id == $participantStatus['Pending in cart'] &&
      $session->get("cartcheckout_{$qfKey}_event_id") == $objectRef->event_id
    ) {
      $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
      // fixme: add contribution-id at some point
      $cart->addItem('civicrm_participant', $objectId);
    } 
  }
  // use membership-payment for adding membership as cart-item, so it works for both
  // new memberships and renewals.
  if ($op == 'create' && $objectName == 'MembershipPayment' && $objectId) {
    $session = CRM_Core_Session::singleton();
    $qfKey   = CRM_Utils_Request::retrieve('qfKey', 'String', CRM_Core_DAO::$_nullObject);
    // check if any membership was added as cart item
    if ($session->get("cartcheckout_{$qfKey}_membership_page_id")) {
      $contribution = civicrm_api3('contribution', 'getsingle', [
        'return' => ["contribution_page_id", "contribution_status_id"],
        'id' => $objectRef->contribution_id
      ]);
      // check if contribution page id matches
      if ($contribution['contribution_page_id'] == $session->get("cartcheckout_{$qfKey}_membership_page_id")) {
        $contributionStatus = CRM_Contribute_PseudoConstant::contributionStatus(NULL, 'label');
        $contributionStatus = array_flip($contributionStatus);
        if ($contribution['contribution_status_id'] == $contributionStatus['Pending']) {
          $membership = civicrm_api3('membership', 'getsingle', ['id' => $objectRef->membership_id]);
          // add membership as cart item
          $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
          $cart->addItem('civicrm_membership', $membership['id'], $objectRef->contribution_id);
        }
      }
    }
  }

  // online contribution first creates pending contribution,which then gets completed 
  // after creating lineitem and financial item. And therefore we use 'edit' as operation.
  // if ($op == 'edit' && $objectName == 'Contribution' && $objectId) {
  //   if (CRM_Core_Transaction::isActive()) {
  //     CRM_Core_Transaction::addCallback(CRM_Core_Transaction::PHASE_POST_COMMIT, 'cartcheckout_civicrm_postCallback', [$op, $objectName, $objectId, $objectRef]);
  //   }
  //   else {
  //     cartcheckout_civicrm_postCallback($op, $objectName, $objectId, $objectRef);
  //   }
  // }
}

// function cartcheckout_civicrm_postCallback($op, $objectName, $objectId, $objectRef) {
//   if ($op == 'edit' && $objectName == 'Contribution' && $objectId) {
//   }
// }

function cartcheckout_civicrm_buildAmount($pageType, &$form, &$amount) {
  if (CRM_Utils_System::getClassName($form) == 'CRM_Contribute_Form_Contribution_Main' && 
    $form->_id == Civi::settings()->get('cartcheckout_page_id')
  ) {
    // fixme: form preprocess might be a better place to trigger linking
    $items = CRM_Cartcheckout_BAO_Cart::getUserCart()->linkItemsToPriceSetFields();
    $feeBlock = &$amount;
    foreach ($feeBlock as $pfId => &$fee) {
      if ($fee['name'] == 'cart_items' && is_array($fee['options'])) {
        $defaults = ["price_{$pfId}" => []];
        foreach ($fee['options'] as $opId => &$option) {
          if (array_key_exists($opId, $items)) {
            $items[$opId]->getLabelAndAmount();
            $option['label']  = $items[$opId]->label;
            $option['amount'] = $items[$opId]->amount;
            $option['tax_amount'] = $items[$opId]->tax_amount;
            $defaults["price_{$pfId}"][$opId] = 1;
          } else {
            unset($fee['options'][$opId]);
          }
        }
        if (!empty($defaults["price_{$pfId}"])) {
          // Just changing the default flag in feeBlock doesn't work, 
          // as default method is separate and change doesn't propagate.
          // Use $form method instead.
          $form->setDefaults($defaults);
        }
      } else {
        unset($feeBlock[$pfId]);
      }
    }
  }
}

/**
 * Implements hook_civicrm_alterMailParams().
 *
 *
 */
function cartcheckout_civicrm_alterMailParams(&$params, $context) {
  if ($context == 'messageTemplate'
    && in_array($params['groupName'], ['msg_tpl_workflow_event', 'msg_tpl_workflow_membership'])
    && !empty($params['isEmailPdf'])
    && !empty($params['contributionId'])
  ) {
    // tocheck: see if changing contribution-id to that of cart 
    //          payment, changes invoice info
    //
    $entityId = NULL;
    if ($params['groupName'] == 'msg_tpl_workflow_event') {
      $entityTable = 'civicrm_participant';
      $entityId    = CRM_Core_DAO::getFieldValue('CRM_Event_DAO_ParticipantPayment', $params['contributionId'], 'participant_id', 'contribution_id');
    } else if ($params['groupName'] == 'msg_tpl_workflow_membership') {
      $entityTable = 'civicrm_membership';
      $entityId    = CRM_Core_DAO::getFieldValue('CRM_Member_DAO_MembershipPayment', $params['contributionId'], 'membership_id', 'contribution_id');
    }
    if ($entityId) {
      // Get in-progress cart if any
      $cart = CRM_Cartcheckout_BAO_Cart::getUserCart(TRUE);
      if ($cart) {
        $participantIds = [];
        foreach ($cart->getCheckedOutItems() as $item) {
          if (($item->entity_table == $entityTable) && ($entityId == $item->entity_id)) {
            // unset isemailpdf to invoice doesn't get attached. Invoice should only be sent 
            // for checkout payment.
            unset($params['isEmailPdf']);
            break;
          }
        }
      }
    }
  }
}

// fixme: move it to Utils
function cartcheckout_civicrm_completeCheckout($checkoutContributionId) {
  $checkoutContribution = CRM_Contribute_BAO_Contribution::getValues(['id' => $checkoutContributionId]);
  $contributionStatuses = CRM_Contribute_PseudoConstant::contributionStatus(NULL, 'name');
  if ($checkoutContribution && 
    $checkoutContribution->contribution_page_id == Civi::settings()->get('cartcheckout_page_id') && 
    $checkoutContribution->contribution_status_id == array_search('Completed', $contributionStatuses)
  ) {
    $cart = CRM_Cartcheckout_BAO_Cart::getUserCart();
    if (empty($cart->is_completed)) { // not already completed
      foreach ($cart->getCheckedOutItems() as $item) {
        $itemContribution = $item->getContribution();
        if ($itemContribution && 
          $itemContribution->contribution_status_id == array_search('Pending', $contributionStatuses)
        ) {
          try {
            $result = civicrm_api3('Payment', 'create', [
              'contribution_id' => $itemContribution->id,//linked pending payment
              'total_amount'    => $itemContribution->total_amount,
              'payment_instrument_id' => 'Check',
            ]);
            if (!empty($result['id'])) {
              // receipt would have been successfull (without invoice) 
              // replace linked payment to that of checkout payment
              CRM_Contribute_BAO_Contribution::deleteContribution($itemContribution->id);
              if ($item->entity_table == 'civicrm_participant') {
                $params = [
                  'participant_id'  => $item->entity_id,
                  'contribution_id' => $checkoutContributionId,
                ];
                $ppcreate = civicrm_api3('ParticipantPayment', 'create', $params);
              } else if ($item->entity_table == 'civicrm_membership') {
                $params = [
                  'membership_id'  => $item->entity_id,
                  'contribution_id' => $checkoutContributionId,
                ];
                $mpcreate = civicrm_api3('MembershipPayment', 'create', $params);
              }
            }
          }
          catch (Exception $e) {
            \Civi::log()->debug('CartPayment error creating payments: ' . $e->getMessage());
          }
        } else if ($item->entity_table == 'civicrm_custom_pdfpapers' && $item->entity_id) {
          // Add details to individual custom set
          CRM_Cartcheckout_BAO_PurchasedPapers::addPaper($item->entity_id, $checkoutContribution->id, $checkoutContribution->contact_id);
        }
      }
      $completedCart = $cart->setCompleted($checkoutContributionId);
    }
  }
}

function cartcheckout_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
  if ($pageName == 'CRM_Contact_Page_View_UserDashBoard') {
    $template = CRM_Core_Smarty::singleton();
    $dashElements = $template->get_template_vars('dashboardElements');
    array_unshift($dashElements, [
      'class'        => 'crm-dashboard-papers',
      'templatePath' => 'CRM/Cartcheckout/Page/UserDashboard.tpl',
      'sectionTitle' => 'Papers',
      'weight'       => 10,
    ]);
    $template->assign('dashboardElements', $dashElements);
    $papers = CRM_Cartcheckout_BAO_PurchasedPapers::getPapers();
    $template->assign('cartcheckoutPaperRows', $papers);
  }
}

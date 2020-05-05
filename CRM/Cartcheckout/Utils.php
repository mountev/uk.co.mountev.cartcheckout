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
}

<?php

use CRM_Cartcheckout_ExtensionUtil as E;

return [
  'cartcheckout_page_id' => [
    'name' => 'cartcheckout_page_id',
    'type' => 'Integer',
    'html_type'  => 'select',
    'pseudoconstant' => [
      'callback'  => 'CRM_Contribute_PseudoConstant::contributionPage',
    ],
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'default'     => 0,
    'add'         => '5.24',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Checkout Contribution Page'),
    'description' => E::ts('Contribution page that will be used for cart checkout.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_addtocart_event_id' => [
    'name' => 'cartcheckout_addtocart_event_id',
    'type' => 'Integer',
    'html_type'  => 'select',
    'pseudoconstant' => [
      'callback'  => 'CRM_Cartcheckout_Utils::getEvents',
    ],
    'html_attributes' => [
      'class' => 'crm-select2 huge',
      'multiple' => 'multiple',
    ],
    'default'     => 0,
    'add'         => '5.22',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Event pages that require Add-to-Cart option'),
    'description' => E::ts('Exposes Add to Cart option on the event registration pages.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_addtocart_page_id' => [
    'name' => 'cartcheckout_addtocart_page_id',
    'type' => 'Integer',
    'html_type'  => 'select',
    'pseudoconstant' => [
      'callback'  => 'CRM_Contribute_PseudoConstant::contributionPage',
    ],
    'html_attributes' => [
      'class' => 'crm-select2 huge',
      'multiple' => 'multiple',
    ],
    'default'     => 0,
    'add'         => '5.22',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Membership or Contribution pages that require Add-to-Cart option'),
    'description' => E::ts('Exposes Add to Cart option on the membership or contribution pages. Do NOT specify cart-checkout contribution page here.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_civicrm_participant_ft_id' => [
    'name' => 'cartcheckout_civicrm_participant_ft_id',
    'type' => 'Integer',
    'html_type'  => 'select',
    'pseudoconstant' => [
      'callback'  => 'CRM_Financial_BAO_FinancialType::getAvailableFinancialTypes',
    ],
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'default'     => 0,
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Financial Type for Event Cart Items'),
    'description' => E::ts('Line item financial type to use for event related cart items.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_civicrm_membership_ft_id' => [
    'name' => 'cartcheckout_civicrm_membership_ft_id',
    'type' => 'Integer',
    'html_type'  => 'select',
    'pseudoconstant' => [
      'callback'  => 'CRM_Financial_BAO_FinancialType::getAvailableFinancialTypes',
    ],
    'html_attributes' => [
      'class' => 'crm-select2',
    ],
    'default'     => 0,
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Financial Type for Membership Cart Items'),
    'description' => E::ts('Line item financial type to use for membership related cart items.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_paper_path' => [
    'name' => 'cartcheckout_paper_path',
    'type' => 'String',
    'html_type'  => 'text',
    'html_attributes' => [
      'class' => 'huge',
    ],
    'default'     => FALSE,
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Path to Papers'),
    'description' => E::ts('Specify the path that will be used to construct the full path to papers. E.g: https://example.org/system/files/papers/'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
];

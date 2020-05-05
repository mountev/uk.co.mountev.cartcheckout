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
];

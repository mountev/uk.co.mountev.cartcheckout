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
  'cartcheckout_force_login' => [
    'name' => 'cartcheckout_force_login',
    'type' => 'Boolean',
    'html_type'  => 'radio',
    'quick_form_type'  => 'YesNo',
    'default'     => 0,
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Does cart checkout require login?'),
    'description' => E::ts('When set forces user to login first before making any cart payments.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
  'cartcheckout_login_path' => [
    'name' => 'cartcheckout_login_path',
    'type' => 'String',
    'html_type'  => 'text',
    'html_attributes' => [
      'class' => 'huge',
    ],
    'default'     => 'user/login',
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Login Path'),
    'description' => E::ts('When users are required to login before making cart payments, this path would be used for constructing the login url. E.g user/login'),
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
  'cartcheckout_paper_amount' => [
    'name' => 'cartcheckout_paper_amount',
    'type' => 'String',
    'html_type'  => 'text',
    'default'     => '2.50',
    'add'         => '5.25',
    'is_domain'   => 1,
    'is_contact'  => 0,
    'title'       => E::ts('Paper Amount'),
    'description' => E::ts('Cost of any paper item that is going to be added to the Cart.'),
    'settings_pages' => [
      'cart-checkout' => [
        'weight' => 10,
      ]
    ],
  ],
];

<?php

return [
    // Currency
    '/finance/currency' => [
        'controller' => 'Currency@indexAction'
    ],

    '/finance/currency/save' => [
        'controller' => 'Currency@saveAction'
    ],

    '/finance/currency/edit/(:var)' => [
        'controller' => 'Currency@editAction'
    ],

    '/finance/currency/delete/(:var)' => [
        'controller' => 'Currency@deleteAction'
    ],

    // Spendings
    '/finance/spending' => [
        'controller' => 'Spending@indexAction'
    ],

    '/finance/spending/save' => [
        'controller' => 'Spending@saveAction'
    ],

    '/finance/spending/edit/(:var)' => [
        'controller' => 'Spending@editAction'
    ],

    '/finance/spending/delete/(:var)' => [
        'controller' => 'Spending@deleteAction'
    ],

    // Calendar
    '/finance/pivot/(:var)' => [
        'controller' => 'Calendar@pivotAction'
    ],
    
    '/finance/calendar' => [
        'controller' => 'Calendar@indexAction'
    ],

    '/finance/calendar/explore/(:var)' => [
        'controller' => 'Calendar@exploreAction'
    ],

    '/finance/calendar/save' => [
        'controller' => 'Calendar@saveAction'
    ],

    '/finance/calendar/edit/(:var)' => [
        'controller' => 'Calendar@editAction'
    ],

    '/finance/calendar/delete/(:var)' => [
        'controller' => 'Calendar@deleteAction'
    ],

    // Income
    '/finance/income' => [
        'controller' => 'Income@indexAction'
    ],

    '/finance/income/save' => [
        'controller' => 'Income@saveAction'
    ],

    '/finance/income/edit/(:var)' => [
        'controller' => 'Income@editAction'
    ],

    '/finance/income/delete/(:var)' => [
        'controller' => 'Income@deleteAction'
    ]
];

<?php
return [
    'dashboard' => [
        'type' => 2,
        'description' => 'Админ панель',
    ],
    'User' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'userRole',
    ],
    'distributor' => [
        'type' => 1,
        'description' => 'Distributor',
        'ruleName' => 'userRole',
        'children' => [
            'User',
            'dashboard',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'userRole',
        'children' => [
            'distributor',
        ],
    ],
];

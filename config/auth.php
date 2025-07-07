<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'admins',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'pelanggan' => [
            'driver' => 'session',
            'provider' => 'pelanggans',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'pelanggans' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pelanggan::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'pelanggans' => [
            'provider' => 'pelanggans',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];

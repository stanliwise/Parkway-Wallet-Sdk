<?php

return [
    'parkway-wallet' => [
        'publicKeyPath' => env('PARKWAY_PUBLIC_KEY_PATH', storage_path('pwsdk/public.key')),
        'baseUrl' => env('PARKWAY_WALLET_BASE_URL', 'https://wallet.parkway.ng')
    ],

    'publicKeyPath' => env('RSA_PUBLIC_KEY_PATH', storage_path('rsaKeys/public.key')),

    'privateKeyPath' => env('RSA_PRIVATE_KEY_PATH', storage_path('rsaKeys/private.key')),

    'readycash' => [
        'base_url' => env('READYCASH_BASE_URL'),
        'wallet_url' => env('READYCASH_BASE_URL') . '/api/provider/wallets',
        'token' => env('READYCASH_TOKEN'),
    ]
];

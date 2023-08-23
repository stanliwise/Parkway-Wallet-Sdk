<?php

return [
    'parkway-wallet' => [
        'publicKeyPath' => env('PARKWAY_PUBLIC_KEY_PATH', storage_path('pwsdk/public.key')),
        'baseUrl' => env('PARKWAY_WALLET_BASE_URL', 'https://wallet.parkway.ng')
    ],

    'publicKeyPath' => env('RSA_PUBLIC_KEY_PATH', storage_path('rsaKeys/public.key')),

    'privateKeyPath' => env('RSA_PRIVATE_KEY_PATH', storage_path('rsaKeys/private.key')),
];

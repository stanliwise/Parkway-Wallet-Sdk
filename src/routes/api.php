<?php

use Illuminate\Support\Facades\Route;

Route::middleware('pwsdk.verify-signature')->prefix('transact')->group(function(){
    Route::post('walletToWallet', function(){
        logger('worked well');
    });
});
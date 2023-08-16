<?php

use Illuminate\Support\Facades\Route;

Route::middleware('parkway.verify-signature')->prefix('transact')->group(function(){
    Route::post('walletToWallet', function(){
        logger('worked well');
    });
});
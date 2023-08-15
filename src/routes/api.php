<?php

use Illuminate\Support\Facades\Route;

Route::middleware('signature.validate')->prefix('transact')->group(function(){
    ///Route::post('walletToWallet', [])
});
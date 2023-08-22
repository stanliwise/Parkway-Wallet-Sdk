<?php

use Illuminate\Support\Facades\Route;
use Parkway\Wallet\Sdk\Http\Controllers\TransactionController;

Route::middleware(['pwsdk.verify-signature', 'pwsdk.encryt-response'])->prefix('transact')->group(function () {
    Route::post('{walletNumber}/transferToWallet', [TransactionController::class, 'walletToWallet']);
    Route::post('{walletNumber}/transferToBank', [TransactionController::class, 'walletToBank']);
});

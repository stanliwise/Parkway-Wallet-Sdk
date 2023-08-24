<?php

namespace Parkway\Wallet\Sdk\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Parkway\Wallet\Sdk\Services\BankServices;

class TransactionController
{
    public function walletToBank(Request $request, string $walletNumber)
    {
        $validation_payload = $request->all() + ['walletNumber' => $walletNumber];

        $validator = Validator::make($validation_payload, [
            'destinationBankCode' => 'bail|required|numeric|min:3',
            'toAccountNumber' => 'bail|required|numeric|min:10',
            'toAccountName' => 'bail|required|string',
            'transactionRef' => 'bail|required|string|min:5',
            'memo' => 'bail|string|nullable',
            'amount' => ['bail', 'required', 'numeric', 'gt:0'],
            'walletNumber' => 'bail|required|min:11|max:11'
        ]);

        $validator->validate();

        try {
            $bankService = new BankServices;

            $response = $bankService->processExternalTransfer(
                $walletNumber,
                $request->toAccountNumber,
                $request->toAccountName,
                $request->memo,
                $request->amount,
                $request->transactionRef,
                $request->memo
            );

            return response()->json($response);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function walletToWallet(Request $request, string $walletNumber)
    {
        $request->validate([]);
    }
}

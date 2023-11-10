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
            'destinationBankCode' => 'bail|required|numeric|digits:3',
            'toAccountNumber' => 'bail|required|numeric|digits:10',
            'toAccountName' => 'bail|required|string',
            'transactionRef' => 'bail|required|string|min:5',
            'memo' => 'bail|string|nullable',
            'amount' => ['bail', 'required', 'numeric', 'gt:0'],
            'walletNumber' => 'bail|required|min:11|digits:10'
        ]);

        if ($validator->fails())
            return response()->json([
                'code' => '00976',
                'desc' => $validator->getMessageBag()->first(),
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ]);

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
            return [
                'code' => '00988',
                'desc' => 'An Unknown error occured',
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ];
        }
    }

    public function walletToWallet(Request $request, string $walletNumber)
    {
        $validation_payload = $request->all() + ['walletNumber' => $walletNumber];

        $validator = Validator::make($validation_payload, [
            'fromAccountNumber' => 'bail|required|numeric|digits:10',
            'toAccountNumber' => 'bail|required|string',
            'transactionRef' => 'bail|required|string|min:5',
            'memo' => 'bail|string|nullable',
            'amount' => ['bail', 'required', 'numeric', 'gt:0'],
            'walletNumber' => 'bail|required|digits:10'
        ]);

        if ($validator->fails())
            return response()->json([
                'code' => '00976',
                'desc' => $validator->getMessageBag()->first(),
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ]);

        try {
            $bankService = new BankServices;

            $response = $bankService->processLocalTransfer(
                $request->fromAccountNumber,
                $request->toAccountNumber,
                $request->transactionRef,
                $request->amount,
                $request->memo,
            );

            return response()->json($response);
        } catch (\Throwable $th) {
            logger($th);

            return [
                'code' => '00988',
                'desc' => 'An Unknown error occured',
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ];
        }
    }
}

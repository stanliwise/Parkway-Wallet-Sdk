<?php

namespace Parkway\Wallet\Sdk\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Parkway\Wallet\Sdk\Wrappers\TransactionResponse;

class BankServices
{
    public function processExternalTransfer(
        string $wallet,
        string $toAccountNumber,
        string $toAccountName,
        string $bankCode,
        string $amount,
        string $transaction_reference,
        ?string $narration
    ): array {

        try {
            #check if wallet has been blacklisted
            $response = Http::withToken(config('readycash.token'))->post(config('readycash.wallet_url') . '/transactions/banktransfer', [
                "destinationBankCode" => $bankCode,
                "fromAccountNumber" => $wallet,
                "toAccountNumber" => $toAccountNumber,
                "transactionRef" => $transaction_reference,
                "toAccountName" => $toAccountName,
                "amount" => $amount,
                "memo" => $narration
            ]);

            if (!$response)
                $response->throw();

            return $response->collect()->toArray();
        } catch (ConnectionException $conEx) {
            return [
                'code' => '00976',
                'desc' => 'Service Unreachable',
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ];
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


    public function processLocalTransfer(string $fromAccountNumber, string $toAccountNumber, string $sender_reference, string $amount, string $narration)
    {
        try {
            $response = Http::withToken(config('readycash.token'))->post(config('readycash.wallet_url') . '/transactions/transfer', [
                "fromAccountNumber" => $fromAccountNumber,
                "amount" => $amount,
                "memo" => $narration,
                "toAccountNumber" => $toAccountNumber,
                "transactionRef" => $sender_reference,
            ]);

            if (!$response)
                $response->throw();

            return $response->collect()->toArray();
        } catch (ConnectionException $conEx) {
            return [
                'code' => '00976',
                'desc' => 'Service Unreachable',
                'retRef' => '',
                'stan' => '',
                'transdatetime' => NULL,
                'bvn' => '',
                'voucher' => '',
                'extra' => '',
                'pin' => '',
            ];;
        } catch (\Throwable $th) {
            return [
                'code' => '000988',
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

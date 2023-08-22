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
                "fromAccountNumber" => $wallet,
                "toAccountNumber" => $toAccountNumber,
                "toAccountName" => $toAccountName,
                "destinationBankCode" => $bankCode,
                "transactionRef" => $transaction_reference,
                "amount" => $amount,
                "memo" => $narration
            ]);

            if (!$response)
                $response->throw();

            return $response->collect()->toArray();
        } catch (ConnectionException $conEx) {
            return [];
        } catch (\Throwable $th) {
            return [];
        }
    }


    public function processLocalTransfer()
    {
    }
}

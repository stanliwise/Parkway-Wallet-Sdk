<?php

namespace Parkway\Wallet\Sdk\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Crypto\Rsa\KeyPair;

class FetchParkwayWalletPublicKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pwsdk:get-public-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Parkway RSA Public Key';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        // Define the URL of the file you want to download
        $fileUrl = env('PARKWAY_WALLET_RSA_KEY_URL', 'https://wallet.parkway.ng/security/rsa/public.key');

        // Define the local directory where you want to save the downloaded file
        $localDirectory = dirname(config('pwsdk.parkway-wallet.publicKeyPath')); // Change this to your desired directory

        // Ensure the local directory exists; if not, create it
        if (!is_dir($localDirectory)) {
            mkdir($localDirectory, 0755, true);
        }

        // Use HttpClient to download the file and save it locally
        logger($fileUrl);
        $response = Http::get($fileUrl);

        if (!$response->ok())
            $response->throw();

        file_put_contents(config('pwsdk.parkway-wallet.publicKeyPath'), $response->body());

        return static::SUCCESS;
    }
}

<?php

namespace Parkway\Wallet\Sdk\Console;

use Illuminate\Console\Command;
use Spatie\Crypto\Rsa\KeyPair;

class GenerateRSAKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pwsdk:generate-rsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate RSA Keys for parnters';

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
        //check folder is present else create
        if (!file_exists($path = dirname(config('pwsdk.publicKeyPath'))))
            mkdir($path, 0600, true);

        (new KeyPair())->generate(config('pwsdk.privateKeyPath'), config('pwsdk.publicKeyPath'));

        return static::SUCCESS;
    }
}

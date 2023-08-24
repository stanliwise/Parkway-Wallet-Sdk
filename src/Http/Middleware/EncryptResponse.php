<?php

namespace Parkway\Wallet\Sdk\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EncryptResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse|mixed|Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the response from the next middleware or controller
        $response = $next($request);

        try {
            //code...
            // Encrypt the JSON data
            $encryptedData = PrivateKey::fromFile(config('pwsdk.privateKeyPath'))->sign($response->getContent() ?? '');

            // Set the encrypted data in the "PW-header" header
            $response->headers->set('PW-Signature', $encryptedData);
        } catch (\Throwable $th) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'An Unknown Server Error Occured');
        }

        return $response;
    }

    protected  function base64ToUrlEncode($data)
    {
        // Replace characters that are not URL-safe
        $base64Url = strtr($data, '+/', '-_');

        // Remove padding characters
        $base64Url = rtrim($base64Url, '=');

        return $base64Url;
    }
}

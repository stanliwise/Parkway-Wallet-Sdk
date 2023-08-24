<?php

namespace Parkway\Wallet\Sdk\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Spatie\Crypto\Rsa\PublicKey;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateRequestSignature
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
        try {
            $json = $request->getContent() ?? "";
            $is_valid = PublicKey::fromFile(config('pwsdk.parkway-wallet.publicKeyPath'))->verify($json, $request->header('Pw-Signature') ?? "");
            abort_unless($is_valid, Response::HTTP_UNAUTHORIZED, 'Signature verification failed');
        } catch (HttpResponseException | HttpException $httpEx) {
            throw $httpEx;
        } catch (\Throwable $th) {
            logger($th);
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'An Unknown error occured');
        }

        #TODO: verify counter is correct
        return $next($request);
    }
}

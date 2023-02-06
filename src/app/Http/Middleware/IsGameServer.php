<?php

namespace App\Http\Middleware;

use App\Exceptions\ErrorException;
use Closure;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class IsGameServer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token && !$this->checkIfGameServer($token)) {
            throw new ErrorException('exception.unauthorized', [], 401);
        }

        if ($request->user_auth_token) {
            $userId = $this->getUserIdFromToken($request->user_auth_token);

            if ($userId === "") {
                throw new ErrorException('exception.invalid_user_auth_token');
            }

            $request->request->set('user_id', $userId);
        }

        return $next($request);
    }

    private function checkIfGameServer(string $token)
    {
        $key_path = Passport::keyPath('oauth-public.key');
        $parseTokenKey = file_get_contents($key_path);

        try {
            $token = (new Parser())->parse($token);
        } catch (\Exception $e) {
            throw new ErrorException('exception.auth');
        }

        $signer = new Sha256();

        if (!$token->verify($signer, $parseTokenKey)) {
            throw new ErrorException('exception.auth');
        }

        return $token->getClaim('sub') === "";
    }

    private function getUserIdFromToken(string $token)
    {
        $key_path = Passport::keyPath('oauth-public.key');
        $parseTokenKey = file_get_contents($key_path);

        try {
            $token = (new Parser())->parse($token);
        } catch (\Exception $e) {
            throw new ErrorException('exception.invalid_user_auth_token');
        }

        $signer = new Sha256();

        if (!$token->verify($signer, $parseTokenKey)) {
            throw new ErrorException('exception.invalid_user_auth_token');
        }

        return $token->getClaim('sub');
    }
}

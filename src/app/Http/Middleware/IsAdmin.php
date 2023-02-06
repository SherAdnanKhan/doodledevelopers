<?php

namespace App\Http\Middleware;

use App\Exceptions\AccountSuspendedException;
use App\Exceptions\ErrorException;
use App\Models\User;
use Closure;

class IsAdmin
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
        $this->checkIsAdmin();

        if (auth()->user()->status !== User::USER_STATUS_ACTIVE) {
            $exception = (auth()->user()->status === User::USER_STATUS_NEW) ? 'exception.user_email_not_verified' : 'exception.account_disabled';
            throw new ErrorException($exception);
        }
        return $next($request);
    }

    private function checkIsAdmin()
    {
        if (!auth()->user()->is_admin) {
            throw new ErrorException('exception.unauthorized', [], 401);
        }
    }
}

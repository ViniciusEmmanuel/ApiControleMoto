<?php

namespace App\Http\Middleware;

use App\Services\AuthJwt;
use Closure;
use phpDocumentor\Reflection\Types\Object_;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $validate = (new AuthJwt($request))->verify();

        if (!$validate) {
            return response(['message' => 'Unauthorized.', 'data' => new Object_()], 401);
        }

        return $next($request);
    }
}

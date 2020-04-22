<?php

namespace App\Http\Middleware;

use App\Models\User;
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

        $auth = new AuthJwt($request);

        $validate = $auth->verify();

        if (!$validate) {
            return response(['message' => 'Unauthorized.', 'data' => new Object_()], 401);
        }

        $user = $auth->getUser();

        if (!User::where('id', $user)->first()) {
            return response(['message' => 'Unauthorized.', 'data' => new Object_()], 401);
        }

        return $next($request);
    }
}

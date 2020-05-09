<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('apiToken')) {
            return response('Api Token doesn\'t exist', 401);
        }
        $apiToken = $request->header('apiToken');
        $user = User::where('api_token', $apiToken)->first();
        if (!$user) {
            return response('Invalid User', 401);
        }
        Auth::login($user);
        return $next($request);
    }
}

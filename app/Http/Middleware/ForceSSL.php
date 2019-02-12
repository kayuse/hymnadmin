<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/12/19
 * Time: 8:10 PM
 */

namespace App\Http\Middleware;


class ForceSSL
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
        if (!$request->secure() && in_array(env('APP_ENV'), ['staging', 'production'])) {
            return redirect()->secure($request->getRequestUri())->header('api_token',$request->header('api_token'));
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Contractor
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
        if (\Auth::guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('/');
            }
        } elseif ( ! \Auth::user()->isContractor() ) {
            return abort(403);
        }

        return $next($request);
    }
}

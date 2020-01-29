<?php

namespace App\Http\Middleware;

use Closure;

class AllowAccess
{

    // разрешенные IP с которых можно запускать скрипты
    private $allow_ip = [
        '127.0.0.1',
        '77.244.220.215',
        '192.3.220.199',
        '87.249.39.222'
    ];

    private $key = '64B2';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if( !in_array($request->ip(), $this->allow_ip) ){
        if( $request->k != $this->key ){
            abort(403);
        }
        return $next($request);
    }
}

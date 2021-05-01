<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response=$next($request);
        return $response;
    }
}

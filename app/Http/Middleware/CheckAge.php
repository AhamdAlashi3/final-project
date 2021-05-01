<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$role)
    {
       $age=17;
       if($age<18 ||$role != 'Admin'){
           return response()->json(['status'=>false,'message'=>'Age is less than 18'], 400);
       }
       return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdminOrSelf
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
      $requestUserId = $request->route()->parameter('id');
      if ( 
        Auth::user()->role === 2 ||
        Auth::user()->id === $requestUserId
      ) {
        return $next($request);
      } else {
        return response()->json(['error' => 'Unauthorized'], 403);
      }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
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
        if (auth()->check() && auth()->user()->is_active == '1') {
            auth()->logout();

            $message = 'Conta desativada. Contate o administrador';

            return redirect()->route('login')->with('error', $message);
        }

        return $next($request);
    }
}

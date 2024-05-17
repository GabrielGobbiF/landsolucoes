<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPassword
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
        $id = Auth::user()->id;
        if (auth()->check()) {

            if ($id != '3' || $id != '6' || $id != '8') {
                if (Auth::user()->rg == '') {
                    return redirect()->route('password.change');
                }
            }
        }

        return $next($request);
    }
}

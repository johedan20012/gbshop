<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class ChecarPrivilegios
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(Auth::guard()->check()){ #Esto indica que esta loggeado como admin
            $admin = Auth::guard()->user();

            if($admin->privilegios == 1){ #Este admin es poderoso
                return $next($request);
            }
            return redirect('/admin');
        }
        return redirect('/');
    }
}

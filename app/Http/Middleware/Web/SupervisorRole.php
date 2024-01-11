<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
 
class SupervisorRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'super') {
                return $next($request);
            } else {
                return redirect('/');              
            }
        } else {
            return redirect()->route('login');
        }
        //   return  redirect()->intended('login');
        // return redirect('/dashboard');
    }
}

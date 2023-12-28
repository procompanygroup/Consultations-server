<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *  protected function redirectTo(Request $request): ?string
     */
    /*
    protected function redirectTo(Request $request): Response
    {
     
        return response()->json(['error' => 'Unauthorized']);
      // return  $request->expectsJson() ? null :redirect()->route('faild');; 
     // return $request->expectsJson() ? null : ("Unauthorized")->json();
         
    }
    */
    public function handle(Request $request, Closure $next): Response
    {
      //  if(Auth::user()->role=='admin'){
      //  $x=1;
        if( $request->expectsJson() ){
            return $next($request);
          
        }else{
        return redirect()->route('faild');
        }
        
    //   return  redirect()->intended('login');
   // return redirect('/dashboard');
   
    }
}

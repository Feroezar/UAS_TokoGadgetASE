<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class manajer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect('/login');
        }

        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user=Auth::user();
        if($user->role=2){
            return $next($request);
        }
        if($user->role==1){
            return redirect()->route('admin');
        }
        if($user->role==3){
            return redirect()->route('customer');
        }
        if($user->role==4){
            return redirect()->route('kasir');
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'exam':
                if (Auth::guard($guard)->check()) {
                    return redirect(route('exam.home'));
                }
                break;
            
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/admin');
                }
                break;
        }
        
        return $next($request);
    }
}

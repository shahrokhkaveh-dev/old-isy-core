<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PwaAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            $step = Auth::user()->status;
            switch ($step) {
                case 1:
                    return redirect()->route('pwa.get.step1');
                    break;
                case 2:
                    return redirect()->route('pwa.get.step2');
                    break;
            }
            return $next($request);
        }
        return redirect()->route('pwa.login');
    }
}

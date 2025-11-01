<?php

namespace App\Http\Middleware;

use App\Services\Application\ApplicationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LetterPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->access(3)) {
            return ApplicationService::responseFormat([
                'letters' => []
            ]);
        }

        return $next($request);
    }
}

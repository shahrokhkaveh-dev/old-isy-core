<?php

namespace App\Http\Middleware;

use App\Services\Application\ApplicationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHasLegalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->is_branding) {
            return ApplicationService::responseFormat([], false, 'شما اجازه دسترسی به این صفحه ندارید.');
        }
        return $next($request);
    }
}

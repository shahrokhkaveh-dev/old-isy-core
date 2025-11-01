<?php

namespace App\Http\Middleware\Admin;

use App\Enums\AdminLoginAttempt\Fields;
use App\Enums\CommonFields;
use App\Repositories\AdminLoginAttemptRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserAndIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $username = $request->input(CommonFields::USERNAME);
        $referrer = $request->header(Fields::REFERRER);
        $repository = new AdminLoginAttemptRepository();

        if ($referrer != null) {
            $referrer = parse_url($referrer)[CommonFields::HOST];
        }

        $requestIsNotValid = $repository->checkAttempt($ipAddress, $username);

        if ($requestIsNotValid) {
            return back()->withErrors([CommonFields::ERROR => __('auth.login_limit')]);
        }

        $loginAttemptData = [
            Fields::IP => $ipAddress,
            Fields::REFERRER => $referrer,
            Fields::AGENT => $request->header(Fields::AGENT),
            CommonFields::USERNAME => $username,
        ];

        $repository->createEntry($loginAttemptData);

        return $next($request);
    }
}

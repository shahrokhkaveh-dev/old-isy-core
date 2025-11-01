<?php

namespace App\Http\Middleware\Admin;

use App\Enums\Admin\Entries;
use App\Enums\Admin\Fields;
use App\Enums\CommonFields;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminGuardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard(Fields::ADMIN_GUARD);

        if (!$guard->check()) {
            return redirect()->route('admin.login')->withErrors(
                [CommonFields::ERROR => __('auth.login_first')]
            );
        }

        $user = $guard->user();

        if ($user[Fields::IS_ACTIVE] != Entries::ACTIVE_USER) {
            return redirect()->route('admin.login')->withErrors(
                [CommonFields::ERROR => __('dashboard.your_account_is_deactivated')]
            );
        }

        if ($user[Fields::SESSION] != $request->session()->getId()) {
            $guard->logout();
            return redirect()->route('admin.login')->withErrors(
                [CommonFields::ERROR => __('auth.you_have_logged_in_with_another_device')]
            );
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\Fields;
use App\Enums\CommonFields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Repositories\AdminLoginAttemptRepository;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::guard(Fields::ADMIN_GUARD)->attempt([CommonFields::USERNAME => $request[CommonFields::USERNAME], Fields::PASSWORD => $request[Fields::PASSWORD]])) {
            return back()->withErrors([CommonFields::ERROR => __('auth.wrong_credentials')]);
        }

        Auth::guard(Fields::ADMIN_GUARD)->logoutOtherDevices($request[Fields::PASSWORD]);

        $adminRepository = new AdminRepository();
        $adminRepository->updateUserAfterLogin(auth(Fields::ADMIN_GUARD)->user(), $request->session()->getId());

        $adminLoginAttemptRepository = new AdminLoginAttemptRepository();
        $adminLoginAttemptRepository->successStatus();

        return redirect()->route('admin.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Admin\Fields;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $active = 'dashboard';
    public function index(){
        // Auth::guard('admin')->loginUsingId(1);
        // dd(auth('admin')->user());
        $lastLogin = jdate(DB::table('admin_login_attempts')->where(['username'=>Auth::guard('admin')->user()->username , 'status'=>1])->latest()->first()->created_at)->toString();
        $unreadTickets = 0;
        $role = Fields::ROLE_ARRAY[Auth::guard('admin')->user()->role];
        return view('admin.panel.dashboard' , compact(['lastLogin' , 'unreadTickets' , 'role']))->with(['active' =>$this->active]);
    }
}

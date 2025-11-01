<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('panel.profile' , compact(['user']));
    }

    public function setImage(Request $request)
    {
        $request->validate([
            'image'=>'required|image'
        ]);
        $path = ImageService::upload($request->file('image'));
        $user = Auth::user();
        $user->update([
            'avatar'=>$path
        ]);
        return back();
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password'=>'required',
            'confirmed_password'=>'required'
        ]);
        if ($request->input('password') == $request->input('confirmed_password')){
            $user = Auth::user();
            $user->update([
                'password'=>$request->input('password'),
            ]);
        }
        return back();
    }
}

<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Services\ImageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $brand = Auth::user()->brand;
        $images = DB::table('brand_images')
            ->where('brand_id', $brand->id)
            ->latest()->select(['image_path'])
            ->get()
            ->toArray();
        $images = array_column($images, 'image_path');
        $users = \App\Models\User::where('brand_id' , $brand->id)->get();
        return view('panel.company.index', compact(['brand', 'images', 'users']));
    }

    public function setlogo(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);
        $path = ImageService::upload($request->file('image'));
        $brand = Auth::user()->brand;
        $brand->update([
            'logo_path' => $path
        ]);
        return back();
    }

    public function insertImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);
        $path = ImageService::upload($request->file('image'));
        DB::table('brand_images')->insert([
            'brand_id'=>Auth::user()->brand->id,
            'image_path'=>$path,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ]);
        return response()->json(['path'=> url($path) , 'link'=>$path]);
    }

    public function removeImage(Request $request)
    {
        $image = DB::table('brand_images')->where(['brand_id'=>Auth::user()->brand->id , 'image_path'=>$request->input('image_path')])->delete();
        if (file_exists($request->input('image_path'))){
            unlink($request->input('image_path'));
        }
        return response()->json(['link'=>$request->input('image_path')]);
    }

    public function addmember (Request $request)
    {
        $request->validate([
            'fname'=>'required|persian_alpha|max:250',
            'lname'=>'required|persian_alpha|max:250',
            'phone'=>'required|ir_mobile:zero|max:11',
        ]);
        $user = \App\Models\User::where('phone' , $request->input('phone'))->first();
        if($user){
            return back()->with(['error'=>'شماره وارد شده تکراری است.']);
        }
        $user = \App\Models\User::create([
            'first_name'=>$request->input('fname'),
            'last_name'=>$request->input('lname'),
            'name'=>$request->input('fname').' '.$request->input('lname'),
            'phone'=>$request->input('phone'),
            'is_branding'=>true,
            'brand_id'=>Auth::user()->brand->id,
            'status'=>4
        ]);
        foreach (array_keys($request->input('permission')) as $p){
            DB::table('user_permissions')->insert([
                'user_id'=>$user->id,
                'permission_id'=>$p
            ]);
        }
        $permissions = Permission::all();
        return back();
    }
    public function editmember(Request $request)
    {
        $brand = Auth::user()->brand;
        $user = User::find($request->input('user_id'));
        if($user->brand_id == $brand->id){
            DB::table('user_permissions')->where('user_id' , $user->id)->delete();
            $user->update([
                'first_name'=>$request->input('fname'),
                'last_name'=>$request->input('lname'),
                'name'=>$request->input('fname').' '.$request->input('lname'),
                'phone'=>$request->input('phone'),
            ]);
            foreach (array_keys($request->input('permission')) as $p){
                DB::table('user_permissions')->insert([
                    'user_id'=>$user->id,
                    'permission_id'=>$p
                ]);
            }
        }
        return back();
    }
    public function removemember(Request $request)
    {
        $request->validate([
            'user_id'=>'required'
        ]);
        $brand = Auth::user()->brand;
        $user = User::find($request->input('user_id'));
        if($user->brand_id == $brand->id){
            $user->update([
                'brand_id'=>null,
                'is_branding'=>false,
                'status'=>1
            ]);
            DB::table('user_permissions')->where('user_id' , $user->id)->delete();
        }
        return back();
    }
    public function managment(Request $request){
        $inputs['description'] = $request->input('description');
        $inputs['managment_name']=$request->input('managment_name');
        $inputs['managment_number']=$request->input('managment_number');
        if ($request->file('managment_profile_image')) {
            $name = time() . random_int(1000, 9999) . '.' . $request->file('managment_profile_image')->getClientOriginalExtension();
            $request->file('managment_profile_image')->move('upload/images/', $name);
            $path ='upload/images/' . $name;
            $inputs['managment_profile_path'] = $path;
        }
        Auth::user()->brand->update($inputs);
        return back();
    }
}

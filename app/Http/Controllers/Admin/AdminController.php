<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Admin\Admin;
use App\Repositories\AdminRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(AdminRepository $repository){
        $perPage = $_GET['perPage'] ?? 10;
        [$admins , $items] = $repository->getAll($perPage);
        return view('admin.panel.admins.index' , compact(['admins' , 'items']));
    }

    public function create(){
        return view('admin.panel.admins.create');
    }

    public function store(AdminRequest $request){
        $inputs = [
            'username' => $request->input('username'),
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role'),
        ];
        $inputs['password'] = Hash::make($request->input('password'));
        if($request->file('image')){
            $path = ImageService::upload($request->file('image'));
            $inputs['image_url'] = $path;
        }
        $admin = AdminRepository::insert($inputs);
        return redirect()->route('admin.admin.index')->with('success' , 'مدیر جدید ساخته شد');
    }

    public function edit(string $id , AdminRepository $repository){
        $admin = $repository->find($id);
        return view('admin.panel.admins.edit' , compact(['admin' , 'id']));
    }

    public function changeActivation(string $id , AdminRepository $repository){
        $repository->changeStatus($id);
        return redirect()->back();
    }

    public function update(AdminRepository $repository, string $id, AdminRequest $request){
        $admin = $repository->updateAdmin($id, $request);
    }
}

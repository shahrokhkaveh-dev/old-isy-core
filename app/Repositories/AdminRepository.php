<?php

namespace App\Repositories;

use App\Enums\Admin\Fields;
use App\Models\Admin\Admin;

class AdminRepository extends BaseRepository
{
    protected $roles = [
        'admin' => 'ادمین'
    ];

    public function __construct()
    {
        $model = new Admin();
        parent::__construct($model);
    }

    public function updateUserAfterLogin($user, $sessionId)
    {
        $user->update([
            Fields::LAST_LOGIN => now(),
            Fields::SESSION => $sessionId
        ]);
    }

    public function getAll($perPage){
        $admins = Admin::query();
        if(isset($_GET['search'])){
            $string = $_GET['search'];
            $searchValues = preg_split('/\s+/', $string, -1, PREG_SPLIT_NO_EMPTY);
            $admins = $admins->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                    $q->orWhere('fname', 'like', "%{$value}%")->orWhere('lname', 'like', "%{$value}%");
                }
            });
        }
        $admins = $admins->select(['username' , 'fname' , 'lname' , 'role' , 'created_at' , 'id'])->paginate($perPage);
        if($admins == null){
            return [];
        }
        $items = [];
        foreach($admins as $key => $admin){
            $items[$key]['username'] = $admin->username;
            $items[$key]['name'] = $admin->fname . ' ' . $admin->lname;
            $items[$key]['role'] = $this->roles[$admin->role];
            $items[$key]['created_at'] = jdate($admin->created_at)->format('Y/m/d');
            $items[$key]['id'] = encrypt($admin->id);
        }
        return [$admins , $items];
    }

    static function insert($inputs){
        $admin = Admin::create($inputs);
        return $admin;
    }

    public function find($id){
        $id = decrypt($id);
        $admin = Admin::findOrFail($id , ['fname' , 'lname' , 'role' , 'username' , 'email' ,'phone' , 'image_url' , 'is_active']);
        return $admin;
    }

    public function changeStatus($id){
        $admin = Admin::findOrFail(decrypt($id));
        $admin->update(['is_active' => $admin->is_active ? 0 : 1]);
        $admin->save();
    }
}

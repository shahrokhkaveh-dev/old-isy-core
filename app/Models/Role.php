<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name'];
    protected array $translatable = ['name'];

    public function permissions(){
        return $this->belongsToMany(Permission::class)->using(RolePermission::class);
    }

    public function hasPermission($name){
        foreach($this->permissions as $permission){
            if($permission->name == $name){
                return true;
            }
        }
        return false;
    }

    public function users(){
        return $this->belongsToMany(User::class)->using(UserRole::class);
    }
}

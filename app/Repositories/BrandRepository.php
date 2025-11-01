<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Province;
use App\Models\User;

class BrandRepository {


    public function provinceOrCitySearch(){
        // foreach(Ipark::all() as $item){
        //     $item->name = str_replace('ك', 'ک', $item->name);
        //     $item->save();
        // }
        // dd('done');
        if(isset($_GET['locale']) && strlen($_GET['locale']) > 0){
            $provinces = Province::where('name', 'LIKE', "%{$_GET['locale']}%")->get(['id']);
            $cities = City::where('name', 'LIKE', "%{$_GET['locale']}%")->get(['id']);
            if($provinces){
                $provinces = $provinces->toArray();
                $provinces = array_column($provinces , 'id');
            }else{
                $provinces = null;
            }
            if($cities){
                $cities = $cities->toArray();
                $cities = array_column($cities , 'id');
            }else{
                $cities = null;
            }
            return [$provinces , $cities];
        }else{
            return [null , null];
        }
    }

    public function starterData(){
        $category = Category::where('parent_id' , null)->get(['name' , 'id']);
        return [$category , null];
    }

    public function search(array $search){

        $perPage = isset($_GET['perPage'])? $_GET['perPage'] : 10;
        [$provinces , $cities] = $this->provinceOrCitySearch();
        $brands = Brand::query();

        if(isset($_GET['name']) && strlen($_GET['name']) > 0){
            $brands = $brands->where('brands.name', 'LIKE', "%{$_GET['name']}%");
        }

        if($provinces && !$cities){
            $brands = $brands->whereIn('province_id' , $provinces);
        }
        if(!$provinces && $cities){
            $brands = $brands->whereIn('city_id' , $cities);
        }
        if($provinces && $cities){
            $brands = $brands->where(function ($query) use ($provinces, $cities) {
                $query->whereIn('province_id' , $provinces)
                    ->orWhereIn('city_id', $cities);
            });
        }
        if(isset($_GET['category']) && strlen($_GET['category']) > 0){
            $brands = $brands->where('brands.category_id', '=', $_GET['category']);
        }

        $brands->join('provinces' , 'provinces.id' , '=', 'brands.province_id');
        $brands = $brands->select(['brands.id' , 'brands.logo_path' , 'brands.name', 'brands.created_at' , 'provinces.name as province'])
            ->paginate($perPage);
        return $brands;
    }

    public function create(array $data): Brand
    {
        return Brand::create($data);
    }

    public function findById(int $id): Brand
    {
        return Brand::find($id);
    }

    public function attachUser(int $userId, int $brandId): void
    {
        $user = User::find($userId);
        if($user){
            $user->brand_id = $brandId;
            $user->save();
        }
    }
}

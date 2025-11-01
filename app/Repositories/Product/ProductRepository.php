<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Product());
    }

    public function getRandomItems($items = 10, $where = null, $select = null, array $targetCategories = [])
    {
        $products = $this->model->newQuery();
        if($where){
            $products = $products->where($where);
        }
        if($select){
            $products = $products->select($select);
        }

        if(!empty($targetCategories)){
            $product = $products->whereIn('category_id', $targetCategories);
        }
        $products->with(['category:id,name,code', 'brand:id,name,slug']);
        return $products->inRandomOrder()->limit($items)->get()->map(function ($product) {
            $product->image = $product->image ? asset($product->image) : 'https://fakeimg.pl/100x90';
            return $product;
        });
    }
}

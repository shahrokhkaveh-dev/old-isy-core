<?php

namespace Database\Seeders\Category;

use App\Enumerations\Category\Fields;
use App\Enumerations\Category\Status;
use App\Enumerations\CommonFields;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MadeInChinaCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = require_once __DIR__ . '/madeInChinaCategories.php';
        $code = ['00','00','00','00'];
        $prevId = ['1'=>null, '2'=>null, '3'=>null];
        foreach ($data as $category){
            $inputs = [];
            $parentId = null;
            if($category['val3'] == '4'){
                $parentId = $prevId['3'];
            }elseif($category['val3'] == '3'){
                $parentId = $prevId['2'];
            }elseif($category['val3'] == '2'){
                $parentId = $prevId['1'];
            }

            // Set Code
            if($category['val3'] == '4'){
                $code[3] = str_pad((int)$code[3] + 1, 2, '0', STR_PAD_LEFT);
            }elseif($category['val3'] == '3'){
                $code[2] = str_pad((int)$code[2] + 1, 2, '0', STR_PAD_LEFT);
                $code[3] = '00';
            }elseif($category['val3'] == '2'){
                $code[1] = str_pad((int)$code[1] + 1, 2, '0', STR_PAD_LEFT);
                $code[2] = '00';
                $code[3] = '00';
            }else{
                $code[0] = str_pad((int)$code[0] + 1, 2, '0', STR_PAD_LEFT);
                $code[1] = '00';
                $code[2] = '00';
                $code[3] = '00';
            }

            $inputs[Fields::NAME->value] = $category['val2'];
            $inputs[Fields::ENAME->value] = $category['val1'];
            $inputs[Fields::DESCRIPTION->value] = null;
            $inputs[Fields::ICONS->value] = null;
            $inputs[Fields::PARENT_ID->value] = $parentId;
            $inputs[Fields::STATUS->value] = Status::ACTIVE->value;
            $inputs[Fields::ORDER->value] = 1;
            $inputs[Fields::LEVEL->value] = (int)$category['val3'];
            $inputs[Fields::CODE->value] = implode('', $code);
            $inputs[Fields::IMAGES->value] = json_encode(['198x120'=>'https://fakeimg.pl/250x100','300x380'=>'https://fakeimg.pl/250x100']);
            $inputs[Fields::IMAGE->value] = 'https://fakeimg.pl/198x120';
            $cat = Category::create($inputs);
            if($category['val3'] != '4'){
                $prevId[$category['val3']] = $cat->getAttribute(CommonFields::ID->value);
            }
        }
    }
}

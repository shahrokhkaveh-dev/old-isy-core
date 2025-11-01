<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Product;
use App\Models\ProductInquery;
use App\Models\Province;
use App\Models\User;
use App\Services\Notifications\FirebaseService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $otherProducts = Product::where('brand_id', $product->brand->id)->where('id', '!=', $product->id)->inRandomOrder()->limit(10)->get();
        return view('web.product', compact(['product', 'otherProducts']));
    }

    public function search()
    {
        $categories = Category::where('parent_id', null)->orderBy('search_url')->get();
        $products = Product::join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(['products.name', 'products.image', 'products.slug', 'products.category_id', 'products.brand_id', 'products.isExportable', 'brands.ipark_id', 'brands.province_id', 'brands.city_id']);
        if (isset($_GET['province_id']) && $_GET['province_id']) {
            $products = $products->where('brands.province_id', $_GET['province_id']);
            $cities = City::where('province_id', $_GET['province_id'])->get();
        } else {
            $cities = City::all();
        }
        if (isset($_GET['city_id']) && $_GET['city_id']) {
            $products = $products->where('brands.city_id', $_GET['city_id']);
        }
        if (isset($_GET['search']) && $_GET['search']) {
            $products = $products->where('products.name', 'LIKE', '%' . $_GET['search'] . '%');
        }
        if (isset($_GET['category_id']) && $_GET['category_id']) {
            $products = $products->where('products.category_id', $_GET['category_id']);
        }
        if (isset($_GET['ipark_id']) && $_GET['ipark_id']) {
            $products = $products->where('ipark_id', $_GET['ipark_id']);
        }
        if (isset($_GET['justExportable']) && $_GET['justExportable'] == 'on') {
            $products = $products->where('isExportable', true);
        }

        $provinces = Province::all();
        $iparks = Ipark::all();
        $products = $products->inRandomOrder()->paginate(96);
        return view('web.products', compact('products', 'categories', 'provinces', 'cities' , 'iparks'));
    }

    public function inquiry(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric',
            'product_id' => 'required'
        ]);
        $product = Product::find($request->input('product_id'));
        $brand = $product->brand;
        $inquiry = new ProductInquery;
        $inquiry->author_id = auth()->user()->id;
        $inquiry->product_id = $request->input('product_id');
        $inquiry->brand_id = auth()->user()->brand ? auth()->user()->brand->id : null;
        $inquiry->destination_id = $brand->id;
        $inquiry->number = $request->input('number');
        $inquiry->description = null;
        $inquiry->save();
        $users = User::select(['users.phone', 'users.avatar', 'users.id'])
        ->leftjoin('user_permissions' , 'user_permissions.user_id' , 'users.id')
        ->where(['user_permissions.permission_id'=>5 , 'users.brand_id'=>$brand->id])
        ->get();
        $firebaseService = new FirebaseService();
        foreach($users as $user){
            SMSPattern::sendInquery($user->phone, \request()->user()->brand->name);

            $firebaseService->sendInquiryNotificationToUser(\request()->user(),$user);
        }
        if ($inquiry) {
            return response()->json(['status' => 1, 'text' => 'استعلام با موفقیت ثبت شد']);
        } else {
            return response()->json(['status' => 0, 'text' => 'در برقراری ارتباط با سایت مشکلی پیش آمد']);
        }
    }
}

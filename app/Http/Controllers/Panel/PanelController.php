<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanelController extends Controller
{
    public function dashboard()
    {   $brand_id = Auth::user()->brand ? Auth::user()->brand->id : null;
        $created_at_ago = Auth::user()->created_at;
        $created_at_ago = jdate($created_at_ago)->ago();
        $created_at_ago = str_replace('پیش' , '' , $created_at_ago);

        $code = $brand_id + 1446;

        $wallet = Auth::user()->brand ? Auth::user()->brand->wallet : null;

        $expired = Auth::user()->brand ? Auth::user()->brand->vip_expired_time : null;
        $expired = $expired ? jdate($expired)->format('Y/m/d') : null;

        $user_invited = Brand::where('identification_code' , $code)->count();

        $product_inquiries = DB::table('product_inquiries')->where(['destination_id'=>$brand_id , 'response_date'=>null])->count();

        $products = DB::table('products')->where('brand_id' , $brand_id)->count();

        $activation = Auth::user()->is_active ? 'فعال' : 'غیرفعال';

        $activation_list = DB::table('fake_logs')->where('brand_id' , $brand_id)->latest()->limit(5)->select('text')->get()->toArray();
        $activation_list = array_column($activation_list, 'text');

        return view('panel.index' , compact(['created_at_ago' , 'code' , 'wallet' , 'expired' , 'user_invited' , 'product_inquiries' , 'products' , 'activation' , 'activation_list']));
    }
}

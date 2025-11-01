<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductInquery;
use App\Services\ImageService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Auth::user()->brand;
        $products = Product::where('brand_id' , $brand->id)->latest()->get();
        return view('panel.product.index' , compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('panel.product.create' , compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:250',
            'image'=>'required|image',
        ]);
        $excerpt = strip_tags($request->input('description'));
        $excerpt = mb_substr($excerpt , 1 , 149 , 'utf-8');
        $excerpt = strip_tags($request->input('description'));
        $product = new Product();
        $product->name = $request->input('name');
        $product->ename = null;
        $product->brand_id = auth()->user()->brand->id;
        $product->excerpt = $excerpt;
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->province_id = auth()->user()->brand->province->id;
        $product->city_id = auth()->user()->brand->city->id;
        $product->sub_category_id = auth()->user()->brand->category_id;
        $product->image = '';
        if($request->input('isExportable')){
            $product->isExportable = true;
        }
        $product->save();
        if($request->hasFile('image')){
            $product->image = ImageService::store($request->file('image') , 'products');
            $product->save();
        }
        if($request->input('key')){
            foreach($request->input('key') as $key=>$val){
                if(isset($request->input('key')[$key]) && isset($request->input('value')[$key]) && strlen($request->input('key')[$key])<200 && strlen($request->input('value')[$key])<200){
                    ProductAttributes::create([
                        'product_id'=>$product->id,
                        'name' => $request->input('key')[$key],
                        'value' => $request->input('value')[$key]
                    ]);
                }
            }
        }
        return redirect()->route('panel.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $user = auth()->user();
        $brand = $user->brand;
        $categories = Category::all();
        $attributes = DB::table('product_attributes')->where('product_id' , $product->id)->select(['name' , 'value'])->get()->toArray();
        return view('panel.product.edit',compact('brand', 'user' , 'categories' , 'product' , 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|max:250',
            'image'=>'image',
        ]);
        $excerpt = strip_tags($request->input('description'));
        $excerpt = mb_substr($excerpt , 1 , 149 , 'utf-8');
        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->excerpt = $excerpt;
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        if($request->input('isExportable')){
            $product->isExportable = true;
        }
        if($request->hasFile('image')){
            if (file_exists($product->image)){
                unlink($product->image);
            }
            $product->image = ImageService::store($request->file('image') , 'products');

        }
        $product->save();
        DB::table('product_attributes')->where('product_id' , $product->id)->delete();
        if($request->input('key')){
            foreach($request->input('key') as $key=>$val){
                if(isset($request->input('key')[$key]) && isset($request->input('value')[$key]) && strlen($request->input('key')[$key])<200 && strlen($request->input('value')[$key])<200){
                    ProductAttributes::create([
                        'product_id'=>$product->id,
                        'name' => $request->input('key')[$key],
                        'value' => $request->input('value')[$key]
                    ]);
                }
            }
        }
        return redirect()->route('panel.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if($product->brand_id == Auth::user()->brand->id){
            if($product->image && file_exists($product->image)){
                unlink($product->image);
            }
            $product->delete();
        }

        return redirect()->back();
    }

    public function request()
    {
        $inqueries = ProductInquery::where(['brand_id'=>Auth::user()->brand->id ])->latest()->get();
        return view('panel.productInquery.request' , compact('inqueries'));
    }

    public function response()
    {
        $inqueries = ProductInquery::where(['destination_id'=>Auth::user()->brand->id ])->latest()->get();
        return view('panel.productInquery.response' , compact(['inqueries']));
    }

    public function storeresponse(Request $request)
    {
        // dd($request->all());
        $inquery = ProductInquery::find($request->input('productInqueryId'));
        if($inquery->destination_id == auth()->user()->brand->id){

            $inquery->update([
                'status' => $request->input('status'),
                'amount' => $request->input('amount'),
                'response_date'=>Carbon::now()
            ]);
            if($request->hasFile('prefactor')){
                $request->file('prefactor')->move('upload/prefactors/' , $inquery->id.'.pdf');
                $inquery->update([
                    'prefactor_path' => 'upload/prefactors/' . $inquery->id.'.pdf'
                ]);
            }
            $inquery->save();
        }
        $author = Brand::find($inquery->author_id);
        if($author && $author->user){
            SMSPattern::sendInqueryResponse($author->user->phone, auth()->user()->brand->name);
        }
        return redirect()->back();
    }
}

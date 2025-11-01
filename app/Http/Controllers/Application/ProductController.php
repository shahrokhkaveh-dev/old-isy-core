<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ProductStoreRequest;
use App\Http\Requests\Application\ProductUpdateRequest;
use App\Http\Requests\Application\ProdustStoreResponseRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributes;
use App\Models\ProductInquery;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\Application\ApplicationService;
use App\Services\FileService;
use App\Services\ImageService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index()
    {
        $user = \request()->user();
        if (!$user) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_found'), -2);
        }
        $brand = $user->brand;
        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -3);
        }
        $products = Product::where('brand_id', $brand->id)
            ->select(['products.id', 'products.image', 'products.name', 'categories.name as category', 'products.slug', 'products.created_at'])
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->latest()->get()->toArray();
        $products = array_map(function ($product) {
            $product['id'] = encrypt($product['id']);
            return $product;
        }, $products);
        $data['products'] = $products;
        return ApplicationService::responseFormat($data);
    }

    public function index2(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return ApplicationService::responseFormat([], false, __('messages.user_not_found'), -2);
        }

        $brand = $user->brand;
        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -3);
        }

        $productsArray = Product::query()
            ->where('brand_id', $brand->id)
            ->with('category:id,name')
            ->select(['id', 'image', 'name', 'slug', 'created_at', 'category_id'])
            ->latest()
            ->get()
            ->toArray();

        $currentLocale = app()->getLocale();

        $processedProducts = array_map(
            fn($product) => [
                'id' => encrypt($product['id']),
                'image' => $product['image'],
                'name' => $product['name'],
                'category' => $product['category']['name'] ?? '',
                'slug' => $product['slug'],
                'created_at' => $currentLocale === 'fa-IR'
                    ? jdate($product['created_at'])->format('Y/m/d H:i:s')
                    : Carbon::parse($product['created_at'])->format('Y-m-d H:i:s'),
            ],
            $productsArray
        );

        return ApplicationService::responseFormat(['products' => $processedProducts]);
    }

    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $data['categories'] = $categories;
        return ApplicationService::responseFormat($data);
    }

    public function store(ProductStoreRequest $request)
    {
        $excerpt = strip_tags($request->input('description'));
        $excerpt = mb_substr($excerpt, 1, 149, 'utf-8');

        $product = new Product();
        $product->name = $request->input('name');
        $product->ename = null;
        $product->brand_id = auth()->user()->brand->id;
        $product->excerpt = $excerpt;
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->HSCode = $request->input('HSCode');
        $product->isExportable = $request->input('isExportable') ? true : false;
        $product->province_id = auth()->user()->brand->province?->id;
        $product->city_id = auth()->user()->brand->city?->id;
        $product->sub_category_id = auth()->user()->brand->category_id;
        $product->image = '';
        $product->save();

        if ($request->hasFile('image')) {
            $product->image = ImageService::store($request->file('image'), 'products');
            $product->save();
        }

        if ($request->input('key')) {
            foreach ($request->input('key') as $key => $val) {
                if (isset($request->input('key')[$key]) && isset($request->input('value')[$key]) && strlen($request->input('key')[$key]) < 200 && strlen($request->input('value')[$key]) < 200) {
                    ProductAttributes::create([
                        'product_id' => $product->id,
                        'name' => $request->input('key')[$key],
                        'value' => $request->input('value')[$key]
                    ]);
                }
            }
        }

        $data['product'] = $product;

        if (auth('sanctum')->user()->is_admin) {
            $user = auth('sanctum')->user();
            $now = Carbon::now();
            $isFriday = $now->isFriday();
            $currentTime = $now->format('H:i');
            $startTime = '08:00';
            $endTime = '15:20';
            $jalaliDate = Jalalian::fromCarbon($now);
            $year = $jalaliDate->getYear();
            $month = str_pad($jalaliDate->getMonth(), 2, '0', STR_PAD_LEFT);
            $day = str_pad($jalaliDate->getDay(), 2, '0', STR_PAD_LEFT);
            $isHoliday = false;

            try {
                $response = Http::get("https://holidayapi.ir/jalali/{$year}/{$month}/{$day}");
                if ($response->ok()) {
                    $data = $response->json();
                    if (isset($data['isHoliday']) && $data['isHoliday'] === true) {
                        $isHoliday = true;
                    }
                }
            } catch (\Throwable $th) {
                // Handle exception
            }

            if ($user->is_admin) {
                if ($user->is_staff) {
                    if (!$isFriday && ($currentTime < $startTime || $currentTime > $endTime)) {
                        $user->increment('wallet');
                    } elseif ($isFriday || $isHoliday) {
                        $user->increment('wallet');
                    }
                } else {
                    $user->increment('wallet');
                }
            }
        }

        return ApplicationService::responseFormat($data, true, __('messages.product_added_successfully'));
    }

    public function edit(string $id)
    {
        $id = decrypt($id);
        $product = Product::where('id', $id)
            ->select(['id', 'brand_id', 'name', 'isExportable', 'category_id', 'HSCode', 'description', 'image'])
            ->first()->toArray();
        $user = \request()->user();
        $brand = $user->brand;

        if ($product['brand_id'] != $user->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.product_access_denied'));
        }

        $product['brand_id'] = encrypt($product['brand_id']);
        $attributes = DB::table('product_attributes')->where('product_id', $id)->select(['name', 'value'])->get()->toArray();
        $data['category'] = Category::whereId($product['category_id'])->select(['id', 'name'])->first();
        $data['product'] = $product;
        $data['attributes'] = $attributes;
        $data['product']['id'] = encrypt($data['product']['id']);

        return ApplicationService::responseFormat($data);
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $id = decrypt($id);
        $user = \request()->user();
        $excerpt = strip_tags($request->input('description'));
        $excerpt = mb_substr($excerpt, 1, 149, 'utf-8');
        $product = Product::find($id);

        if ($product->brand_id != $user->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.product_access_denied'), -2);
        }

        $product->name = $request->input('name') ? $request->input('name') : $product->name;
        $product->excerpt = $request->input('description') ? $excerpt : $product->excerpt;
        $product->description = $request->input('description') ? $request->input('description') : $product->description;
        $product->category_id = $request->input('category_id') ? $request->input('category_id') : $product->category_id;
        $product->HSCode = $request->input('HSCode');
        $product->isExportable = $request->input('isExportable') ? true : false;

        if ($request->hasFile('image')) {
            if (file_exists($product->image)) {
                unlink($product->image);
            }
            $product->image = ImageService::store($request->file('image'), 'products');
        }

        $product->save();

        if ($request->input('key')) {
            DB::table('product_attributes')->where('product_id', $product->id)->delete();
            foreach ($request->input('key') as $key => $val) {
                if (isset($request->input('key')[$key]) && isset($request->input('value')[$key]) && strlen($request->input('key')[$key]) < 200 && strlen($request->input('value')[$key]) < 200) {
                    ProductAttributes::create([
                        'product_id' => $product->id,
                        'name' => $request->input('key')[$key],
                        'value' => $request->input('value')[$key]
                    ]);
                }
            }
        }

        return ApplicationService::responseFormat([], true, __('messages.product_updated_successfully'));
    }

    public function destroy(string $id)
    {
        $id = decrypt($id);
        $user = \request()->user();
        $product = Product::find($id);

        if ($product->brand_id != $user->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.product_access_denied'), -2);
        }

        if ($product->image && file_exists($product->image)) {
            unlink($product->image);
        }

        $product->delete();

        return ApplicationService::responseFormat([], true, __('messages.product_deleted_successfully'));
    }

    public function request()
    {
        $user = \request()->user();
        if (!$user->access(4)) {
            return ApplicationService::responseFormat(['data' => []]);
        }

        $inquiries = ProductInquery::where(['product_inquiries.brand_id' => $user->brand_id])
            ->select(['product_inquiries.id', 'product_inquiries.number', 'product_inquiries.unit', 'product_inquiries.status', 'product_inquiries.created_at', 'product_inquiries.amount', 'product_inquiries.response_description', 'product_inquiries.response_date', 'product_inquiries.prefactor_path', 'product_inquiries.description',
                'users.name as author', 'responser.name as responser',
                'products.name as product_name', 'products.slug as product_slug', 'products.image as product_image',
                'brands.name as destination_name', 'brands.slug as destination_slug'])
            ->join('users', 'users.id', '=', 'product_inquiries.author_id')
            ->leftJoin('users as responser', 'responser.id', '=', 'product_inquiries.responsor_id')
            ->join('products', 'products.id', '=', 'product_inquiries.product_id')
            ->join('brands', 'brands.id', '=', 'product_inquiries.destination_id')
            ->latest()->get();

        $inquiries = $inquiries ? $inquiries->toArray() : null;
        $inquiries = array_map(function ($inquiry) {
            $inquiry['id'] = encrypt($inquiry['id']);
            $inquiry['created_at'] = jdate($inquiry['created_at'])->format('Y/m/d');
            $inquiry['response_date'] = $inquiry['response_date'] ? jdate($inquiry['response_date'])->format('Y/m/d') : null;
            return $inquiry;
        }, $inquiries);

        $data['data'] = $inquiries;

        return ApplicationService::responseFormat($data);
    }

    public function request2(Request $request)
    {
        $user = $request->user();
        if (!$user->access(4)) {
            return ApplicationService::responseFormat(['data' => []]);
        }

        $inquiriesArray = ProductInquery::query()
            ->where('brand_id', $user->brand_id)
            ->with([
                'author:id,name',
                'responser:id,name',
                'product:id,name,slug,image',
                'destination:id,name,slug'
            ])
            ->select([
                'id', 'number', 'unit', 'status', 'created_at', 'amount',
                'response_description', 'response_date', 'prefactor_path', 'description',
                'author_id', 'responsor_id', 'product_id', 'destination_id'
            ])
            ->latest()
            ->get()
            ->toArray();

        $currentLocale = app()->getLocale();

        $inquiries =   array_map(
            fn($inquiry) => [
                'id' => encrypt($inquiry['id']),
                'number' => $inquiry['number'],
                'unit' => $inquiry['unit'],
                'status' => $inquiry['status'],
                'created_at' => $currentLocale === 'fa-IR'
                    ? jdate($inquiry['created_at'])->format('Y/m/d')
                    : Carbon::parse($inquiry['created_at'])->format('Y-m-d'),

                'amount' => $inquiry['amount'],
                'response_description' => $inquiry['response_description'],
                'response_date' => $inquiry['response_date']
                    ? (
                    $currentLocale === 'fa-IR'
                        ? jdate($inquiry['response_date'])->format('Y/m/d')
                        : Carbon::parse($inquiry['response_date'])->format('Y-m-d')
                    )
                    : null,
                'prefactor_path' => $inquiry['prefactor_path'],
                'description' => $inquiry['description'],
                'author' => $inquiry['author']['name'],
                'responser' => $inquiry['responser']['name'] ?? null,
                'product_name' => $inquiry['product']['name'],
                'product_slug' => $inquiry['product']['slug'],
                'product_image' => $inquiry['product']['image'],
                'destination_name' => $inquiry['destination']['name'],
                'destination_slug' => $inquiry['destination']['slug'],
            ],
            $inquiriesArray
        );

        return ApplicationService::responseFormat(['data' => $inquiries]);
    }

    public function response()
    {
        $user = \request()->user();
        if (!$user->access(5)) {
            return ApplicationService::responseFormat(['data' => []]);
        }

        Log::channel('user_activity')->info('User accessed response function', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);

        $inquiries = ProductInquery::where(['product_inquiries.destination_id' => $user->brand_id])
            ->select(['product_inquiries.id', 'product_inquiries.number', 'product_inquiries.unit', 'product_inquiries.status', 'product_inquiries.created_at', 'product_inquiries.amount', 'product_inquiries.response_description', 'product_inquiries.response_date', 'product_inquiries.prefactor_path',
                'users.name as author', 'responser.name as responser',
                'products.name as product_name', 'products.slug as product_slug', 'products.image as product_image',
                'brands.name as brand_name', 'brands.slug as brand_slug'])
            ->join('users', 'users.id', '=', 'product_inquiries.author_id')
            ->leftJoin('users as responser', 'responser.id', '=', 'product_inquiries.responsor_id')
            ->join('products', 'products.id', '=', 'product_inquiries.product_id')
            ->join('brands', 'brands.id', '=', 'product_inquiries.brand_id')
            ->latest()->get();

        $inquiries = $inquiries ? $inquiries->toArray() : null;
        $inquiries = array_map(function ($inquiry) {
            $inquiry['id'] = encrypt($inquiry['id']);
            $inquiry['created_at'] = jdate($inquiry['created_at'])->format('Y/m/d');
            $inquiry['response_date'] = $inquiry['response_date'] ? jdate($inquiry['response_date'])->format('Y/m/d') : null;
            return $inquiry;
        }, $inquiries);

        $data['data'] = $inquiries;

        return ApplicationService::responseFormat($data);
    }

    public function response2(Request $request)
    {
        $user = $request->user();
        if (!$user->access(5)) {
            return ApplicationService::responseFormat(['data' => []]);
        }

        Log::channel('user_activity')->info('User accessed response function', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);

        $inquiriesArray = ProductInquery::where('destination_id', $user->brand_id)
            ->with([
                'author:id,name',
                'responser:id,name',
                'product:id,name,slug,image',
                'brand:id,name,slug',
            ])
            ->select([
                'id', 'number', 'unit', 'status', 'created_at', 'amount',
                'response_description', 'response_date', 'prefactor_path',
                'author_id', 'responsor_id', 'product_id', 'brand_id',
            ])
            ->latest()
            ->get()
            ->toArray();

        $currentLocale = app()->getLocale();

        $inquiries = array_map(
            fn($inquiry) => [
                'id' => encrypt($inquiry['id']),
                'number' => $inquiry['number'],
                'unit' => $inquiry['unit'],
                'status' => $inquiry['status'],
                'created_at' => $currentLocale === 'fa-IR'
                    ? jdate($inquiry['created_at'])->format('Y/m/d')
                    : Carbon::parse($inquiry['created_at'])->format('Y-m-d'),
                'amount' => $inquiry['amount'],
                'response_description' => $inquiry['response_description'],
                'response_date' => $inquiry['response_date']
                    ? (
                    $currentLocale === 'fa-IR'
                        ? jdate($inquiry['response_date'])->format('Y/m/d')
                        : Carbon::parse($inquiry['response_date'])->format('Y-m-d')
                    )
                    : null,
                'prefactor_path' => $inquiry['prefactor_path'],
                'author' => $inquiry['author']['name'],
                'responser' => $inquiry['responser']['name'] ?? null,
                'product_name' => $inquiry['product']['name'],
                'product_slug' => $inquiry['product']['slug'],
                'product_image' => $inquiry['product']['image'],
                'brand_name' => $inquiry['brand']['name'],
                'brand_slug' => $inquiry['brand']['slug'],
            ],
            $inquiriesArray
        );

        return ApplicationService::responseFormat(['data' => $inquiries]);
    }

    public function storeresponse(ProdustStoreResponseRequest $request)
    {
        $inquiry = ProductInquery::findOrFail(decrypt($request->input('id')));

        if ($inquiry->destination_id != \request()->user()->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.inquiry_access_denied'), -2);
        }

        $data['status'] = $request->input('status');
        $data['response_description'] = $request->input('response_description');
        $data['amount'] = intval(str_replace(",", "", $request->input('amount')));
        $data['response_date'] = Carbon::now();

        if ($request->hasFile('prefactor')) {
            $data['prefactor_path'] = FileService::upload($request->file('prefactor'), 'prefactors');
        }

        $inquiry->update($data);
        $brand = Brand::find($inquiry->brand_id);
        $users = User::where(['users.brand_id' => $brand->id, 'user_permissions.permission_id' => 5])
            ->select(['users.phone'])
            ->join('user_permissions', 'user_permissions.user_id', '=', 'users.id')
            ->get()->toArray();
        $users = array_map(function ($user) {
            return $user['phone'];
        }, $users);

        foreach ($users as $user) {
            SMSPattern::sendInqueryResponse($user, \request()->user()->brand->name);
        }

        return ApplicationService::responseFormat([]);
    }

    public function wishlist(Request $request)
    {
        $user = \request()->user();
        $product = Product::find(decrypt($request->input('product_id')));

        if (!$product) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_product'), -2);
        }

        $status = Wishlist::where(['product_id' => $product->id, 'user_id' => $user->id])->first();

        if ($status) {
            DB::table('wishlist')->where(['user_id' => $user->id, 'product_id' => $product->id])->delete();
            return ApplicationService::responseFormat([], true, __('messages.product_removed_from_wishlist'));
        } else {
            Wishlist::create(['product_id' => $product->id, 'user_id' => $user->id]);
            return ApplicationService::responseFormat([], true, __('messages.product_added_to_wishlist'));
        }
    }
}

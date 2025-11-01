<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/panel/plan/callback' , [App\Http\Controllers\Panel\PlanController::class , 'callback'])->name('panel.plan.callback');

Route::get('/location/provinces',function (){
    $provinces = \App\Models\Province::get(['id','name']);
    return response()->json(['provinces' => $provinces]);
});

Route::get('location/cities',function (){
    $provinceId = $_GET['province'] ?? null;
    $cities = $provinceId ? \App\Models\City::where('province_id' , $provinceId)->get(['id','name']) : null;
    return response()->json(['cities' => $cities]);
});

Route::get('location/iparks',function (){
    $provinceId = $_GET['province'] ?? null;
    $iparks = $provinceId ? \App\Models\Ipark::where('province_id' , $provinceId)->get(['id','name']) : null;
    return response()->json(['cities' => $iparks]);
});
Route::post('data/fetchCategories', [\App\Http\Controllers\Application\CategoryController::class, 'getCategories']);

Route::get('explore',[\App\Http\Controllers\New\SearchController::class , 'explore']);

Route::prefix('new')->middleware('setLocale')->group(function (){
    Route::get('/', [\App\Http\Controllers\New\HomeController::class, 'homePage']);
    Route::get('/test', [\App\Http\Controllers\New\HomeController::class, 'homePage2']);

    Route::get('/explore', [\App\Http\Controllers\New\SearchController::class, 'explore']);
    Route::get('/brands', [\App\Http\Controllers\New\SearchController::class, 'brands2']);
    Route::get('/products', [\App\Http\Controllers\New\SearchController::class, 'products2']);
    Route::get('/products2', [\App\Http\Controllers\New\SearchController::class, 'products3']);

    Route::get('/company/{slug}', [\App\Http\Controllers\New\CompanyController::class, 'show']);
    Route::get('/product/{slug}', [\App\Http\Controllers\New\ProductController::class, 'show']);
    Route::get('/all-categories', [\App\Http\Controllers\New\HomeController::class, 'getCategories']);
});


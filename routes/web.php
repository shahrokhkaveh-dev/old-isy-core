<?php

use App\Http\Controllers\SitemapController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Ipark;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('register-get-city', function(){
   if(isset($_GET['id'])){
       $cities = City::where('province_id' , $_GET['id'])->get();
       return response()->json($cities);
   }
   return response()->json([]);
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/login' , \App\Livewire\Authentication::class)->name('login')->middleware(['guest']);
// // Route::get('/login' , \App\Livewire\Authentication::class)->name('login')->middleware(['guest' , 'throttle:10,1440']);
// Route::get('/logout' , function (){
//     \Illuminate\Support\Facades\Auth::logout();
//     return redirect('/');
// })->middleware('auth')->name('logout');

// Route::get('/province' , function (){
//     $cities = City::where('province_id' , $_GET['id'])->get();
//     $iparks = Ipark::where('province_id' , $_GET['id'])->get();
//     $data = [$cities , $iparks];
//     $data = json_encode($data);
//     return response($data);
// });
// Route::get('/', function() {
//     return redirect('https://app.sanatyariran.com');
// });
// Route::get('/home', function() {
//     return redirect('https://app.sanatyariran.com');
// })->name('home');

// Route::get('/login' , function() {
//     return redirect('https://app.sanatyariran.com');
// })->name('login')->middleware(['guest']);
// Route::get('/login' , \App\Livewire\Authentication::class)->name('login')->middleware(['guest' , 'throttle:10,1440']);
// Route::get('/logout' , function() {
//     return redirect('https://app.sanatyariran.com');
// })->middleware('auth')->name('logout');

Route::get('/province' , function (){
    $cities = City::where('province_id' , $_GET['id'])->get();
    $iparks = Ipark::where('province_id' , $_GET['id'])->get();
    $data = [$cities , $iparks];
    $data = json_encode($data);
    return response($data);
});
//Route::get('sitemap.xml',[SitemapController::class , 'sitemap']);

/*
|--------------------------------------------------------------------------
| Theme Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::prefix(Illuminate\Support\Facades\App::getLocale())->group(function(){
    // Route::prefix('fa')->group(function(){
    // Route::get('home' , [App\Http\Controllers\User\SearchController::class , 'main'])->name('main');
    // Route::get('/product/{slug}',[App\Http\Controllers\User\ProductController::class , 'show'])->name('user.product.show');
    // Route::get('/product',[App\Http\Controllers\User\ProductController::class , 'search'])->name('user.search.index');
    // Route::post('/product/inq',[App\Http\Controllers\User\ProductController::class , 'inquiry'])->name('user.inquiry.store');
    // Route::get('/brands',[App\Http\Controllers\User\BrandController::class , 'all'])->name('user.brands.all');
    // Route::get('/brand/{slug}',[App\Http\Controllers\User\BrandController::class , 'show'])->name('user.brands.show');
    // Route::get('/about-us' , function(){
    //     return view('user.about');
    // })->name('user.about');
    // Route::get('/contact-us' , function(){
    //     return view('user.contact');
    // })->name('user.contact');
    // Route::get('/help' , function(){
    //     return view('user.help');
    // })->name('user.help');
    // Route::get('/gifts' , function(){
    //     return view('user.gift');
    // })->name('user.gifts');
    // Route::get('/jobs' , function(){
    //     return view('user.job');
    // })->name('user.job');
    // Route::get('/pages/{slug}',[App\Http\Controllers\User\PageController::class , 'show'])->name('user.pages.show');
    // Route::get('/news' , [App\Http\Controllers\User\NewsController::class , 'index'])->name('user.news.index');
    // Route::get('/news/{id}' , [App\Http\Controllers\User\NewsController::class , 'show'])->name('user.news.show');
    // Route::get('/advertising' , [App\Http\Controllers\User\AdvertisingController::class , 'index'])->name('user.advertising.index');
    // Route::get('/advertising/{id}' , [App\Http\Controllers\User\AdvertisingController::class , 'show'])->name('user.advertising.show');
    // Route::get('/expo',[App\Http\Controllers\User\ExpoController::class , 'search'])->name('user.expo.index');
// });
// Route::fallback(function () {
//     return redirect('https://app.sanatyariran.com');
// });

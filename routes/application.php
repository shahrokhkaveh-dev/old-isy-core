<?php

use App\Http\Controllers\Api\ReferralController;
use App\Http\Controllers\Application\AutomationSystemController;
use App\Http\Controllers\Application\BrandController;
use App\Http\Controllers\Application\HomeController;
use App\Http\Controllers\Application\InquiryController;
use App\Http\Controllers\Application\LocationController;
use App\Http\Controllers\Application\ProductController;
use App\Http\Controllers\Application\ProfileController;
use App\Http\Controllers\Application\PriceController;
use App\Http\Controllers\Application\SliderController;
use App\Services\Application\ApplicationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware('setLocale')->group(function () {
    Route::get('/', [App\Http\Controllers\Application\HomeController::class, 'index'])->name('home');
    Route::get('/index2', [App\Http\Controllers\Application\HomeController::class, 'index2'])->name('home');
    Route::get('/version', [App\Http\Controllers\Application\HomeController::class, 'version'])->name('version');
    Route::get('/search', [App\Http\Controllers\Application\HomeController::class, 'search2'])->name('search');
    Route::get('/expo/brands', [App\Http\Controllers\Application\ExpoController::class, 'brands'])->name('expo.brands');
    Route::get('/expo/products', [App\Http\Controllers\Application\ExpoController::class, 'products'])->name('expo.products');
    // Route::get('/search2', [App\Http\Controllers\Application\HomeController::class, 'search2'])->name('search2');
    Route::get('/brands', [HomeController::class, 'brands2'])->name('brands');

    Route::post('/login/check-number', [\App\Http\Controllers\Application\LoginController::class, 'login'])->middleware('throttle:5');
    Route::post('login/check-code', [\App\Http\Controllers\Application\LoginController::class, 'code']);
    Route::post('/register', [\App\Http\Controllers\Application\RegisterController::class, 'register']);
    Route::post('/do-register', [\App\Http\Controllers\Application\RegisterController::class, 'doRegister']);



    Route::get('/filters/province', [LocationController::class, 'province'])->name('location.province');
    Route::get('/filters/city', [LocationController::class, 'city'])->name('location.city');
    Route::get('/filters/ipark', [LocationController::class, 'ipark'])->name('location.ipark');
    Route::get('/filters/freezone', [LocationController::class, 'freezone'])->name('location.freezone');
    Route::get('/filters/category', [LocationController::class, 'category'])->name('location.category');
    Route::get('/filters/brand-types', [LocationController::class, 'brandTypes'])->name('location.brandTypes');
    Route::get('/brand', [HomeController::class, 'brand'])->name('brand');
    Route::get('/brand-products', [HomeController::class, 'brand_products'])->name('brandProducts');
    Route::get('/product', [HomeController::class, 'product'])->name('product');

    Route::middleware('applicationAuth:sanctum')->group(function () {
        Route::post('/set-firebase', [\App\Http\Controllers\Application\AuthController::class, 'setFirebase']);
        Route::post('/remove-firebase', [\App\Http\Controllers\Application\AuthController::class, 'removeFirebase']);
        Route::get('/logout', [\App\Http\Controllers\Application\AuthController::class, 'logout']);
        Route::post('/logout', [\App\Http\Controllers\Application\AuthController::class, 'logout']);

        Route::post('/complete-register', [\App\Http\Controllers\Application\RegisterController::class, 'completeRegister']);
        Route::post('login-another-site', [\App\Http\Controllers\Auth\ApiKey\LoginToAnotherController::class, 'login']);
        Route::prefix('panel')->name('panel.')->group(function () {
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'index'])->name('index');
                Route::get('/reload', [ProfileController::class, 'reload'])->name('reload');
                Route::post('/change_name', [ProfileController::class, 'changeName'])->name('changeName');
                Route::post('/change_email', [ProfileController::class, 'changeEmail'])->name('changeEmail');
                Route::post('/change_phone', [ProfileController::class, 'changePhone'])->name('changePhone');
                Route::post('/change_birthday', [ProfileController::class, 'changeBirthday'])->name('changeBirthday');
                Route::post('/change_avatar', [ProfileController::class, 'changeAvatar'])->name('changeAvatar');
                Route::post('/remove_avatar', [ProfileController::class, 'removeAvatar'])->name('removeAvatar');
                Route::post('/change_password', [ProfileController::class, 'changePassword'])->name('changePassword');
                Route::post('/wishlist', [ProfileController::class, 'wishlist2'])->name('wishlist');
                Route::get('/permissions', [ProfileController::class, 'permissions'])->name('permissions');
            });
            Route::prefix('brand')->middleware('userHasLegal')->name('brand.')->group(function () {
                Route::get('/', [BrandController::class, 'index'])->name('index');
                Route::get('/vip-status', [BrandController::class, 'vipStatus'])->name('index');
                Route::post('/change-logo', [BrandController::class, 'changeLogo'])->name('changeLogo');
                Route::post('/insert-image', [BrandController::class, 'insertImage'])->name('insertImage');
                Route::post('/remove-image', [BrandController::class, 'removeImage'])->name('removeImage');
                Route::post('/update-image', [BrandController::class, 'updateImage'])->name('updateImage');
                Route::post('/add-member', [BrandController::class, 'addMember'])->name('addMember');
                Route::post('/edit-member', [BrandController::class, 'editMember'])->name('editMember');
                Route::post('/remove-member', [BrandController::class, 'removeMember'])->name('removeMember');
                Route::post('/management', [BrandController::class, 'management'])->name('management');
                Route::get('/edit',[BrandController::class, 'edit'])->name('edit');
                Route::post('/update',[BrandController::class, 'update'])->name('update');
                Route::post('/logout', [BrandController::class, 'logout'])->name('logout');
            });
            Route::prefix('products')->middleware('userHasLegal')->name('products.')->group(function () {
                Route::get('/', [ProductController::class, 'index2'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/store', [ProductController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('destroy');
                Route::get('request', [ProductController::class, 'request2'])->name('request');
                Route::get('response', [ProductController::class, 'response2'])->name('response');
                Route::post('storeresponse', [ProductController::class, 'storeresponse'])->name('storeresponse');
                Route::post('wishlist', [ProductController::class, 'wishlist'])->name('wishlist');
                Route::post('inquiry', [InquiryController::class, 'show2'])->name('inquiry');
            });
            Route::prefix('plan')->middleware('userHasLegal')->name('plan.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Application\PlanController::class, 'index'])->name('index');
                Route::post('/buy', [\App\Http\Controllers\Application\PlanController::class, 'buy'])->name('buy');
                Route::get('/print-prefactor/{plan_id}', [\App\Http\Controllers\Application\PlanController::class, 'printPrefactor'])->name('printPrefactor');
            });
            Route::post('inquiry/store', [InquiryController::class, 'store'])->middleware('userHasLegal')->name('inquiry.store');
            Route::prefix('as')->name('as.')->middleware('userHasLegal')->group(function () {
                Route::middleware('letterPermission')->group(function () {
                    Route::get('inbox', [AutomationSystemController::class, 'inboxPage2'])->name('inboxPage');
                    Route::get('archive', [AutomationSystemController::class, 'archivePage'])->name('archivePage');
                    Route::get('outbox', [AutomationSystemController::class, 'outboxPage'])->name('outboxPage');
                    Route::get('create', [AutomationSystemController::class, 'createPage'])->name('createPage');
                    Route::get('/bulk', [AutomationSystemController::class, 'bulkPage'])->name('bulk');
                });

                Route::post('search', [AutomationSystemController::class, 'search2'])->name('search');
                Route::post('send', [AutomationSystemController::class, 'send'])->name('send');
                Route::post('send-to-organization', [AutomationSystemController::class, 'sendToOrganization'])->name('sendToOrganization');
                Route::post('show', [AutomationSystemController::class, 'show'])->name('show');
                Route::post('attach', [AutomationSystemController::class, 'attach'])->name('attach');
                Route::post('/archive', [AutomationSystemController::class, 'archive'])->name('archive');
                Route::post('print', [AutomationSystemController::class, 'print'])->name('print');
                Route::get('/setting', [AutomationSystemController::class, 'settingPage'])->name('settingPage');
                Route::post('/setting', [AutomationSystemController::class, 'setting'])->name('setting');
                Route::post('/setting/delete-signature', [AutomationSystemController::class, 'deleteSignature'])->name('deleteSignature');
                Route::post('/groupsPage', [AutomationSystemController::class, 'groupsPage'])->name('groupsPage');
                Route::post('/groupStore', [AutomationSystemController::class, 'groupStore'])->name('groupStore');
                Route::post('/groupShow', [AutomationSystemController::class, 'groupShow'])->name('groupShow');
                Route::post('/addBrandToGroup', [AutomationSystemController::class, 'addBrandToGroup'])->name('addBrandToGroup');
                Route::post('/removeBrandFromGroup', [AutomationSystemController::class, 'removeBrandFromGroup'])->name('removeBrandFromGroup');
                Route::post('/destroyGroup', [AutomationSystemController::class, 'destroyGroup'])->name('destroyGroup');

                Route::post('/bulk', [AutomationSystemController::class, 'bulkAction'])->name('doBulk');
            });

            Route::prefix('impersonation')->name('impersonation.')->group(function () {
                Route::get('/search/{name}', [\App\Http\Controllers\Application\ImpersonationController::class, 'search'])->name('search');
                Route::post('/do-impersonate/{brandId}', [\App\Http\Controllers\Application\ImpersonationController::class, 'doImpersonate'])->name('doImpersonate');
            });
        });


        Route::post('price/store',[PriceController::class,'store']);
        Route::get('/referral/stats', [ReferralController::class, 'getReferralStats']);
        Route::post('/referral/apply-code', [ReferralController::class, 'applyReferralCode']);
    });
    Route::get('/blogs', [\App\Http\Controllers\Application\BlogController::class, 'blogs']);
    Route::get('/blog/{id}', [\App\Http\Controllers\Application\BlogController::class, 'article']);
    Route::get('/info', function (){
        return ApplicationService::responseFormat([
            'android_version' => '1.4.5',
            'ios_version' => '0.0.0',
            'webapp_version' => '1.0.0',
            'api_version' => '1.0.0',
            'versionCode' => 67,
            'android_must_be_update' => true,
            'ios_must_be_update' => false,
            'android_update_url' => 'https://app.sanatyariran.com/sanatyar.apk',
        ]);
    });
    Route::get('/statistic', function (){
        if(getMode() == 'freezone'){
            return ApplicationService::responseFormat([
                'total_brands' => DB::table('brands')->where('brands.freezone_id','!=',null)->count(),
                'total_products' => DB::table('products')->leftJoin('brands', 'brands.id', 'products.brand_id')->where('brands.freezone_id','!=',null)->count(),
                'total_users' => DB::table('users')->count(),
                'total_inquiries' => DB::table('product_inquiries')->count(),
                'total_letters' => DB::table('letters')->count(),
                'total_reviews' => 1000,
                'today_reviews' => intval(( (time() - strtotime('today')) / 86400 ) * 1000)
            ]);
        }else{
            return ApplicationService::responseFormat([
                'total_brands' => DB::table('brands')->count(),
                'total_products' => DB::table('products')->count(),
                'total_users' => DB::table('users')->count(),
                'total_inquiries' => DB::table('product_inquiries')->count(),
                'total_letters' => DB::table('letters')->count(),
                'total_reviews' => 1000,
                'today_reviews' => intval(( (time() - strtotime('today')) / 86400 ) * 1000)
            ]);
        }

    });

    Route::get('/sliders/{sliderId}/slides', [SliderController::class, 'getSlides']);
});

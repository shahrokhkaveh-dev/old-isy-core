<?php

use App\Http\Controllers\Panel\AutomationsystemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Panel\PanelController::class, 'dashboard'])->name('panel');
    Route::get('/status', function () {
        return view('panel.status1');
    })->name('status');

    Route::prefix('plan')->group(function () {
        Route::get('/', [App\Http\Controllers\Panel\PlanController::class, 'index'])->name('panel.plan.index');
        Route::post('/buy', [App\Http\Controllers\Panel\PlanController::class, 'buy'])->name('panel.plan.buy');
        Route::post('/status', [App\Http\Controllers\Panel\PlanController::class, 'status'])->name('panel.plan.status');
    });

    Route::get('products', [\App\Http\Controllers\Panel\ProductController::class, 'index'])->name('panel.products.index');
    Route::get('products/create', [\App\Http\Controllers\Panel\ProductController::class, 'create'])->name('panel.products.create');
    Route::post('products/create', [\App\Http\Controllers\Panel\ProductController::class, 'store'])->name('panel.products.store');
    Route::get('products/{id}/show', [\App\Http\Controllers\Panel\ProductController::class, 'create'])->name('panel.products.show');
    Route::get('products/{id}/edit', [\App\Http\Controllers\Panel\ProductController::class, 'edit'])->name('panel.products.edit');
    Route::put('products/{id}/edit', [\App\Http\Controllers\Panel\ProductController::class, 'update'])->name('panel.products.update');
    Route::delete('products/{id}/delete', [\App\Http\Controllers\Panel\ProductController::class, 'destroy'])->name('panel.products.destroy');

    Route::middleware('userValidation')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Panel\ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/setimage', [\App\Http\Controllers\Panel\ProfileController::class, 'setImage'])->name('profile.setimage');
        Route::post('/profile/setpassword', [\App\Http\Controllers\Panel\ProfileController::class, 'setPassword'])->name('profile.setpassword');

        Route::get('/company', [\App\Http\Controllers\Panel\CompanyController::class, 'index'])->name('panel.company.index');
        Route::post('/company/setlogo', [\App\Http\Controllers\Panel\CompanyController::class, 'setlogo'])->name('panel.company.setlogo');
        Route::post('/company/insertImage', [\App\Http\Controllers\Panel\CompanyController::class, 'insertImage'])->name('panel.company.insertimage');
        Route::post('/company/removeImage', [\App\Http\Controllers\Panel\CompanyController::class, 'removeImage'])->name('panel.company.removeimage');
        Route::post('/company/addmember', [\App\Http\Controllers\Panel\CompanyController::class, 'addmember'])->name('panel.company.addmember');
        Route::post('/company/editmember', [\App\Http\Controllers\Panel\CompanyController::class, 'editmember'])->name('panel.company.editmember');
        Route::post('/company/removemember', [\App\Http\Controllers\Panel\CompanyController::class, 'removemember'])->name('panel.company.removemember');
        Route::post('/company/managment', [\App\Http\Controllers\Panel\CompanyController::class, 'managment'])->name('panel.company.managment');

        Route::get('/product/inquiry/request', [\App\Http\Controllers\Panel\ProductController::class, 'request'])->name('panel.inquiry.request');
        Route::get('/product/inquiry/response', [\App\Http\Controllers\Panel\ProductController::class, 'response'])->name('panel.inquiry.response');
        Route::post('/product/inquiry/response', [\App\Http\Controllers\Panel\ProductController::class, 'storeresponse'])->name('panel.inquiry.store');

        Route::prefix('automationSystem')->name('automationSystem.')->group(function(){
            Route::get('inbox' , [AutomationsystemController::class , 'inboxPage'])->name('inboxpage');
            Route::get('archive' , [AutomationsystemController::class , 'archivePage'])->name('archivepage');
            Route::get('outbox' , [AutomationsystemController::class , 'outboxPage'])->name('outboxpage');
            Route::get('create' , [AutomationsystemController::class , 'createPage'])->name('createpage');
            Route::post('search' , [AutomationsystemController::class , 'search'])->name('search');
            Route::post('send' , [AutomationsystemController::class , 'send'])->name('send');
            Route::get('/show/{type}/{id}' , [AutomationsystemController::class , 'show'])->name('show');
            Route::get('/attach/{type}/{id}' , [AutomationsystemController::class , 'attach'])->name('attach');
            Route::get('/archive/{type}/{id}' , [AutomationsystemController::class , 'archive'])->name('archive');
            Route::get('/print/{type}/{id}' , [AutomationsystemController::class , 'print'])->name('print');
            Route::get('/setting' , [AutomationsystemController::class , 'settingPage'])->name('settingpage');
            Route::post('/setting' , [AutomationsystemController::class , 'setting'])->name('setting');
            Route::get('/groupsPage' , [AutomationsystemController::class , 'groupsPage'])->name('groupsPage');
            Route::get('/groupCreatePage' , [AutomationsystemController::class , 'groupCreatePage'])->name('groupCreatePage');
            Route::post('/groupStore' , [AutomationsystemController::class , 'groupStore'])->name('groupStore');
            Route::get('/groupShow/{id}' , [AutomationsystemController::class , 'groupShow'])->name('groupShow');
            Route::post('/addBrandToGroup' , [AutomationsystemController::class , 'addBrandToGroup'])->name('addBrandToGroup');
            Route::post('/removeBrandFromGroup' , [AutomationsystemController::class , 'removeBrandFromGroup'])->name('removeBrandFromGroup');
            Route::post('/destroyGroup' , [AutomationsystemController::class , 'destroyGroup'])->name('destroyGroup');
            Route::get('/bulk' , [AutomationsystemController::class , 'bulkPage'])->name('bulk');
            Route::post('/bulk' , [AutomationsystemController::class , 'bulkAction'])->name('doBulk');
        });
    });
});


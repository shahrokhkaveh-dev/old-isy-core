<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CheckMembershipsController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'loginIndex'])->name('login');
Route::middleware('logUserAndIP')->post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.post');
Route::group(['middleware' => 'admin.guard'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**---- بررسی عضویت‌ها ----- **/
    Route::get('check-memberships',
        [\App\Http\Controllers\Admin\CheckMembershipsController::class, 'index'])->name('check.memberships');
    Route::get('check-memberships/{id}',
        [\App\Http\Controllers\Admin\CheckMembershipsController::class, 'show'])->name('check.memberships.show');
    Route::get('approve-membership/{id}',
        [\App\Http\Controllers\Admin\CheckMembershipsController::class, 'changeStatus'])
        ->name('approve.membership')->defaults(\App\Enums\CommonFields::STATUS, \App\Enums\CommonEntries::CONFIRMED_STATUS);
    Route::post('reject-membership/{id}',
        [\App\Http\Controllers\Admin\CheckMembershipsController::class, 'changeStatus'])
        ->name('reject.membership')->defaults(\App\Enums\CommonFields::STATUS, \App\Enums\CommonEntries::REJECTED_STATUS);

    Route::get('check-products',
        [\App\Http\Controllers\Admin\CheckProductsController::class, 'index'])->name('check.products');
    Route::get('check-products/{id}',
        [\App\Http\Controllers\Admin\CheckProductsController::class, 'show'])->name('check.products.show');
    Route::get('approve-product/{id}',
        [\App\Http\Controllers\Admin\CheckProductsController::class, 'changeStatus'])
        ->name('approve.product')->defaults(\App\Enums\CommonFields::STATUS, \App\Enums\CommonEntries::CONFIRMED_STATUS);
    Route::post('reject-product/{id}',
        [\App\Http\Controllers\Admin\CheckProductsController::class, 'changeStatus'])
        ->name('reject.product')->defaults(\App\Enums\CommonFields::STATUS, \App\Enums\CommonEntries::REJECTED_STATUS);

    Route::get('i-parks',
        [\App\Http\Controllers\Admin\IParkController::class, 'index'])->name('i-parks');
    Route::post('i-park',
        [\App\Http\Controllers\Admin\IParkController::class, 'store'])->name('i-park.store');


    /**---- مدیران ----- **/
    Route::get('/admins', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admins/create', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admins/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admins/edit/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::get('/admins/change-activation/{id}', [AdminController::class, 'changeActivation'])->name('admin.changeActivation');

    /**---- جستجوی شرکت‌ها ----- **/
    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/', [\App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('categories.delete');
        Route::put('/', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
    });

    Route::prefix('sub-categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::post('/', [\App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->name('sub-categories.store');
        Route::delete('/', [\App\Http\Controllers\Admin\SubCategoryController::class, 'destroy'])->name('sub-categories.delete');
        Route::put('/', [\App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->name('sub-categories.update');
    });

    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/show/{id}', [CheckMembershipsController::class, 'show'])->name('brands.show');
    Route::get('/brands/search', [BrandController::class, 'search'])->name('brands.search');

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
        Route::get('/{userId}/show', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('user.show');
        Route::put('/{userId}/update', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.update');
        Route::delete('/', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('user.create');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('user.store');
    });

    Route::prefix('tickets')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('ticket.index');
        Route::get('/{uuid}', [\App\Http\Controllers\Admin\TicketController::class, 'show'])->name('ticket.show');
    });

     Route::prefix('ticket-comments')->group(function (){
         Route::post('/{uuid}', [\App\Http\Controllers\Admin\TicketCommentController::class, 'send'])->name('ticket-comment.send');
     });

    Route::get('/temporary-file/{path}',[\App\Http\Controllers\Admin\FileController::class, 'getTemporaryUrl'])->name('temporary-file');
});

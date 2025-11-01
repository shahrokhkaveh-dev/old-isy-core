<?php
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Inertia\HomeController::class, 'homePage']);

Route::get('/explore', [\App\Http\Controllers\Inertia\SearchController::class, 'explore']);
Route::get('/brands', [\App\Http\Controllers\Inertia\SearchController::class, 'brands']);
Route::get('/products', [\App\Http\Controllers\Inertia\SearchController::class, 'products']);

Route::get('/company/{slug}', [\App\Http\Controllers\Inertia\CompanyController::class, 'show']);
Route::get('/product/{slug}', [\App\Http\Controllers\Inertia\ProductController::class, 'show']);

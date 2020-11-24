<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('template.admin.template');
});

// Route::get('/product','ProductController@index');
Route::get('/product',[ProductController::class, 'index']);
Route::get('/product/all',[ProductController::class, 'all']);
Route::post('/product-save',[ProductController::class, 'save']);
Route::get('/product-edit/{id}',[ProductController::class, 'show']);
Route::post('/product-update',[ProductController::class, 'update']);
Route::get('/product-delete/{id}',[ProductController::class, 'delete']);
Route::get('/product-detail/{id}',[ProductController::class, 'detail']);

//category
Route::get('/category',[CategoryController::class, 'index']);
Route::get('/category/all',[CategoryController::class, 'all']);
Route::post('/category-save',[CategoryController::class, 'save']);
Route::get('/category-edit/{id}',[CategoryController::class, 'show']);
Route::post('/category-update',[CategoryController::class, 'update']);
Route::get('/category-delete/{id}',[CategoryController::class, 'delete']);
// Route::get('users/{id}', [CategoryController]);

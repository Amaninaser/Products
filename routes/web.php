<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DasboardController;
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
    return view('welcome');
});

Route::get('/deshboard',[DasboardController::class,'index']);

Route::group([
    'prefix' => 'admin/categories',
    'namespace' => 'Admin',
    'as' => 'admin.categories.',
],function(){ 

    Route::get('/', 'CategoriesController@index')->name('index');
    Route::get('/create', 'CategoriesController@create')->name('create'); 
    Route::post('/create',[CategoriesController::class,'store'])->name('store');
    Route::get('/{id}/edit',[CategoriesController::class,'edit'])->name('edit');
    Route::put('/{id}',[CategoriesController::class,'update'])->name('update');
    Route::delete('/{id}',[CategoriesController::class,'destroy'])->name('destroy'); 
 

    
});
Route::get("user", [UserController::class, 'create']);
Route::post("user/create", [UserController::class, 'store']);
/*Route::prefix('admin/categories')
->namespace('Admin')
->as('admin.categories.')
->group(function(){
        Route::get('/create', 'CategoriesController@create')->name('create');
});*/

//Route::resource('admin/categories', 'Admin\CategoriesController');

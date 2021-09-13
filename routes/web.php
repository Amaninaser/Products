<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Auth\Stores\LoginController;

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

Route::get('/', [HomeController::class,'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web,store'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/stores/login', [LoginController::class, 'create'])
                ->middleware('guest:store')
                ->name('stores.login');

Route::post('/stores/login', [LoginController::class, 'store'])
                ->middleware('guest:store');

Route::namespace('Admin')
    ->prefix('admin')
    ->as('admin.')
    ->group(function() {

        Route::resource('prods', 'ProdsController')->names([
            'index' => 'prods.index',
        ]);
         Route::resource('categories', 'CategoriesController')->names([
            'index' => 'categories.index',
        ]);
        Route::get('tags/{id}/prods', [TagsController::class, 'prods']);

    });



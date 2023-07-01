<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/NEWS',[HomeController::class,'news']);

Route::group([
    'prefix'=>'/dashboard',
    'as'=>'dashboard.',
    'namespace'=>'Dashboard'
] , function() {
       Route::get('/',[DashboardController::class,'index']);

       Route::prefix('/categories')->as('categories.')->group(function(){

               //Read
               Route::get('/',[CategoriesController::class,'index'])
                       ->name('index');

               // Create
               Route::get('/create',[CategoriesController::class,'create'])
                       ->name('create');

               Route::post('/',[CategoriesController::class,'store'])
               ->name('store') ;


               // Update
               Route::get('/{id}/edit',[CategoriesController::class,'edit'])
                       ->name('edit') ;

               Route::put('/{id}',[CategoriesController::class,'update'])
                       ->name('update') ;


               //Destroy
               Route::delete('/{id}',[CategoriesController::class,'destroy'])
                       ->name('destroy') ;
       });

});

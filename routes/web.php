<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
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
//     'namespace'=>'Dashboard'
] , function() {
       Route::get('/',[DashboardController::class,'index']);  


       Route::get('/products/trash',[ProductsController::class,'trash'])
                ->name('products.trash');

        Route::patch('/products/{product}/restore',[ProductsController::class,'restore'])
                ->name('products.restore');        
                
                //All Route Products
                Route::resource('/product',ProductsController::class);  

       Route::prefix('/categories')->as('categories.')->group(function(){

               //Read
               Route::get('/',[CategoriesController::class,'index'])
                       ->name('index');

                //Trash
                Route::get('/trash',[CategoriesController::class,'trash'])
                       ->name('trash');

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

                //Restore
                Route::patch('/{id}/restore',[CategoriesController::class,'restore'])
                       ->name('restore') ;


                 Route::get('/search',[CategoriesController::class,'search'])
                    ->name('search');
       });

});

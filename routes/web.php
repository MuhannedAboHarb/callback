<?php

use App\Http\Controllers\Auth\ChangeuserPasswordController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NotificationsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductsController as StoreProductsController;
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


Route::get('/',[HomeController::class,'index'])
        ->name('home');


Route::get('/products/{category:slug?}',[StoreProductsController::class,'index'])
        ->name('products'); 


Route::get('/products/{category:slug?}/{product:slug}',[StoreProductsController::class,'show'])
        ->name('products.show');         


 Route::post('/products/{product}/reviews', [StoreProductsController::class, 'review'])
        ->name('products.reviews.store');  


Route::get('/cart',[CartController::class , 'index'])
        ->name('cart');

Route::post('cart' , [CartController::class , 'store']);

Route::delete('cart/{id}' , [CartController::class , 'destroy'])
        ->name('card.destroy'); 

 
Route::get('/checkout',[CheckoutController::class , 'index'])
        ->name('checkout');

Route::post('checkout' , [CheckoutController::class , 'store']);


Route::get('orders/{order}/payments/create', [PaymentsController::class, 'create'])
    ->name('payments.create');

Route::get('orders/{order}/payments/refund', [PaymentsController::class, 'refund'])
    ->name('payments.refund');

Route::get('orders/{order}/payments/return', [PaymentsController::class, 'callback'])
    ->name('payments.callback');
    
Route::get('orders/{order}/payments/cancel', [PaymentsController::class, 'cancel'])
    ->name('payments.cancel');


Route::group([
    'prefix'=>'/dashboard',
    'as'=>'dashboard.',
//     'namespace'=>'Dashboard'
//      'middleware'=>['auth:admin']  
      
] , function() {
       Route::get('/',[DashboardController::class,'index']);  

        Route::get('notifications', [NotificationsController::class,'index'])
                ->name('notifications');

        Route::get('notifications/{notification}', [NotificationsController::class,'read'])
                ->name('notifications.read');        


       Route::get('/products/trash',[ProductsController::class,'trash'])
                ->name('products.trash');

        Route::patch('/products/{product}/restore',[ProductsController::class,'restore'])
                ->name('products.restore');
                

        Route::resource('roles',RolesController::class);
        Route::resource('users',UsersController::class);

                //All Route Products
                Route::resource('/products',ProductsController::class);  

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


        /// Changed Profile   ///
Route::get('/profile', [UserProfileController::class, 'index'])
        ->name('profile') 
        ->middleware(['auth:web,admin', 'password.confirm']);

Route::patch('/profile',[UserProfileController::class, 'update']) 
        ->name('profile.update') 
        ->middleware(['auth:web,admin', 'password.confirm']);




       
        /// Changed Password   ///
Route::get('/change-password', [ChangeuserPasswordController::class, 'index'])
        ->name('change-password') 
        ->middleware(['auth:web,admin']);

Route::put('/change-password',[ChangeuserPasswordController::class, 'update']) 
        ->name('change-password.update') 
        ->middleware(['auth:web,admin']);








Route::get('/dashboard/breeze', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\livreurcontroller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;



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
    return view('home2');
});

Route::get('/artisan', [ArtisanController::class, 'index'])->name('artisan');
Route::get('/addproduct', [ArtisanController::class, 'addProduct'])->name('artisan.add.product');
Route::get('/artisan_allproducts', [ArtisanController::class, 'allProducts'])->name('artisan.all.products');

Route::get('/home', function () {
    return view('home');
});
Route::get('/home2', function () {
    return view('home2');
});

Route::get('/driver', [LivreurController::class, 'index'])->name('livreur');

Route::get('/product-list', function () {
    return view('product-list');
});
Route::get('/product', function () {
    return view('product');
});
Route::get('/artisans', [ArtisanController::class,'showArtisanList'])->name('artisans.list');
Route::post('/artisans/filter', [ArtisanController::class, 'filter'])->name('artisans.filter');


Route::get('/worktime', function () {
    return view('livreur_worktime');
});

Route::get('/history', [LivreurController::class, 'history'])->name('livreur.history');
Route::get('/driver_history', [ArtisanController::class, 'driverHistory'])->name('artisan.history');






Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile');
    Route::get('/profile_history', [ProfileController::class, 'history'])->name('profile.edit');

    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/products/{product}/rate', [ProductController::class,'rate'])->name('products.rate');
    Route::get('/home', [NotificationController::class, 'getNotificationsForHome'])->name('home');


    // Other authenticated routes...
});


Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
Route::post('/subcategories/store', [SubcategoryController::class, 'store'])->name('subcategories.store');


// Route for displaying the artisan business profile form
Route::get('/artisan/business-profile/form', [ArtisanController::class, 'showBusinessProfileForm'])->name('artisan.business_profile');
// Route for storing the artisan business profile
Route::post('/artisan/business-profile/store', [ArtisanController::class, 'store'])->name('artisan.store_business_profile');
Route::get('/artisan/business-profile/show', [ArtisanController::class, 'showBusinessProfile'])->name('artisan.show_business_profile');
Route::get('/business-profile-picture/{userId}', [ArtisanController::class, 'showBusinessProfilePicture'])->name('artisan.show_business_profile_picture');
Route::get('/artisan/asign-livreurs', [ArtisanController::class, 'asignlivreurs'])->name('artisan.asign_livreurs');
Route::post('/artisan/pie-chart-data', [ArtisanController::class,'getPieChartData'])->name('artisan.pie-chart-data');
Route::post('/artisan/total-revenue-chart-data', [ArtisanController::class, 'totalRevenueChartData'])->name('artisan.total-revenue-chart-data');





Route::post('/add-product', [ProductController::class, 'store'])->name('products.store');


Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/products', [ProductController::class, 'showProductList'])->name('products.list');
Route::post('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/product/details/{id}', [ProductController::class, 'showDetails'])->name('product.details');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');



Route::post('/livreur/save-working-hours', [LivreurController::class, 'saveWorkingHours'])->name('livreur.save-working-hours');
Route::get('/livreur/working-hours', [LivreurController::class, 'workingHoursForm'])->name('livreur.working-hours');
Route::get('/livreur/edit-working-hours', [LivreurController::class, 'editworkingHoursForm'])->name('livreur.edit-working-hours');
Route::put('/livreur/update-working-hours', [LivreurController::class, 'updateWorkingHours'])->name('livreur.update-working-hours');





Route::resource('orders', OrderController::class);
Route::post('orders/{order}/assign-livreur', [OrderController::class, 'assignLivreur'])->name('orders.assignLivreur');

Route::post('/orders/accept/{order}', [OrderController::class,'acceptOrder'])->name('orders.accept');
Route::delete('/orders/refuse/{order}', [OrderController::class,'refuseOrder'])->name('orders.refuse');
Route::post('/update-order-queue', [OrderController::class,'updateOrderQueue'])->name('update.order.queue');
Route::put('/livreur/{order}', [LivreurController::class,'updateOrderStatus'])->name('livreur.updateOrderStatus');


Route::get('/notifications', [NotificationController::class, 'getNotifications']);
Route::get('/user-orders', [OrderController::class, 'getUserOrders']);
Route::get('/livreur/profile', [LivreurController::class, 'livreurProfile'])->name('livreur.profile');








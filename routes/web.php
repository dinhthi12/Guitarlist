<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CateItemController;
use App\Http\Controllers\client\CategoryController as ClientCategoryController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\client\ProductController as ClientProductController;
use App\Http\Controllers\client\WishlistController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SlideController;
use Illuminate\Support\Facades\Auth;
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
//route user
Route::prefix('/')->group(function () {
    //trang index
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/category/{id}', [ClientCategoryController::class, 'getProByCate'])->name('getProByCate');
    Route::get('/cateitem/{id}', [ClientCategoryController::class, 'getProByCateItem'])->name('getProByCateItem');
    Route::post('/getcateitem',[ClientCategoryController::class,'getCateItemByCate'])->name('getCateItemByCate');
    Route::get('/sort',[ClientCategoryController::class,'sortProducts'])->name('sortProducts');
    Route::get('product/{id}',[ClientProductController::class,'getProById'])->name('getProById');
    Route::get('wishlist', [WishlistController::class,'wishlist'])->name('listWish');
    Route::get('/add/{id}', [WishlistController::class,'add'])->name('addWish');
    Route::get('/manager',[ClientController::class,'manager'] )->name('manager');
});

Route::post('/clientLogin',[ClientController::class,'loginClient'])->name('clientLogin');
//route login user
Route::get('signup',[ClientController::class,'signup'] )->name('signup');
Route::post('/register', [RegisterController::class, 'register'])->name('register');


//route login admin
Route::post('adminLogin', [AdminController::class, 'adminLogin'])->name('adminLogin');
//fix lại route
Route::get('adminlogin', function () {
    return view('admin.pages.login');
});

//route admin
Route::prefix('admin')->middleware('checkAdmin')->group(function () {
    //trang index
    Route::get('index', [AdminController::class, 'index'])->name('indexAdmin');

    //trang quan trị category
    Route::prefix('categories')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('listCate');
        Route::post('create', [CategoryController::class, 'create'])->name('createCate');
        Route::get('edit/{id}', [CategoryController::class, 'loadEdit'])->name('loadEditCate');
        Route::post('edit', [CategoryController::class, 'edit'])->name('editCate');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('deleteCate');
    });
    //trang quan trị category item
    Route::prefix('cateitems')->group(function () {
        Route::get('index/{id}', [CateItemController::class, 'index'])->name('getCateItems');
        Route::post('create', [CateItemController::class, 'create'])->name('createCateItem');
        Route::get('edit/{id}', [CateItemController::class, 'loadEdit'])->name('loadEditCateItem');
        Route::post('edit', [CateItemController::class, 'edit'])->name('editCateItem');
        Route::get('delete/{id}', [CateItemController::class, 'delete'])->name('deleteCateItem');
    });
    //trang quản trị product
    Route::prefix('products')->group(function () {
        Route::get('index', [ProductController::class, 'index'])->name('listPro');

        Route::get('create', [ProductController::class, 'createView'])->name('loadCreatePro');
        Route::post('create', [ProductController::class, 'create'])->name('createPro');

        Route::post('cateItems', [ProductController::class, 'loadCateItem'])->name('loadCateItems');

        Route::get('edit/{id}', [ProductController::class, 'loadEdit'])->name('loadEditPro');
        Route::post('edit', [ProductController::class, 'edit'])->name('editPro');

        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('deletePro');

        Route::get('variants/{id}', [ProductController::class, 'showVariants'])->name('showVariants');

        Route::post('createColor', [ProductController::class, 'createColor'])->name('createColor');

        Route::post('createMemory', [ProductController::class, 'createMemory'])->name('createMemory');
    });
    //trang quản trị slide
    Route::prefix('slider')->group(function () {
        Route::get('index', [SlideController::class, 'index'])->name('listSlide');
        Route::get('create', [SLideController::class, 'loadCreate'])->name('loadCreateSlide');
        Route::post('create', [SLideController::class, 'create'])->name('createSlide');
        Route::get('edit/{id}', [SLideController::class, 'loadEdit'])->name('loadEditSlide');
        Route::post('edit', [SLideController::class, 'edit'])->name('editSlide');
        Route::get('delete/{id}', [SLideController::class, 'delete'])->name('deleteSlide');
    });
    //route logout admin
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

Auth::routes(['verify' => true]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

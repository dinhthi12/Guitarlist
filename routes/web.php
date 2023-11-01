<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CateItemController;
use App\Http\Controllers\client\CategoryController as ClientCategoryController;
use App\Http\Controllers\client\ClientController;
use App\Http\Controllers\client\ContactController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\client\ProductController as ClientProductController;
use App\Http\Controllers\client\WishlistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController as ControllersContactController;
use App\Http\Controllers\DeliveryController;
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
    //chức năng danh mục
    Route::get('/category/{id}', [ClientCategoryController::class, 'getProByCate'])->name('getProByCate');
    Route::get('/cateitem/{id}', [ClientCategoryController::class, 'getProByCateItem'])->name('getProByCateItem');
    Route::post('/getcateitem', [ClientCategoryController::class, 'getCateItemByCate'])->name('getCateItemByCate');
    Route::get('/sort', [ClientCategoryController::class, 'sortProducts'])->name('sortProducts');
    //chức năng chi tiết sp
    Route::get('product/{id}', [ClientProductController::class, 'getProById'])->name('getProById');
    //chức năng wishlist
    Route::get('wishlist', [WishlistController::class, 'index'])->name('listWish');
    Route::get('/add/{id}', [WishlistController::class, 'add'])->name('addWish');
    Route::get('deleteWish/{id}', [WishlistController::class, 'delete'])->name('deleteWish');
    //chức năng thông tin người dùng
    Route::get('/manager', [ClientController::class, 'manager'])->name('manager');
    Route::get('edit_profile', [ClientController::class, 'edit_profile'])->name('edit_profile');
    Route::post('updateAccount', [ClientController::class, 'updateAccount'])->name('updateAccount');
    //chức năng thêm địa chỉ người dùng
    Route::get('/user_address', [ClientController::class, 'user_address'])->name('user_address');
    Route::post('/addAddress', [ClientController::class, 'addAddress'])->name('addAddress');
    Route::get('/editAddress/{id}', [ClientController::class, 'getEditAddress'])->name('getEditAddress');
    Route::post('/editAddress', [ClientController::class, 'editAddress'])->name('editAddress');
    Route::get('deleteAddress/{id}', [ClientController::class, 'deleteAddress'])->name('deleteAddress');
    //tìm kiếm sp theo tên
    Route::get('/search', [ClientProductController::class, 'search'])->name('search');
    //chức năng liên hệ
    Route::get('contact',[ContactController::class,'contact'] )->name('contacts');
    Route::post('/addContact',[ContactController::class,'addContact'] )->name('addContact');
    Route::get('deleteContact/{id}', [ContactController::class,'deleteContact'])->name('deleteContact');
    //chức năng bình luận
    Route::post('/product/comment/{id}',[ClientController::class,'comment'])->name('comment');
    //chức năng thêm sản phẩm vào giỏ hàng + thanh toán
    Route::prefix('cart')->group(function () {
        Route::get('/index', [OrderController::class,'viewCart'] )->name('viewCart');
        Route::post('/addCart',[OrderController::class,'addCart'])->name('addCart');
        Route::get('/deleteItemCart/{name}',[OrderController::class,'deleteItemCart'])->name('deleteItemCart');
        Route::post('/getAddressById',[OrderController::class,'getAddressById'])->name('getAddressById');
        Route::post('/updateCart',[OrderController::class,'updatCart'])->name('updateCart');
    });
    Route::post('/insertOrder',[OrderController::class,'insertOrder'])->name('insertOrder');
    Route::get('/orders',[ClientController::class,'orders'])->name('myOrders');
    Route::post('/discountCode',[ClientController::class,'discountCode'])->name('discountCode');
});
//chức năng login người dùng
Route::post('/clientLogin', [ClientController::class, 'loginClient'])->name('clientLogin');
//chức năng đăng ký người dùng
Route::get('signup', [ClientController::class, 'signup'])->name('signup');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// <---------------------------------------------------------------------------------------------------->
//chức năng login admin
Route::post('adminLogin', [AdminController::class, 'adminLogin'])->name('adminLogin');
Route::get('adminlogin', function () {
    return view('admin.pages.login');
});

Route::prefix('admin')->middleware('checkAdmin')->group(function () {
    //trang index
    Route::get('index', [AdminController::class, 'index'])->name('indexAdmin');

    //chức năng quản trị danh mục
    Route::prefix('categories')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('listCate');
        Route::post('create', [CategoryController::class, 'create'])->name('createCate');
        Route::get('edit/{id}', [CategoryController::class, 'loadEdit'])->name('loadEditCate');
        Route::post('edit', [CategoryController::class, 'edit'])->name('editCate');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('deleteCate');
    });
    //chức năng quản trị danh mục con
    Route::prefix('cateitems')->group(function () {
        Route::get('index/{id}', [CateItemController::class, 'index'])->name('getCateItems');
        Route::post('create', [CateItemController::class, 'create'])->name('createCateItem');
        Route::get('edit/{id}', [CateItemController::class, 'loadEdit'])->name('loadEditCateItem');
        Route::post('edit', [CateItemController::class, 'edit'])->name('editCateItem');
        Route::get('delete/{id}', [CateItemController::class, 'delete'])->name('deleteCateItem');
    });
    //chức năng quản trị sản phẩm
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
        Route::post('createVariant', [ProductController::class, 'createVariant'])->name('createVariant');
        Route::get('deleteColor/{id}',[ProductController::class,'deleteColor'])->name('deleteColor');
        Route::get('deleteVariant/{id}',[ProductController::class,'deleteVariant'])->name('deleteVariant');
    });
    //chức năng quản trị slide
    Route::prefix('slider')->group(function () {
        Route::get('index', [SlideController::class, 'index'])->name('listSlide');
        Route::get('create', [SLideController::class, 'loadCreate'])->name('loadCreateSlide');
        Route::post('create', [SLideController::class, 'create'])->name('createSlide');
        Route::get('edit/{id}', [SLideController::class, 'loadEdit'])->name('loadEditSlide');
        Route::post('edit', [SLideController::class, 'edit'])->name('editSlide');
        Route::get('delete/{id}', [SLideController::class, 'delete'])->name('deleteSlide');
        Route::get('unActive/{id}', [SLideController::class,'unActive'])->name('off');
        Route::get('active/{id}', [SLideController::class,'active'])->name('on');
    });
    //chức năng quản trị bình luận
    Route::prefix('comments')->group(function () {
        Route::get('index',[CommentController::class,'index'])->name('listCom');
        Route::get('delete/{id}',[CommentController::class,'destroy'])->name('deleteCom');
        Route::get('/index1',[CommentController::class,'searchName'] )->name('searchName');
        Route::get('/index2',[CommentController::class,'searchDate'] )->name('searchDate');
    });
    //chức năng quản trị liên hệ
    Route::prefix('contacts')->group(function () {
        Route::get('index',[ControllersContactController::class,'index'])->name('contact');
        Route::get('searchContact',[ControllersContactController::class,'searchContact'])->name('searchContact');
    });
    //chức năng quản trị phương thức giao hàng
    Route::prefix('delivery')->group(function () {
        Route::get('index', [DeliveryController::class,'index'])->name('ListDelivery');
        Route::get('create', [DeliveryController::class,'CreateDelivery'])->name('CreateDelivery');
        Route::post('create_', [DeliveryController::class,'CreateDelivery_'])->name('CreateDelivery_');
        Route::get('edit/{id}', [DeliveryController::class,'getEdit'])->name('EditDelivery');
        Route::post('edit', [DeliveryController::class,'edit'])->name('EditDelivery_');
        Route::get('delete/{id}',[DeliveryController::class,'DeleteDelivery'])->name('DeleteDelivery');
    });
});

Auth::routes(['verify' => true]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 //route logout admin
    // Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

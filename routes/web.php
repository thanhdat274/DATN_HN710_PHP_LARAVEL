<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryBlogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Ajax\LocationController;
use App\Http\Controllers\Ajax\ShopAjaxController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\PointController;
use App\Http\Controllers\Ajax\DeleteController;
use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\CommentController as ClientCommentController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\ChatController;
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

// ----------------------------CLIENT ROUTES--------------------------------

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');


//ajax get location
Route::get('ajax/location/getDistrics', [LocationController::class, 'getDistrics']);
Route::get('ajax/location/getWards', [LocationController::class, 'getWards']);
Route::get('/api/districts', [LocationController::class, 'getDistricts']);
Route::get('/api/wards', [LocationController::class, 'getWardLoad']);



// Shop
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/compare/{id}', [ShopController::class, 'compare'])->name('shops.compare');
Route::get('/shops/category/{id}', [ShopController::class, 'showByCategory'])->name('shops.category');
Route::get('/shops/{slug}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/ajax/shops/{slug}', [ShopAjaxController::class, 'showAjax']);
//Route::get('shop/ajax/getSizePrice', [ShopController::class, 'getSizePrice']);
Route::get('shop/ajax/getSizePriceDetail', [ShopAjaxController::class, 'getSizePriceDetail']);
Route::get('shop/ajax/getSizePriceDetail2', [ShopAjaxController::class, 'getSizePriceDetail']);
Route::get('/shop-search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/shop-filter', [ShopController::class, 'filter'])->name('shop.filter');

//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/ajax/addToCart', [CartController::class, 'addToCart']);
Route::delete('/ajax/deleteToCartHeader', [CartController::class, 'deleteToCart']);
Route::post('/ajax/updateQuantityCart', [CartController::class, 'updateQuantity']);

//sản phẩm yêu thích
Route::get('/san-pham-yeu-thich', [FavoriteController::class, 'index'])->name('favorite_Prd.index');
Route::post('/ajax/addToCart', [CartController::class, 'addToCart']);
Route::post('/ajax/addToFavorite', [FavoriteController::class, 'addToFavorite']);
Route::delete('/ajax/deleteToFavorite', [FavoriteController::class, 'deleteToFavorite']);

// Comment
Route::post('comments/store', [ClientCommentController::class, 'store'])->name('comments.store');

// Blog
Route::get('/blogs', [ClientBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/category/{id}', [ClientBlogController::class, 'getBlogCategory'])->name('blogs.category');
Route::get('/blogs/{id}', [ClientBlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs-search', [ClientBlogController::class, 'search'])->name('blogs.search');
Route::post('/voucher/apply-code', [ClientBlogController::class, 'applyVoucher'])->name('voucher.apply_code');

// Chat
Route::get('/support', [ChatController::class, 'index'])->name('support');
Route::middleware('auth')->group(function () {
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chats/create', [ChatController::class, 'createRoom'])->name('chat.createRoom');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chats/{chat}/send', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
});


// Checkout
 Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
 Route::post('/store-session-data', [CheckoutController::class, 'storeData']);

 Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('placeOrder');
 Route::get('/payment-return', [CheckoutController::class, 'paymentReturn'])->name('paymentReturn');
 Route::get('/thanks/{order_code}', [CheckoutController::class, 'thanks'])->name('thanks');
 Route::get('/fail', [CheckoutController::class, 'fail'])->name('fail');
 Route::post('/apply-voucher', [CheckoutController::class, 'applyVoucher'])->name('voucher.apply');
 Route::get('/billSearch', [CheckoutController::class, 'billSearch'])->name('bill.search');
// Tài khoản
Route::middleware('guest')->group(function () {
    Route::get('/login', [AccountController::class, 'loginForm'])->name('login');
    Route::post('/login', [AccountController::class, 'login'])->name('login');
    Route::get('/register', [AccountController::class, 'registerForm']);
    Route::post('/register', [AccountController::class, 'register'])->name('register');
    Route::get('/forgot', [AccountController::class, 'forgotForm'])->name('forgot');
    Route::post('/forgot', [AccountController::class, 'forgot'])->name('forgot.password');
    Route::get('verify-email/{token}', [AccountController::class, 'verifyEmail'])->name('verify.email');
    Route::get('user/password/reset/{token}', [AccountController::class, 'showResetForm'])->name('user.password.reset');
    Route::post('user/password/reset', [AccountController::class, 'reset'])->name('user.password.update');
});

//Đổi điểm
Route::get('/ajax/getVoucher', [PointController::class, 'redeemVoucher']);


Route::middleware('auth')->group(function () {
    Route::post('user/logout', [AccountController::class, 'logout'])->name('user.logout');
    Route::get('/my_account', [AccountController::class, 'myAccount'])->name('my_account');
    Route::post('/my_acount/update/{id}', [AccountController::class, 'updateMyAcount'])->name('updateMyAcount');
    Route::post('/my_acount/update-password/{id}', [AccountController::class, 'updatePassword'])->name('user.updatePassword');
    Route::get('/my_acount/{id}/bill_detail', [AccountController::class, 'orderBillDetail'])->name('viewBillDetail');
    Route::get('my_acount/orders/cancel/{id}', [AccountController::class, 'cancelOrder'])->name('cancelOrder');
});
Route::get('/verify/{token}', [AccountController::class, 'verify'])->name('verify');

// ----------------------------END CLIENT ROUTES--------------------------------

Route::middleware('guest')->group(function () {
    Route::get('admin/login', [LoginController::class, 'loginForm'])->name('admin.loginForm');
    Route::post('admin/checkLogin', [LoginController::class, 'login'])->name('admin.checkLogin');
    Route::get('admin/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('admin.forgot');
    Route::post('admin/forgot', [ForgotPasswordController::class, 'forgot'])->name('admin.forgot.password');
    Route::get('admin/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('admin.password.update');
});
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

Route::prefix('admin')->as('admin.')->middleware(['check.working.shift','auth', 'isAdmin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('support/{chat}', [SupportController::class, 'show'])->name('chat');

    // Các route tùy chỉnh
    Route::get('/accounts/my_account', [UserController::class, 'myAccount'])->name('accounts.myAccount');
    Route::put('accounts/my_account', [UserController::class, 'updateMyAcount'])->name('accounts.updateMyAccount');
    Route::get('/accounts/change-password', [UserController::class, 'showChangePasswordForm'])->name('accounts.showChangePasswordForm');
    Route::put('/accounts/change-password', [UserController::class, 'updatePassword'])->name('accounts.updatePassword');

    Route::get('accounts/listUser', [UserController::class, 'listUser'])->name('accounts.listUser');

    // Quản lí tài khoản
    Route::resource('accounts', UserController::class)->except(['destroy']);
    Route::resource('shift', ShiftController::class)->except(['show']);


    // Quản lý các size đã bị xóa mềm
    Route::get('sizes/trashed', [SizeController::class, 'trashed'])->name('sizes.trashed');
    Route::put('sizes/restore/{id}', [SizeController::class, 'restore'])->name('sizes.restore');
    Route::delete('sizes/forceDelete/{id}', [SizeController::class, 'forceDelete'])->name('sizes.forceDelete');

    Route::resource('sizes', SizeController::class);

    // Quản lý các size đã bị xóa mềm
    Route::get('colors/trashed', [ColorController::class, 'trashed'])->name('colors.trashed');
    Route::put('colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
    Route::delete('colors/forceDelete/{id}', [ColorController::class, 'forceDelete'])->name('colors.forceDelete');

    Route::resource('colors', ColorController::class);

    // Vouchers
    Route::resource('vouchers', VoucherController::class)->except(['destroy']);;

    // Quản lý các danh mục đã bị xóa mềm
    Route::get('categories/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::put('categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/forceDelete/{id}', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');

    Route::resource('categories', CategoryController::class);

    // Quản lý các sản phẩm đã bị xóa mềm
    Route::get('products/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
    Route::put('products/restore/{id}', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/forceDelete/{id}', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    Route::resource('products', ProductController::class);

    // Quản lý các danh mục đã bị xóa mềm
    Route::get('category_blogs/trashed', [CategoryBlogController::class, 'trashed'])->name('category_blogs.trashed');
    Route::put('category_blogs/restore/{id}', [CategoryBlogController::class, 'restore'])->name('category_blogs.restore');
    Route::delete('category_blogs/forceDelete/{id}', [CategoryBlogController::class, 'forceDelete'])->name('category_blogs.forceDelete');
    Route::resource('category_blogs', CategoryBlogController::class);


    //Quản lý bài viết xóa mềm
    Route::get('blogs/trashed', [BlogController::class, 'trashed'])->name('blogs.trashed');
    Route::put('blogs/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('blogs/forceDelete/{id}', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');

    Route::resource('blogs', BlogController::class);

    // Quản lý các banner đã bị xóa mềm
    Route::get('banners/trashed', [BannerController::class, 'trashed'])->name('banners.trashed');
    Route::put('banners/restore/{id}', [BannerController::class, 'restore'])->name('banners.restore');
    Route::delete('banners/forceDelete/{id}', [BannerController::class, 'forceDelete'])->name('banners.forceDelete');

    // Danh sách bình luận
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');

    // Chi tiết bình luận
    Route::get('comments/{id}', [CommentController::class, 'show'])->name('comments.show');
    Route::get('comments/{parent_id}/children', [CommentController::class, 'showChildren'])->name('comments.showChildren');

    // Quản lí banner
    Route::resource('banners', BannerController::class);

    //Quản lý đơn hàng
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/{order_id}/order-detail', [OrderController::class, 'detail'])->name('order.detail');
    Route::get('order/confirm/{order_id}', [OrderController::class, 'confirmOrder'])->name('order.confirmOrder');
    Route::get('order/ship/{order_id}', [OrderController::class, 'shipOrder'])->name('order.shipOrder');
    Route::get('order/confirm-shipping/{order_id}', [OrderController::class, 'confirmShipping'])->name('order.confirmShipping');
    Route::get('order/cancel/{order_id}', [OrderController::class, 'cancelOrder'])->name('order.cancelOrder');
    Route::get('order-print/{checkout_code}', [OrderController::class, 'print_order'])->name('order.printOrder');

    //Thông báo
    Route::get('notification', [NotificationController::class, 'notification'])->name('notification');
    Route::get('order/{order_id}/order-detail-notication/{noti_id}', [NotificationController::class, 'detailNotication'])->name('order.detailNotication');
    Route::delete('notication/{id}', [NotificationController::class, 'delete'])->name('deleteNoti');
    Route::get('deleteNoticationRead', [NotificationController::class, 'deleteAllNotiRead'])->name('deleteAllNotiRead');
    Route::get('deleteNotication', [NotificationController::class, 'deleteAllNoti'])->name('deleteAllNoti');

    // Thống kê
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::post('statistics/show', [StatisticsController::class, 'showStatistics'])->name('statistics.show');
});

//ajax category
Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);
Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);
//ajax comment
Route::post('comments/ajax/changeActiveComment', [ChangeActiveController::class, 'changeActiveComment']);
Route::post('comments/ajax/changeAllActiveComment', [ChangeActiveController::class, 'changeActiveAllComment']);
//ajax product
Route::post('products/ajax/changeActiveProduct', [ChangeActiveController::class, 'changeActiveProduct']);
Route::post('products/ajax/changeAllActiveProduct', [ChangeActiveController::class, 'changeActiveAllProduct']);
//ajax account
Route::post('accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
Route::post('accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
Route::post('accounts/accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
Route::post('accounts/accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
//ajax category blog
Route::post('category_blogs/ajax/changeActiveCategoryBlog', [ChangeActiveController::class, 'changeActiveCategoryBlog']);
Route::post('category_blogs/ajax/changeAllActiveCategoryBlog', [ChangeActiveController::class, 'changeActiveAllCategoryBlog']);
//ajax xoa cac muc da chon categoryblog
Route::delete('categoryBlogs/ajax/deleteAllCategoryBlog', [DeleteController::class, 'deleteAllCategoryBlog']);
//update count thung rac
Route::get('categoryBlogs/ajax/trashedCount', [CategoryBlogController::class, 'trashedCount']);
//ajax banner
Route::post('banners/ajax/changeActiveBanner', [ChangeActiveController::class, 'changeActiveBanner']);
Route::post('banners/ajax/changeAllActiveBanner', [ChangeActiveController::class, 'changeActiveAllBanner']);
//ajax comment
Route::post('comments/ajax/changeActiveComment', [ChangeActiveController::class, 'changeActiveComment']);
Route::post('comments/ajax/changeAllActiveComment', [ChangeActiveController::class, 'changeActiveAllComment']);
//ajax blog
Route::post('blogs/ajax/changeActiveBlog', [ChangeActiveController::class, 'changeActiveBlog']);
Route::post('blogs/ajax/changeAllActiveBlog', [ChangeActiveController::class, 'changeActiveAllBlog']);
//ajax xoa cac muc da chon blog
Route::delete('blogs/ajax/deleteAllBlog', [DeleteController::class, 'deleteAllBlog']);
//update count thung rac
Route::get('blogs/ajax/trashedCount', [BlogController::class, 'trashedCount']);
//ajax delete notification
Route::delete('notification/ajax/deleteNoti', [DeleteController::class, 'deleteCheckedNoti'])->name('deleteNoti');
//ajax delete categorie
Route::delete('categori/ajax/deleteCheckedCategori', [DeleteController::class, 'deleteCheckedCategori']);
//ajax delete product
Route::delete('product/ajax/deleteCheckedProduct', [DeleteController::class, 'deleteCheckeProduct']);
//ajax delete size
Route::delete('/size/ajax/deleteCheckedSize', [DeleteController::class, 'deleteCheckeSize']);
//ajax delete color
Route::delete('/color/ajax/deleteCheckedColor', [DeleteController::class, 'deleteCheckeColor']);
//ajax delete banner
Route::delete('/banner/ajax/deleteCheckedBanner', [DeleteController::class, 'deleteCheckeBanner']);

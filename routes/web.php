<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ExtraBanners;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategory;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\Subcategories;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WebsiteContoller;
use Illuminate\Support\Facades\Route;


// --------------------------------------- ADMIN ROUTE HERE ---------------------------
Route::get('admin',action: [AdminController::class,'login']);
Route::post('admin/auth',action: [AdminController::class,'auth'])->name('admin.login.process');
Route::get('admin/dashboard',action: [AdminController::class,'dashboard'])->name('admin.dashboard');

Route::resource('admin/category', controller: ProductCategory::class);
Route::delete('admin/category/delete/{id}',action: [ProductCategory::class, 'destroy'])->name('category.destroy');
Route::resource('admin/subcategories',controller: Subcategories::class);
Route::delete('admin/subcategories/delete/{id}',action: [Subcategories::class, 'destroy'])->name('subcategories.destroy');


Route::resource('admin/size',controller: SizeController::class);
Route::delete('admin/size/delete/{id}',action: [SizeController::class, 'destroy'])->name('size.destroy');

Route::resource('admin/user',controller: UsersController::class);
// Route::delete('size/delete/{id}',action: [SizeController::class, 'destroy'])->name('size.destroy');

Route::resource('admin/color',controller: ColorsController::class);
Route::delete('admin/color/delete/{id}',action: [ColorsController::class, 'destroy'])->name('color.destroy');

Route::resource('admin/brand',controller: BrandController::class);
Route::delete('admin/brand/delete/{id}',action: [BrandController::class, 'destroy'])->name('brand.destroy');

Route::resource('admin/tag',controller: TagController::class);
Route::delete('admin/tag/delete/{id}', action: [TagController::class, 'destroy'])->name('tag.destroy');

Route::resource('admin/product', controller: ProductController::class);
Route::delete('admin/product/delete/{id}',action: [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('admin/product/copy/{id}',action: [ProductController::class, 'ProductCopy'])->name('product.copy');
Route::get('admin/product/image_upload/{id}', [ProductController::class,'image_upload'])->name('product.image.upload');
Route::post('admin/product/image_upload/process', [ProductController::class,'upload'])->name('images.upload.process');
Route::get('admin/product/bulk/upload', [ProductController::class,'bulk_upload'])->name('product.bulk.form');
Route::post('admin/upload-excel', [ProductController::class, 'uploadExcel'])->name('product.uploadExcel');
Route::delete('admin/product-image/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');
Route::post('admin/product/{product}', [ProductController::class, 'updateData'])->name('product.updateData');

Route::get('admin/productsubcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('productsubcategories.get');
Route::delete('admin/product/attribute/{id}', [ProductController::class, 'deleteAttribute'])->name('product.attribute.delete');




Route::resource('admin/coupon', CouponController::class);
Route::delete('admin/coupon/delete/{id}', action: [CouponController::class, 'destroy'])->name('coupon.destroy');

Route::resource('admin/collections', CollectionController::class);
Route::delete('admin/collections/delete/{id}', action: [CollectionController::class, 'destroy'])->name('collections.destroy');

Route::resource('admin/banner', BannerController::class);
Route::delete('admin/banner/delete/{id}', action: [BannerController::class, 'destroy'])->name('banner.destroy');
Route::delete('admin/manual/order/delete/{id}', action: [OrderController::class, 'manualdestroy'])->name('manual.order.destroy');

Route::resource('admin/invoice', InvoiceController::class);
// Route::delete('banner/delete/{id}', action: [BannerController::class, 'destroy'])->name('banner.destroy');


Route::resource('admin/extra-banner', ExtraBanners::class);
Route::post('/extra-banner/store1', [ExtraBanners::class, 'store1'])->name('extra-banner.store1');
Route::post('/extra-banner/store2', [ExtraBanners::class, 'store2'])->name('extra-banner.store2');
Route::post('/extra-banner/store3', [ExtraBanners::class, 'store3'])->name('extra-banner.store3');
Route::post('/extra-banner/store4', [ExtraBanners::class, 'store4'])->name('extra-banner.store4');
// Route::delete('admin/banner/delete/{id}', action: [BannerController::class, 'destroy'])->name('banner.destroy');

Route::get('admin/orders/latest',[OrderController::class,'latestOrder'])->name('latestOrder');
Route::get('admin/orders/ongoingorder',[OrderController::class,'OngoingOrder'])->name('OngoingOrder');
Route::get('admin/orders/deliveredorder',[OrderController::class,'DeliveredOrder'])->name(name: 'DeliveredOrder');
Route::get('admin/orders/cancel',[OrderController::class,'CancelOrder'])->name('CancelOrder');
Route::get('admin/orders/{custom_order_id}', [OrderController::class, 'latestOrderView'])->name('order.view');
Route::get('admin/contacts',[AdminController::class,'contacts'])->name('admin.contact');
Route::get('admin/manual/orders',[OrderController::class,'ManualOrder'])->name('ManualOrder');
Route::get('admin/manual/ongoing/orders',[OrderController::class,'ManualOngoingOrder'])->name('ManualOrder.OngoingOrder');

Route::post('/update-proceed-status', [OrderController::class, 'updateProceedStatus'])->name('manual.update.proceed.status');
Route::post('/update-confirm-status', [OrderController::class, 'updateConfirmStatus'])->name('manual.update.confirm.status');


Route::get('admin/shipped/orders',[OrderController::class,'ShippedOrder'])->name('ShippedOrder');
Route::post('/order/tracking-details', [OrderController::class, 'storeTrackingDetails'])->name('order.tracking.store');
Route::get('/order/tracking/view', [OrderController::class, 'viewTrackingDetails'])->name('order.tracking.view');




Route::get('/',[WebsiteContoller::class,'home'])->name('website.home');
Route::get('/product/view',[WebsiteContoller::class,'view_product'])->name('view.product');
Route::get('/login',[WebsiteContoller::class,'login'])->name('login');
Route::post('/login/process', [WebsiteContoller::class, 'login_process'])->name('login.process');
Route::get('/logout', [WebsiteContoller::class, 'logout'])->name('logout');
Route::get('/register',[WebsiteContoller::class,'register'])->name('website.auth.register');
Route::post('/signup', [WebsiteContoller::class, 'store'])->name('signup.store');
Route::get('/account',[WebsiteContoller::class,'account'])->name('account');
Route::get('/privacy-policy',[WebsiteContoller::class,'privacy'])->name('privacy-Policy');
Route::get('/refund',[WebsiteContoller::class,'refund'])->name('refund');
Route::get('/terms',[WebsiteContoller::class,'terms'])->name('terms');
Route::get('/shipping',[WebsiteContoller::class,'shipping'])->name('shipping');
Route::get('/contact',[WebsiteContoller::class,'contact'])->name('contact');
Route::post('/contact/store',[WebsiteContoller::class,'storeContact'])->name('contact.store');
Route::get('/get-colors-by-size', [WebsiteContoller::class, 'getColorsBySize'])->name('product.getColorsBySize');
Route::get('product/{slug}', [WebsiteContoller::class, 'ProductView'])->name('view.product');
Route::get('subcategories/collection/{slug}', [WebsiteContoller::class, 'SubcategoriesCollection'])->name('view.subcategories.collection');

Route::post('add-to-cart', [WebsiteContoller::class, 'addToCart'])->name('add-to-cart');
Route::get('collections', [WebsiteContoller::class, 'collections'])->name('collections');
Route::get('brands', [WebsiteContoller::class, 'brands'])->name('view.brands');
Route::get('collections/{id}', [WebsiteContoller::class, 'collectionFilter'])->name('collction.filter');

Route::get('category/{id}', [WebsiteContoller::class, 'categoryFilter'])->name('filter.product.category');
Route::get('sub-category/{id}', [WebsiteContoller::class, 'SubcategoryFilter'])->name('filter.product.sub_category');
Route::get('brand/{id}', [WebsiteContoller::class, 'brandFilter'])->name(name: 'filter.product.brand');
Route::get('discounted/products', [WebsiteContoller::class, 'DiscountedProduct'])->name('view.discounted.product');

Route::get('collections/shop/filter', [WebsiteContoller::class, 'FilterProduct'])->name('shop.product.filter');

Route::post('remove-from-cart', [WebsiteContoller::class, 'removeFromCart'])->name('remove-from-cart');
Route::get('cart',[WebsiteContoller::class,'Viewcart'])->name('cart');
Route::get('/load-more-featured-products', [WebsiteContoller::class, 'loadMoreFeaturedProducts'])->name('load.more.featured.products');
Route::get('/load-more-latest-products', [WebsiteContoller::class, 'loadMoreLatestProducts'])->name('load.more.latest.products');
Route::get('/load-more-seller-products', [WebsiteContoller::class, 'loadMoreSellerProducts'])->name('load.more.seller.products');
Route::get('/product/view', [WebsiteContoller::class, 'getProductDetails'])->name('product.details');
Route::post('/add-to-wishlist', [WebsiteContoller::class, 'addToWishlist'])->name('add-to-wishlist');
// Route::post('/wishlist/remove', [WebsiteContoller::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::post('/cart/update-quantity', [WebsiteContoller::class, 'updateQuantity'])->name('cart.update.quantity');
Route::post('/cart/clear-all', [WebsiteContoller::class, 'clearAll'])->name('cart.clear.all');


// Route::post('/cart/remove/product', [WebsiteContoller::class,'removeProductFromCart'])->name('cart.remove.product');

Route::get('wishlist',[WebsiteContoller::class,'wishlist'])->name('wishlist');
// Route::post('/wishlist-add-to-cart', [WebsiteContoller::class, 'WishlistAddToCart'])->name('wishlist-add-to-cart');


// Route::post('/apply-coupon', [WebsiteContoller::class, 'applyCoupon'])->name('apply.coupon');
Route::get('collections/{slug}', [WebsiteContoller::class, 'filter_product'])->name('filter.product');
Route::get('collections/category/{slug}', [WebsiteContoller::class, 'filter_product_category'])->name('filter.product.category');

Route::get('checkout',[WebsiteContoller::class,'checkout'])->name('check-out');
Route::post('user/update-address', [WebsiteContoller::class, 'updateAddress'])->name('user.update.address');
Route::get('order/placed',[WebsiteContoller::class,'order_placed'])->name('order.placed');
Route::post('/store-order', [WebsiteContoller::class, 'storeOrder'])->name('store.order');

Route::post('/payment/phonepe/initiate', [WebsiteContoller::class, 'initiatePayment'])->name('phonepe.payment.initiate');
Route::post('/payment/phonepe/callback', [WebsiteContoller::class, 'handleCallback'])->name('phonepe.payment.callback');


Route::get('/search', [WebsiteContoller::class, 'Searchfilter_product'])->name('search-product');
Route::get('/search-collections', [WebsiteContoller::class, 'searchCollections'])->name('search-collections');


Route::post('user/address/store', [WebsiteContoller::class, 'UserAddressStore'])->name('user.address.store');
Route::post('user/address/update', [WebsiteContoller::class, 'UserAddressUpdate'])->name('user.address.update');
Route::delete('/address/{id}', [WebsiteContoller::class, 'Address_destroy'])->name('address.delete');
Route::put('/update-order-status/{orderId}', [OrderController::class, 'updateOrderStatus'])->name('order.updateStatus');
Route::put('/order/{orderId}/cancel', [OrderController::class, 'updateOrderCancelStatus'])->name('order.updateCanceltatus');
Route::put('user/order/{orderId}/cancel', [WebsiteContoller::class, 'UserupdateOrderCancelStatus'])->name('user.order.updateCancelStatus');

Route::get('forget-password', [WebsiteContoller::class, 'forget_password'])->name('forget.password');
Route::post('send-reset-password-email', [WebsiteContoller::class, 'sendResetPasswordEmail'])->name('send-reset-password-email');
Route::get('password-reset', [WebsiteContoller::class, 'password_reset'])->name('password.reset');
Route::post('password-update', [WebsiteContoller::class, 'password_update'])->name('password.update');


Route::post('/push-to-maruti', [OrderController::class, 'pushToMaruti'])->name('push.to.maruti');

Route::get('/manual',[WebsiteContoller::class,'MaualOrderPage']);
Route::post('/store-manual-order', [WebsiteContoller::class, 'StoreManualOrder'])->name('store.manual.order');
Route::post('/admin/push-to-shiprocket', [AdminController::class, 'pushToShiprocket'])->name('admin.pushToShiprocket');
Route::post('/admin/maual-order-push-to-shiprocket', [AdminController::class, 'maual_order_pushtoshiprocket'])->name('maual-order-push-to-shiprocket');

<?php

use Livewire\Volt\Volt;
use Livewire\Livewire;
use App\Livewire\HomePage;
use App\Livewire\DesignPage;
use App\Livewire\Collections;
use App\Livewire\CollectionDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CustomColorController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\FinishController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\LedController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RazorpayController;
use App\Http\Middleware\CustomAuthMiddleware;

Route::get('/', HomePage::class)->name('home');
Route::get('/design', DesignPage::class)->name('design');
Route::get('/your-collection', Collections::class)->name('collections');
Route::get('/collection/{slug}', CollectionDetail::class)->name('collections_detail');

Route::get('/privacy-policy', [PagesController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PagesController::class, 'refund'])->name('refund');
Route::get('/shipping-policy', [PagesController::class, 'shipping'])->name('shipping');
Route::get('/terms-and-conditions', [PagesController::class, 'terms'])->name('terms');
Route::get('/faq', [PagesController::class, 'faq'])->name('faq');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');
Route::post('/contact-form', [PagesController::class, 'submit'])->name('contact.submit');

Route::post('/update-frame-config', [MainController::class, 'update_config'])->name('update.frame.config');
Route::get('/get-uploaded-images', [MainController::class, 'get_images'])->name('get.uploaded.images');
Route::post('/delete-frame-config', [MainController::class, 'destroy'])->name('delete.frame.config');
Route::post('/add-to-cart-product', [MainController::class, 'store'])->name('add_to_cart_product');
Route::get('/cart', [MainController::class, 'cart'])->name('cart');
Route::get('/order_summary', [MainController::class, 'order_summary'])->name('order_summary');
Route::post('/upload-image', [MainController::class, 'upload_image'])->name('upload_image');
Route::get('/get-session-images', [MainController::class, 'get_session_images'])->name('get_session_images');
Route::post('/delete-session-image', [MainController::class, 'delete_session_image'])->name('delete_session_image');
Route::post('/get-frame-config', [MainController::class, 'get_frame_config'])->name('get_frame_config');
Route::post('/save-cropped-image', [MainController::class, 'save_cropped_image'])->name('save_cropped_image');
Route::post('/reset-cropped-image', [MainController::class, 'reset_cropped_image'])->name('reset_cropped_image');
Route::get('/get-grand-total', [MainController::class, 'get_grand_total'])->name('get_grand_total');
Route::get('/get-all-images', [MainController::class, 'get_all_images'])->name('get_all_images');
Route::post('/add-to-cart', [MainController::class, 'add_to_cart'])->name('add_to_cart');

Route::post('/save-coupon', [MainController::class, 'save_coupon'])->name('save_coupon');
Route::post('/remove-coupon', [MainController::class, 'remove_coupon'])->name('remove_coupon');
Route::get('/get-applied-coupon', [MainController::class, 'get_applied_coupon'])->name('get_applied_coupon');
Route::post('/remove-from-cart', [MainController::class, 'remove_from_cart'])->name('remove_from_cart');
Route::post('/update-cart-grand-total', [MainController::class, 'update_cart_grand_total'])->name('update_cart_grand_total');
Route::post('/place-order', [MainController::class, 'place_order'])->name('place_order');
Route::post('/add-address', [MainController::class, 'add_address'])->name('add_address');

Route::post('/upload-images', [MainController::class, 'upload_images'])->name('upload_images');
Route::post('/delete-image', [MainController::class, 'delete_images'])->name('delete_images');
Route::get('/fetch-images', [MainController::class, 'fetch_images'])->name('fetch_images');

Route::post('/update-gift-session', function (\Illuminate\Http\Request $request) {
    if ($request->gift_card_applied) {
        session(['gift_card_applied' => true]);
    } else {
        session()->forget('gift_card_applied');
    }
    return response()->json(['status' => 'success']);
});

Route::get('/state', [MainController::class, 'states'])->name('states');
Route::get('/cities/{state_id}', [MainController::class, 'getCities'])->name('get.cities');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/password/send-otp', [AuthController::class, 'sendOtp'])->name('password.sendOtp');
Route::post('/password/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verifyOtp');
Route::post('/password/reset', [AuthController::class, 'reset'])->name('password.resetPassword');

// Profile-related routes
Route::get('/myprofile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/update-myprofile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
Route::get('/orders/{id}', [ProfileController::class, 'viewOrder'])->name('orders.view');
Route::get('/orders/delete/{id}', [ProfileController::class, 'deleteOrder'])->name('orders.delete');
Route::get('/get-orders', [ProfileController::class, 'getOrders'])->name('get.orders');
Route::post('/orders/update-status/{order}', [ProfileController::class, 'updateStatus'])->name('orders.update-status');
Route::get('/address', [ProfileController::class, 'address'])->name('address');
Route::post('/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
Route::post('/address/update/{id}', [ProfileController::class, 'updateAddress'])->name('address.update');
Route::delete('/address/delete/{id}', [ProfileController::class, 'deleteAddress'])->name('address.delete');
Route::post('/address/set-default', [ProfileController::class, 'setDefault'])->name('address.set-default');
Route::get('/resetpassword', [ProfileController::class, 'resetpassword'])->name('resetpassword');
Route::post('/profile/reset-password', [ProfileController::class, 'resetPasswordPost'])->name('profile.reset-password');

// Product-related routes
Route::get('/frames', [ProductController::class, 'index'])->name('frames.index');
Route::get('/frames/data', [ProductController::class, 'getData'])->name('frames.data');
Route::post('/frames/store', [ProductController::class, 'store'])->name('frames.store');
Route::get('/frames/{id}/edit', [ProductController::class, 'edit'])->name('frames.edit');
Route::post('/frames/{id}', [ProductController::class, 'update'])->name('frames.update');
Route::delete('/frames/{id}', [ProductController::class, 'destroy'])->name('frames.destroy');
Route::delete('/frames/{id}/delete-image', [ProductController::class, 'deleteAdditionalImage'])->name('frames.deleteImage');
Route::get('/frames/get-image-url', [ProductController::class, 'getProductImage'])->name('frames.getProductImage');
Route::get('/frames/coordinates', [ProductController::class, 'post_coordinates'])->name('frames.post_coordinates');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/get', [AdminController::class, 'getData'])->name('admin.get');
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::get('/admin/login-as/{id}', [AdminController::class, 'loginAsUser'])->name('admin.login.as');

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');

Route::get('/color', [CustomColorController::class, 'index'])->name('color.index');
Route::get('/color/get', [CustomColorController::class, 'getData'])->name('color.get');
Route::post('/color/store', [CustomColorController::class, 'store'])->name('color.store');
Route::get('/color/edit/{id}', [CustomColorController::class, 'edit'])->name('color.edit');
Route::post('/color/update/{id}', [CustomColorController::class, 'update'])->name('color.update');
Route::delete('/color/delete/{id}', [CustomColorController::class, 'destroy'])->name('color.destroy');

Route::get('/size', [SizesController::class, 'index'])->name('size.index');
Route::get('/size/get', [SizesController::class, 'getData'])->name('size.get');
Route::post('/size/store', [SizesController::class, 'store'])->name('size.store');
Route::get('/size/edit/{id}', [SizesController::class, 'edit'])->name('size.edit');
Route::post('/size/update/{id}', [SizesController::class, 'update'])->name('size.update');
Route::delete('/size/delete/{id}', [SizesController::class, 'destroy'])->name('size.destroy');

Route::get('/finish', [FinishController::class, 'index'])->name('finish.index');
Route::get('/finish/get', [FinishController::class, 'getData'])->name('finish.get');
Route::post('/finish/store', [FinishController::class, 'store'])->name('finish.store');
Route::get('/finish/edit/{id}', [FinishController::class, 'edit'])->name('finish.edit');
Route::post('/finish/update/{id}', [FinishController::class, 'update'])->name('finish.update');
Route::delete('/finish/delete/{id}', [FinishController::class, 'destroy'])->name('finish.destroy');

Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
Route::get('/coupon/get', [CouponController::class, 'getData'])->name('coupon.get');
Route::post('/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
Route::get('/coupon/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
Route::post('/coupon/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
Route::delete('/coupon/delete/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');

Route::get('/led', [LedController::class, 'index'])->name('led.index');
Route::get('/led/get', [LedController::class, 'getData'])->name('led.get');
Route::post('/led/store', [LedController::class, 'store'])->name('led.store');
Route::get('/led/edit/{id}', [LedController::class, 'edit'])->name('led.edit');
Route::post('/led/update/{id}', [LedController::class, 'update'])->name('led.update');
Route::delete('/led/delete/{id}', [LedController::class, 'destroy'])->name('led.destroy');


Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
Route::get('/addresses/get', [AddressController::class, 'getData'])->name('addresses.get');
Route::post('/addresses/store', [AddressController::class, 'store'])->name('addresses.store');
Route::get('/addresses/edit/{id}', [AddressController::class, 'edit'])->name('addresses.edit');
Route::post('/addresses/update/{id}', [AddressController::class, 'update'])->name('addresses.update');
Route::delete('/addresses/delete/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

Route::get('/states', [StatesController::class, 'index'])->name('states.index');
Route::get('/states/get', [StatesController::class, 'getData'])->name('states.get');
Route::post('/states/store', [StatesController::class, 'store'])->name('states.store');
Route::get('/states/edit/{id}', [StatesController::class, 'edit'])->name('states.edit');
Route::post('/states/update/{id}', [StatesController::class, 'update'])->name('states.update');
Route::delete('/states/delete/{id}', [StatesController::class, 'destroy'])->name('states.destroy');

Route::get('/city', [CityController::class, 'index'])->name('city.index');
Route::get('/city/get', [CityController::class, 'getData'])->name('city.get');
Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
Route::get('/city/edit/{id}', [CityController::class, 'edit'])->name('city.edit');
Route::post('/city/update/{id}', [CityController::class, 'update'])->name('city.update');
Route::delete('/city/delete/{id}', [CityController::class, 'destroy'])->name('city.destroy');

Route::post('/add-to-cart-collection', [MainController::class, 'add_to_cart_collection'])->name('add_to_cart_collection');
Route::get('/frame-defaults', [MainController::class, 'getFrameDefaults'])->name('getFrameDefaults');

Route::get('/razorpay/create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.create_order');
Route::post('/razorpay/verify-payment', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify_payment');

Route::get('/orders/payment-info/{id}', [ProfileController::class, 'getPaymentInfo']);
Route::post('/orders/refund', [ProfileController::class, 'processRefund']);

Route::get('/canvas', function () {
    return view('canvas');
});

Route::get('/check-user-address', function () {
    return response()->json(['hasAddress' => session()->has('user_address') && !empty(session('user_address'))]);
})->name('check_user_address');

require __DIR__.'/auth.php';

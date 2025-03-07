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

Route::get('/', HomePage::class)->name('home');
Route::get('/design', DesignPage::class)->name('design');
Route::get('/your-collection', Collections::class)->name('collections');
Route::get('/collection/symmetry', CollectionDetail::class)->name('collections_detail');

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
Route::get('/get-grand-total', [MainController::class, 'get_grand_total'])->name('get_grand_total');
Route::get('/get-all-images', [MainController::class, 'get_all_images'])->name('get_all_images');
Route::post('/add-to-cart', [MainController::class, 'add_to_cart'])->name('add_to_cart');

Route::post('/save-coupon', [MainController::class, 'save_coupon'])->name('save_coupon');
Route::post('/remove-coupon', [MainController::class, 'remove_coupon'])->name('remove_coupon');
Route::get('/get-applied-coupon', [MainController::class, 'get_applied_coupon'])->name('get_applied_coupon');
Route::post('/remove-from-cart', [MainController::class, 'remove_from_cart'])->name('remove_from_cart');
Route::post('/update-cart-grand-total', [MainController::class, 'update_cart_grand_total'])->name('update_cart_grand_total');
Route::get('/place-order', [MainController::class, 'place_order'])->name('place_order');
Route::post('/add-address', [MainController::class, 'add_address'])->name('add_address');

Route::post('/update-gift-session', function (\Illuminate\Http\Request $request) {
    if ($request->gift_card_applied) {
        session(['gift_card_applied' => true]);
    } else {
        session()->forget('gift_card_applied');
    }
    return response()->json(['status' => 'success']);
});

Route::get('/states', function () {
    return response()->json([
        "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh",
        "Goa", "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand",
        "Karnataka", "Kerala", "Madhya Pradesh", "Maharashtra", "Manipur",
        "Meghalaya", "Mizoram", "Nagaland", "Odisha", "Punjab",
        "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
        "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands",
        "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi",
        "Lakshadweep", "Puducherry"
    ]);
});

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/myprofile',[ProfileController::class,'profile'])->name('profile');
Route::get('/orders',[ProfileController::class,'orders'])->name('orders');
Route::get('/address',[ProfileController::class,'address'])->name('address');
Route::get('/resetpassword',[ProfileController::class,'resetpassword'])->name('resetpassword');

Route::get('/frames',[ProductController::class,'index'])->name('frames.index');
Route::get('/frames/data', [ProductController::class, 'getData'])->name('frames.data');
Route::post('/frames/store', [ProductController::class, 'store'])->name('frames.store');
Route::get('/frames/{id}/edit', [ProductController::class, 'edit'])->name('frames.edit');
Route::post('/frames/{id}', [ProductController::class, 'update'])->name('frames.update');
Route::delete('/frames/{id}', [ProductController::class, 'destroy'])->name('frames.destroy');
Route::delete('/frames/{id}/delete-image', [ProductController::class, 'deleteAdditionalImage'])->name('frames.deleteImage');

require __DIR__.'/auth.php';

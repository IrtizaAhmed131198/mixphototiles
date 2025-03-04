<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\HomePage;
use App\Livewire\DesignPage;
use App\Livewire\Collections;
use App\Livewire\CollectionDetail;
use App\Http\Controllers\MainController;

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

require __DIR__.'/auth.php';

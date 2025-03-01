<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\HomePage;
use App\Livewire\DesignPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/design', DesignPage::class)->name('design');

require __DIR__.'/auth.php';

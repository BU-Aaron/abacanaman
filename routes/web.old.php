<?php

use App\Http\Livewire\ProductList;
use App\Http\Livewire\ProductDetail;
use Illuminate\Support\Facades\Route;

// Home Page Route
Route::get('/', ProductList::class)->name('home');

// Product Detail Page Route
Route::get('/product/{product}', ProductDetail::class)->name('product.show');

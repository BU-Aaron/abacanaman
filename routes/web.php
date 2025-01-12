<?php

use App\Filament\Seller\Pages\Auth\SellerApprovedVerification;
use App\Livewire\DiscountCalendar;
use App\Livewire\BuyerChat;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\BlogPage;
use App\Livewire\BlogPost;
use App\Livewire\CancelPage;
use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use App\Livewire\SellerPage;
use App\Livewire\SuccessPage;
use App\Livewire\BuyerProfilePage;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('index');

Route::get('/categories', CategoriesPage::class)->name('product-categories');

Route::get('/products', ProductsPage::class)->name('all-products');

Route::get('/product/{slug}', ProductDetailPage::class)->name('product-details');

Route::get('/cart', CartPage::class)->name('cart-products');



Route::get('/blog', BlogPage::class)->name('blog');

Route::get('/blog/{slug}', BlogPost::class)->name('blog.post');

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');

    Route::get('/register', RegisterPage::class)->name('register');

    Route::get('/forgot-password', ForgotPasswordPage::class)->name('password.request');

    Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
});

Route::middleware('auth.buyer')->group(function () {
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    });

    Route::get('/profile', BuyerProfilePage::class)->name('buyer.profile');

    Route::get('/checkout', CheckoutPage::class)->name('checkout');

    Route::get('/chat/seller/{seller_id}', BuyerChat::class)->name('buyer.chat');

    Route::get('/my-orders', MyOrdersPage::class)->name('my-orders');

    Route::get('/my-orders/{order_id}', MyOrderDetailPage::class)->name('my-orders.show');

    Route::get('/success', SuccessPage::class)->name('success');

    Route::get('/cancelled', CancelPage::class)->name('cancelled');
});

Route::get('info/seller/{seller_id}', SellerPage::class)->name('seller.page');

Route::get('/discounts/calendar', DiscountCalendar::class)->name('discounts.calendar');

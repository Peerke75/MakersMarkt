<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');
Route::resource('orders', OrderController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('portfolio.create');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    Route::get('/portfolio/{product}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio/{product}', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::delete('/portfolio/{product}', [PortfolioController::class, 'destroy'])->name('portfolio.destroy');
});

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{id}/info', [ProductController::class, 'show'])->name('products.info');
Route::get('/products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');


Route::get('/reviews/search', [ReviewController::class, 'search'])->name('reviews.search');
Route::get('/reviews/{product}', [ReviewController::class, 'index'])->name('reviews');
Route::get('/reviews/create/{product}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

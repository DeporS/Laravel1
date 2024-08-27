<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Center;
use App\Http\Controllers\CartController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// admin
Route::middleware(['auth', 'admin'])->group(function () {
    // form center
    Route::get('/form-center', [Center::class, 'show'])->name('formCenter');

    // route do sklepu dla admina
    Route::resource('shop', ShopController::class)->except(['index', 'show']);
});



// kazdy uzytkownik
Route::middleware('auth')->group(function () {
    // profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // form
    Route::get('/form', [FormController::class, 'show'])->name('form');

    Route::post('/form', [FormController::class, 'validateForm'])->name('validateForm');


    // Aktualizacja rekordu
    Route::post('/update-post', [PostController::class, 'update'])->name('post.update'); 

    // Usuniecie rekordu
    Route::post('/delete-post', [PostController::class, 'delete'])->name('post.delete');


    // Photos route resource
    Route::resource('photos', PhotoController::class);

    // trasa do kupowania
    Route::get('/shop/buy', [ShopController::class, 'buy'])->name('shop.buy');
    Route::post('/shop/buy', [ShopController::class, 'validateOrder'])->name('validateOrder');
    
    // route do sklepu dla usera
    Route::resource('shop', ShopController::class)->only(['index', 'show']);
    


    // koszyk
    Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/show', [CartController::class, 'show'])->name('cart.show'); 
    Route::post('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
});


require __DIR__.'/auth.php';


// dodac zdjecie profilowe

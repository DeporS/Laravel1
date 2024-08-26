<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Center;
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

    // Route resource do sklepu, ale bez mozliwosci adminowskich
    Route::resource('shop', ShopController::class)->except(['update', 'destroy']);
});

// admin
Route::middleware(['auth', 'admin'])->group(function () {
    // form center
    Route::get('/form-center', [Center::class, 'show'])->name('formCenter');

    // route do sklepu dla admina
    Route::put('shop/{shop}', [ShopController::class, 'update'])->name('shop.update');
    Route::delete('shop/{shop}', [ShopController::class, 'destroy'])->name('shop.destroy');
});



require __DIR__.'/auth.php';


// dodac zdjecie profilowe

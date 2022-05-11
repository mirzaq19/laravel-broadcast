<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/message',[MessageController::class,'index']);
Route::get('/private-message',[MessageController::class,'private'])->middleware(['auth']);
Route::get('/presence-message',[MessageController::class,'presence'])->middleware(['auth']);

require __DIR__.'/auth.php';

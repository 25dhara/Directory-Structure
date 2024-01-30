<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PermissionController;

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

Route::get('/dashboard', function () {
    return view('layouts.welcome');
})->name('dashboard.index');

Route::get('/',             [AuthController::class, 'index'])->name('login');
Route::get('/login',        [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::post('logout',       [AuthController::class, 'logout'])->name('logout');

// Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.index');

Route::middleware(['auth'])->group(function () {
    Route::resource('users',         UserController::class);
    Route::resource('permission',       PermissionController::class);
    Route::resource('folders', FolderController::class);
    Route::resource('files', FileController::class);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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

Route::get('/login', [AuthController::class,'LoginPage'])->name('login');
Route::post('/login', [AuthController::class,'Authenticate'])->name('auth.login');
Route::get('/signup', [AuthController::class,'SignupPage'])->name('auth.signup');
Route::post('/signup', [AuthController::class,'Signup'])->name('auth.signup');
Route::get('/logout', [AuthController::class,'Logout'])->name('logout');



Route::get('/', [HomeController::class, 'Page'])->name('home')->middleware('auth');
Route::get('/create', [HomeController::class, 'Create'])->name('home.create')->middleware('auth');
Route::post('/create', [HomeController::class, 'Store'])->name('home.create')->middleware('auth');
Route::get('/edit/{id}', [HomeController::class, 'Edit'])->name('home.edit')->middleware('auth');
Route::post('/edit/{id}', [HomeController::class, 'Update'])->name('home.update')->middleware('auth');
Route::get('/delete/{id}', [HomeController::class, 'Delete'])->name('home.delete')->middleware('auth');
Route::post('/delete/{id}', [HomeController::class, 'Deleted'])->name('home.delete')->middleware('auth');

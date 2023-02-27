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
Route::get('/', [HomeController::class, 'Page'])->name('home')->middleware('auth');

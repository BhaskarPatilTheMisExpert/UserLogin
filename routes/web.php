<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\ImageController;

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

Route::get('/login',[loginController::class, 'index'])->name('login.index');
Route::get('getOtp',[loginController::class, 'generateOtp']);
Route::get('userLogin',[loginController::class, 'userLogin'])->name('userLogin.userLogin');
Route::get('uploadImg',[ImageController::class, 'uploadImag']);
Route::get('imageUploadSave',[ImageController::class, 'imageUploadSave'])->name('imageUploadSave');


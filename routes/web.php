<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\UsersController;

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

Route::post('/save-data', [DataController::class, 'saveData']);
Route::post('/login', [UsersController::class, 'login']);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cart', function () {
    return view('welcome');
});
Route::get('/checkout', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('welcome');
});
Route::get('/getuser', [UsersController::class, 'getUser']);
Route::get('/logout', [UsersController::class, 'logout']);

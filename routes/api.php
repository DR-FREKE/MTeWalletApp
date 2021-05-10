<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\FundAccountController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//route for registration
Route::get("/auth/register", [RegisterController::class, 'index'])->name('register');
Route::post("/auth/register", [RegisterController::class, 'store']);

//route for login
Route::get("/auth/login", [LoginController::class, 'index'])->name('login');
Route::post("/auth/login", [LoginController::class, 'userLogin']);

//group all route in the middleware
Route::middleware(['auth:api'])->group(function () {
    // crud route for creating an account
    Route::apiResource("/generate_account", AccountController::class);
    
    //crud route for Funding account
    Route::apiResource("/fund-account", FundAccountController::class);
});
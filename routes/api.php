<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware('auth:api')->prefix('user')->group(function (){

    Route::post('password/reset', [\App\Http\Controllers\API\User\ressetPasswordController::class, 'changePassword']);
    Route::post('/logout', function (Request $request) {
        $user = Auth::user();
        $user->tokens()->delete(); // revoke all the user's access tokens

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    })->middleware('auth:api');
    Route::apiResource("profile", \App\Http\Controllers\API\User\UserProfileController::class);
});



Route::post('login', [\App\Http\Controllers\API\User\loginController::class,'login']);
Route::post('register', [\App\Http\Controllers\API\Admin\registerController::class,'signup']);
//Route::post('password/email', [\App\Http\Controllers\API\User\ResetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('admin/login', [\App\Http\Controllers\API\Admin\adminloginController::class,'login'])->middleware('api');

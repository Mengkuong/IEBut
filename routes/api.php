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

                          //Create User Admin

    Route::post('Create_User', [\App\Http\Controllers\API\Admin\UserManagement::class,'createUser']);
    Route::get('Get_User', [\App\Http\Controllers\API\Admin\UserManagement::class,'index']);
    Route::post('Update_User/{id}', [\App\Http\Controllers\API\Admin\UserManagement::class,'updateUser']);
    Route::post('Get/{id}}', [\App\Http\Controllers\API\Admin\UserManagement::class,'show']);



                            // create Admin
    Route::post('Create_Admin', [\App\Http\Controllers\API\SuperAdmin\ManagementAdminController::class,'createAdmin']);



                               // User Create Post

    Route::post('Create_post', [\App\Http\Controllers\API\Admin\PostController::class,'store']);
    Route::post('update_post/{id}', [\App\Http\Controllers\API\Admin\PostController::class,'update']);
    Route::get('Get_post', [\App\Http\Controllers\API\Admin\PostController::class,'index']);
    Route::get('Get_post/{id}', [\App\Http\Controllers\API\Admin\PostController::class,'show']);
    Route::delete('Delete_post/{id}', [\App\Http\Controllers\API\Admin\PostController::class,'destroy']);

                               //View Post
    Route::get('view_post', [\App\Http\Controllers\API\User\ViewPostController::class,'index']);

                              //Admin create Certificate
    Route::post('Create_certificate', [\App\Http\Controllers\API\Admin\CertificateController::class,'store']);
    Route::post('Update_certificate/{id}', [\App\Http\Controllers\API\Admin\CertificateController::class,'update']);
    Route::get('Get_certificate', [\App\Http\Controllers\API\Admin\CertificateController::class,'index']);
    Route::get('Get_certificate/{id}', [\App\Http\Controllers\API\Admin\CertificateController::class,'show']);
    Route::delete('Delete_certificate/{id}', [\App\Http\Controllers\API\Admin\CertificateController::class,'destroy']);

                                       //User View certificate
    Route::get('view_certificate', [\App\Http\Controllers\API\User\ViewCertificateController::class,'index']);
    Route::get('view_certificate/{id}', [\App\Http\Controllers\API\User\ViewCertificateController::class,'show']);

                                         // User Create Sell
    Route::post('Create_sell', [\App\Http\Controllers\API\User\SellController::class,'store']);
    Route::get('Get_sell', [\App\Http\Controllers\API\User\SellController::class,'index']);
    Route::get('Get_sell/{id}', [\App\Http\Controllers\API\User\SellController::class,'show']);
    Route::post('Update_sell/{id}', [\App\Http\Controllers\API\User\SellController::class,'update']);
    Route::delete('Delete_sell/{id}', [\App\Http\Controllers\API\User\SellController::class,'destroy']);

                             //View User Request Sell Super Admin
    Route::get('Get_sell', [\App\Http\Controllers\API\SuperAdmin\ViewSellController::class,'index']);
    Route::get('Get_sell/{id}', [\App\Http\Controllers\API\SuperAdmin\ViewSellController::class,'show']);

                            // Finance Payment
    Route::post('Create_payment', [\App\Http\Controllers\API\Finance\PaymentController::class,'store']);
    Route::get('Get_payment', [\App\Http\Controllers\API\Finance\PaymentController::class,'index']);
    Route::get('Get_payment/{id}', [\App\Http\Controllers\API\Finance\PaymentController::class,'show']);
    Route::get('Update/{id}', [\App\Http\Controllers\API\Finance\PaymentController::class,'update']);

                           //SuperAdmin View Finance
    Route::get('Get_payment_super', [\App\Http\Controllers\API\SuperAdmin\ViewFinanceController::class,'index']);


                           //Admin View Finance
    Route::get('Get_payment_admin', [\App\Http\Controllers\API\Admin\ViewFinanceController::class,'index']);

                             //User View Finance
    Route::get('Get_payment_user', [\App\Http\Controllers\API\User\ViewFinanceController::class,'ViewFinance']);

                             // Buyer
    Route::post('Create_buy', [\App\Http\Controllers\API\User\BuyController::class,'store']);
    Route::get('Get_buy', [\App\Http\Controllers\API\User\BuyController::class,'index']);
    Route::get('Get_buy/{id}', [\App\Http\Controllers\API\User\BuyController::class,'show']);
    Route::post('Update_buy/{id}', [\App\Http\Controllers\API\User\BuyController::class,'update']);
    Route::delete('Delete_buy/{id}', [\App\Http\Controllers\API\User\BuyController::class,'destroy']);


                               //User view All Seller
    Route::get('Get_All_seller', [\App\Http\Controllers\API\User\ViewSellerController::class,'ViewSeller']);

                                //AcceptOrReject Super Admin
    Route::get('Accept/{id}', [\App\Http\Controllers\API\SuperAdmin\RejectAndAcceptController::class,'accept']);
    Route::get('Reject/{id}', [\App\Http\Controllers\API\SuperAdmin\RejectAndAcceptController::class,'reject']);

                            // Super Admin View Buyer
    Route::get('View_Buyer', [\App\Http\Controllers\API\SuperAdmin\ViewBuyController::class,'ViewBuy']);

                             // Super Admin View post
    Route::get('View_Post', [\App\Http\Controllers\API\SuperAdmin\ViewPostController::class,'ViewAll']);

                            // Wallet
//    Route::post('deposit', [\App\Http\Controllers\API\User\depositController::class,'deposit']);
    Route::post('transfer', [\App\Http\Controllers\API\User\transferController::class,'transfer']);
    Route::get('balance', [\App\Http\Controllers\API\User\BalanceController::class,'balance']);


    Route::post('Deposit', [\App\Http\Controllers\API\SuperAdmin\DipositController::class,'deposit']);
    Route::post('Transfer', [\App\Http\Controllers\API\SuperAdmin\transferController::class,'transfer']);


});

Route::post('login', [\App\Http\Controllers\API\User\loginController::class,'login']);
Route::post('register', [\App\Http\Controllers\API\SuperAdmin\registerController::class,'signup']);


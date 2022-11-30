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



Route::prefix('auth')->group(function () {

    // Send reset password mail
    Route::post('reset-password', 'AuthController@sendPasswordResetLink');

    // handle reset password form process
    //Route::post('reset/password', 'AuthController@callResetPassword');

});

Route::group(['middleware' => 'auth:api'],function($router) {
    Route::Resource('/offices', 'OfficeController');
    Route::get('/logout','Auth\LoginController@logout');

    Route::group(['prefix'=>'offices'],function(){

        Route::apiResource('/{office}/refunds','RefundController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/refund_files','RefundFileController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/contracts','ContractController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/contract_budget_edits','ContractBudgetEditController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/contract_schedule_edits','ContractScheduleEditController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/contract_time_edits','ContractTimeEditController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/delivers','DeliverController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/deposit_penalties','DepositPenaltyController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/approve_refunds','ApproveRefundController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms','RefundFormController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms/{refund_form}/refund_details','RefundDetailController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms/{refund_form}/refund_reports','ReportController')->middleware('log.route');
        Route::apiResource('/{office}/refunds/{refund}/refund_status','RefundStatusController')->middleware('log.route');

        //Route::apiResource('/{article}/article_tests/{article_test}/article_questions/{article_question}/options','OptionController');
    });
    Route::Resource('/user_temp','UserTempController');
    Route::Resource('/forms','FormController');
    Route::group(['prefix'=>'forms'],function(){
        Route::apiResource('/{form}/form_rules','FormRuleController');
        
        Route::apiResource('/{form}/form_rules/{form_rule}/form_conditions','FormConditionController');
        Route::apiResource('/{form}/form_rules/{form_rule}/form_considers','ConsiderController');
    });
    Route::get('/forms/{form}/form_rules/{form_rule}/get_sub_rules','FormRuleController@GetSubRules');

    Route::group(['prefix' => 'admin'],function(){
        Route::apiResource('/{admin}/refunds','RefundController');
        Route::post('/{admin}/register','Auth\RegisterController@register');
    });

    // Route::get('/user', function (Request $request) {
    //     return $request->user();
    // });
    Route::apiResource('/users','UserController')->middleware('log.route');

    // Route::get('/user_online','UserController@UserOnlineStatus');
    // Route::get('/test_mail','Auth\RegisterController@send');
    Route::get('/create_users','Auth\RegisterController@createUsers');


    Route::post('/change_password','Auth\RegisterController@changePassword');



});


    // Route::Resource('/offices', 'OfficeController')->middleware('auth:api');


    // Route::Resource('/forms','FormController');


Auth::routes();
Route::post('/login','Auth\LoginController@login');

Route::get('/user_manual','RefundFileController@user_manual');

Route::get('/profile','AuthController@index');



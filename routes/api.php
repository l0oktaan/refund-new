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





Route::group(['middleware' => 'auth:api'],function() {
    Route::Resource('/offices', 'OfficeController');


    Route::group(['prefix'=>'offices'],function(){

        Route::apiResource('/{office}/refunds','RefundController');
        Route::apiResource('/{office}/refunds/{refund}/refund_files','RefundFileController');
        Route::apiResource('/{office}/refunds/{refund}/contracts','ContractController');
        Route::apiResource('/{office}/refunds/{refund}/contract_budget_edits','ContractBudgetEditController');
        Route::apiResource('/{office}/refunds/{refund}/contract_time_edits','ContractTimeEditController');
        Route::apiResource('/{office}/refunds/{refund}/delivers','DeliverController');
        Route::apiResource('/{office}/refunds/{refund}/deposit_penalties','DepositPenaltyController');
        Route::apiResource('/{office}/refunds/{refund}/approve_refunds','ApproveRefundController');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms','RefundFormController');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms/{refund_form}/refund_details','RefundDetailController');
        Route::apiResource('/{office}/refunds/{refund}/refund_forms/{refund_form}/refund_reports','ReportController');

        //Route::apiResource('/{article}/article_tests/{article_test}/article_questions/{article_question}/options','OptionController');
    });

    Route::Resource('/forms','FormController');
    Route::group(['prefix'=>'forms'],function(){
        Route::apiResource('/{form}/form_rules','FormRuleController');
        Route::apiResource('/{form}/form_rules/{form_rule}/form_conditions','FormConditionController');
        Route::apiResource('/{form}/form_rules/{form_rule}/form_considers','ConsiderController');
    });

    Route::group(['prefix' => 'admin'],function(){
        Route::apiResource('/{admin}/refunds','RefundController');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user_online','UserController@UserOnlineStatus');

    Route::get('/create_users','Auth\RegisterController@createUsers');

    Route::post('/change_password','Auth\RegisterController@changePassword');


});


    // Route::Resource('/offices', 'OfficeController')->middleware('auth:api');


    // Route::Resource('/forms','FormController');


Auth::routes();

Route::get('/profile','AuthController@index');


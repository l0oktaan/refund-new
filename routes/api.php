<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Resource('/offices', 'OfficeController');
Route::group(['prefix'=>'offices'],function(){
    Route::apiResource('/{office}/refunds','RefundController');
    Route::apiResource('/{office}/refunds/{refund}/contract','ContractController');
    Route::apiResource('/{office}/refunds/{refund}/contract_budget_edits','ContractBudgetEditController');
    Route::apiResource('/{office}/refunds/{refund}/contract_time_edits','ContractTimeEditController');
    Route::apiResource('/{office}/refunds/{refund}/delivers','DeliverController');
    Route::apiResource('/{office}/refunds/{refund}/deposit_penalties','DepositPenaltyController');
    Route::apiResource('/{office}/refunds/{refund}/approve_refunds','ApproveRefundController');

    //Route::apiResource('/{article}/article_tests/{article_test}/article_questions/{article_question}/options','OptionController');
});

Route::Resource('/forms','FormController');
Route::group(['prefix'=>'forms'],function(){
    Route::apiResource('/{form}/form_rules','FormRuleController');
    Route::apiResource('/{form}/form_rules/{form_rule}/form_conditions','FormConditionController');
});

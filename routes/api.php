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
    //Route::apiResource('/{article}/article_tests/{article_test}/article_questions/{article_question}/options','OptionController');
});

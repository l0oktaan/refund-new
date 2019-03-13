<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\ContractBudgetEdit;
use Illuminate\Http\Request;
use App\Http\Requests\ContractBudgetEditRequest;
use Symfony\Component\HttpFoundation\Response;

class ContractBudgetEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        return $office->contract_budget_edits()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Office $office, Refund $refund, Request $request)
    {
        return $request;
        $budget_edit = new ContractBudgetEdit($request->all());
        $refund->contract_budget_edits()->save($budget_edit);
        return response([
            'data' => new ContractResource($budget_edit)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function show(ContractBudgetEdit $contractBudgetEdit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractBudgetEdit $contractBudgetEdit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContractBudgetEdit $contractBudgetEdit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContractBudgetEdit $contractBudgetEdit)
    {
        //
    }
}

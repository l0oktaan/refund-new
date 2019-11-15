<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\ContractBudgetEdit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ContractBudgetEditRequest;
use App\Http\Resources\ContractBudgetEditResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractBudgetEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $budgetEdit = new ContractBudgetEdit;
        $budgetEdit =  $office->contract_budget_edits()
                    ->where('refund_id','=',$refund->id)
                    ->orderBy('contract_edit_date','asc')
                    ->get();
        return ContractBudgetEditResource::collection($budgetEdit);
        //return COntractBudgetEditResource::collection($office->contract_budget_edits()->get());
        // $contract_edits = new ContractBudgetEdit;
        // $contract_edits = $office->contract_budget_edits()
        //                        ->where("refund_id","=",$refund->id)
        //                        ->get();

        // return COntractBudgetEditResource::collection($contract_edits);
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



        if ($refund->office_id == $office->id){

            $budget_edit = new ContractBudgetEdit($request->all());
            $refund->contract_budget_edits()->save($budget_edit);
            return response([
                'data' => new ContractBudgetEditResource($budget_edit)
            ],Response::HTTP_CREATED);

        }else{
            return '';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, ContractBudgetEdit $contractBudgetEdit)
    {
        try {
        $budgetEdit = new ContractBudgetEdit;
        $budgetEdit = $office->contract_budget_edits()
                    ->where([
                        ['refund_id','=',$refund->id]
                        //['id','=',$contractBudgetEdit->id]

                    ])
                    ->findOrFail($contractBudgetEdit->id);
        //return $refund->contract_budget_edits()->get();
        //return $contractBudgetEdit->where("refund_id","=",$refund->id)->get();
        //return ContractBudgetEditResource::collection($contractBudgetEdit->where("refund_id","=",$refund->id)->get());
        //return 1;
        //return $office->load("contract_budget_edits");

            //return ContractBudgetEditResource::collection($refund->contract_budget_edits()->where("id","=",$contractBudgetEdit->id)->get());
            return new ContractBudgetEditResource($budgetEdit);
        } catch (ModelNotFoundException $ex) {
            //throw $th;
        }
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
    public function update(Office $office, Refund $refund, ContractBudgetEditRequest $request, ContractBudgetEdit $contractBudgetEdit)
    {
        if ($refund->office_id == $office->id){
            $contractBudgetEdit->update($request->all());
            return response([
                'data' => new ContractBudgetEditResource($contractBudgetEdit)
            ],Response::HTTP_CREATED);
        }else{
            return '';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContractBudgetEdit  $contractBudgetEdit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund, ContractBudgetEdit $contractBudgetEdit)
    {

        if ($refund->office_id == $office->id){

            $contractBudgetEdit->delete();
            return response(null,Response::HTTP_NO_CONTENT);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }

    }
}

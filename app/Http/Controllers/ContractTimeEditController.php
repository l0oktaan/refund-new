<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\ContractTimeEdit;
use Illuminate\Http\Request;
use App\Http\Requests\ContractTimeEditRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ContractTimeEditResource;

class ContractTimeEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {

        if ($refund->office_id == $office->id)
        {
            $timeEdits = new ContractTimeEdit;
            $timeEdits =  $office->contract_time_edits()
                        ->where('refund_id','=',$refund->id)
                        ->orderBy('approve_date','asc')
                        ->orderBy('edit_start_date','asc')
                        ->orderBy('edit_end_date','asc')
                        ->get();
            return ContractTimeEditResource::collection($timeEdits);
        }

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
    public function store(Office $office, Refund $refund, ContractTimeEditRequest $request)
    {

        if ($refund->office_id == $office->id){

            $time_edit = new ContractTimeEdit($request->all());
            $refund->contract_time_edits()->save($time_edit);
            if ($refund->status < 4){
                $refund->update(['status' => 4]);
            }

            return response([
                'data' => new ContractTimeEditResource($time_edit)
            ],Response::HTTP_CREATED);

        }else{
            return '';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContractTimeEdit  $contractTimeEdit
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, ContractTimeEdit $contractTimeEdit)
    {
        $timeEdit = new ContractTimeEdit;

        $timeEdit = $office->contract_time_edits()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($contractTimeEdit->id);
        if ($timeEdit == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            return new ContractTimeEditResource($timeEdit);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContractTimeEdit  $contractTimeEdit
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContractTimeEdit  $contractTimeEdit
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund,Request $request, ContractTimeEdit $contractTimeEdit)
    {
        $timeEdit = new ContractTimeEdit;

        $timeEdit = $office->contract_time_edits()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($contractTimeEdit->id);

        /* $timeEdit = new ContractTimeEdit;
        $timeEdit = $office->contract_time_edits()
                            ->where([
                                ['refund_id','=',$refund->id]
                                //['id','=',$contractBudgetEdit->id]

                            ])
                            ->findOrFail($contractTimeEdit->id);
*/
        if ($timeEdit == null){
            return response([],Response::HTTP_NOT_FOUND);
        }else{
            $timeEdit->update($request->all());
            return response([
                'data' => new ContractTimeEditResource($timeEdit)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContractTimeEdit  $contractTimeEdit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund, ContractTimeEdit $contractTimeEdit)
    {
        if ($refund->office_id == $office->id){
            $timeEdit = new ContractTimeEdit;
            $timeEdit = $office->contract_time_edits()
                                ->where([
                                    ['refund_id',"=",$refund->id],

                                ])->findOrFail($contractTimeEdit->id);

            /* $timeEdit = new ContractTimeEdit;
            $timeEdit = $office->contract_time_edits()
                                ->where([
                                    ['refund_id','=',$refund->id]
                                    //['id','=',$contractBudgetEdit->id]

                                ])
                                ->findOrFail($contractTimeEdit->id);
    */
            if ($timeEdit == null){
                return response(null,Response::HTTP_NOT_FOUND);
            }else{
                $timeEdit->delete();
                return response(null,Response::HTTP_CREATED);
            }
        }

    }
}

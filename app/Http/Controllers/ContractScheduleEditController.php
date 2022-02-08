<?php

namespace App\Http\Controllers;

use App\ContractScheduleEdit;
use Illuminate\Http\Request;

use App\Office;
use App\Refund;


use Symfony\Component\HttpFoundation\Response;

use App\Http\Resources\ContractScheduleEditResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractScheduleEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        
        try {
            $scheduleEdit = new ContractScheduleEdit;        
            $scheduleEdit =  $office->contract_schedule_edits()
                        ->where('refund_id','=',$refund->id)
                        ->orderBy('contract_edit_date','asc')
                        ->get();
            return ContractScheduleEditResource::collection($scheduleEdit);
        } catch (\Throwable $th) {
            return $th;
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
    public function store(Office $office, Refund $refund, Request $request)
    {



        if ($refund->office_id == $office->id){

            $schedule_edit = new ContractScheduleEdit($request->all());
            $refund->contract_schedule_edits()->save($schedule_edit);
            return response([
                'data' => new ContractScheduleEditResource($schedule_edit)
            ],Response::HTTP_CREATED);

        }else{
            return '';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContractScheduleEdit  $contractScheduleEdit
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, ContractScheduleEdit $contractScheduleEdit)
    {

        $scheduleEdit = new ContractScheduleEdit;
        $scheduleEdit = $office->contract_schedule_edits()
            ->where([
                ['refund_id','=',$refund->id]
                //['id','=',$contractBudgetEdit->id]

            ])
            ->findOrFail($contractScheduleEdit->id);
        

            
            return new ContractBudgetEditResource($scheduleEdit);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContractScheduleEdit  $contractScheduleEdit
     * @return \Illuminate\Http\Response
     */
    public function edit(ContractScheduleEdit $contractScheduleEdit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContractScheduleEdit  $contractScheduleEdit
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund, Request $request, ContractScheduleEdit $contractScheduleEdit)
    {
        if ($refund->office_id == $office->id){
            $contractScheduleEdit->update($request->all());
            return response([
                'data' => new ContractScheduleEditResource($contractScheduleEdit)
            ],Response::HTTP_CREATED);
        }else{
            return '';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContractScheduleEdit  $contractScheduleEdit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund, ContractScheduleEdit $contractScheduleEdit)
    {

        if ($refund->office_id == $office->id){

            $contractScheduleEdit->delete();
            return response(null,Response::HTTP_NO_CONTENT);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }

    }
}

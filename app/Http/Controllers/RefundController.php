<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use OfficeController;
use Illuminate\Http\Request;
use App\Http\Requests\RefundRequest;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Refunds as RefundResource;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office)
    {
        //return $office->refunds();

        // $refund = new Refund;
        // $refund = $office->refunds()->get();
        // //$refund = Office::with('refunds')->get();
        // return RefundResource::collection($refund);
        $office_id = $office->id;
        // $refund = Refund::with([
        //     'contracts'=>function($query){
        //     //$query->select('refund_id');
        //     },
        //     'contract_budget_edits'=>function($query){

        //     }
        // ])->get();
        if (Input::has('fields'))
        {
            $fields = Input::get('fields');

            $refund = Refund::with(explode("|",$fields))
            ->where('office_id',$office_id)
            ->get();
        }else{
            $refund = $office->refunds()->get();
        }

        return $refund;
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
    public function store(RefundRequest $request, Office $office)
    {
        $refund = new Refund;
        //$refund->office_id = $office->id;
        $refund->approve_code = $request->approve_code;
        $refund->create_date = date('Y-m-d');
        $refund->status = "1";
        $office->refunds()->save($refund);
        return response([
            'data' => new RefundResource($refund)
        ],Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund)
    {
        return RefundResource::collection($office->refunds()->where('id',$refund->id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office,Refund $refund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function update(RefundRequest $request,Office $office, Refund $refund)
    {
        $refund->update($request->all());
        return response([
            'data' => new RefunsResource($refund)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Refund  $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refund $refund)
    {
        $refund->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}

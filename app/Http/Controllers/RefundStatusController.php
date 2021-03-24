<?php

namespace App\Http\Controllers;

use App\RefundStatus;
use App\Refund;
use App\Office;
use Illuminate\Http\Request;
use App\Http\Resources\RefundStatusResource;
class RefundStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office,Refund $refund)
    {

        if ($office->id == $refund->office_id){

            $refund_status = $refund->refund_status()->orderBy('id')->get();
            return RefundStatusResource::collection($refund_status);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefundStatus  $refundStatus
     * @return \Illuminate\Http\Response
     */
    public function show(RefundStatus $refundStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefundStatus  $refundStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(RefundStatus $refundStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefundStatus  $refundStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundStatus $refundStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefundStatus  $refundStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundStatus $refundStatus)
    {
        //
    }
}

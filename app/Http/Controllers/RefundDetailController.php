<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\RefundForm;
use App\RefundDetail;
use RefundFormController;
use App\Http\Requests\RefundDetailRequest;
use App\Http\Resources\RefundDetailResource;
use Symfony\Component\HttpFoundation\Request;


class RefundDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund, RefundForm $refund_form)
    {
        $detail = new RefundDetail();
        $detail = $refund_form->refund_details()->get();
        return RefundDetailResource::collection($detail);
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
    public function store(Request $request, Office $office, Refund $refund, RefundForm $refund_form)
    {
        if ($request->has('data'))
        {
            $details = $request->data;
            foreach($details as $item)
            {
                if (!empty($item))
                {

                    $detail = new RefundDetail($item);
                    $refund_form->refund_details()->save($detail);
                }
            }
            return $details;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function show(RefundDetail $refundDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(RefundDetail $refundDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RefundDetail $refundDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RefundDetail  $refundDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RefundDetail $refundDetail)
    {
        //
    }
}

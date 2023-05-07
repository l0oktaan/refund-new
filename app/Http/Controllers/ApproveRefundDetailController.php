<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\RefundCode;
use App\ApproveRefund;
use App\ApproveRefundDetail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ApproveRefundDetailRequest;
use App\Http\Resources\ApproveRefundDetailResource;


class ApproveRefundDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $detail = new ApproveRefundDetail;
        $detail =  $office->approve_refund_details()
                    ->where('refund_id','=',$refund->id)
                    ->get();
        return ApproveRefundDetailResource::collection($detail);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Office $office, Refund $refund, ApproveRefundDetailRequest $request)
    {
        try {
            if ($refund->office_id == $office->id){
                $approve = new ApproveRefundDetail($request->all());
                $refund->approve_refund_details()->save($approve);


                return response([
                    'data' => new ApproveRefundDetailResource($approve)
                ],Response::HTTP_CREATED);

            }else{
                return response(null,Response::HTTP_NOT_FOUND);
            }
        } catch (\Throwable $th) {
            return $th;
        }

    }
     /**
     * Display the specified resource.
     *
     * @param  \App\ApproveRefundDetail  $approveRefundDetail
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund,ApproveRefundDetail $approveRefundDetail)
    {
        $approve = new ApproveRefundDetail;
        $approve = $office->approve_refund_details()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($approveRefundDetail->id);

        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{

            return response([
                'data' => new ApproveRefundDetailResource($approve)
            ],Response::HTTP_CREATED);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApproveRefundDetail  $approveRefundDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund,ApproveRefundDetailRequest $request, ApproveRefundDetail $approveRefundDetail)
    {
        $approve = new ApproveRefundDetail;
        $approve = $office->approve_refund_details()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($approveRefundDetail->id);

        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $approve->update($request->all());
            return response([
                'data' => new ApproveRefundDetailResource($approve)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApproveRefundDetail  $approveRefundDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund,ApproveRefundDetail $approveRefundDetail)
    {
        $approve = new ApproveRefundDetail;
        $approve = $office->approve_refund_details()
                            ->where([
                                ['refund_id',"=",$refund->id],
                            ])->findOrFail($approveRefundDetail->id);
        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $approve->delete();
            return response(null,Response::HTTP_CREATED);
        }
    }
}

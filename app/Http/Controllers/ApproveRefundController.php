<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\ApproveRefund;
use App\RefundCode;
use Illuminate\Http\Request;
use App\Http\Requests\ApproveRefundRequest;
use App\Http\Resources\ApproveRefundResource;
use Symfony\Component\HttpFoundation\Response;

class ApproveRefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $approve = new ApproveRefund;
        $approve =  $office->approve_refunds()
                    ->where('refund_id','=',$refund->id)
                    ->get();
        return ApproveRefundResource::collection($approve);
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
    private function getCode(RefundCode $refund_code){
        $y = Date('Y') + 543;
        if (Date('m')>9) {
            $y = $y + 1;
        }
        $code = substr($y,2) . '-' . sprintf('%04d', $refund_code->id);
        return $code;
    }
    public function store(Office $office, Refund $refund, ApproveRefundRequest $request)
    {
        if ($refund->office_id == $office->id){

            $approve = new ApproveRefund($request->all());
            $refund->approve_refunds()->save($approve);
            $refund_code = new RefundCode;
            $refund_code->refund_id = $refund->id;
            $refund_code->create_date = date('Y-m-d');
            $refund_code->save();
            if ($refund->status < 7){
                $get_code = $this->getCode($refund_code);
                $refund->update([
                    'approve_code' => $get_code,
                    'status' => 7
                ]);
                
            }
            return response([
                'data' => new ApproveRefundResource($approve)
            ],Response::HTTP_CREATED);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApproveRefund  $approveRefund
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund,ApproveRefund $approveRefund)
    {
        $approve = new ApproveRefund;

        $approve = $office->approve_refunds()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($approveRefund->id);

        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            
            return response([
                'data' => new ApproveRefundResource($approve)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApproveRefund  $approveRefund
     * @return \Illuminate\Http\Response
     */
    public function edit(ApproveRefund $approveRefund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApproveRefund  $approveRefund
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund,ApproveRefundRequest $request, ApproveRefund $approveRefund)
    {
        $approve = new ApproveRefund;

        $approve = $office->approve_refunds()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($approveRefund->id);

        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $approve->update($request->all());
            return response([
                'data' => new ApproveRefundResource($approve)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApproveRefund  $approveRefund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund,ApproveRefund $approveRefund)
    {
        $approve = new ApproveRefund;

        $approve = $office->approve_refunds()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($approveRefund->id);

        if ($approve == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $approve->delete();
            return response(null,Response::HTTP_CREATED);
        }
    }
}

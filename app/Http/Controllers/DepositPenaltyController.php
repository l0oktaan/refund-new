<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\DepositPenalty;
use Illuminate\Http\Request;
use App\Http\Requests\DepositPenaltyRequest;
use App\Http\Resources\DepositPenaltyResource;
use Symfony\Component\HttpFoundation\Response;

class DepositPenaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $deposit = new DepositPenalty;
        $deposit =  $office->deposit_penalties()
                    ->where('refund_id','=',$refund->id)
                    ->orderBy('order','asc')
                    ->get();
        return DepositPenaltyResource::collection($deposit);
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
    public function store(Office $office, Refund $refund, DepositPenaltyRequest $request)
    {
        if ($refund->office_id == $office->id){

            $deposit = new DepositPenalty($request->all());
            $refund->deposit_penalties()->save($deposit);
            return response([
                'data' => new DepositPenaltyResource($deposit)
            ],Response::HTTP_CREATED);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DepositPenalty  $depositPenalty
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, DepositPenalty $depositPenalty)
    {
        $deposit = new DepositPenalty;

        $deposit = $office->deposit_penalties()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($depositPenalty->id);

        if ($deposit == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            return response([
                'data' => new DepositPenaltyResource($deposit)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DepositPenalty  $depositPenalty
     * @return \Illuminate\Http\Response
     */
    public function edit(DepositPenalty $depositPenalty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DepositPenalty  $depositPenalty
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund, DepositPenaltyRequest $request, DepositPenalty $depositPenalty)
    {
        $deposit = new DepositPenalty;

        $deposit = $office->deposit_penalties()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($depositPenalty->id);

        if ($deposit == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $deposit->update($request->all());
            return response([
                'data' => new DepositPenaltyResource($deposit)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DepositPenalty  $depositPenalty
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepositPenalty $depositPenalty)
    {
        $deposit = new DepositPenalty;

        $deposit = $office->deposit_penalties()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($depositPenalty->id);

        if ($deposit == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $deposit->delete();
            return response(null,Response::HTTP_CREATED);
        }
    }
}

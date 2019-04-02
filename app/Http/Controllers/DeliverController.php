<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\Deliver;
use Illuminate\Http\Request;
use App\Http\Requests\DeliverRequest;
use App\Http\Resources\DeliverResource;
use Symfony\Component\HttpFoundation\Response;

class DeliverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $delivers = new Deliver;
        $delivers =  $office->delivers()
                    ->where('refund_id','=',$refund->id)
                    ->orderBy('order','asc')
                    ->get();
        return DeliverResource::collection($delivers);
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
    public function store(Office $office, Refund $refund,DeliverRequest $request)
    {
        if ($refund->office_id == $office->id){

            $deliver = new Deliver($request->all());
            $refund->delivers()->saveMany($deliver);
            return response([
                'data' => new DeliverResource($deliver)
            ],Response::HTTP_CREATED);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund,Deliver $deliver)
    {
        $iDeliver = new Deliver;

        $iDeliver = $office->delivers()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($deliver->id);

        if ($iDeliver == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{

            return response([
                'data' => new DeliverResource($iDeliver)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliver $deliver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function update(Office $office, Refund $refund,DeliverRequest $request, Deliver $deliver)
    {
        $iDeliver = new Deliver;

        $iDeliver = $office->delivers()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($deliver->id);

        if ($iDeliver == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $iDeliver->update($request->all());
            return response([
                'data' => new DeliverResource($iDeliver)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deliver  $deliver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office, Refund $refund,Deliver $deliver)
    {
        $iDeliver = new Deliver;

        $iDeliver = $office->delivers()
                            ->where([
                                ['refund_id',"=",$refund->id],

                            ])->findOrFail($deliver->id);

        if ($iDeliver == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $deliver->delete();
            return response(null,Response::HTTP_CREATED);
        }
    }
}

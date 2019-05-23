<?php

namespace App\Http\Controllers;

use App\Office;
use App\Refund;
use App\Contract;
use Illuminate\Http\Request;
use App\Http\Requests\ContractRequest;
use App\Http\Resources\ContractResource;
use Symfony\Component\HttpFoundation\Response;
class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Office $office, Refund $refund)
    {
        $contract = new Contract;
        $contract = $office->contracts()
                            ->where('refund_id','=',$refund->id)
                            ->get();
        return ContractResource::collection($contract);





        //return ContractResource::collection($office->refunds()->contract()->get());
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
    public function store(Office $office, Refund $refund, ContractRequest $request)
    {

        $contract = new Contract($request->all());
        $refund->contracts()->save($contract) ;

        return response([
            'data' => new ContractResource($contract)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office, Refund $refund, Contract $contract)
    {
        return new ContractResource($contract);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**2
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, Contract $contract)
    {
        $contract->update($request->all());
        return response([
            'data' => new ContractResource($contract)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}

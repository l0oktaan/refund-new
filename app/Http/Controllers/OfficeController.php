<?php

namespace App\Http\Controllers;

use App\Office;
use Illuminate\Http\Request;
use App\Http\Resources\Offices as OfficeResource;
use App\Http\Requests\OfficeRequest;
use Symfony\Component\HttpFoundation\Response;
//use App\Http\Resources\OfficeCollection;
class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OfficeResource::collection(Office::all());
        //return Office::all();
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
    public function store(OfficeRequest $request)
    {
        return $request;
        $office = new Office;
        $office->code = $request->code;
        $office->name = $request->name;
        $office->contact_name = $request->contact_name;
        $office->phone = $request->phone;
        $office->status = $request->status;
        $office->save();
        return response([
            'data' => OfficeResource::collection($article)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}

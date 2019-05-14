<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use App\Http\Requests\iFormRequest;
use App\Http\Resources\FormResource;
use Symfony\Component\HttpFoundation\Response;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return FormResource::collection(Form::all());

        $form = new Form;
        $form = Form::orderBy('order')
                    ->where('status','<>',0)
                    ->get();
        return FormResource::collection($form);
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
    public function store(iFormRequest $request)
    {
        $iForm = new Form($request->all());
        $iForm->save();

        return response([
            'data' => new FormResource($iForm)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $iForm = new Form;
        $iForm = Form::find($form->id);
        return new FormResource($iForm);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(iFormRequest $request, Form $form)
    {
        $iForm = new Form;
        $iForm = Form::find($form->id);
        $iForm->update($request->all());
        return response([
            'data' => new FormResource($iForm)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }
}

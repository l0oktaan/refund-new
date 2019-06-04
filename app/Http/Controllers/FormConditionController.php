<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormRule;
use App\FormCondition;
use Illuminate\Http\Request;
use App\Http\Requests\FormConditionRequest;
use App\Http\Resources\FormConditionResource;
use Symfony\Component\HttpFoundation\Response;

class FormConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Form $form, FormRule $formRule)
    {
        return FormConditionResource::collection($formRule->form_conditions()->get());
        $formCondition = new FormCondition;
        $formCondition = $form->form_conditions()
                            ->where('form_rule_id','=',$formRule->id)
                            ->orderBy('order','asc')
                            ->get();
        return FormConditionResource::collection($formCondition);

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
    public function store(Form $form, FormRule $formRule,FormConditionRequest $request)
    {
        if ($formRule->form_id == $form->id){

            $formCondition = new FormCondition($request->all());
            $formRule->form_conditions()->save($formCondition);
            return response([
                'data' => new FormConditionResource($formCondition)
            ],Response::HTTP_CREATED);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FormCondition  $formCondition
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form, FormRule $formRule, FormCondition $formCondition)
    {
        $condition = new FormCondition;
        $condition = $form->form_conditions()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formCondition->id);
        return $condition;
        // if ($condition == null){
        //     return response(null,Response::HTTP_NOT_FOUND);
        // }else{
        //     return response([
        //         'data' => new FormConditionResource($condition)
        //     ],Response::HTTP_CREATED);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FormCondition  $formCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(FormCondition $formCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormCondition  $formCondition
     * @return \Illuminate\Http\Response
     */
    public function update(Form $form, FormRule $formRule,FormConditionRequest $request, FormCondition $formCondition)
    {

        $condition = new FormCondition;
        $condition = $form->form_conditions()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formCondition->id);
        if ($condition == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $condition->update($request->all());
            return response([
                'data' => new FormConditionResource($condition)
            ],Response::HTTP_CREATED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormCondition  $formCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form, FormRule $formRule,FormCondition $formCondition)
    {
        $condition = new FormCondition;
        $condition = $form->form_conditions()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formCondition->id);
        if ($condition == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $condition->delete();
            return response([null],Response::HTTP_CREATED);
        }
    }
}

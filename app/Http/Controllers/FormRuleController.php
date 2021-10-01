<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\FormRuleRequest;
use App\Http\Resources\FormRuleResource;
use Symfony\Component\HttpFoundation\Response;

class FormRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubRules(Form $form,FormRule $form_rule)
    {
        // return "Get Sub Rules";
        
        $sub_rules = $form_rule
                    ->where("sub_of", $form_rule->id)
                    ->get();
        // return $form_rule->id;
        return $sub_rules;
    }

    public function index(Form $form)
    {
        $form_rules = $form->form_rules()
                        ->where('sub_of','=','0')
                        ->orderBy('order')
                        ->get();


        // if (Input::has('sub_of'))
        // {
            
        //     $sub_of = Input::get('sub_of');
        //     // return $sub_of;
        //     $form_rules = $form->form_rules()
        //                 ->where("sub_of","='",$sub_of . "'")
        //                 ->orderBy('order')
        //                 ->get();
        //     return $form_rules;
        // } else {
        //     $form_rules = $form->form_rules()
        //                 ->where('sub_of','=','0')
        //                 ->orderBy('order')
        //                 ->get();
        // }

        return FormRuleResource::collection($form_rules);
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
    public function store(Form $form, FormRuleRequest $request)
    {
        $form_rule = new FormRule($request->all());
        $form->form_rules()->save($form_rule);
        //$form_rule_new = new FormRuleResource($form_rule);
        return response([
            'data' => new FormRuleResource($form_rule)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FormRule  $formRule
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form, FormRule $formRule)
    {

        if ($formRule->form_id == $form->id){
            return response([
                'data' => new FormRuleResource($formRule)
            ],Response::HTTP_CREATED);
        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FormRule  $formRule
     * @return \Illuminate\Http\Response
     */
    public function edit(FormRule $formRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormRule  $formRule
     * @return \Illuminate\Http\Response
     */
    public function update(Form $form, FormRuleRequest $request, FormRule $formRule)
    {
        if ($formRule->form_id == $form->id){
            $formRule->update($request->all());
            return response([
                'data' => new FormRuleResource($formRule)
            ],Response::HTTP_CREATED);
        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormRule  $formRule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form, FormRule $formRule)
    {
        if ($formRule->form_id == $form->id){
            $formRule->delete();
            $form_rules = new FormRule;
            $form_rules = $form->form_rules()
                        ->where('sub_of','=',$formRule->id)
                        ->delete();
            return response(null,Response::HTTP_CREATED);
        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }
}

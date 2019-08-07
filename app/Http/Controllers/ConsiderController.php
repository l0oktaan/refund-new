<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormRule;
use App\Consider;
use Illuminate\Http\Request;
use App\Http\Requests\ConsiderRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\ConsiderResource;
class ConsiderController extends Controller
{
    public function index(Form $form, FormRule $formRule)
    {
        //return FormConditionResource::collection($formRule->form_conditions()->get());
        $formConsider = new Consider;
        $formConsider = $form->form_considers()
                            //->where('form_rule_id','=',$formRule->id)
                            //->orderBy('order','asc')
                            ->get();
        return $formConsider;
        //return FormConditionResource::collection($formCondition);

    }

    public function store(Form $form, FormRule $formRule,ConsiderRequest $request)
    {
        if ($formRule->form_id == $form->id){

            $formConsider = new Consider($request->all());
            $formRule->considers()->save($formConsider);
            return response([
                'data' => new ConsiderResource($formConsider)
            ],Response::HTTP_CREATED);

        }else{
            return response(null,Response::HTTP_NOT_FOUND);
        }
    }

    public function show(Form $form, FormRule $formRule, Consider $formConsider)
    {
        $consider = new Consider;
        // return $form->form_conditions()
        //     ->where([
        //         ['form_rule_id','=',$formRule->id]
        //     ])
        //     ->get();
        $consider = $form->considers()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formConsider->id);

        if ($consider == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            return response([
                'data' => new ConsiderResource($consider)
            ],Response::HTTP_CREATED);
        }
    }

    public function update(Form $form, FormRule $formRule,ConsiderRequest $request, Consider $formConsider)
    {

        $consider = new Consider;
        $consider = $form->considers()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formConsider->id);
        if ($consider == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $consider->update($request->all());
            return response([
                'data' => new ConsiderResource($consider)
            ],Response::HTTP_CREATED);
        }
    }

    public function destroy(Form $form, FormRule $formRule,Consider $formConsider)
    {
        $consider = new Consider;
        $consider = $form->Considers()
                        ->where([
                            ['form_rule_id','=',$formRule->id]
                        ])
                        ->findOrFail($formConsider->id);
        if ($consider == null){
            return response(null,Response::HTTP_NOT_FOUND);
        }else{
            $consider->delete();
            return response([null],Response::HTTP_CREATED);
        }
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;


class FormRuleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'form_id' => $this->form_id,
            'order' => $this->order,
            'name' => $this->name,
            'sub_of' => $this->sub_of,
            'rule_type' => $this->rule_type,
            'result_type' => $this->result_type,
            'condition' => $this->condition,
            'condition_type' => $this->condition_type,
            'description' => $this->description,
            'status' => $this->status
            //'conditions' => $this->form_conditions
        ];
    }
}

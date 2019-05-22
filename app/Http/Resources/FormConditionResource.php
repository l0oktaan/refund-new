<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class FormConditionResource extends Resource
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
            'form_rule_id' => $this->form_rule_id,
            'order' => $this->order,
            'name' => $this->name,
            'description' => $this->description,
            'condition_type' => $this->condition_type,
            'status' => $this->status
        ];
    }
}

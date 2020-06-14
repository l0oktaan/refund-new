<?php

namespace App\Http\Resources;


use Illuminate\Support\Facades\Route;
use App\Http\Resources\FormRuleResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FormResource extends Resource
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
            'name1' => $this->name1,
            'name2' => $this->name2,
            'name3' => $this->name3,
            'type' => $this->type,
            'minutes_date' => $this->minutes_date,
            'book_no' => $this->book_no,
            'book_date' => $this->book_date,
            'order' => $this->order,

            'rules' => FormRuleResource::collection($this->form_rules),
            'create_by' => $this->create_by,
            'status' => $this->status
        ];
    }
}

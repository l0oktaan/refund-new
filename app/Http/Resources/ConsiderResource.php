<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsiderResource extends JsonResource
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
            'type' => $this->type,
            'oper' => $this->oper,
            'var1' => $this->var1,
            'var2' => $this->var2
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RefundDetailResource extends Resource
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
            'refund_form_id' => $this->refund_form_id,
            'consider_id' => $this->consider_id,
            'result_type' => $this->result_type,
            'selected' => $this->selected,
            'value' => $this->value,
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractTimeEditResource extends JsonResource
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
            'refund_id' => $this->refund_id,
            'order' => $this->order,
            'approve_date' => $this->approve_date,
            'edit_type' => $this->edit_type,
            'edit_detail' => $this->edit_detail,
            'edit_days' => $this->edit_days
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractScheduleEditResource extends JsonResource
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
            //'order' => $this->order,            
            'contract_edit_date' => $this->contract_edit_date,
            'contract_new_start_date' => $this->contract_new_start_date,
            'contract_new_end_date' => $this->contract_new_end_date,
        ];
    }
}

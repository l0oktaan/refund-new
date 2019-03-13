<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'contract_party' => $this->contract_party,
            'contract_no' => $this->contract_no,
            'contract_date' => $this->contract_date,
            'budget' => $this->budget,
            'penalty_per_day' => $this->penalty_per_day,
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end

        ];
    }
}

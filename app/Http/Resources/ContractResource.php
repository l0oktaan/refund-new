<?php

namespace App\Http\Resources;

//use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;

class ContractResource extends Resource
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
            'penalty_type' => $this->penalty_type,
            'penalty_per_day' => $this->penalty_per_day,
            'penalty_per_day_percent' => $this->penalty_per_day_percent,
            'contract_start' => $this->contract_start,
            'contract_end' => $this->contract_end
        ];
    }
}

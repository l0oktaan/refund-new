<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractBudgetEditResource extends JsonResource
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
            'budget_new' => $this->budget_new,
            'penalty_new' => $this->penalty_new,
            'contract_edit_date' => $this->contract_edit_date,
        ];
    }
}

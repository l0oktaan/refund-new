<?php

namespace App\Http\Resources;
use App\Http\Resources\ContractResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Refunds extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'office_id' => $this->office_id,
            'approve_code' => $this->approve_code,
            'create_date' => $this->create_date,
            'sent_date' => $this->sent_date,
            'complete_date' => $this->complete_date,
            'contracts' => ContractResource::collection($this->contracts),
            'contract_edits' => ContractBudgetEditResource::collection($this->contract_budget_edits),
            'delivers' => DeliverResource::collection($this->delivers),
            'status' => $this->status,
        ];
    }
}

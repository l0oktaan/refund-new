<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;



use App\Http\Resources\ContractResource;




class RefundCollection extends Resource
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
            'office' => $this->office,
            'approve_code' => $this->approve_code,
            'create_date' => $this->create_date,
            'sent_date' => $this->sent_date,            
            'complete_date' => $this->complete_date,
            'complete_by' => $this->complete_by,
            'complete_description' => $this->complete_description,
            'contracts' => ContractResource::collection($this->contracts),
            'contract_schedule_edits' => ContractScheduleEditResource::collection($this->contract_schedule_edits),
            'contract_edits' => ContractBudgetEditResource::collection($this->contract_budget_edits),
            'delivers' => DeliverResource::collection($this->delivers),
            'status' => $this->status,
        ];
    }
}

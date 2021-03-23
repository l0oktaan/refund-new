<?php

namespace App\Http\Resources;
use App\Http\Resources\ContractResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        if ($user->type == 'admin'){
            return [
                'id' => $this->id,
                'office_id' => $this->office_id,
                'office' => $this->office,
                'approve_code' => $this->approve_code,
                'create_date' => $this->create_date,
                'sent_date' => $this->sent_date,
                'consider_date' => $this->consider_date,
                'consider_by' => $this->consider_by,
                'return_date' => $this->return_date,
                'return_by' => $this->return_by,
                'return_description' => $this->return_description,
                'draft_date' => $this->draft_date,
                'draft_by' => $this->draft_by,
                'draft_description' => $this->draft_description,
                'director_date' => $this->director_date,
                'director_by' => $this->director_by,
                'director_description' => $this->director_description,
                'discuss_date' => $this->discuss_date,
                'discuss_by' => $this->discuss_by,
                'discuss_description' => $this->discuss_description,
                'complete_date' => $this->complete_date,
                'complete_by' => $this->complete_by,
                'complete_description' => $this->complete_description,
                'contracts' => ContractResource::collection($this->contracts),
                'contract_edits' => ContractBudgetEditResource::collection($this->contract_budget_edits),
                'delivers' => DeliverResource::collection($this->delivers),
                'status' => $this->status,
            ];
        }else{
            return [
                'id' => $this->id,
                'office_id' => $this->office_id,
                'office' => $this->office,
                'approve_code' => $this->approve_code,
                'create_date' => $this->create_date,
                'sent_date' => $this->sent_date,
                'consider_date' => $this->consider_date,
                'consider_by' => $this->consider_by,
                'return_date' => $this->return_date,
                'return_by' => $this->return_by,
                'return_description' => $this->return_description,
                // 'draft_date' => $this->draft_date,
                // 'draft_by' => $this->draft_by,
                // 'draft_description' => $this->draft_description,
                // 'director_date' => $this->director_date,
                // 'director_by' => $this->director_by,
                // 'director_description' => $this->director_description,
                // 'discuss_date' => $this->discuss_date,
                // 'discuss_by' => $this->discuss_by,
                // 'discuss_description' => $this->discuss_description,
                'complete_date' => $this->complete_date,
                'complete_by' => $this->complete_by,
                'complete_description' => $this->complete_description,
                'contracts' => ContractResource::collection($this->contracts),
                'contract_edits' => ContractBudgetEditResource::collection($this->contract_budget_edits),
                'delivers' => DeliverResource::collection($this->delivers),
                'status' => $this->status,
            ];
        }
        
    }
}



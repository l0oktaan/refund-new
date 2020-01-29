<?php

namespace App\Http\Resources;




use App\Http\Resources\FormResource;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\RefundDetailResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Refunds as RefundResource;
use App\Http\Resources\ContractBudgetEditResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RefundFormResource extends Resource
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
            'form_id' => $this->form_id,
            'refund_id' => $this->refund_id,
            'form' => new FormResource($this->form),
            'detail' => RefundDetailResource::collection($this->refund_details),
            'result' => $this->result,
            'status' => $this->status,
            'refund' => new RefundResource($this->refund)

        ];
    }
}

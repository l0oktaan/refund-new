<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApproveRefundResource extends JsonResource
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
            'receive_refund_date' => $this->approve_refund_date,
            'approve_refund_days' => $this->approve_refund_days,
            'approve_refund_amount' => $this->approve_refund_amount,
            'amount' => $this->amount
        ];
    }
}

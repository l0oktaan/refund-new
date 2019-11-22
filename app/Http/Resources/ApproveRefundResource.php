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
            'receive_date' => $this->receive_date,
            'refund_days' => $this->refund_days,
            'refund_amount' => $this->refund_amount,
            'approve_amount' => $this->approve_amount
        ];
    }
}

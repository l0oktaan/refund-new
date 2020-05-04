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
            'refund_days' => $this->refund_days,
            'refund_money' => $this->refund_money,
            'refund_amount' => $this->refund_amount,
            'approve_amount' => $this->approve_amount
        ];
    }
}

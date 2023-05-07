<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApproveRefundDetailResource extends JsonResource
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
            'approve_refund_detail' => $this->approve_refund_detail,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'refund_days' => $this->refund_days

        ];
    }
}

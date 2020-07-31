<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class DeliverResource extends Resource
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
            'delivery' => $this->delivery,
            'detail' => $this->detail,
            'delivery_date' => $this->delivery_date,
            'overdue_start_date' => $this->overdue_start_date,
            'overdue_end_date' => $this->overdue_end_date,
            'overdue_days' => $this->overdue_days,
            'penalty' => $this->penalty,
            'penalty_accept'=> $this->penalty_accept,
        ];
    }
}

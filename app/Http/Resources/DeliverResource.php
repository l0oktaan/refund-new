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
            'deliver_date' => $this->deliver_date,
            'overdue_days' => $this->overdue_days,
            'penalty' => $this->penalty
        ];
    }
}

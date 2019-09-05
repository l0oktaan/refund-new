<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


use Illuminate\Support\Facades\Route;
use App\Http\Resources\FormResource;
use Illuminate\Http\Resources\Json\Resource;
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
            'form' => $this->form,
            'result' => $this->result,
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTempResource extends JsonResource
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
            'order' => $this->order,
            'code' => $this->code,
            'office_id' => $this->office_id,
            'name' => $this->name,            
            'position' => $this->position,   
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status
        ];
    }
}

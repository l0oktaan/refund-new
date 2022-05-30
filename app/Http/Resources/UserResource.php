<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'username' => $this->username,
            'office_id' => $this->office_id,
            'office' => $this->office_id >0 ? $this->office->name : 'admin',
            'email' => $this->email,            
            'status' => $this->status
        ];
    }
}

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
            'level' => $this->level,
            'position' => $this->position,
            'username' => $this->username,
            'office_id' => $this->office_id,
            'office' => $this->office_id >0 ? $this->office->name : 'admin',
            'email' => $this->email,
            'sub_office_name'  => $this->sub_office_name,
            'phone' => $this->phone,
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class FormResource extends Resource
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
            'name1' => $this->name1,
            'name2' => $this->name2,
            'name3' => $this->name3,
            'order' => $this->order,
            'create_by' => $this->create_by,
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RefundFileResource extends Resource
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
            'fname' => $this->file_name,
            'fpath' => storage_path() . '/files/uploads/' . $this->file_path,
            'description' => $this->description,
            'upload_by' => $this->upload_by,
            'status' => $this->status
        ];
    }
}

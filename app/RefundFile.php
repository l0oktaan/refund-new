<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundFile extends Model
{
    protected $table = "14_refund_files";
    protected $fillable = [
        'id',       
        'refund_id',
        'file_name',
        'file_path',        
        'description',
        'upload_by',
        'status'
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
}

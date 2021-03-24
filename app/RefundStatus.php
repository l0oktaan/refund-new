<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundStatus extends Model
{
    protected $table = "16_refund_status";
    protected $fillable = [
        'id',
        'refund_id',
        'status_code',
        'status_date',
        'status_by'
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
}

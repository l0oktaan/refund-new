<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class ApproveRefundDetail extends Model
{
    protected $table = "81_approve_refund_details";
    protected $fillable = [
        'id',
        'refund_id',
        'approve_refund_detail',
        'start_date',
        'end_date',
        'refund_days'

    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
}

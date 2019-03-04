<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class ApproveRefund extends Model
{
    protected $table = "8_approve_refunds";
    protected $fillable = [
        'id',
        'refund_id',
        'receive_refund_date',
        'approve_refund_day',
        'approve_refund_amount',
        'amount'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

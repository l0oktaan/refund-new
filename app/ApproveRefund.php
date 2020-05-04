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
        'refund_days',
        'refund_money',
        'refund_amount',
        'approve_amount'
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
}

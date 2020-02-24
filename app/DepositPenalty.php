<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class DepositPenalty extends Model
{
    protected $table = "7_deposit_penalties";
    protected $fillable = [
        'id',
        'refund_id',
        'deposit_no',
        'deposit_date',
        'amount',
        'amount_in_contract',
        'description'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

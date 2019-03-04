<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = "3_contracts";
    protected $fillable = [
        'id',
        'refund_id',
        'contract_party',
        'contract_no',
        'contract_date',
        'budget',
        'penalty_per_day',
        'contract_start',
        'contract_end'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

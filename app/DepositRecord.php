<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositRecord extends Model
{
    protected $table = "33_deposit_record";
    protected $fillable = [
        'id',
        'contract_new_id',
        'deposit_no',
        'deposit_date',
        'amount',
        'amount_in_contract',
        'description'
        // 'budget',
        // 'currency_unit',
        // 'penalty_type',
        // 'penalty_per_day',
        // 'penalty_per_day_percent',
        // 'contract_start',
        // 'contract_end'
    ];


    public function contract_new(){
        return $this->belongsTo(ContractNew::class);
    }
}

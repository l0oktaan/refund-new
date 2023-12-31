<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractNew extends Model
{
    protected $table = "32_contract_news";
    protected $fillable = [
        'id',
        'office_id',
        'contract_party_id',
        'contract_no',
        'status'
        // 'contract_date',
        // 'budget',
        // 'currency_unit',
        // 'penalty_type',
        // 'penalty_per_day',
        // 'penalty_per_day_percent',
        // 'contract_start',
        // 'contract_end'
    ];

    public function office(){
        return $this->belongsTo(Office::class);
    }
    public function contract_party(){
        return $this->belongsTo(ContractParty::class);
    }

    public function deposit_records(){
        return $this->hasMany(DepositRecord::class);
    }
    public function approve_refund_records(){
        return $this->hasMany(ApproveRefundRecord::class);
    }
}

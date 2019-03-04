<?php

namespace App;
use Office;
use Contract;
use ContractBudgetEdit;
use ContractTimeEdit;
use Deliver;
use DepositPenalty;
use ApproveRefund;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table = "2_refunds";
    protected $fillable = [
        'id',
        'office_id',
        'approve_code',
        'create_date',
        'sent_date',
        'complete_date',
        'status'
    ];

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }

    public function contract_budget_edits(){
        return $this->hasMany(ContractBudgetEdit::class);
    }

    public function contract_time_edits(){
        return $this->hasMany(ContractTimeEdit::class);
    }

    public function delivers(){
        return $this->hasMany(Deliver::class);
    }

    public function deposit_penalties(){
        return $this->hasMany(DepositPenalty::class);
    }

    public function approve_refunds(){
        return $this->hasMany(ApproveRefund::class);
    }
}

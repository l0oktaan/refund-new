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
        return $this->belongsTo('App\Office');
    }

    public function contract(){
        return $this->hasOne('App\Contract');
    }

    public function contract_budget_edits(){
        return $this->hasMany('App\ContractBudgetEdit');
    }

    public function contract_time_edits(){
        return $this->hasOne(ContractTimeEdit::class);
    }

    public function delivers(){
        return $this->hasOne(Deliver::class);
    }

    public function deposit_penalties(){
        return $this->hasOne(DepositPenalty::class);
    }

    public function approve_refunds(){
        return $this->hasOne(ApproveRefund::class);
    }
}

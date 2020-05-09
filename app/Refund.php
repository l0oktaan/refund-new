<?php

namespace App;
use Office;
use Contract;
use ContractBudgetEdit;
use ContractTimeEdit;
use Deliver;
use DepositPenalty;
use ApproveRefund;
use RefundForm;
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
        'consider_date',
        'consider_by',
        'return_date',
        'return_by',
        'return_description',
        'complete_date',
        'complete_by',
        'complete_description',
        'status'
    ];

    public function office(){
        return $this->belongsTo('App\Office');
    }

    public function contracts(){
        return $this->hasMany('App\Contract','refund_id','id');
    }

    public function refund_files(){
        return $this->hasMany('App\RefundFile');
    }

    public function contract_budget_edits(){
        return $this->hasMany('App\ContractBudgetEdit','refund_id','id');
    }

    public function contract_time_edits(){
        return $this->hasMany('App\ContractTimeEdit','refund_id','id');
    }

    public function delivers(){
        return $this->hasMany('App\Deliver','refund_id','id');
    }

    public function deposit_penalties(){
        return $this->hasMany('App\DepositPenalty','refund_id','id');
    }

    public function approve_refunds(){
        return $this->hasMany('App\ApproveRefund','refund_id','id');
    }

    public function refund_forms(){
        return $this->hasMany('App\RefundForm','refund_id','id');
    }
}

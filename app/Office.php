<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "1_offices";
    protected $fillable = [
        'id',
        'code',
        'name',
        'contact_name',
        'email',
        'phone',
        'status'
    ];

    public function refunds(){
        return $this->hasMany('App\Refund');
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function contracts(){
        return $this->hasManyThrough(
            'App\Contract',
            'App\Refund',
            'office_id',
            'refund_id'

        );
    }
    public function contract_budget_edits(){
        return $this->hasManyThrough(
            'App\ContractBudgetEdit',
            'App\Refund',
            'office_id',
            'refund_id'

        );
    }

    public function contract_schedule_edits(){
        return $this->hasManyThrough(
            'App\ContractScheduleEdit',
            'App\Refund',
            'office_id',
            'refund_id'

        );
    }

    public function contract_time_edits(){
        return $this->hasManyThrough(
            'App\ContractTimeEdit',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function delivers(){
        return $this->hasManyThrough(
            'App\Deliver',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function refund_files(){
        return $this->hasManyThrough(
            'App\RefundFile',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function deposit_penalties(){
        return $this->hasManyThrough(
            'App\DepositPenalty',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function approve_refunds(){
        return $this->hasManyThrough(
            'App\ApproveRefund',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function approve_refund_details(){
        return $this->hasManyThrough(
            'App\ApproveRefundDetail',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }

    public function refund_forms(){
        return $this->hasManyThrough(
            'App\RefundForm',
            'App\Refund',
            'office_id',
            'refund_id'
        );
    }
}

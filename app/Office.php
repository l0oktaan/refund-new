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
        'phone',
        'status'
    ];

    public function refunds(){
        return $this->hasMany('App\Refund');
    }

    public function contracts(){
        return $this->hasManyThrough(
            'App\Contract',
            'App\Refund',
            'office_id',
            'refund_id',
            'id',
            'id'
        );
    }
    public function contract_budget_edits(){
        return $this->hasManyThrough(
            'App\ContractBudgetEdit',
            'App\Refund',
            'office_id',
            'refund_id',
            'id',
            'id'
        );
    }
}

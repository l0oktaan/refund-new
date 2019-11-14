<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class ContractBudgetEdit extends Model
{
    protected $table = "4_contract_budget_edits";
    protected $fillable = [
        'id',
        'refund_id',
        //'order',
        'budget_new',
        'penalty_new',
        'contract_edit_date',
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
    public function office(){
        return $this->belongsTo('App\Office');
    }
}

<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class ContractTimeEdit extends Model
{
    protected $table = "5_contract_time_edits";
    protected $fillable = [
        'id',
        'refund_id',
        'approve_date',
        'edit_type',
        'edit_detail',
        'edit_days',
        'edit_budget',
        'edit_start_date',
        'edit_end_date',
        'approve_type',
        'approve_other_desc',
        'approve_other_type',
        'approve_case',
        'zero_penalty_consider',
        'zero_penalty_detail',
        'problem_end_date',
        'book_date'
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
    public function office(){
        return $this->belongsTo('App\Office');
    }
}

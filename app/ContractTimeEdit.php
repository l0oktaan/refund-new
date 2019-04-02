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
        'order',
        'approve_date',
        'edit_type',
        'edit_detail',
        'edit_days'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

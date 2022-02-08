<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractScheduleEdit extends Model
{
    protected $table = "41_contract_schedule_edits";
    protected $fillable = [
        'id',
        'refund_id',        
        'contract_edit_date',
        'contract_new_start_date',
        'contract_new_end_date',
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }
    public function office(){
        return $this->belongsTo('App\Office');
    }
}

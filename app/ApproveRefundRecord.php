<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApproveRefundRecord extends Model
{
    protected $table = "34_approve_refund_record";
    protected $fillable = [
        'id',
        'contract_new_id',
        'refund_order',
        'refund_amount',
        'balance',
        'refund_case',
        'approve_book_no',
        'created_date',
        'modified_by',
        'description',
        // 'penalty_type',
        // 'penalty_per_day',
        // 'penalty_per_day_percent',
        // 'contract_start',
        // 'contract_end'
    ];


    public function contract_new(){
        return $this->belongsTo(ContractNew::class);
    }
}

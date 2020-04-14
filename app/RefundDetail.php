<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundDetail extends Model
{
    protected $table = "13_refund_details";
    protected $fillable = [
        'id',
        'refund_form_id',
        'consider_id',
        'result_type',
        'selected',
        'value',
        'status'
    ];

    public function refund_form(){
        return $this->belongsTo('App\RefundForm');
    }

    public function consider(){
        return $this->belongsTo('App\Consider');
    }

}

<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class RefundForm extends Model
{
    protected $table = "12_refund_forms";
    protected $fillable = [
        'id',
        'form_id',
        'refund_id',
        'result',
        'status'
    ];

    public function refund(){
        return $this->belongsTo('App\Refund');
    }

    public function form(){
        return $this->belongsTo('App\Form');
    }

    public function refund_details(){
        return $this->hasMany('App\RefundDetail','refund_form_id','id');
    }
}

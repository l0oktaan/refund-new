<?php

namespace App;

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
}

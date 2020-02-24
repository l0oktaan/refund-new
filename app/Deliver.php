<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
    protected $table = "6_delivers";
    protected $fillable = [
        'id',
        'refund_id',
        'delivery',
        'detail',
        'delivery_date',
        'overdue_start_date',
        'overdue_end_date',
        'overdue_days',
        'penalty'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

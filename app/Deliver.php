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
        'order',
        'detail',
        'deliver_date',
        'overdue_days',
        'penalty'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class Deliver extends Model
{
    protected $table = "6_delevers";
    protected $fillable = [
        'id',
        'refund_id',
        'order',
        'detail',
        'deliver_date',
        'overdue_day',
        'penalty'
    ];

    public function refund(){
        return $this->belongsTo(Refund::class);
    }
}

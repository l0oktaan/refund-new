<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefundCode extends Model
{
    protected $table = "15_refund_codes";
    protected $fillable = [
        'id',
        'refund_id',
        'year',
        'code',
        'create_date'
    ];

    public function refund(){
        return $this->hasOne('App\Refund');
    }
}

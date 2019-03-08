<?php

namespace App;
use Refund;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "1_offices";
    protected $fillable = [
        'id',
        'code',
        'name',
        'contact_name',
        'phone',
        'status'
    ];

    public function refunds(){
        return $this->hasMany('App\Refund');
    }
}

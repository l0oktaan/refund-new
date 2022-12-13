<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTemp extends Model
{
    protected $table = "user_temp";
    protected $fillable = [
        'order','code','office_id','name', 'position','phone','email','status','sub_office_name'
    ];
}

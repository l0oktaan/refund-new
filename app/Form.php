<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = "9_forms";
    protected $fillable = [
        'id',
        'name1',
        'name2',
        'name3',
        'create_by',
        'status'
    ];
}

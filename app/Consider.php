<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consider extends Model
{
    protected $table = "112_considers";
    protected $fillable = [
        'id',
        'form_rule_id',
        'order',
        'name',
        'type',
        'oper',
        'var1',
        'var2'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormRule extends Model
{
    protected $table = "10_form_rules";
    protected $fillable = [
        'id',
        'form_id',
        'order',
        'name',
        'sub_of',
        'rule_type',
        'result_type',
        'status'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormCondition extends Model
{
    protected $table = "11_form_conditions";
    protected $fillable = [
        'id',
        'form_rule_id',
        'order',
        'name',
        'description',
        'condition_type',
        'status'
    ];
    public function form_rule()
    {
        return $this->belongsTo('App\FormRule');
    }
}

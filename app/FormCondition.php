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

    public function form_details()
    {
        return $this->hasMany('App\FormDetail');
    }
    public function form()
    {
        return $this->belongsTo('App\Form');
    }

}

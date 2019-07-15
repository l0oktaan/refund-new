<?php

namespace App;
use FormCondition;
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
        'condition',
        'condition_type',
        'description',
        'status'
    ];

    public function form(){
        return $this->belongsTo('App\Form');
    }

    public function form_conditions(){
        return $this->hasMany('App\FormCondition','form_rule_id','id');
    }
}

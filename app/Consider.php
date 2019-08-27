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
        'description',
        'type',
        'oper',
        'var1',
        'var2'
    ];

    public function form_rule()
    {
        return $this->belongsTo('App\FormRule');
    }

    public function form()
    {
        return $this->belongsTo('App\Form');
    }
}

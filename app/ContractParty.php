<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractParty extends Model
{
    protected $table = "31_contract_parties";
    protected $fillable = [
        'id',
        'name',
        'description'
        // 'contract_date',
        // 'budget',
        // 'currency_unit',
        // 'penalty_type',
        // 'penalty_per_day',
        // 'penalty_per_day_percent',
        // 'contract_start',
        // 'contract_end'
    ];


    public function contract_news(){
        return $this->hasMany(ContractNew::class);
    }
}

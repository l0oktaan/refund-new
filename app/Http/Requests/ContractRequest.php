<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    /* public function authorize()
    {
        return false;
    } */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contract_party' => 'required',
            'contract_no' => 'required',
            // 'contract_date' => 'required',
            // 'budget' => 'required',
            // 'penalty_type' => 'required',            
            
            // 'contract_start' => 'required',
            // 'contract_end' => 'required'

        ];
    }
}

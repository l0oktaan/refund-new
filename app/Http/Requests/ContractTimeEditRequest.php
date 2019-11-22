<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractTimeEditRequest extends FormRequest
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
            'approve_date' => 'required',
            'edit_type' => 'required',
            'edit_days' => 'required',
            'edit_budget'=> 'required',
            'contract_end_date'=> 'required',
            'approve_type'=> 'required',
            'approve_case'=> 'required',
            'problem_end_date'=> 'required',
            'book_date' => 'required'
        ];
    }
}

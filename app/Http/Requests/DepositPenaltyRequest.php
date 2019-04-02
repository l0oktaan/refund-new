<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositPenaltyRequest extends FormRequest
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
            'order' => 'required',
            'deposit_no' => 'required|max:50',
            'deposit_date' => 'required',
            'amount' => 'required'
        ];
    }
}

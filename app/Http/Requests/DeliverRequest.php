<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliverRequest extends FormRequest
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
            'delivery' => 'required',
            'detail' => 'required',
            'delivery_date' => 'required'
            // 'overdue_start_date' => 'required',
            // 'overdue_end_date' => 'required',
            // 'overdue_days' => 'required',
            // 'penalty' => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
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
            // 'code' => 'max:10',
            // 'name' => 'max:255',
            // 'contact_name' => 'max:120',
            // 'phone' => 'max:50',
        ];
    }
}

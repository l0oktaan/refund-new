<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class iFormRequest extends FormRequest
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
            'name1' => 'required',
            'name2' => 'required',
            'name3' => 'required',
            'create_by' => 'required',
            'status' => 'required'
        ];
    }
}

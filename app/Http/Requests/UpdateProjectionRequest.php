<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'real_weight' => 'sometimes',
            'pic_date' => 'sometimes',
            'misbirth' => 'sometimes',
            'birth' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

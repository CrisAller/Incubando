<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required|unique:companies,name,'.$this->id,
            'address' => 'sometimes',
            'city' => 'required|string',
            'cif' => 'sometimes',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Error en el nombre',
            'city.required' => 'Error en la ciudad'
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Debes estar logeado para modificar los datos de la empresa');
    }

}

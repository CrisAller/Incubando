<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class StoreEggRequest extends FormRequest
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
            'reference' => ['required'],
            'weight' =>['required', 'numeric', 'min:1', 'max:99,999'],
            'collection_date' => ['required'],
            'incubation_day' => ['required', 'numeric', 'min:1', 'max:33'],
            'specie_id' => ['required','numeric'],
            'company_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'reference.required' => 'Es necesario introducir la referencia',
            'weight.required' => 'Es necesario introducier el peso',
            'weight.numeric' => 'El peso ha de ser un número entre 1 y 99.999',
            'collection_date.required' => 'Es necesario introducir la fecha de recogida del huevo',
            'incubation_day.required' => 'El necesario indicar el día de incubación',            
            'incubation_day.numeric' => 'El día de incubación ha de ser un número entero entre 1 y 33',
            'specie.required' => 'Es necesario seleccionar una especie',
            'specie.numeric' => 'Es necesario seleccionar una especie',
            'company_id.required' => 'Error en el id de la compañía',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('Debes estar logeado para crear un nuevo registro');
    }
}

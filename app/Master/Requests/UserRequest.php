<?php namespace App\Master\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required'],
            'email' => ['required'],
            'role_id' => ['required'],
            'status'    =>  ['required']

        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    =>   'Debe escoger un Nombre al Usuario',
            'email.required'   =>   'Es necesario un Email para crear o actualizar un Usuario',
            'role_id.required'  =>  'Es necesario asignar un Rol al Usuario',
            'status.required'   =>  'Debe seleccionar un Estado para el Usuario'
        ];
    }
}

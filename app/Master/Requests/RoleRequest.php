<?php namespace App\Master\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required'],
            'slug' => ['required'],
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'    =>  'Debe escoger un Nombre al Rol',
            'slug.required'    =>  'Es necesario un Email para Notificar el Proceso',
        ];
    }
}

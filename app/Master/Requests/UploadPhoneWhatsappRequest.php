<?php namespace App\Master\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Tenant\Configuration;

class UploadPhoneWhatsappRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'email' => ['required'],
            'upload_date' => ['required', 'date_format:Y-m-d'],
            'uploadFiles' => ['required']
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'upload_date.required'          =>  'La Fecha de Carga es Obligatorio',
            'uploadFiles.required'          =>  'Debe subir un Archivo por lo Menos',
            'upload_date.date_format'       =>  'La Fecha de Carga no tiene un Formato Válido'
        ];
    }
}

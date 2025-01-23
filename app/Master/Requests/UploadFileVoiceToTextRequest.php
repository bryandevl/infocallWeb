<?php namespace App\Master\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Tenant\Configuration;

class UploadFileVoiceToTextRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'finance_entity_id' => ['required'],
            'email' => ['required'],
            'upload_date' => ['required', 'date_format:Y-m-d'],
            'uploadFiles' => ['required']
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'finance_entity_id.required'    =>  'Debe escoger una Entidad Financiera.',
            'email.required'                =>  'Es necesario un Email para Notificar el Proceso',
            'upload_date.required'          =>  'La Fecha de Carga es Obligatorio',
            'uploadFiles.required'          =>  'Debe subir un Archivo por lo Menos',
            'upload_date.date_format'       =>  'La Fecha de Carga no tiene un Formato Válido'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProtectorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id =  $this->input('id');

        return [
            'login_for' => 'required',
            'service' => 'required',
            'terminal_id' => 'required',
            'name' => 'required',
            'password' => 'required',
            'website' => 'required',
            'contact_number' => 'required',
            'support_name' => 'required',
            'support_number' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'login_for.required' => 'Please enter login for',
            'service.required' => 'Please select service name',
            'terminal_id.required'  => 'Please enter terminal id',
            'name.required'  => 'Please enter name',
            'password.required'  => 'Please enter password',
            'website.required'  => 'Please enter website url',
            'contact_number.required'  => 'Please enter contact number',
            'support_name.required'  => 'Please enter urgent support name',
            'support_number.required'  => 'Please enter urgent support number'
        ];
    }
}

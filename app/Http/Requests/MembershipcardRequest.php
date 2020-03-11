<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipcardRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id =  $this->input('id');
        if ($this->method() == 'PUT') {
            $attachment = '';
        } else  {
            $attachment = 'required';
        }

        return [
            'client' => 'required',
            'airline' => 'required',
            'membership_number' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'files' => $attachment
        ];
    }

    public function messages()
    {
        return [
            'client.required' => 'Please select client Name',
            'airline.required' => 'Please enter airline',
            'membership_number.required'  => 'Please enter membership number',
            'password.required'  => 'Please enter password',
            'email.required'  => 'Please enter email',
            'files.required'  => 'Please choose attachment card'
        ];
    }
}

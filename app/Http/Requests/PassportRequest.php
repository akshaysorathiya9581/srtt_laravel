<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PassportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id =  $this->input('id');
        if ($this->method() == 'PUT') {
            $passport_number = 'required|unique:passports,passport_number,'.$id;
            $passport_pdf = 'required,'.$id;
        } else  {
            $passport_number = 'required|unique:passports,passport_number';
            $passport_pdf = 'required';
        }

        return [
            'client' => 'required',
            'passport_number' => $passport_number,
            'issue_date' => 'required',
            'issue_place' => 'required',
            'expiry_date' => 'required',
            'dob' => 'required',
            'ecr' => 'required',
            'nationality' => 'required',
            'files' => $passport_pdf
        ];
    }

    public function messages()
    {
        return [
            'client.required' => 'Please select client Name',
            'passport_number.required' => 'Please enter passport number',
            'passport_number.unique'  => 'Passport number allready exists',
            'issue_date.required'  => 'Please enter issue date',
            'issue_place.required'  => 'Please enter issue place',
            'expiry_date.required'  => 'Please enter expiry date',
            'dob.required'  => 'Please enter dob',
            'ecr.required'  => 'Please enter ecr',
            'nationality.required'  => 'Please enter nationality',
            'files.required' => 'Please choose passport copy attached',
        ];
    }
}
